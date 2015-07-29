<?php
class ContactModel{
	private $pdo;
	public $data;
	function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function sendMail($data){
		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			$this->data[] = "False";
			$this->data[] = "Please enter a valid e-mail.";
		}
		$array = $this->purifyMail($data);
		if (mail("1llusion@seznam.cz", $array[0], "E-mail: ".$array[1]."\n\n".$array[2])){
			$this->data[] = "True";
			$this->data[] = "Mail sent";
		}else{
			$this->data[] = "False";
			$this->data[] = "An error occured";
		}
	}
	private function purifyMail($data){
		return array(preg_replace("/[^\da-zA-Z]+/", "", $data['title']), $data['email'], htmlentities(wordwrap($data['body'], 70))); //Mail is already verified
	}
}
?>