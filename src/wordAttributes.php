<?php

namespace wordControl;

//属性节点
class wordAttributes{

    public function __construct(){

    }

    public function getNodes($data = array()){
        $nodeLists = array();
        foreach($data as $name=>$vals){
            if(isset($vals['@attributes'])){
                $nodeLists[] = $this->getAttr($vals['@attributes'],$name);
            }else{
                if($vals){
                    $nodeLists[] = sprintf('<%s>%s</%s>',$name,$this->getNodes($vals),$name);
                }else{
                    $nodeLists[] = $this->getAttr([],$name);
                } 
            }
        }
        return implode("",$nodeLists);
    }

    public function getAttr($data,$nodeName = ''){
        $attrList = array();
        if($data){
            foreach($data as $name=>$val){
                $attrList[] = sprintf('%s="%s"',$name,$val);
            }
        }
        return sprintf("<%s %s />",$nodeName,implode(" ",$attrList));
    }
}
?>