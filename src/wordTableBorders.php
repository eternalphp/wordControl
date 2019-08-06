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

    public function size($value){
        $this->option[$this->borderAttrName]['@attributes']['w:sz'] = $value;
		return $this;
    }

    public function space($value){
        $this->option[$this->borderAttrName]['@attributes']['w:space'] = $value;
		return $this;
    }

    public function color($value){
        $this->option[$this->borderAttrName]['@attributes']['w:color'] = ltrim($value,'#');
		return $this;
    }

    public function value($value){
        $this->option[$this->borderAttrName]['@attributes']['w:val'] = $value;
		return $this;
    }

    public function getAttrs(){
        return $this->option;
    }

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