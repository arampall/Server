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
	$user_account = new AdstonCashUser();
	$message = array();
	
	//obtaining and parsing JSON POST data
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$email_id = $request->email_id;
    @$user_pass = $request->user_pass;
	
	//setting params and calling user api to get the User Object
	$params = array();
	$params['email_id'] = isset($email_id) ? $email_id : '';
	$params['user_pass'] = isset($user_pass) ? $user_pass : '';
	$data = $user_account->getUserAccount($params);
		if ($data!=[]) {
			//User data exists with the given email-id and password
			$message["code"] = "0";
			$message["data"] = $data;
			session_start();
			$_SESSION["username"] = "hi";
		} else {
			//User not registered or Invalid Credentials
			$message["code"] = "1";
			$message["message"] = "User does not exist";
		}
	
	//encoding the JSON response that is sent to the client
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
