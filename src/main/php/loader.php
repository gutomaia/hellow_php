<?php
if (!function_exists('__autoload')){
	function __autoload($classname){
		$path = explode('_',$classname);
		$pathStr = implode(DIRECTORY_SEPARATOR, $path);
		require_once($pathStr.".php");
	}
}
