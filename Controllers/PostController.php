<?php
class PostController{
	private $model;

	function __construct($model){
		$this->model = $model;
	}

	public function view($data){
		$this->model->output = "view";
		$this->model->getPost($data);
	}

	public function page($data){
		$this->model->getSummaries(intval($data[0]));
	}

	public function edit($data){
		if(empty($data) && empty($_POST['title']) && empty($_POST['summary']) && empty($_POST["body"]) && empty($_POST['url']))
			return "";
		if(empty($_POST['title']) || empty($_POST['summary']) || empty($_POST["body"]) || empty($_POST['url']))
			return $this->model->editPost(array(false, $data));
		$this->model->editPost(array(true, array('title' => $_POST['title'], 'summary' => $_POST['summary'], 'body' => $_POST['body'], 'url' => $_POST['url']), $data[0]));
	}
	public function delete($data){
		$this->model->deletePost($data);
	}

	public function add(){
		if(empty($_POST['title']) || empty($_POST['summary']) || empty($_POST["body"]) || empty($_POST['url']))
			return $this->model->newPost(false);
		$this->model->newPost(array('title' => $_POST['title'], 'summary' => $_POST['summary'], 'body' => $_POST['body'], 'url' => $_POST['url']));
	}
}
?>