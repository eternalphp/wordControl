<?php

namespace wordControl;

use wordControl\wordStyle;
use wordControl\wordException;
use wordControl\wordAttributes;

//文本
class wordText{

    private $option = array(); //文本属性
    private $text = ''; //文本内容
    private $space = false; //是否空白内容
	
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
                    'w:val'=>'21'
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
		$this->option['w:spacing']['@attributes']['w:val'] = intval($value);
		return $this;
    }
	
    /**
     * Get font size values
     *
	 * @param string $size
     * @return object
     */
	public function getFontSize($fontSize){
		$fontSizeList = array(
			'初号'=>42,
			'小初'=>36,
			'一号'=>26,
			'小一'=>24,
			'二号'=>22,
			'小二'=>18,
			'三号'=>16,
			'小三'=>15,
			'四号'=>14,
			'小四'=>12,
			'五号'=>10.5,
			'六号'=>7.5,
			'小六'=>6.5,
			'七号'=>5.5,
			'八号'=>5
		);
		return isset($fontSizeList[$fontSize]) ? $fontSizeList[$fontSize] : $fontSize['五号'];
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
        $this->option['w:u']['@attributes']['w:val'] = 'single';
		return $this;
    }
	
    /**
     * Setting Text Underlines
     *
     * @return $this
     */
    public function underlines(){
        $this->option['w:u']['@attributes']['w:val'] = 'double';
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
     * Setting Text style
     *
     * @param  wordStyle $wordStyle
     * @return $this
     */
    public function style(wordStyle $wordStyle){
        if($wordStyle){
            $this->option = array_merge($this->option,$wordStyle->getAttrs());
        }
        return $this;
    }

    /**
     * Setting Text Properties
     *
     * @param  array $option
     * @return $this
     */
    public function setAttrs($option = array()){
        if($option){
            $this->option = array_merge($this->option,$option);
        }
        return $this;
    }

    /**
     * Setting Text Content
     *
     * @param  array $option
     * @return $this
     */
    public function text($value = ''){
        $this->text = $value;
		return $this;
    }

    /**
     * Setting Text Spacing
     *
     * @return $this
     */
    public function space(){
        $this->space = true;
        return $this;
    }

    /**
     * Getting text objects
     *
     * @return array
     */
    public function getTexts(){
        return $this->text;
    }

    /**
     * Getting text object content
     *
     * @return string
     */
    public function getText(){
        $wordAttributes = new wordAttributes();
        if ($this->space == false) {
            return sprintf('<w:r><w:rPr>%s</w:rPr><w:t>%s</w:t></w:r>', $wordAttributes->getNodes($this->option), $this->text);
        }else{
            return sprintf('<w:r><w:rPr>%s</w:rPr><w:t xml:space="preserve">%s</w:t></w:r>', $wordAttributes->getNodes($this->option), $this->text);
        }
    }

    public function __call($method,$args){
        $wordExcption = new wordException(sprintf('CLASS：%s, method %s is not exists!',__CLASS__,$method));
        $wordExcption->showError();
    }

	public function __destruct(){
        unset($this->text,$this->option);
    }

}
?>