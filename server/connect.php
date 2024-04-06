<?php
require_once("query.php"); 
$conn=mysqli_connect("localhost","root",'','data_leakage');
if($conn){
	mysqli_query($conn, USER_TABLE_QUERY);
	mysqli_query($conn, DATA_FILE_TABLE_QUERY);
	mysqli_query($conn, KEY_REQUEST_TABLE_QUERY);
	mysqli_query($conn, LEAKER_TABLE_QUERY);
	mysqli_query($conn, LEAKED_MESSAGES_QUERY);
	mysqli_query($conn, ATTEMPTS_QUERY);
	if(mysqli_num_rows(mysqli_query($conn, ADMIN_EXIST_QUERY)) == 0){
		mysqli_query($conn, CREATE_ADMIN_QUERY);
	}
}
else{
	die('Please make sure you have created a database with name "Data Leakage" ');
}
?>