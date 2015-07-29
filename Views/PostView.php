<?php
/**
* 
*/
class PostView
{
	private $model;
	function __construct($model)
	{
		$this->model = $model;
	}

	public function output(){
		$output = "html".$this->model->output;

		return $this->{$output}();
	}

	private function htmlPreview(){
		if(empty($this->model->data))
			$this->model->getSummaries();
		$data = $this->model->data;
		$pagination = $data["pagination"];
		unset($data["pagination"]);

		//A few more pagination vars to help along the way
		$begin_pagination = ($pagination["current_page"] - 5 < 0) ? 1 : $pagination["current_page"] - 5;
		$end_pagination = ($pagination["current_page"] + 5 > $pagination["last_page"]) ? $pagination["last_page"] : $pagination["current_page"] + 5 ;

		?>
			<?php foreach ($data as $post):?>
				<div class="postPreview">
					<div class="postTitle"><a href="<?=BASE_PATH?>/post/view/<?= $post["year"]."/".$post["month"]."/".$post["url"]?>"><?= $post["title"]?></a>
					<?php if(isset($_SESSION["login"])):?> 
							<a class="adminPostControll" href="<?=BASE_PATH?>/post/edit/<?= $post["year"]."/".$post["month"]."/".$post["url"]?>">[EDIT]</a>
							<a class="adminPostControll" onClick="if(confirm('Are you sure you want to delete this post?') == true){$.post('<?=BASE_PATH?>/post/delete/<?= $post["year"]."/".$post["month"]."/".$post["url"]?>', {delete: 'true'}, function(){window.location.replace('<?= BASE_PATH ?>/post'), alert('Post deleted.')})}">[DELETE]</a> </div>
					<?php endif ?>
					<div class="postSummary"><?= $post["summary"]?></div>
					<div class="postTime">Last updated at: <?= date('Y-m-d H:i:s', $post["timestamp"])?></div>
				</div>
			<?php endforeach ?>
			<div class="pagination">
					<span class="paginationNumber"><a href="<?=BASE_PATH?>/post/page/1">|<<</a></span>
				<?php for ($var = $begin_pagination; $var <= $end_pagination; $var++):?>
						<?php if($var != $pagination["current_page"])
									echo '<span class="paginationNumber"><a href="'.BASE_PATH.'/post/page/'.$var.'">'.$var.'</a></span>';
								else
									echo '<span class="paginationNumberSelected">'.$var.'</span>'?>
				<?php endfor ?>
					<span class="paginationNumber"><a href="<?=BASE_PATH?>/post/page/<?= $pagination["last_page"] ?>">>>|</a></span>
				</div>
		<?php
	}

	private function htmlView(){
		$post = $this->model->data;
		?>
			<div class="postView">
					<div class="postTitle"><?= $post["title"]?></div>
					<div class="postSummary"><?= $post["summary"]?></div>
					<div class="postBody"><?= $post["body"]?></div>
					<div class="postTime">Last updated at: <?= date('Y-m-d H:i:s', $post["timestamp"])?></div>
			</div>
		<?php
	}

	private function htmlNew(){
		if(!isset($_SESSION["login"]))
			return "";
		?>
		<div class="form">
			<form action="<?=BASE_PATH?>/post/<?php echo isset($this->model->data) ? 'edit/'.$this->model->data['id'] : 'add' ?>" method="POST">
				<input type="text" name="title" placeholder="Title" value="<?php if(isset($this->model->data)) echo $this->model->data['title'] ?>">
				<input type="text" name="summary" placeholder="Summary" value="<?php if(isset($this->model->data)) echo $this->model->data['summary'] ?>">
				<textarea name="body" rows="4" cols="50"><?php if(isset($this->model->data)) echo $this->model->data['body'] ?></textarea>
				<input type="text" name="url" placeholder="Url" value="<?php if(isset($this->model->data)) echo $this->model->data['url'] ?>">
				<input type="submit" value="Submit">
			</form>
		</div>
		<?php
	}
}
?>