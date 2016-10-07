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
			@$user_fname = $request->user_fname;
			@$user_lname = $request->user_lname;
			@$user_contact = $request->user_contact;
			@$user_dob = $request->user_dob;
			@$user_address_line1 = $request->user_address_line1;
			@$user_address_line2 = $request->user_address_line2;
			@$user_state = $request->user_state;
			@$user_address_city = $request->user_address_city;
			@$user_address_zip = $request->user_address_zip;
			@$user_gender = $request->user_gender;
			@$user_cashphrase = $request->user_cashphrase;
			@$user_paypalnumber = $request->user_paypalnumber;
			@$user_username = $request->user_username;
			@$user_emailid = $request->user_emailid;
			@$user_pwd = $request->user_pwd;
			
			$params = array();
			
			$params['user_fname'] = isset($user_fname) ? $user_fname : '';
			$params['user_lname'] = isset($user_lname) ? $user_lname : '';
			$params['user_contact'] = isset($user_contact) ? $user_contact : '';
			$params['user_dob'] = isset($user_dob) ? $user_dob : '';
			$params['user_address_line1'] = isset($user_address_line1) ? $user_address_line1 : '';
			$params['user_address_line2'] = isset($user_address_line2) ? $user_address_line2 : '';
			$params['user_state'] = isset($user_state) ? $user_state : '';
			$params['user_address_city'] = isset($user_address_city) ? $user_address_city : '';
			$params['user_address_zip'] = isset($user_address_zip) ? $user_address_zip : '';
			$params['user_gender'] = isset($user_gender) ? $user_gender : '';
			$params['user_cashphrase'] = isset($user_cashphrase) ? $user_cashphrase : '';
			$params['user_paypalnumber'] = isset($user_paypalnumber) ? $user_paypalnumber : '';
			$params['user_username'] = isset($user_username) ? $user_username : '';
			$params['user_emailid'] = isset($user_emailid) ? $user_emailid : '';
			$params['user_pwd'] = isset($user_pwd) ? $user_pwd : '';
			
			$data=$user_account->addUser($params);
			//$message["res"]=$data;
			
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
				$userId=$message["login_data"]["user_id"];
				$message["category_data"] = $video->getAllCategories();
				$message["queue_data"] = $video->getAllVideos($userId);				
								
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
			$message["queue_data"] = $video->getAllVideos(1);
			$message["auth_status"] = $user_account->accessValidator($access_token);
			break;
	}
	
	//encoding the JSON response that is sent to the client
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
