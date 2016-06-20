<?php
class AdstonCashUser{
	public $db;
	
	public function __construct(){
		//$conf = json_decode(file_get_contents('configuration.json'), TRUE);
		//$this->db = new PDO($conf["db_name"].":".$conf["host"].";".$conf["database"], $conf["user"], $conf["password"]);
		try 
        {
            $this->db = new PDO("mysql:host=localhost;dbname=adston",'root', '');
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
		$query = 'SELECT * FROM user_account WHERE user_email=:user_email and user_password=:user_password';
		$sql = $this->db->prepare('SELECT * FROM user_account ');
		//$sql->execute(array(':user_email' => $login_data['email_id'],':user_password' => $login_data['user_pass']));
		$sql->execute(array(':user_email' => ' ',':user_password' => ' '));
		//$sql->execute();
		$list = array();
		while ($row = $sql->fetch((PDO::FETCH_ASSOC)))
		{
			$list[] = $row;
		}
		return $list;
	}
		
}

?>