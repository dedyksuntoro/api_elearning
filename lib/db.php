<?php

/**
* Author : https://www.roytuts.com
*/
	
// $dbConn = mysqli_connect('localhost', 'mandalag', 'mandalaputra', 'mandalag_inventory') or die('MySQL connect failed. ' . mysqli_connect_error());
$dbConn = mysqli_connect('localhost', 'root', 'root', 'db_elearning') or die('MySQL connect failed. ' . mysqli_connect_error());

function dbQuery($sql) {
	global $dbConn;
	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));
	return $result;
}

function dbQueryMultiple($sql) {
	global $dbConn;
	$result = mysqli_multi_query($dbConn, $sql) or die(mysqli_error($dbConn));
	return $result;
}

function dbQueryInsertLastId($sql) {
	global $dbConn;
	$result = mysqli_query($dbConn, $sql) or die(mysqli_error($dbConn));
	if ($result) {
		$last_id = mysqli_insert_id($dbConn);
	}
	return $last_id;
}

function dbFetchAssoc($result) {
	return mysqli_fetch_assoc($result);
}

function dbNumRows($result) {
    return mysqli_num_rows($result);
}

function closeConn() {
	global $dbConn;
	mysqli_close($dbConn);
}

function reformat_date($strdate){
    $t = strtotime($strdate);
    $r = date('Y-m-d',$t);
    return($r);
}
	
//End of file