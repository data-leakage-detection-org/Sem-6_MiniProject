<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("../sanitize.php"); ?>
<?php require_once("hasAccessUser.php"); ?>
<?php require_once("library.php"); ?>

<?php 
check_attempts($_GET['id']);
function checkSecretKeyRequest($id, $user_id){
	global $conn;
	$sql="SELECT * FROM key_requests WHERE file='$id' AND request_by_user='$user_id'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_array($result);
		if($row['status'] == 'pending' || $row['status']=='rejected'){
			return 'no';
		}		
		return "yes";
	}
	return 'no';
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php include_once("bootstrap.php"); ?>
</head>
<body class="dashboard_background">
	<?php include_once("menubar.php"); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 mx-auto">
			<div class="card my-5">
				<div class="card-body">
<?php
if(isset($_POST['download'])){	
	$id=$_GET['id'];	
	$user_id=$_SESSION['user_id'];

	$secret_key=sanitize($_POST['secret_key']);
	$sql="SELECT * FROM data_files WHERE id='$id' AND secret_key='$secret_key'";
	$result=mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			$row=mysqli_fetch_array($result);


$status = checkSecretKeyRequest($row['id'], $_SESSION['user_id']);
if($status == "no"){
 // mark as leaker
	
	$subject=$row['subject'];
	$secret_key=$row['secret_key'];
	$file_id=$row['id'];
	$sql="INSERT INTO leakers(user_id, subject, file_id, secret_key)VALUES('$user_id', '$subject','$file_id','$secret_key')";
	mysqli_query($conn, $sql);

	
}


$filename = $row['file_name'];

$url="../assets/files/$filename";
$ext=pathinfo($url, PATHINFO_EXTENSION);
if($ext=="pdf"){
$url="../download_with_watermark.php?name=$filename";
header("Location:$url");
exit();
}
else{
// File to download other files other than PDF
$contenttype = "application/force-download";
header("Content-Type: " . $contenttype);
header("Content-Disposition: attachment; filename=\"" .$filename. "\";");
readfile("../assets/files/".$filename);
exit();		
}

		}
		else{			
			mark_attempt($id);			
			$remaining_attempts = get_attempt($id);
			echo "
			<div class='alert alert-danger'>
				Invalid secret key, try again, Only $remaining_attempts attempt left.
			</div>";
			if($remaining_attempts == "0"){
				$created_at=date("Y-m-d H:i:s");
				$sql="INSERT INTO leaked_messages(user_id, file_id, created_at)VALUES('$user_id', '$id', '$created_at')";
				$result=mysqli_query($conn, $sql);
			}
		}
	}
}
?>
					<form action="download.php?id=<?=$_GET['id']?>" method="POST">
						<div class="mb-2">
						<input 
						placeholder="Enter 4 digit secret key to download file" 
						type="number" name="secret_key" class="form-control" required>
						</div>
						<div class="mb-2">
							<input type="submit" name="download" value="Download" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php 
$id=$_GET['id'];
?>