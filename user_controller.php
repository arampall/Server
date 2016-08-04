 <?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		header( "HTTP/1.1 200 OK" );
		exit();
	}
    
	require_once 'user_api.php';
	require_once 'video_api.php';
	$user_account = new AdstonCashUser();
	$video = new AdstonCashVideo();
	$message = array();
	
	//obtaining and parsing JSON POST data
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
	@$method = $request->method;
	switch($method){
		case "signup":
			break;
		case "login":
			//setting params and calling user api to get the User Object
			@$email_id = $request->email_id;
			@$user_pass = $request->user_pass;
			$params = array();
			$params['email_id'] = isset($email_id) ? $email_id : '';
			$params['user_pass'] = isset($user_pass) ? $user_pass : '';
			$data = $user_account->getUserAccount($params);
			if ($data!="") {
				//User data exists with the given email-id and password
				$message["code"] = "0";
				$message["login_data"] = $data;
<<<<<<< HEAD
				$message["queue_data"] = $video->getAllVideos();
=======
				$message["queue_data"] = $video->getAllVideoDetails();
>>>>>>> 2358e7bd097f255791eb08411de4134768648e14
				$userId=$message["login_data"]["user_id"];
				
				//Generate a random string.
				$token = openssl_random_pseudo_bytes(16);
	 
				//Convert the binary data into hexadecimal representation.
				$message['access_token']= bin2hex($token)."$".$userId;
				$message["login_data"]['access_token']=$message['access_token'];
				$user_account->updateLoginInfo($message['access_token'],$userId);
				
			} else {
				//User not registered or Invalid Credentials
				$message["code"] = "1";
				$message["message"] = "User does not exist";
			}
			break;
		default:
			@$access_token=$request->access_token;
			$message["auth_status"] = $user_account->accessValidator($access_token);
			break;
	}
	
	//encoding the JSON response that is sent to the client
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
