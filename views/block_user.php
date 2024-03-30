<?php require_once("../server/connect.php"); ?>
<?php 
$id=$_GET['id'];
$sql="UPDATE users SET blocked='1' WHERE id='$id' LIMIT 1";
mysqli_query($conn, $sql);
header("Location:dashboard.php");
exit();
 ?>