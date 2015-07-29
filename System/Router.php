<?php
/**
* Taking care of routing
*/
class Router{
	private $routeSettings; //Route objects here
	public $baseRoute; //We store the current route here
	public $action;
	public $errorException = array(false, array()); //If custom error or exception handle is present

	function __construct(){
		$settings = parse_ini_file(BASE_DIR."/Settings/Routes.ini", true);

		//Getting the base script name, so we can remove it from the rest of the parameters.
		$parameter = substr($_SERVER['REQUEST_URI'], strlen(BASE_PATH));
		$parameter = explode("/", $parameter);
		array_shift($parameter); //First element is NULL se we can throw it away

		/*Following lines set a few default routes. 
		* Index is always required and used as the default page.
		* Error and exception routes are optional. Each can use a separate model, view or even controller if needed.
		*/
		$this->baseRoute = (empty($parameter[0])) ? "index" : $parameter[0];
		if(!empty($settings["error"])){
			$this->errorException[0] = true;
			$this->errorException[1]["error"] = array("model" => $settings["error"]["model"], "view" => $settings["error"]["view"]);
		}
		if(!empty($settings["exception"])){
			/*
			* I keep error and exception completely separate, so development and production applications can be switched easily by switching routes.
			* The idea is, that errors should be seen only in development phase and not production.
			* For example, there can be ErrorDebugView and ErrorView. The former contains more information and can also display exceptions on the same page
			* while the later simply results in "Internal server error".
			*/
			$this->errorException[0] = true;
			$this->errorException[1]["exception"] = array("model" => $settings["exception"]["model"], "view" => $settings["exception"]["view"]);
		}

		if(!empty($parameter[1])){
			array_shift($parameter);
			$this->action = $parameter;
		}
		else
			$this->action = false;
		foreach($settings as $key => $val){
			if(!isset($val["controller"]))
				$val["controller"] = NULL; //Sometimes we don't need a controller
			$this->routeSettings[$key] = new Route($val["model"], $val["view"], $val["controller"]);

		}
	}

	public function getRoute($route){
		if(empty($this->routeSettings[$route]))
			throw new Exception("Page not found.");
		return $this->routeSettings[$route];
	}
}
?>