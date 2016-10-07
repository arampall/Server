<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
	require_once 'video_api.php';
	require_once 'user_api.php';
	require_once 'question_api.php';
	$video = new AdstonCashVideo();
	$question = new AdstonCashQuestion();
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$video_id = $request->video_id;
	@$auth_token = $request->auth_token;
	if($auth_token){
		$user_id = explode('$',$auth_token)[1];
	}
	$video_data=[];
	if($video_id!=""){
		//If a video_id is provided, the respective video_url is obtained
		$video_data = $video->getVideoUrl($video_id,$user_id);
		$video_data['questions']=$question->getQuestions($video_id);
	}
	else{
		//Get all the video details like (id,category,poster) of a particular demographics
		//$video_data["all"] = $video->getAllVideos(1);
		$video_data = $video->getVideoUrl(3,1);
		$video_data['questions']=$question->getQuestions(4);
		$video_data["cat"] = $video->getAllCategories();
	}
	
	//encoding the response JSON object
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($video_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>