<?php

namespace wordControl;

//段落
class wordSection{

    private $option = array(); //段落属性
    private $texts = array(); //文本对象
    private $images = array(); //图片对象
    private $links = array();

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
        $this->option['w:spacing']['@attributes']['w:line'] = (intval($value) * 240);
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

    /*******************************************
        'w:val'=>'single',
        'w:sz'=>'12',
        'w:space'=>'2',
        'w:color'=>'auto'
    ********************************************/
    public function bottom(callable $callback){
        if($callback){
            $wordSectionBottom = new wordSectionBottom();
            call_user_func($callback,$wordSectionBottom);
            $this->option['w:pBdr'] = $wordSectionBottom->getAttrs();
        }
		return $this;
    }

	//创建文本对象
    public function createText(callable $callback){
        if($callback){
			$wordText = new wordText();
			call_user_func($callback,$wordText);
			$this->texts[] = $wordText;
        }
        return $this;
    }

	//创建图片对象
    public function createImage(callable $callback){
        if($callback){
            $wordImage = new wordImage();
            call_user_func($callback,$wordImage);
            $this->images[] = $wordImage;
        }
        return $this;
    }
	
	//创建链接对象
    public function createLink(callable $callback){
        if($callback){
            $wordLink = new wordLink();
            call_user_func($callback,$wordLink);
            $this->links[] = $wordLink;
        }
        return $this;
    }

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

    //获取当前段落文本对象列表
    public function getSectionTexts(){
        return $this->texts;
    }

    //在指定位置添加文本对象
    public function addText(wordText $wordText,$index = 0){
        $this->texts[$index] = $wordText;
        return $this;
    }

    //修改文本对象
    public function updateText(wordText $wordText){
        unset($this->texts);
        $this->texts[] = $wordText;
        return $this;
    }

    //替换段落下的文本
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
	
	//查询文本
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
	
	//修改属性
    public function setAttrs($option = array()){
        if($option){
            $this->option = array_merge($this->option,$option);
        }
        return $this;
    }
	
	//获取段落节点
    public function getSection(){
        $wordAttributes = new wordAttributes();
        return sprintf('<w:p><w:pPr>%s</w:pPr>%s</w:p>',$wordAttributes->getNodes($this->option),$this->getTexts());
    }
	
	//获取图片对象
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