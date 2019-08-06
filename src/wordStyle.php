<?php

namespace wordControl;

//文本样式
class wordStyle{

    private $option = array();
    public function __construct(){
        $this->option = array(
            'w:rFonts'=>array(
                '@attributes'=>array(
                    'w:ascii'=>'Arial',
                    'w:cs'=>'Arial',
                    'w:eastAsia'=>'Times New Roman',
                    'w:hAnsi'=>'Arial',
                    'w:hint'=>'eastAsia'
                )
            ),
            'w:color'=>array(
                '@attributes'=>array(
                    'w:val'=>'333333'
                )
            ),
            'w:sz'=>array(
                '@attributes'=>array(
                    'w:val'=>'21'
                )
            ),
            'w:szCs'=>array(
                '@attributes'=>array(
                    'w:val'=>'21'
                )
            ),
            'w:spacing'=>array(
                '@attributes'=>array(
                    'w:val'=>'0'
                )
            )
        );  
    }

    public function font($value = 'Arial'){
		foreach($this->option['w:rFonts']['@attributes'] as $key=>$val){
			$this->option['w:rFonts']['@attributes'][$key] = $value;
		}
		return $this;
    }

    public function color($value = '333333'){
        $this->option['w:color']['@attributes']['w:val'] = ltrim($value,'#');
		return $this;
    }

    public function size($value){
        $this->option['w:sz']['@attributes']['w:val'] = (intval($value) * 2);
        $this->option['w:szCs']['@attributes']['w:val'] = (intval($value) * 2);
		return $this;
    }

    //字间距
    public function spacing($value){
        $this->option['w:spacing']['@attributes']['w:val'] = intval($value);
		return $this;
    }

    //加粗
    public function bold(){
        $this->option['w:b']['@attributes']['w:val'] = 'on';
		return $this;
    }

    //斜体
    public function italic(){
        $this->option['w:i']['@attributes']['w:val'] = 'on';
		return $this;
    }

    //下划线
    public function underline(){
        $this->option['w:u']['@attributes']['w:val'] = 'on';
		return $this;
    }

    //删除线
    public function deleteline(){
        $this->option['w:strike']['@attributes']['w:val'] = 'on';
		return $this;
    }

    public function getAttrs(){
        return $this->option;
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