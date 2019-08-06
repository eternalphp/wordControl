<?php

namespace wordControl;

//图片
class wordImage{

    private $image = '';
    public function __construct(){
        $this->image = '<w:r><w:rPr><w:noProof/></w:rPr><w:drawing><wp:inline distT="0" distB="0" distL="0" distR="0"><wp:extent cx="1238596" cy="1238596"/><wp:effectExtent l="0" t="0" r="0" b="0"/><wp:docPr id="%d" name="图片 %d"/><wp:cNvGraphicFramePr><a:graphicFrameLocks xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" noChangeAspect="1"/></wp:cNvGraphicFramePr><a:graphic xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main"><a:graphicData uri="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:pic xmlns:pic="http://schemas.openxmlformats.org/drawingml/2006/picture"><pic:nvPicPr><pic:cNvPr id="%d" name="%s"/><pic:cNvPicPr/></pic:nvPicPr><pic:blipFill><a:blip r:embed="rId%d"><a:extLst><a:ext uri="{28A0092B-C50C-407E-A947-70E740481C1C}"><a14:useLocalDpi xmlns:a14="http://schemas.microsoft.com/office/drawing/2010/main" val="0"/></a:ext></a:extLst></a:blip><a:stretch><a:fillRect/></a:stretch></pic:blipFill><pic:spPr><a:xfrm><a:off x="0" y="0"/><a:ext cx="1238596" cy="1238596"/></a:xfrm><a:prstGeom prst="rect"><a:avLst/></a:prstGeom></pic:spPr></pic:pic></a:graphicData></a:graphic></wp:inline></w:drawing></w:r>';
    }

    /**
     * Create image objects
     *
     * @param  string $filename
     * @return void
     */
    public function image($filename){
        if(file_exists($filename)){
            wordBase::addWordImage($filename);
            $imageIndex = count(wordBase::getImageList());
            $nodeIndex = wordBase::getCount();
            $nodeNum = $nodeIndex + $imageIndex;
            $this->image = sprintf($this->image,$imageIndex,$imageIndex,$imageIndex,basename($filename),$nodeNum);
        }
    }

    /**
     * Getting Picture Objects
     *
     * @return objects
     */
    public function getImage(){
        return $this->image;
    }
}
?>