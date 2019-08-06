<?php

namespace wordControl;

require(__DIR__ .'/Autoloader.php');

Autoloader::Register();

//word操作类
class wordControl{

    private $sectionLists = array();//段落对象
    private $pageAttr = '<w:sectPr>%s %s %s</w:sectPr>';
    private $pageHeader = ''; //页眉标签
    private $pageFooter = ''; //页脚标签
	private $wordHeader = null; //页眉对象
	private $wordFooter = null; //页脚对象
    private $filename = 'tempFileName.docx';
    private $documentXML = '';
    private $templeteList = array(); //段落模板
    private $sectionTextList = array(); //文本列表
    private $option = array();

    public function __construct(){
        $this->xmlTag = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $this->headerTag = '<w:document xmlns:wpc="http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp14="http://schemas.microsoft.com/office/word/2010/wordprocessingDrawing" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:w14="http://schemas.microsoft.com/office/word/2010/wordml" xmlns:w15="http://schemas.microsoft.com/office/word/2012/wordml" xmlns:wpg="http://schemas.microsoft.com/office/word/2010/wordprocessingGroup" xmlns:wpi="http://schemas.microsoft.com/office/word/2010/wordprocessingInk" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml" xmlns:wps="http://schemas.microsoft.com/office/word/2010/wordprocessingShape" mc:Ignorable="w14 w15 wp14">';
        $this->bodyTag = '<w:body>%s %s</w:body>';
        $this->endTag = '</w:document>';

        $this->option = array(
            'w:pgSz'=>array(
                '@attributes'=>array(
                    'w:w'=>'11906',
                    'w:h'=>'16838'
                )
            ),
            'w:pgMar'=>array(
                '@attributes'=>array(
                    'w:top'=>'1814',
                    'w:right'=>'1474',
                    'w:bottom'=>'1729',
                    'w:left'=>'1588',
                    'w:header'=>'851',
                    'w:footer'=>'1418',
                    'w:gutter'=>'0'
                )
            ),
            'w:cols'=>array(
                '@attributes'=>array(
                    'w:space'=>'720'
                )
            ),
            'w:docGrid'=>array(
                '@attributes'=>array(
                    'w:type'=>'lines',
                    'w:linePitch'=>'579'
                )
            )
        );
    }
	
	//创建页眉
    public function createPageHeader(callable $callback){
		if($callback){
			$wordHeader = new wordHeader();
			call_user_func($callback,$wordHeader);
			$this->wordHeader = $wordHeader;
			
			$nodeIndex = wordBase::getCount();
			$this->pageHeader = sprintf('<w:headerReference w:type="default" r:id="rId%d" />', $nodeIndex + 1);
			wordBase::addWordHeader();
		}
        return $this;
    }

	//创建页脚
    public function createPageFooter(callable $callback){
		if($callback){
			$wordFooter = new wordFooter();
			call_user_func($callback,$wordFooter);
			$this->wordFooter = $wordFooter;
			
			$nodeIndex = wordBase::getCount();
			$this->pageHeader = sprintf('<w:footerReference w:type="default" r:id="rId%d" />', $nodeIndex + 1);
			wordBase::addWordFooter();
		}
        return $this;
    }

    //创建段落
    public function createSection(callable $callback){
        if($callback){
			$wordSection = new wordSection();
            call_user_func($callback,$wordSection);
			$this->sectionLists[] = array(
                'type'=>'section',
                'section'=>$wordSection
            );
        }
        return $this;
    }

    //创建段落模板
    public function createTemplate($name){
        if ($this->sectionLists) {
            $this->templeteList[$name] = end($this->sectionLists);
        }
        return $this;
    }

    //为模板设置内容
    public function templateText($name,$text){
        if (isset($this->templeteList[$name])) {
            $wordSection = clone $this->templeteList[$name]['section'];
            foreach ($wordSection->getSectionTexts() as $wordText) {
                $newWordText = clone $wordText;
                $newWordText->text($text);
                $wordSection->addText($newWordText);
            }
            $this->sectionLists[] = array('type'=>'section','section'=>$wordSection);
        }
        return $this;
    }

    //创建表格
    public function createTable(callable $callback){
        if($callback){
			$wordTable = new wordTable();
            call_user_func($callback,$wordTable);
            $this->sectionLists[] = array(
                'type'=>'table',
                'section'=>$wordTable
            );
        }
    }
	
