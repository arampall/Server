<?php
	function getVideoUrl($videoID){
		$db = connect();
		$sql = "SELECT video_url FROM video where video_id = :video_id";
		$sql_prepare = $db->prepare($sql);
		$sql_prepare->execute(array(':video_id'=> $videoID));
		return $sql_prepare->fetch((PDO::FETCH_ASSOC));
	}
	
	function getAllVideoDetails(){
		$db = connect();
		$sql = "SELECT video_id, poster_url FROM video";
		$result = $db->query($sql);
		$list = array();
		while ($row = $result->fetch((PDO::FETCH_ASSOC)))
		{
			$list[] = $row;
		}
		return $list;
	}
	
	
	
	
?>