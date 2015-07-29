<?php
/**
* User Model
*/
class UserModel
{
	private $pdo;
	public $data;
	function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		if(isset($_POST["login"])){
			$query = $pdo->query("SELECT title, year, month, url FROM Post");
			$data = $query->fetchAll();	
		}
	}

	public function login($username, $password){
		$query = $this->pdo->prepare("SELECT password FROM User WHERE username = ?");
		$query->execute(array($username));
		$salt = $query->fetch(PDO::FETCH_ASSOC);
		if(password_verify($password, $salt["password"])) {
			$_SESSION["login"] = true;
			$this->data[] = "True";
			$this->data[] = "Logged in.";
		}
		else{
			$this->data[] = "False";
			$this->data[] = "Wrong username or password";
		}
	}

	public function logout(){
		if(!isset($_POST['logout'])) //Might be CSRF attack attempt
			return 0;
		$_SESSION = array();
		session_destroy();
	}
}
?>