<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
	require_once 'video_api.php'; 
	include_once 'connection.php';
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$video_id = $request->video_id;
	$video_data=[];
	if($video_id!=""){
		$video_data = getVideoUrl($video_id);
	}
	else{
		$video_data = getAllVideoDetails();
	}
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($video_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>