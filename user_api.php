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
	
	function addUser($signup_data){
		$firstName=$signup_data['user_fname'];
		$lastName=$signup_data['user_lname'];
		$contact=$signup_data['user_contact'];
		$dob=$signup_data['user_dob'];
		$address_line1=$signup_data['user_address_line1'];
		$address_line2=$signup_data['user_address_line2'];
		$state=$signup_data['user_state'];
		$city=$signup_data['user_address_city'];
		$zip=$signup_data['user_address_zip'];
		$gender=$signup_data['user_gender'];
		$cashPhrase=$signup_data['user_cashphrase'];
		$paypal=$signup_data['user_paypalnumber'];
		$username=$signup_data['user_username'];
		$email=$signup_data['user_emailid'];
		$pwd=$signup_data['user_pwd'];
		
		$que1="INSERT INTO user_personal(first_name,last_name,contact,date_of_birth,address_line1,address_line2,state,city,zip_code,gender,cash_phrase,paypal,user_name,email,password) VALUES('$firstName','$lastName','$contact','$dob','$address_line1','$address_line2','$state','$city','$zip','$gender','$cashPhrase','$paypal','$username','$email','$pwd');";
		$this->db->query($que1);
		$que2="SELECT user_id FROM user_personal WHERE email='$email';";
		$sql=$this->db->query($que2);
		$current_userId=$sql->fetch((PDO::FETCH_ASSOC));
		$que3="INSERT INTO user_account(user_name,user_email,user_password,user_id) VALUES('$username','$email','$pwd','$current_userId');";
		$this->db->query($que3);
		return "Success";
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
