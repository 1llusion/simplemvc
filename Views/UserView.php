<?php
	/**
	* 
	*/
	class UserView
	{
		private $model;
		function __construct($model)
		{
			$this->model = $model;
		}

		public function output(){
			if(isset($_SESSION["login"]))
				header("Location: ".BASE_PATH."/post");
			return $this->html();
		}

		private function html(){
			?>
				<div class="form">
					<?php if(isset($this->model->data)): ?>
						<div class="formText" id="form<?= $this->model->data[0] ?>"><?= $this->model->data[1] ?></div>
					<?php endif ?>
					<form action="<?=BASE_PATH?>/user/login" method="POST">
						<input type="text" name="username" placeholder="Username">
						<input type="password" name="password" placeholder="Password">
						<input type="submit" value="Submit">
					</form>
				</div>
			<?php
		}
	}
?>