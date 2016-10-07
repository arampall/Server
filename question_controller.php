<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
	
    require_once 'question_api.php'; 
	$question = new AdstonCashQuestion();
	
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $score_list=[];
    @$access_token=$request->access_token;
    $user_id = null;
    if($access_token!=null){
        $user_array=explode('$',$access_token);
        $user_id=$user_array[1];
    }
    @$score = $request->score;
	$score_list=[];
	if($user_id!=""){
        $score_list=$question->calculateRank($user_id, $score);
	}

	
	//encoding the response JSON object
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($score_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>