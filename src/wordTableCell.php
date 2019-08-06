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

    public function width($value){
        $this->option['w:tcW']['@attributes']['w:w'] = $value;
    }

    public function getWidth(){
        return  $this->option['w:tcW']['@attributes']['w:w'];
    }

    public function gridSpan($value = 2){
        $this->option['w:gridSpan']['@attributes']['w:val'] = $value;
    }

    public function hasGridSpan(){
        if($this->option['w:gridSpan']['@attributes']['w:val'] > 0){
            return true;
        }else{
            return false;
        }
    }

    public function createSection(callable $callback){
        if($callback){
            $wordSection = new wordSection();
            call_user_func($callback,$wordSection);
            $this->sections[] = $wordSection;
        }
    }

    private function getSections(){
        $sections = array();
        if($this->sections){
            foreach($this->sections as $wordSection){
                $sections[] = $wordSection->getSection();
            }
        }
        return implode("",$sections);
    }

    public function getCell(){
        $wordAttributes = new wordAttributes();
        return sprintf('<w:tc><w:tcPr>%s</w:tcPr>%s</w:tc>',$wordAttributes->getNodes($this->option),$this->getSections());
    }

    public function addSections($sections,$index = 0){
        if($sections){
            foreach($sections as $k=>$wordSection){
                $this->sections[$index + $k] = $wordSection;
            }
        }
        return $this;
    }

    public function getSectionsObj(){
        return $this->sections;
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