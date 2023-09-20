<?php
require_once 'lib/db.php';
require_once 'lib/jwt_utils.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header('Content-type: application/json');

$bearer_token = get_bearer_token();
$is_jwt_valid = is_jwt_valid($bearer_token);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($is_jwt_valid) {
        try {
            $sql = "
                SELECT * FROM tbl_pelajaran
            ";
            $results = dbQuery($sql);
            $rows = array();
            while($row = dbFetchAssoc($results)) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        } catch (Exception $e) {
            echo json_encode(array('pesannya' => 'Some Error Occured', 'status' => 'Error'));
        }
    } else {
        echo json_encode(array('pesannya' => 'Access Denied', 'status' => 'Error'));
    }
} else {
    echo json_encode(array('pesannya' => 'Invalid Request', 'status' => 'Error'));
}
