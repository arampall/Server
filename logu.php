 <?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

	if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		header( "HTTP/1.1 200 OK" );
		exit();
	}
    /*$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    @$email_id = $request->email_id;
    @$user_pass = $request->user_pass;*/
	
	
	require_once 'user.php';
	$user_account = new AdstonCashUser();
	$message = array();
	$params = array();
	$params['email_id'] = isset($_POST["email_id"]) ? $_POST["email_id"] : '';
	$params['user_pass'] = isset($_POST["user_pass"]) ? $_POST["user_pass"] : '';
		if (is_array($data = $user_account->getUserAccount($params))) {
			$message["code"] = "0";
			$message["data"] = $data;
		} else {
			$message["code"] = "1";
			$message["message"] = "Error on post method";
		}
	
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
