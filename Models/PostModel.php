<?php
/**
* Taking care of everything related to posts
*/
class PostModel
{
	private $pdo;
	public $output = "preview";
	public $data;

	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getSummaries($page = 1){
		$items = new Pagination($this->pdo);
		$this->data = $items->paginate("Post", "title, summary, timestamp, year, month, url", $page);

		$this->data["pagination"]["current_page"] = $page;
		$this->data["pagination"]["last_page"] = $items->lastPage("Post");
	}

	public function getPost($data){
		$query = $this->pdo->prepare('SELECT title, summary, body, timestamp FROM Post WHERE year = ? AND month = ? AND url = ?');
		$query->execute($data);

		$this->data = $query->fetch(PDO::FETCH_ASSOC);
	}

	public function getLast(){
		$query = $this->pdo->query("SELECT title, summary, timestamp, year, month, url FROM Post ORDER BY id DESC LIMIT 1");
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public function newPost($data){
		if(!$data)
			return $this->output = "New";
		$query = $this->pdo->prepare("INSERT INTO Post (title, summary, body, year, month, url, timestamp) VALUE (?, ?, ?, YEAR(CURDATE()), MONTH(CURDATE()), ?, UNIX_TIMESTAMP())");
		$query->execute($this->purifyPost($data));
	}
	public function editPost($data){
		if(!$data[0]){
			$query = $this->pdo->prepare("SELECT id, title, summary, body, url FROM Post WHERE year = ? AND month = ? AND url = ?");
			$query->execute($data[1]);
			$this->data = $query->fetch(PDO::FETCH_ASSOC);
			return $this->output = "New";
		}
		$array = $this->purifyPost($data[1]);
		$array[] = $data[2];

		$query = $this->pdo->prepare("UPDATE Post SET title = ?, summary = ?, body = ?, timestamp = UNIX_TIMESTAMP(), url = ? WHERE id = ?");
		$query->execute($array);
	}
	public function deletePost($data){
		if(!isset($_POST['delete'])) //Might be CSRF attack attempt
			return 0;
		
		$query = $this->pdo->prepare("DELETE FROM Post WHERE year = ? AND month = ? AND url = ?");
		$query->execute($data);

	}

	private function purifyPost($data){
		return array(preg_replace("/[^\da-zA-Z]+/", "", $data['title']), preg_replace("/[^\w ]+/", "", $data['summary']), htmlentities($data['body']), preg_replace("/[^a-z-]+/", "-", $data['url']));
	}
}
?>