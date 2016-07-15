<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

	require 'connection.php';
	
	$dbconn=connect();
	$list=array();
    //obtaining and parsing JSON POST data
	$postdata = file_get_contents("php://input");
    $response = json_decode($postdata);
	$list['request'] = $response;
	var_dump($response);
	$access_token=$response->access_token;
	$user_array=explode('$',$access_token);
	$user_id= $user_array[1];
	$query="SELECT access_token FROM user_account WHERE user_id=:user_id;";
	$sql=$dbconn->prepare($query);
	$sql->execute(array(':user_id' => $user_id));
	
	while ($row = $sql->fetch((PDO::FETCH_ASSOC)))
		{
			$list[] = $row;
		}
	if($list[0]["access_token"]==$access_token){
		$list["message"]="User session exists";
	}
	else{
		$list["message"]="User session expired";
	}
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	
	
?>