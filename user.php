<?php
class AdstonCashUser{
	public $db;
	
	public function __construct(){
		$conf = include('config.php');
		try 
        {
			$this->db = new PDO(($conf["database"].":host=".$conf["host"].";dbname=".$conf["db_name"]), $conf["user"], $conf["password"]);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) 
        {
            echo $e->getMessage();

        }	
	}
	
	public function __destruct()
	{
		$this->db = null;
	}
	
	function getUserAccount($login_data){
		if($login_data['email_id']==""){
			$query = 'SELECT * FROM user_account';
		}
		else{
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