	//创建word文档内容
    public function createXML(){
        $sectionsList = array();
        if($this->sectionLists){
            foreach($this->sectionLists as $section){
                if ($section['type'] == 'section') {
                    $sectionsList[] = $section['section']->getSection();
                }elseif($section['type'] == 'table'){
                    $sectionsList[] = $section['section']->getTable();
                }
            }
        }

        $wordAttributes = new wordAttributes();
        $this->pageAttr = sprintf($this->pageAttr,$wordAttributes->getNodes($this->option),$this->pageHeader,$this->pageFooter);

        $this->bodyTag = sprintf($this->bodyTag,implode("",$sectionsList),$this->pageAttr);
        return $this;
    }
	
	//生成word文档
    public function save($filename = ''){
        if($filename != ''){
            $this->filename = $filename;
        }
        $this->documentXML = $this->xmlTag . $this->headerTag . $this->bodyTag . $this->endTag;
		$zip = new ZipArchive();
        $templateFile = __DIR__ . "/static/template.docx";
        $tempFileName = __DIR__ . sprintf("/tempFileName_%d.docx",time());
        copy($templateFile,$tempFileName);
		
        if($zip->open($tempFileName,ZipArchive::CREATE) == true){
            $zip->addFromString('word/document.xml', $this->documentXML);
			
            if(wordBase::getImageList()){
				foreach (wordBase::getImageList() as $index=>$filename) {
					$zip->addFromString(sprintf("word/media/image%d.jpg", $index + 1), file_get_contents($filename));
				}
            }
			
			if($this->wordHeader != null){
				$zip->addFromString('word/header1.xml',$this->wordHeader->getHeader());
			}
			
			if($this->wordFooter != null){
				$zip->addFromString('word/footer1.xml',$this->wordFooter->getHeader());
			}
			
			if(wordBase::$xmlElement != null){
				$zip->addFromString('word/_rels/document.xml.rels',wordBase::getXML()->asXML());
			}
			$zip->close();
        }
        
		
		try{
			if(file_exists(dirname($this->filename))){
				if(file_exists($this->filename)){
					unlink($this->filename);
				}
				@rename($tempFileName,$this->filename);
			}else{
				unlink($tempFileName);
				throw new wordException('Word file path does not exist！');
			}
		}catch(wordException $e){
			$e->showError();
		}

        return $this;
    }

	//加载word文档
    public function load($filename){
        if(file_exists($filename)){
            $this->zip = new ZipArchive();
            $this->zip->open($filename);
            $xml = $this->zip->getFromName('word/document.xml');
            $this->documentXML = $xml;
        }
        return $this;
    }
	
	//解析word文档
    public function parseWord(){

        if ($this->documentXML != '') {
            $xml = strtr($this->documentXML, array('w:'=>'w_'));
            $wordXml = new DOMDocument("1.0", "UTF-8");
            $wordXml->loadXML($xml);
            $root = $wordXml->documentElement;
            foreach ($root->childNodes[0]->childNodes as $key=>$childNode) {
   
                switch($childNode->tagName){

                    case 'w_p':
                        $this->childNode = simplexml_import_dom($childNode);
                        $this->childNode = $this->simplexmlToArray($this->childNode);

                        //判断是否有图片
                        $images = $childNode->getElementsByTagName('w_drawing');
                        if($images->length > 0){
                            $imageBlips = $images->item(0)->getElementsByTagName('blip');
                            $imageID = $imageBlips->item(0)->getAttribute('r:embed');

                            $xml = $this->zip->getFromName('word/_rels/document.xml.rels');
                            $nodes = new SimpleXMLElement($xml);
                            foreach($nodes->children() as $child){
                                $child = (array)$child;
                                if($child['@attributes']['Id'] == $imageID){
                                   $imagePath = 'word/'.$child['@attributes']['Target'];
                                   $this->sectionTextList[] = array('image'=>base64_encode($this->zip->getFromName($imagePath)));
                                }
                            }
                        }else{
                            $this->createSection(function ($wordSection) {
                                $wordSection->setAttrs($this->childNode['w:pPr']);

                                $this->sectionTexts = array();

                                foreach ($this->childNode as $nodeName=>$nodes) {
                                    if ($nodeName == 'w:r') {
                                        $wordSection =  $this->parseWordText($wordSection, $this->childNode['w:r'], $this->sectionTexts);
                                    } elseif ($nodeName == 'w:hyperlink') {
                                        $wordSection = $this->parseWordLink($wordSection, $this->childNode['w:hyperlink'], $this->sectionTexts);
                                    }
                                }

                                $this->sectionTextList[] = array('section'=>implode('', $this->sectionTexts));
                            });
                        }
                    break;
         
                    case 'w_tbl':
                        $childNode = simplexml_import_dom($childNode);
                        $this->childNode = $this->simplexmlToArray($childNode);

                        $this->createTable(function ($wordTable) {
                            $wordTable->setAttrs($this->childNode['w:tblPr']);

                            $this->table = array();
                            foreach ($this->childNode['w:tr'] as $rowIndex=>$row) {
                                $wordTable->createRow(function ($wordTableRow) use ($row,$rowIndex) {
                                    foreach ($row['w:tc'] as $cellIndex=>$cell) {
                                        $wordTableRow->createCell(function ($wordTableCell) use ($cell,$rowIndex,$cellIndex) {
                                            $wordTableCell->setAttrs($cell['w:tcPr']);
                                            $wordTableCell->createSection(function ($wordSection) use ($cell,$rowIndex,$cellIndex) {
                                                $wordSection->setAttrs($cell['w:p']['w:pPr']);
                                                $wordSection =  $this->parseWordText($wordSection,$cell['w:p']['w:r'],$this->table[$rowIndex][$cellIndex]);

                                            });
                                        });
                                    }
                                });
                            }
                        });

                        $this->sectionTextList[] = array('table'=>$this->table);
                    break;
                
                }
            }
        }

        return $this;
    }

