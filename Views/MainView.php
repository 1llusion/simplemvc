<?php
class MainView{
	public function header(){
		?>
		<!DOCTYPE html>
		 <html>
		 	<head>
		 		<link rel="stylesheet" type="text/css" href="<?=BASE_PATH.'/inc/css/nav.css'?>">
		 		<link rel="stylesheet" type="text/css" href="<?=BASE_PATH.'/inc/css/blog.css'?>">
		 		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
		 		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arvo">
		 		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans">
		 	</head>
		 	<body>
		 		<div class="navigation line-navigation">
		 			<a href="<?=BASE_PATH?>/index">Home</a>
		 			<a href="<?=BASE_PATH?>/post">Posts</a>
		 			<a href="<?=BASE_PATH?>/contact">Contact us</a>
		 			<?php if (isset($_SESSION["login"])): ?>
		 			<a href="<?=BASE_PATH?>/post/add">New</a>
		 			<a onClick="if(confirm('Are you sure you want to logout?') == true){$.post('<?=BASE_PATH?>/user/logout', {logout: 'true'}, function(){window.location.replace('<?= BASE_PATH ?>/index')})}">Logout</a>
		 			<?php else: ?>
		 			<a href="<?=BASE_PATH?>/user">Login</a>
		 			<?php endif ?>
		 		</div>
		 	<div class="container">
		<?php

	}
	public function footer(){
		?>		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			</body>
		</html>
		<?php
		
	}
}
?>