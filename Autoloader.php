<?php
/**
 * WordContrl
 * @category   WordContrl
 * @package    WordContrl
 * @copyright  Copyright (c) 010 WordContrl
 * @version    Beta 0.0.1
 */

class Autoloader
{
	public static function Register() {
		return spl_autoload_register(array('Autoloader', 'Load'));
	}

	public static function Load($className) {
		if((class_exists($className)) || (strpos($className, 'word') === false)) {
			return false;
		}

		$classFilePath = __DIR__ . '/src/' . $className. '.php';
		
		if((file_exists($classFilePath) === false) || (is_readable($classFilePath) === false)) {
			return false;
		}
		
		require($classFilePath);
	}
}
?>