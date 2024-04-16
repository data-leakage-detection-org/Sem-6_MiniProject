<?php 
require_once("../server/connect.php");
$id=$_GET['id'];
$sql="DELETE FROM leaked_messages WHERE id='$id' LIMIT 1";
$result=mysqli_query($conn, $sql);
header("Location:dashboard.php");
exit();
 ?>