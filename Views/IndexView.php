<?php
/**
* Mainly a static page
*/
class IndexView
{
	private $model;
	function __construct($model)
	{
		$this->model = $model;
	}

	public function output(){
		return $this->html();
	}

	public function html(){
		$post = $this->model->getLast();
		?>
		<div class="intro">
			<p><h1>Welcome to my Simple Blog. Have a nice day!</h1></p>
			<p>Bellow, you will find the latest blog entry.</p>
		</div>
			<div class="postPreview">
					<div class="postTitle"><a href="<?=BASE_PATH?>/post/view/<?= $post["year"]."/".$post["month"]."/".$post["url"]?>"><?= $post["title"]?></a></div>
					<div class="postSummary"><?= $post["summary"]?></div>
					<div class="postTime">Last updated at: <?= date('Y-m-d H:i:s', $post["timestamp"])?></div>
			</div>
		</div>
		<?php
	}
}
?>