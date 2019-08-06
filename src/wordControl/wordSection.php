<?php

namespace wordControl;

//段落
class wordSection{

    private $option = array(); //段落属性
    private $texts = array(); //文本对象
    private $images = array(); //图片对象
    private $links = array(); //链接对象

    public function __construct(){
        $this->option = array(
            'w:jc'=>array(
                '@attributes'=>array(
                    'w:val'=>'left'
                )
            ),
            'w:widowControl'=>[],
            'w:spacing'=>array(
                '@attributes'=>array(
                    'w:color'=>'auto',
                    'w:fill'=>'FFFFFF',
                    'w:val'=>"clear",
                    'w:before'=>0,
                    'foreAutospacing'=>0,
                    'w:after'=>0,
                    'w:afterAutospacing'=>0,
                    'w:line'=>'240',
                    'w:lineRule'=>'auto'
                )
            ),
            'w:pStyle'=>array(
                '@attributes'=>array(
                    'w:val'=>'ad'
                )
            ),
            'w:shd'=>array(
                '@attributes'=>array(
                    'w:val'=>'clear',
                    'w:color'=>'auto',
                    'w:fill'=>'FFFFFF',
                )
            ),
            'w:ind'=>array(
                '@attributes'=>array(
                    'w:firstLine'=>'0'
                )
            )
        );
    }

    /**
     * Setting text alignment
     *
     * @param  string $value
     * @return $this
     */
    public function align($value = 'left'){
        $this->option['w:jc']['@attributes']['w:val'] = $value;
		return $this;
    }

    /**
     * Setting Paragraph Line Spacing
     *
     * @param  string $value
     * @return $this
     */
    public function spacing($value){
        $this->option['w:spacing']['@attributes']['w:line'] =  (intval($value) * 240);
		return $this;
    }

    /**
     * Set the first line spacing of a paragraph
     *
     * @param  string $value
     * @return $this
     */
    public function ind($value){
        $this->option['w:ind']['@attributes']['w:firstLine'] = (intval($value) * 240);
		return $this;
    }
	
    /**
     * Set the first line spacing of a paragraph
     *
     * @param  string $value
     * @return $this
     */
    public function pStyle($value = 1){
        $this->option['w:pStyle']['@attributes']['w:val'] = $value;
		return $this;
    }

    /**
     * Modify the bottom attributes of a paragraph
     * 
	 * 'w:val'=>'single',
	 * 'w:sz'=>'12',
	 * 'w:space'=>'2',
	 * 'w:color'=>'auto'
     * @param  callable $callback
     * @return $this
     */
    public function bottom(callable $callback){
        if($callback){
            $wordSectionBottom = new wordSectionBottom();
            call_user_func($callback,$wordSectionBottom);
            $this->option['w:pBdr'] = $wordSectionBottom->getAttrs();
        }
		return $this;
    }

    /**
     * Create text objects
     *
     * @param  callable $callback
     * @return $this
     */
    public function createText(callable $callback){
        if($callback){
			$wordText = new wordText();
			call_user_func($callback,$wordText);
			$this->texts[] = $wordText;
        }
        return $this;
    }

    /**
     * Create image objects
     *
     * @param  callable $callback
     * @return $this
     */
    public function createImage(callable $callback){
        if($callback){
            $wordImage = new wordImage();
            call_user_func($callback,$wordImage);
            $this->images[] = $wordImage;
        }
        return $this;
    }
	
    /**
     * Creating Link Objects
     *
     * @param  callable $callback
     * @return $this
     */
    public function createLink(callable $callback){
        if($callback){
            $wordLink = new wordLink();
            call_user_func($callback,$wordLink);
            $this->links[] = $wordLink;
        }
        return $this;
    }

    /**
     * Getting text content
     *
     * @return string
     */
    public function getTexts(){
        $textNode = array();
        if($this->texts){
            foreach($this->texts as $wordText){
                $textNode[] = $wordText->getText();
            }
        }

        if($this->images){
            foreach($this->images as $wordImage){
                $textNode[] = $wordImage->getImage();
            }
        }

        if($this->links){
            foreach($this->links as $wordLink){
                $textNode[] = $wordLink->getLink();
            }
        }

        return implode("",$textNode);
    }

    /**
     * Get a list of text objects for the current paragraph
     *
     * @return objects
     */
    public function getSectionTexts(){
        return $this->texts;
    }

    /**
     * Adding text objects at specified locations
     *
	 * @param wordText $wordText
	 * @param int $index
     * @return $this
     */
    public function addText(wordText $wordText,$index = 0){
        $this->texts[$index] = $wordText;
        return $this;
    }

    /**
     * Modifying text objects
     *
	 * @param wordText $wordText
     * @return $this
     */
    public function updateText(wordText $wordText){
        unset($this->texts);
        $this->texts[] = $wordText;
        return $this;
    }

    /**
     * Replace the text under the paragraph
     *
	 * @param string $keyword
	 * @param string $newText
     * @return $this
     */
    public function replaceText($keyword,$newText){
        foreach($this->texts as $wordText){
            $text = $wordText->getTexts();
            if(strstr($text,$keyword)){
               $text = str_replace($keyword,$newText,$text);
               $wordText->text($text);
            }
        }
        return $this;
    }
	
    /**
     * Text under query paragraph
     *
	 * @param string $keyword
     * @return bool
     */
    public function searchText($keyword){
        $texts = array();
        foreach($this->texts as $wordText){
            $texts[] = $wordText->getTexts();
        }
        $sectionText = implode("",$texts);
        if(strstr($sectionText,$keyword)){
            return true;
        }else{
            return false;
        }
    }
	
    /**
     * Modify paragraph attributes
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
	
    /**
     * Getting paragraph content
     *
     * @return string
     */
    public function getSection(){
        $wordAttributes = new wordAttributes();
        return sprintf('<w:p><w:pPr>%s</w:pPr>%s</w:p>',$wordAttributes->getNodes($this->option),$this->getTexts());
    }
	
    /**
     * Getting Picture Objects
     *
     * @return objects
     */
	public function getImages(){
		return $this->images;
	}

    public function __call($method,$args){
        $wordExcption = new wordException(sprintf('CLASS：%s, method %s is not exists!',__CLASS__,$method));
        $wordExcption->showError();
    }
	
	public function __destruct(){
        unset($this->tests,$this->option);
    }
}
?>