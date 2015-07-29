<?php 
class ExceptionView{
	private $model;

	function __construct($model){
		$this->model = $model;
	}

	public function output(Exception $ex){
		$mainView = new MainView();
		echo $mainView->header().$ex->getMessage().$mainView->footer();
	}
}
?>