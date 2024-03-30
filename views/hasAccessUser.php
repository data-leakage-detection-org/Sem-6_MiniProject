<?php 
$user_id=$_SESSION['user_id'];
$sql="SELECT * FROM users WHERE id='$user_id'";
$result=mysqli_query($conn, $sql);
$record=mysqli_fetch_array($result);
if($record['blocked']=="1"){
	header("Location:../index.php");
	exit();
}
?>