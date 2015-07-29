<?php
/**
* Pagination class
*/
class Pagination
{
	private $pdo;
	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function paginate($table, $columns = "*", $current_page = 1, $items = 15){//Items per page and Current page
		$maxItems = $this->maxItems($table);

		return $this->items($table, $columns, $items, $current_page, $maxItems);

	}

	public function lastPage($table, $items = 15){
		return ceil($this->maxItems($table) / $items);
	}
	private function maxItems($table){
		$table = preg_replace("/[^\da-zA-Z]+/", "", $table);
		$query = $this->pdo->query("SELECT COUNT(*) FROM Post");
		$data = $query->fetch(PDO::FETCH_ASSOC);

		return $data["COUNT(*)"];
	}

	private function items($table, $columns, $items, $current_page, $maxItems){
		//Taking care of security
		$table = preg_replace("/[^\da-zA-Z]+/", "", $table);
		$columns = preg_replace("/[^\da-zA-Z, ]+/", "", $columns);
		$limit = array(($current_page - 1) * $items, ($current_page * $items));

		if($maxItems < $limit[1])
			$limit[1] = $maxItems;
		if($limit[0] < 0)
			throw new Exception("No posts found.");
		$query = $this->pdo->query("SELECT ".$columns." FROM ".$table." LIMIT ".$limit[0].", ".$limit[1]);
		return $query->fetchAll();
	}
}
?>