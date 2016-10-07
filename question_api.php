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
        $questions=[];
		//$sql = "SELECT * FROM question INNER JOIN videoquestion ON question.question_id=videoquestion.question_id where videoquestion.video_id=:video_id ";
        //ORDER BY RAND() LIMIT 10
		$sql = "SELECT * FROM question";
		$sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':video_id'=> $video_id));
        while ($row = $sql_prepare->fetch((PDO::FETCH_ASSOC)))
		{
			$questions[] = $row;
		}
		return $questions;
	}
    
     function calculateRank($user_id, $score){
		$sql = "UPDATE user_account SET total_score=:score WHERE user_id=:user_id";
		$sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':score'=>$score, ':user_id'=> $user_id));
        
        $sql = "SELECT user_id, total_score FROM user_account";
        $result = $this->db->query($sql);
		$score_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$score_list[] = $row;
		}
        return $score_list;

	}
}
	
?>