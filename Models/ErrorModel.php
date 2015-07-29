<?php
class ErrorModel{
	private $pdo;

	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}
}
?>