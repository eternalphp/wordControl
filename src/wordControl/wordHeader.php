<?php

namespace wordControl;

//页眉
class wordHeader{

    private $pageHeader = '';
	private $sections = array();
    public function __construct(){
		$this->pageHeader = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:hdr xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14">%s</w:hdr>';
    }

    /**
     * Setting header text content
     *
     * @param  callback $callback
     * @return $this
     */
    public function createSection(callable $callback){
		if($callback){
			$wordSection = new wordSection();
			call_user_func($callback,$wordSection);
			$this->sections[] = $wordSection;
		}
		return $this;
    }

    /**
     * Get header content
     *
     * @return string
     */
    public function getHeader(){
		$sections = array();
        if($this->sections){
			foreach($this->sections as $wordSection){
				$sections[] = $wordSection->getSection();
			}
		}
		return sprintf($this->pageHeader,implode("",$sections));
    }
	
	public function __destruct(){
		unset($this->pageHeader,$this->sections);
	}
}
?>