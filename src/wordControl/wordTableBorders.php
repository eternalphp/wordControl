<?php

namespace wordControl;

//表格边框属性
class wordTableBorders{
    private $option = array();
    private $borderAttrName = 'w:top';
    public function __construct(){
        $this->option = array(
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
        );    
    }

    public function get($borderAttrName){
        $this->borderAttrName = sprintf('w:%s',ltrim($borderAttrName,'w:'));
        return $this;
    }

    /**
     * Set Form Border Size
     *
     * @param  int $value
     * @return $this
     */
    public function size($value){
        $this->option[$this->borderAttrName]['@attributes']['w:sz'] = $value;
		return $this;
    }

    /**
     * Set the margin spacing of the table
     *
     * @param  int $value
     * @return $this
     */
    public function space($value){
        $this->option[$this->borderAttrName]['@attributes']['w:space'] = $value;
		return $this;
    }

    /**
     * Set the border color of the table
     *
     * @param  int $value
     * @return $this
     */
    public function color($value){
        $this->option[$this->borderAttrName]['@attributes']['w:color'] = ltrim($value,'#');
		return $this;
    }

    /**
     * Set the border value of the table
     *
     * @param  int $value
     * @return $this
     */
    public function value($value){
        $this->option[$this->borderAttrName]['@attributes']['w:val'] = $value;
		return $this;
    }

	
    /**
     * Get a list of table border properties
     *
     * @return $this
     */
    public function getAttrs(){
        return $this->option;
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