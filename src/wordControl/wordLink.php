<?php

namespace wordControl;

//链接
class wordLink{

    private $option = array();
    private $texts = array();
    public function __construct(){

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
     * Getting text content
     *
     * @return string
     */
    public function getTexts(){
        $texts = array();
        if($this->texts){
            foreach($this->texts as $wordText){
                $texts[] = $wordText->getText();
            }
        }
        return implode("",$texts);
    }

    /**
     * Getting Link Object Content
     *
     * @return string
     */
    public function getLink(){
        return sprintf('<w:hyperlink>%s</w:hyperlink>',$this->getTexts());
    }
}
?>