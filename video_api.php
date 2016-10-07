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
	
	function getVideoUrl($videoID, $user_id){
		$result = $this->updateVideoStatus($user_id, $videoID, 'watched');
		if($result){
			//retrieve a video URL for a particular ID
			$sql = "SELECT video_url FROM video where video_id = :video_id";
			$sql_prepare = $this->db->prepare($sql);
			$sql_prepare->execute(array(':video_id'=> $videoID));
			return $sql_prepare->fetch((PDO::FETCH_ASSOC));
		}
		return null;
	}
	
	function getAllCategories(){
		$sql =  "SELECT category from category_type";
		$result = $this->db->query($sql);
		$category_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$category_list[] = $row["category"];
		}
        return $category_list;
    }
	
	function getAllVideos($user_id){
		$sql =  "SELECT category_type.category,video.video_id,video.company_name,video.video_title,video.poster_url FROM video INNER JOIN category_type on video.category_id = category_type.category_id order by RAND() LIMIT 15";
		$result = $this->db->query($sql);
		$video_list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$video_list[] = $row;
		}
		$sql =  "DELETE from user_video where user_id = :user_id";
		$sql_prepare = $this->db->prepare($sql);
		$sql_prepare->execute(array(':user_id'=> $user_id));
		
		try {
			$this->db->beginTransaction();
			$sql = "INSERT INTO user_video (user_id, video_id, status) VALUES(:user_id, :video_id, 'Queue')";
			$sql_prepare = $this->db->prepare($sql);
			foreach($video_list as $row){
				$sql_prepare->execute(array(':user_id'=> $user_id, ':video_id'=> $row['video_id']));
			}
			$this->db->commit();
			}
		catch(PDOException $e)
		{
			$this->db->rollback();
			echo "Error: " . $e->getMessage();
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
		
}
	
?>