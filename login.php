<?php
require_once 'lib/db.php';
require_once 'lib/jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	// $data = json_decode(file_get_contents("php://input", true));
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
	
	$sql = "SELECT * FROM tbl_login WHERE username = '" . mysqli_real_escape_string($dbConn, $username) . "' AND password = '" . mysqli_real_escape_string($dbConn, urlencode(MD5($password,"1q2w3e4r5t6y"))) . "' LIMIT 1";
	
	$result = dbQuery($sql);
	
	if(dbNumRows($result) < 1) {
        echo json_encode(array('pesannya' => 'Invalid User', 'status' => 'Error'));
	} else {
		$row = dbFetchAssoc($result);
		
		$username = $row['username'];
		
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array('username'=>$username, 'exp'=>(time() + 60));

		$jwt = generate_jwt($headers, $payload);
		
		echo json_encode(array('token' => $jwt,
            'id' => $row['id'],
            'id_user' => $row['id_user'],
            'username' => $row['username'],
        ));
	}
} else {
    echo json_encode(array('pesannya' => 'Invalid Request', 'status' => 'Error'));
}

//End of file