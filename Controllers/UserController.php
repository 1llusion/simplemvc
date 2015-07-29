<?php
/**
* 
*/
class UserController
{
	private $model;
	function __construct($model)
	{
		$this->model = $model;
	}

	public function login(){
		if(empty($_POST["username"]) || empty($_POST["password"]))
			return header("Location: ".BASE_PATH."/user");
		$username = preg_replace("/[^\da-zA-Z]+/", "", $_POST["username"]);
		$password = $_POST["password"];

		$this->model->login($username, $password);
	}

	public function logout(){
		$this->model->logout();
	}
}
?>