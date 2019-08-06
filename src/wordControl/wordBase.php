<?php

namespace wordControl;

//word基类
class wordBase{
	
	static $xmlElement = null;
	static $imageList = array();
	
    /**
     * Parsing XML objects
     *
     * @param  string $filename
     * @return string
     */
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
	
    /**
     * Adding Image Objects
     *
     * @param  string $filename
     * @return string
     */
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
	
    /**
     * Add header for word
     *
     * @return void
     */
	public static function addWordHeader(){
		
		wordBase::getXML();
		
		$childNode = wordBase::$xmlElement->addChild('Relationship');
		$nodeIndex = wordBase::getCount();
		$childNode->addAttribute('Id', 'rId' . $nodeIndex);
		$index = count(wordBase::$imageList);
		$childNode->addAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/header');
		$childNode->addAttribute('Target','header1.xml');
	}
	
    /**
     * Add footer for word
     *
     * @return void
     */
	public static function addWordFooter(){
		
		wordBase::getXML();
		
		$childNode = wordBase::$xmlElement->addChild('Relationship');
		$nodeIndex = wordBase::getCount();
		$childNode->addAttribute('Id', 'rId' . $nodeIndex);
		$index = count(wordBase::$imageList);
		$childNode->addAttribute('Type', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/footer');
		$childNode->addAttribute('Target','footer1.xml');
	}
	
    /**
     * Get a list of image objects
     *
     * @return array
     */
	public static function getImageList(){
		return self::$imageList;
	}
}
?>