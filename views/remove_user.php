<?php require_once("../server/connect.php"); ?>
<?php 
$id=$_GET['id'];
$sql="DELETE FROM users WHERE id='$id'";
mysqli_query($conn, $sql);
header("Location:dashboard.php");
exit();
 ?>