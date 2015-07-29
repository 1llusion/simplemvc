<?php
/**
* Keeping information about routes
*/
class Route
{
	public $model;
	public $view;
	public $controller;

	function __construct($model, $view, $controller){
		$this->model = $model;
		$this->view = $view;
		$this->controller = $controller;
	}
}
?>