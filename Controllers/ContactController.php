<?php
class ContactController{
	private $model;

	function __construct($model){
		$this->model = $model;
	}

	public function send(){
		if(empty($_POST["title"]) || empty($_POST["email"]) || empty($_POST["body"]))
			return header("Location: ".BASE_PATH."/contact");
		$this->model->sendMail(array('title' => $_POST['title'], 'email' => $_POST['email'], 'body' => $_POST['body']));
	}
}
?>