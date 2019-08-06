<?php

namespace wordControl;

//表格行
class wordTableRow{

    private $option = array();
    private $cells = array(); //列
    public function __construct(){
		
    }

    public function createCell(callable $callback){
        if($callback){
            $wordTableCell = new wordTableCell();
            call_user_func($callback,$wordTableCell);
            $this->cells[] = $wordTableCell;
        }
    }

    public function getCells(){
        $cells = array();
        if($this->cells){
            foreach($this->cells as $wordTableCell){
                $cells[] = $wordTableCell->getCell();
            }
        }
        return implode("",$cells);
    }

    public function each(callable $callback){
        if($callback){
            foreach($this->cells as $index=>$wordTableCell){
                call_user_func($callback,$wordTableCell,$index);
            }
        }
    }

    public function getCellsObj(){
        return $this->cells;
    }

    public function addCells($cells = array(),$index = 0){
        if($cells){
            foreach($cells as $k=>$wordTableCell){
                $this->cells[$index + $k] = $wordTableCell;
            }
        }
        return $this;
    }

    public function getRow(){
        return sprintf('<w:tr>%s</w:tr>',$this->getCells());
    }

    public function setAttrs($option = array()){
        if($option){
            $this->option = array_merge($this->option,$option);
        }
        return $this;
    }

    public function __call($method,$args){
        $wordExcption = new wordException(sprintf('CLASS：%s, method %s is not exists!',__CLASS__,$method));
        $wordExcption->showError();
    }

	public function __destruct(){
        unset($this->cells,$this->option);
    }
}
?>