<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
	require_once 'video_api.php'; 
<<<<<<< HEAD
	require_once 'question_api.php';
	$video = new AdstonCashVideo();
    $question = new AdstonCashQuestion();
=======
	$video = new AdstonCashVideo();
>>>>>>> 2358e7bd097f255791eb08411de4134768648e14
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$video_id = $request->video_id;
	$video_data=[];
	if($video_id!=""){
		//If a video_id is provided, the respective video_url is obtained
<<<<<<< HEAD
		$video_data['url'] = $video->getVideoUrl($video_id);
        $video_data['questions']=$question->getQuestions($video_id);
	}
	else{
		//Get all the video details like (id,category,poster) of a particular demographics
		$video_data = $video->getAllVideos();
=======
		$video_data = $video->getVideoUrl($video_id);
	}
	else{
		//Get all the video details like (id,category,poster) of a particular demographics
		$video_data = $video->getAllVideoDetails();
>>>>>>> 2358e7bd097f255791eb08411de4134768648e14
	}
	
	//encoding the response JSON object
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($video_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>