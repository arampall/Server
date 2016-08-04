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
	
<<<<<<< HEAD
	/*function getAllVideoDetails(){
=======
	function getAllVideoDetails(){
>>>>>>> 2358e7bd097f255791eb08411de4134768648e14
		// obtain all the required video details with the particular demographic details provided
		$sql =  "SELECT * from category_type";
		$result = $this->db->query($sql);
		$category_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$category_list[] = $row;
		}
		$sql =  "SELECT category_type.category,video.video_id,video.company_name,video.video_title,video.poster_url FROM video INNER JOIN category_type on video.category_id = category_type.category_id where category_type.category_id=:category_id order by RAND() LIMIT 3";
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
<<<<<<< HEAD
	}*/
	
    function getAllCategories(){
		$sql =  "SELECT * from category_type";
		$result = $this->db->query($sql);
		$category_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$category_list[] = $row;
		}
        return $category_list;
    }
    function getAllVideos(){
		$sql =  "SELECT * from video order by RAND() LIMIT 15";
		$result = $this->db->query($sql);
		$video_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$video_list[] = $row;
		}
        return $video_list;
    }
    
    function getWatchedVideos($userId){
        $sql =  "SELECT video_id from user_video WHERE user_id = :user_id AND status='watched'";
        $sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':user_id'=> $userId));
        $watched_videos = array();
		while ($row = $sql_prepare->fetch((PDO::FETCH_ASSOC)))
		{
			$watched_videos[] = $row;
		}
        return $watched_videos;
    }
    
    function updateVideoStatus($userId,$videoId,$status){
        $sql =  "UPDATE user_video SET status = :status WHERE user_id = :user_id AND video_id = :video_id";
        $sql_prepare = $this->db->prepare($sql);
		$count = $sql_prepare->execute(array(':status'=> $status, ':user_id'=> $userId, ':video_id'=> $videoId));
        return $count;
    }
=======
	}
		
>>>>>>> 2358e7bd097f255791eb08411de4134768648e14
}
	
?>