<?php

namespace wordControl;

//表格列
class wordTableCell{

    private $option = array();
    private $sections = array(); //段落
    public function __construct(){
		$this->option = array(
			'w:tcW'=>array(
                '@attributes'=>array(
                    'w:w'=>'2765',
                    'w:type'=>'dxa'
                )
            ),
            'w:gridSpan'=>array(
                '@attributes'=>array(
                    'w:val'=>'0',
                )
            )
		);
    }

    /**
     * Set table column width
     *
     * @param  int $value
     * @return $this
     */
    public function width($value){
        $this->option['w:tcW']['@attributes']['w:w'] = $value;
		return $this;
    }

    /**
     * Get table column width
     *
     * @return int
     */
    public function getWidth(){
        return  $this->option['w:tcW']['@attributes']['w:w'];
    }

    public function gridSpan($value = 2){
        $this->option['w:gridSpan']['@attributes']['w:val'] = $value;
		return $this;
    }

    public function hasGridSpan(){
        if($this->option['w:gridSpan']['@attributes']['w:val'] > 0){
            return true;
        }else{
            return false;
        }
    }

	
    /**
     * Create paragraph objects
     *
	 * @param callback $callback
     * @return $this;
     */
    public function createSection(callable $callback){
        if($callback){
            $wordSection = new wordSection();
            call_user_func($callback,$wordSection);
            $this->sections[] = $wordSection;
        }
		return $this;
    }

    /**
     * Getting paragraph object content
     *
     * @return string
     */
    private function getSections(){
        $sections = array();
        if($this->sections){
            foreach($this->sections as $wordSection){
                $sections[] = $wordSection->getSection();
            }
        }
        return implode("",$sections);
    }

    /**
     * Get table column object content
     *
     * @return string
     */
    public function getCell(){
        $wordAttributes = new wordAttributes();
        return sprintf('<w:tc><w:tcPr>%s</w:tcPr>%s</w:tc>',$wordAttributes->getNodes($this->option),$this->getSections());
    }

    /**
     * Batch addition of paragraph objects
     *
	 * @param array $sections
	 * @param int $index
     * @return $this
     */
    public function addSections($sections,$index = 0){
        if($sections){
            foreach($sections as $k=>$wordSection){
                $this->sections[$index + $k] = $wordSection;
            }
        }
        return $this;
    }

    /**
     * Get a list of paragraph objects
     *
     * @return array
     */
    public function getSectionsObj(){
        return $this->sections;
    }

    /**
     * Batch Setting Properties
     *
	 * @param array $option
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
        unset($this->sections,$this->option);
    }
}
?>