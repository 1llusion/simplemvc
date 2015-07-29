<?php
class ContactView{
	private $model;
	function __construct($model){
		$this->model = $model;
	}

	public function output(){
		return $this->html();
	}
	private function html(){
		?>
		<div class="form">
			<?php if(isset($this->model->data)): ?>
				<div class="formText" id="form<?= $this->model->data[0] ?>"><?= $this->model->data[1] ?></div>
			<?php endif ?>
			<form action="<?=BASE_PATH?>/contact/send" method="POST">
				<input type="text" name="title" placeholder="Title">
				<input type="text" name="email" placeholder="E-mail">
				<textarea name="body" rows="4" cols="50"></textarea>
				<input type="submit" value="Submit">
			</form>
		</div>
		<?php
	}

}
?>