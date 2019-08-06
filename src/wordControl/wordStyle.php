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

    /**
     * Setting Text Font
     *
     * @param  string $value
     * @return $this
     */
    public function font($value = 'Arial'){
		foreach($this->option['w:rFonts']['@attributes'] as $key=>$val){
			$this->option['w:rFonts']['@attributes'][$key] = $value;
		}
		return $this;
    }

    /**
     * Setting Text Colors
     *
     * @param  string $value
     * @return $this
     */
    public function color($value = '333333'){
        $this->option['w:color']['@attributes']['w:val'] = ltrim($value,'#');
		return $this;
    }

    /**
     * Setting text size
     *
     * @param  string $value
     * @return $this
     */
    public function size($value){
        $this->option['w:sz']['@attributes']['w:val'] = (intval($value) * 2);
        $this->option['w:szCs']['@attributes']['w:val'] = (intval($value) * 2);
		return $this;
    }

    /**
     * Setting Text Word Spacing
     *
     * @param  string $value
     * @return $this
     */
    public function spacing($value){
        $this->option['w:spacing']['@attributes']['w:val'] = intval($value);
		return $this;
    }

    /**
     * Setting Text Coarsening
     *
     * @return $this
     */
    public function bold(){
        $this->option['w:b']['@attributes']['w:val'] = 'on';
		return $this;
    }

    /**
     * Setting text italics
     *
     * @return $this
     */
    public function italic(){
        $this->option['w:i']['@attributes']['w:val'] = 'on';
		return $this;
    }

    /**
     * Setting Text Underlines
     *
     * @return $this
     */
    public function underline(){
        $this->option['w:u']['@attributes']['w:val'] = 'on';
		return $this;
    }

    /**
     * Setting Text Delete Line
     *
     * @param  string $value
     * @return $this
     */
    public function deleteline(){
        $this->option['w:strike']['@attributes']['w:val'] = 'on';
		return $this;
    }

    /**
     * Getting attribute objects
     *
     * @return array
     */
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