    //解析段落文本
    private function parseWordText($wordSection,$word,&$texts = null){

        if (isset($word['w:t'])) {
            $wordSection->createText(function ($wordText) use ($word,&$texts) {
                $text = ' ';
                if (is_string($word['w:t'])) {
                    $text = $word['w:t'];
                }
                $wordText->text($text);
                $texts[] = $text;
                $wordText->setAttrs($word['w:rPr']);
            });
        }else{

            if ($word) {
                foreach ($word as $subWord) {
                    $wordSection->createText(function ($wordText) use ($subWord,&$texts) {
                        $text = ' ';
                        if (is_string($subWord['w:t'])) {
                            $text = $subWord['w:t'];
                        }
                        $wordText->text($text);
                        $texts[] = $text;
                        $wordText->setAttrs($subWord['w:rPr']);
                    });
                }
            }
        }

        return $wordSection;
    }

    //解析链接文本
    private function parseWordLink($wordSection,$word,&$texts = null){
        $wordSection->createLink(function ($wordLink) use ($word,&$texts) {

            if (isset($word['w:r']['w:t'])) {

                $wordLink->createText(function ($wordText) use ($word,&$texts) {
                    $text = ' ';
                    if (is_string($word['w:r']['w:t'])) {
                        $text = $word['w:r']['w:t'];
                    }
                    $wordText->text($text);
                    $texts[] = $text;
                    $wordText->setAttrs($word['w:r']['w:rPr']);
                });

            }else{
                if ($word['w:r']) {
                    foreach ($word['w:r'] as $subWord) {
                        $wordLink->createText(function ($wordText) use ($subWord,&$texts) {
                            $text = ' ';
                            if (is_string($subWord['w:t'])) {
                                $text = $subWord['w:t'];
                            }
                            $wordText->text($text);
                            $texts[] = $text;
                            $wordText->setAttrs($subWord['w:rPr']);
                        });
                    }
                }
            }

        });
        return $wordSection;
    }
	
	//对象转数组
    private function simplexmlToArray($data){
        if (is_object($data)) {
            $data = (array) $data;
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_object($value) || is_array($value)) {
                    unset($data[$key]);
                    $key = str_replace('w_','w:',$key);
                    $data[$key] = $this->simplexmlToArray($value);
                }else{
                    unset($data[$key]);
                    $key = str_replace('w_','w:',$key);
                    $data[$key] = $value;
                }
            }
        }
        return $data;
    }
	
	//获取当前文档的文本列表
    public function getWordSections(){
        return $this->sectionTextList;
    }
	
	//获取当前文档的对象列表
    public function getWordSectionLists(){
        return $this->sectionLists;
    }
	
	//获取指定段落对象
    public function getWordSectionItem($index = 0){
        return $this->sectionLists[$index];
    }
	
	//获取word文档的xml结构
    public function getXML(){
        return $this->documentXML;
    }
	
	//打印xml结构
    public function printXML(){
        echo $this->documentXML;
    }

	//下载文档
    public function output(){
        $fileinfo = pathinfo($this->filename);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($this->filename));
        readfile($this->filename);
        exit;
    }	
    
    public function __call($method,$args){
        $wordExcption = new wordException(sprintf('CLASS：%s, method %s is not exists!',__CLASS__,$method));
        $wordExcption->showError();
    }

	public function __destruct(){
        unset($this->sectionLists,$tables,$this->option,$this->templeteList);
    }
}
?>