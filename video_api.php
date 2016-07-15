<?php
require_once 'connection.php';
class AdstonCashVideo{
	//Video class
	private $db;
	
	public function __construct(){
		//Connecting to the database
		$this->db = connect();
	}
	
	public function __destruct()
	{
		$this->db = null;
	}
	
	function getVideoUrl($videoID){
		//retrieve a video URL for a particular ID
		$sql = "SELECT video_url FROM video where video_id = :video_id";
		$sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':video_id'=> $videoID));
		return $sql_prepare->fetch((PDO::FETCH_ASSOC));
	}
	
	function getAllVideoDetails(){
		// obtain all the required video details with the particular demographic details provided
		$sql =  "SELECT * from category_type";
		$result = $this->db->query($sql);
		$category_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$category_list[] = $row;
		}
		$sql =  "SELECT category_type.category,video.video_id,video.company_name,video.poster_url FROM video INNER JOIN category_type on video.category_id = category_type.category_id where category_type.category_id=:category_id order by RAND() LIMIT 3";
		$sql_prepare = $this->db->prepare($sql);
		$list_queue = array();
		$total_categories = count($category_list);
		for ($x = 0; $x < $total_categories; $x++) {
			$sql_prepare->execute(array(':category_id'=> $category_list[$x]['category_id']));
			$list = array();
			while ($row = $sql_prepare->fetch((PDO::FETCH_ASSOC)))
			{
				$list[] = $row;
			}
			$list_queue[$category_list[$x]['category']] = $list;
		}
		return $list_queue;
	}
		
}
	
?>