<?php
/**
* Creating the main controller, that will take care of initializing rest of the models, views and other controllers. 
*/
class MainController
{
	private $controller;
	private $view;
	private $mainView; //This takes care of global templates such as a header and a footer

	function __construct($router, $route, $action = false, Array $errorException){
		$pdo = $this->database();
		//Setting up the error handler
		if($errorException[0]){
			foreach($errorException[1] as $key => $val){
				$errorExceptionModel = $val["model"];
				$errorExceptionView = $val["view"];
				$errorExceptionClassModel = new $errorExceptionModel($pdo);
				$errorExceptionClassView = new $errorExceptionView($errorExceptionClassModel);

				call_user_func("set_{$key}_handler", array($errorExceptionClassView, "output"));
			}
		}

		$route = $router->getRoute($route);
		$newModel = $route->model;
		$newView = $route->view;
		$newController = $route->controller;

		$model = new $newModel($pdo);
		if($action) //A controller does not have to be present
			$this->controller = new $newController($model);
		$this->view = new $newView($model, $route);
		$this->mainView = new MainView();

		if($action){
			$data = $action;
			array_shift($data);
			$this->controller->{$action[0]}($data); //Calling action and passing parameters
		}
	}

	public function output(){
		return $this->mainView->header().$this->view->output().$this->mainView->footer();
	}

	private function database(){
		$settings = parse_ini_file(BASE_DIR."/Settings/Database.ini"); //Set up routes in the Routes.ini file
		$db = new PDO("mysql:host=".$settings["host"].";dbname=".$settings["name"], $settings["user"], $settings["password"]);
		//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}
?>