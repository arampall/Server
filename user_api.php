<?php
require_once 'connection.php';
class AdstonCashUser{
	//User Account class
	private $db;
	
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
		$list = "";
		while ($row = $sql->fetch((PDO::FETCH_ASSOC)))
		{
			$list = $row;
		}
		return $list;
	}
	
	function updateLoginInfo($access_token,$user_id){
		//setting date & time
		date_default_timezone_set('America/New_York');
		$date=date('Y-m-d H:i:s');
		$query="UPDATE user_account SET access_token=:access_token,last_visited=:last_visited WHERE user_id=:user_id";
		$sql = $this->db->prepare($query);
		$sql->execute(array(':access_token' => $access_token,':last_visited' => $date,':user_id' => $user_id));
	}
	
	function accessValidator($access_token){
		$user_id = null;
		if($access_token!=null){
			$user_array=explode('$',$access_token);
			$user_id=$user_array[1];
		}
		$query="SELECT * FROM user_account WHERE user_id=:user_id AND access_token=:access_token;";
		$sql=$this->db->prepare($query);
		$sql->execute(array(':user_id' => $user_id,':access_token'=>$access_token));
		$result = $sql->fetch((PDO::FETCH_ASSOC));
		$authenticated = null;
		if($result!=null){
			$this->updateLoginInfo($access_token,$user_id);
			return $authenticated="yes";
		}
		else{
			return $authenticated="no";
		}
   }
}

?>
