<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
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
			<div class="col-sm-6 mx-auto">
				<div class="card my-3">
					<div class="card-body">
<?php
$userid=$_SESSION['user_id'];
$sql="SELECT * FROM users WHERE id='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);     
$rows=mysqli_fetch_array($result);
?>
<div class="text-center">
<img src="../assets/profiles/<?=$rows['profile']?>" alt="" class="w-25 rounded-circle">
</div>

<div class="row">
	<div class="col-sm-7 mx-auto border my-3 p-3">
<strong>Username:</strong> <?=$rows['username']?> <br>
<strong>Email Id:</strong> <?=$rows['email']?> <br>
<div class="text-center">
<a href="profile.php">
	<button class='btn btn-primary' style='margin-top:2%'>Edit profile</button>
</a>
</div>
</div>
</div>


					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>