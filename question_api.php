<?php
require_once 'connection.php';
class AdstonCashQuestion{
	//Question class
	private $db;
	
	public function __construct(){
		//Connecting to the database
		$this->db = connect();
	}
	
	public function __destruct()
	{
		$this->db = null;
	}
	
    function getQuestions($video_id){
		$sql = "SELECT * FROM question INNER JOIN videoquestion ON question.question_id=videoquestion.question_id where videoquestion.video_id=:video_id";
		$sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':video_id'=> $video_id));
		return $sql_prepare->fetch((PDO::FETCH_ASSOC));
	}
}
	
?>