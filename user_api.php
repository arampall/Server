<?php
include('connection.php');
class AdstonCashUser{
	//User Account class
	public $db;
	
	public function __construct(){
		//Connecting to the database
		$this->db = connect();
	}
	
	public function __destruct()
	{
		$this->db = null;
	}
	
	//To check the authenticity of the credentials provided
	function getUserAccount($login_data){
		if($login_data['email_id']==""){
			$query = 'SELECT * FROM user_account';
		}
		else{
			//getting the User object if it exists
			$query = 'SELECT * FROM user_account WHERE user_email=:user_email and user_password=:user_password';
		}
		$sql = $this->db->prepare($query);
		$sql->execute(array(':user_email' => $login_data['email_id'],':user_password' => $login_data['user_pass']));
		$list = array();
		while ($row = $sql->fetch((PDO::FETCH_ASSOC)))
		{
			$list[] = $row;
		}
		return $list;
	}
		
}

?>
