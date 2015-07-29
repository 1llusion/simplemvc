<?php
/*
* Simply auto-loading needed classes in all directories
*/
class Autoload{
	private $basePath;
	private $directories;

	function __construct($path, $directories){
		$this->basePath = $path;
		$this->directories = $directories;

		spl_autoload_register(array($this, 'load'));
	}

	private function load($class){
		if(is_array($this->directories)){
			foreach($this->directories as $directory){
				if(file_exists($this->basePath.'/'.$directory.'/'.$class.'.php')){
					require_once $this->basePath.'/'.$directory.'/'.$class.'.php';
				}
			}
		}
		else{
			if(file_exists($this->basePath.'/'.$directory.'/'.$class.'.php'))
					require_once $this->basePath.'/'.$directory.'/'.$class.'.php';
		}
	}
}
?>