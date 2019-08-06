<?php

namespace wordControl;

//word基类
class wordBase{
	
	static $xmlElement = null;
	static $imageList = array();
	
	public static function getXML($filename = 'document.xml.rels'){
		if(wordBase::$xmlElement == null){
			$xml = file_get_contents(dirname(__DIR__).'/static/'.$filename);
			wordBase::$xmlElement = new SimpleXMLElement($xml);
		}
		return wordBase::$xmlElement;
	}
	
	public static function getCount(){
		wordBase::getXML();
		return count(wordBase::$xmlElement->children());
	}
	
	public static function addWordImage($filename){
		if(file_exists($filename)){
			self::$imageList[] = $filename;
			
			wordBase::getXML();
			
			$childNode = wordBase::$xmlElement->addChild('Relationship');
			$nodeIndex = wordBase::getCount();
			$childNode->addAttribute('Id', 'rId' . $nodeIndex);
			$index = count(wordBase::$imageList);
			$childNode->addAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image');
			$childNode->addAttribute('Target', sprintf("media/image%d.jpg", $index));
		}
	}
	
	public static function addWordHeader(){
		
		wordBase::getXML();
		
		$childNode = wordBase::$xmlElement->addChild('Relationship');
		$nodeIndex = wordBase::getCount();
		$childNode->addAttribute('Id', 'rId' . $nodeIndex);
		$index = count(wordBase::$imageList);
		$childNode->addAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/header');
		$childNode->addAttribute('Target','header1.xml');
	}
	
	public static function addWordFooter(){
		
		wordBase::getXML();
		
		$childNode = wordBase::$xmlElement->addChild('Relationship');
		$nodeIndex = wordBase::getCount();
		$childNode->addAttribute('Id', 'rId' . $nodeIndex);
		$index = count(wordBase::$imageList);
		$childNode->addAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer');
		$childNode->addAttribute('Target','footer1.xml');
	}
	
	public static function getImageList(){
		return self::$imageList;
	}
}
?>