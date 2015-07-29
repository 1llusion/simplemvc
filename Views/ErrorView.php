<?php 
class ErrorView{
	private $model;

	function __construct($model){
		$this->model = $model;
	}

	public function output($errorNumber, $errorText){
		$mainView = new MainView();
		echo $mainView->header()."Internal Server Error.".$mainView->footer();
	}
}
?>