<?php

namespace wordControl;

//段落底部属性
class wordSectionBottom{

    private $option = array();
    public function __construct(){
        $this->option = array(
            'w:bottom'=>array(
                '@attributes'=>array(
                    'w:val'=>'single',
                    'w:sz'=>'12',
                    'w:space'=>'2',
                    'w:color'=>'auto'
                )
            )
        );    
    }

    public function size($value){
        $this->option['w:bottom']['@attributes']['w:sz'] = $value;
		return $this;
    }

    public function space($value){
        $this->option['w:bottom']['@attributes']['w:space'] = $value;
		return $this;
    }

    public function color($value){
        $this->option['w:bottom']['@attributes']['w:color'] = $value;
		return $this;
    }

    public function value($value){
        $this->option['w:bottom']['@attributes']['w:val'] = $value;
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
        unset($this->option);
    }
}
?>