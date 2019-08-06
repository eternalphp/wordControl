<?php

namespace wordControl;

//异常
class wordException extends Exception {
    private $level = 0;
	private $debug = true;
    function __construct($message) {
        $this->level = ob_get_level();
        parent::__construct($message, $this->level);
    }
	
    private function _toLogFile() {
        $path = dirname(__DIR__) . '/logs/' . date("Y/md/");
        if (!file_exists($path)){
			mkdir($path, 0777, true);
		}
        $message             = array();
        $message['time']     = date("Y-m-d H:i:s");
        $message['leave'] = parent::getCode();
        $message['file'] = parent::getFile();
        $message['line']     = parent::getLine();
        $message['message']  = parent::GetMessage();
        $filename            = $path . date("Ymd") . ".log";
        @error_log(implode(" | ", $message) . "\r\n", 3, $filename);
		exit;
    }
	
    public function showError() {
		if($this->debug == true){
			ob_start();
			$message = array();
			$message['file'] = str_replace(dirname(dirname(__DIR__)),'',$this->getFile());
			$traces = $this->getTrace();
			foreach($traces as $k=>&$val){
				$val['file'] = str_replace(dirname(dirname(__DIR__)),'',$val['file']);
			}
			$message['traces'] = $traces;
			include(__DIR__ . '/templateError.php');
			$buffer = ob_get_contents();
			ob_end_clean();
			echo $buffer;
			exit;
		}else{
			$this->_toLogFile();
		}
    }
    
}
?>