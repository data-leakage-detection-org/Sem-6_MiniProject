<?php 
require_once("../session.php");
require_once("../server/connect.php");
$id=$_GET['id'];
$asker=$_SESSION['user_id'];

function getfiledetail($fileid){
global $conn;
  $data="";
$sql="SELECT * FROM data_files WHERE id='$fileid' LIMIT 1";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($result);
return $row;
}

$file = getfiledetail($id);
$secret_key = $file['secret_key'];
$request_to_user = $file['sender_id'];
$sql="INSERT INTO key_requests(request_by_user, request_to_user, file, secret_key, status)VALUES('$asker', '$request_to_user', '$id', '$secret_key', 'pending')";
mysqli_query($conn, $sql);
echo "Request successfully sent.";
?>