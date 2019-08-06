<?php

namespace wordControl;

//表格
class wordTable{

    private $option = array();
    private $rows = array();
    private $templateList = array(); //表格行模板

    private $cellWidths = array();
    public function __construct(){
        $this->option = array(
            'w:tblStyle'=>array(
                '@attributes'=>array(
                    'w:val'=>'af2'
                )
            ),
            'w:tblW'=>array(
                '@attributes'=>array(
                    'w:w'=>5000,
                    'w:type'=>'pct'
                )

            ),
            'w:tblLook'=>array(
                '@attributes'=>array(
                    'w:val'=>'04A0',
                    'w:firstRow'=>'1',
                    'w:lastRow'=>'0',
                    'w:firstColumn'=>'0',
                    'w:noHBand'=>'0',
                    'w:noVBand'=>'1'
                )
            ),
            'w:tblBorders'=>array(
                'w:top'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                ),
                'w:left'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                ),
                'w:bottom'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                ),
                'w:right'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                ),
                'w:insideH'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                ),
                'w:insideV'=>array(
                    '@attributes'=>array(
                        'w:val'=>'single',
                        'w:sz'=>'4',
                        'w:space'=>'0',
                        'w:color'=>'auto'
                    )
                )
            )
        );
    }

    /**
     * Create table row objects
     *
     * @param  callable $callback
     * @return $this
     */
    public function createRow(callable $callback){
        if($callback){
           $wordTableRow = new wordTableRow();
           call_user_func($callback,$wordTableRow);
           $this->rows[] = $wordTableRow;
        }
        return $this;
    }

    /**
     * Create table row template
     *
     * @param  callable $callback
     * @return $this
     */
    public function createTemplate($name){
        $this->templateList[$name] = end($this->rows);
        return $this;
    }

    /**
     * Use table row templates
     *
	 * @param string $name
     * @param  array $texts
     * @return $this
     */
    public function templateText($name,$texts = array()){
        if(isset($this->templateList[$name])){
            $wordTableRow = clone $this->templateList[$name];

            $wordTableCells = $wordTableRow->getCellsObj();
            foreach($wordTableCells as $index=>$wordTableCell){
                $newWordTableCell = clone $wordTableCell;

                $wordSections = $newWordTableCell->getSectionsObj();
                foreach($wordSections as $secIndex=>$wordSection){
                    $newWordSection = clone $wordSection;
                    foreach ($newWordSection->getSectionTexts() as $wordText) {
                        $newWordText = clone $wordText;
                        $newWordText->text($texts[$index]);
                        $newWordSection->addText($newWordText);
                    }
                    $wordSections[$secIndex] = $newWordSection;
                }

                $newWordTableCell->addSections($wordSections);

                $wordTableCells[$index] = $newWordTableCell;
            };

            $wordTableRow->addCells($wordTableCells);

            $this->rows[] = $wordTableRow;
        }

        return $this;
    }

    /**
     * Setting table border properties
     *
     * @param  callable $callback
     * @return $this
     */
    public function borders(callable $callback){
        if($callback){
            $wordTableBorders = new wordTableBorders();
            call_user_func($callback,$wordTableBorders);
            $this->option['w:tblBorders'] = $wordTableBorders->getAttrs();
        }
    }

    /**
     * Get table row object content
     *
     * @return string
     */
    private function getRows(){
        $rows = array();
        if($this->rows){
            foreach($this->rows as $wordTableRow){
                $rows[] = $wordTableRow->getRow();

                if (!$this->cellWidths) {
                    $hasfullCell = true;
                    $wordTableRow->each(function ($wordTableCell) use ($hasfullCell) {
                        if ($wordTableCell->hasGridSpan() == false) {
                            $hasfullCell = false;
                        }
                    });

                    if ($hasfullCell == true) {
                        $wordTableRow->each(function ($wordTableCell) {
                            $this->cellWidths[] = $wordTableCell->getWidth();
                        });
                    }
                }
            }
        }
        return implode("",$rows);
    }

    /**
     * Get cell column properties
     *
     * @return string
     */
    private function getTblGrid(){
        $gridCols = array();
        if($this->cellWidths){
            foreach($this->cellWidths as $width){
                $gridCols[] = sprintf('<w:gridCol w:w="%d"/>',$width);
            }
        }
        return implode("",$gridCols);
    }
	
    /**
     * Delete table rows
     *
	 * @param int $rowIndex
	 * @param int $row
     * @return $this
     */
	public function removeRows($rowIndex = 0,$rows = 1){
		if($this->rows){
			for($index = $rowIndex;$index < ($rowIndex + $rows);$index++){
				if(isset($this->rows[$index])){
					unset($this->rows[$index]);
				}
			}
		}
		return $this;
	}

    /**
     * Getting table object content
     *
     * @return string
     */
    public function getTable(){
        $rows = $this->getRows();
        $gridCols = $this->getTblGrid();
        $wordAttributes = new wordAttributes();
        return sprintf('<w:tbl><w:tblPr> %s </w:tblPr><w:tblGrid> %s </w:tblGrid> %s </w:tbl>',$wordAttributes->getNodes($this->option),$gridCols,$rows);
    }

    /**
     * Batch setting table properties
     *
     * @return $this
     */
    public function setAttrs($option = array()){
        if($option){
            $this->option = array_merge($this->option,$option);
        }
        return $this;
    }

    public function __call($method,$args){
        $wordExcption = new wordException(sprintf('CLASS：%s, method %s is not exists!',__CLASS__,$method));
        $wordExcption->showError();
    }

	public function __destruct(){
        unset($this->rows,$this->templateList,$this->option);
    }
}
?>