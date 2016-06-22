 <?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		header( "HTTP/1.1 200 OK" );
		exit();
	}
    
	require_once 'user.php';
	$user_account = new AdstonCashUser();
	$message = array();
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$email_id = $request->email_id;
    @$user_pass = $request->user_pass;
	
	$params = array();
	$params['email_id'] = isset($email_id) ? $email_id : '';
	$params['user_pass'] = isset($user_pass) ? $user_pass : '';
	$data = $user_account->getUserAccount($params);
		if ($data!=[]) {
			$message["code"] = "0";
			$message["data"] = $data;
		} else {
			$message["code"] = "1";
			$message["message"] = "User does not exist";
		}
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>