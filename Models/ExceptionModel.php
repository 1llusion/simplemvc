<?php
class ExceptionModel{
	private $pdo;

	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}
}
?>