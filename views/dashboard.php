<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php require_once("hasAccessUser.php"); ?>
<?php include_once("library.php"); ?>
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
	<?php if(isset($_SESSION['user_type'])){
		if($_SESSION['user_type'] == 'user'){ ?>
	<div class="container-fluid text-center" style="display:flex;align-items: center;justify-content:center;margin-top:12%">
	<?php } 
	elseif($_SESSION['user_type']=='admin'){ ?>
	<div class="container-fluid text-center" style="display:flex;align-items: center;justify-content:center;margin-top:7%">
		<?php } } ?>
	<div class="row my-3" style=" width:70%">
			<div class="col-sm-3" style=" width:130%">
<div class="list-group" style="font-size:17pt">
<a href="user_profile.php" class="list-group-item"><i class="bi bi-person-circle"></i> Profile</a>
<a href="send_files_to_users.php" class="list-group-item"><i class="bi bi-send-fill"></i> Send Files</a>
<a href="list_of_key_requests.php" class="list-group-item"><i class="bi bi-key-fill"></i> Key Requests</a>
<a href="list_of_files_send_by_me.php" class="list-group-item"><i class="bi bi-send-check-fill"></i> Sent files</a>
<a href="list_of_received_files.php" class="list-group-item"><i class="bi bi-send-check-fill"></i> Received files</a>
<?php 
if(isset($_SESSION['user_type'])){
	if($_SESSION['user_type']=='admin'){
?>
<a href="list_of_files_send_by_other_users.php" class="list-group-item"><i class="bi bi-people"></i> Files sent by another</a>
<a href="display_graphs.php" class="list-group-item"><i class="bi bi-bar-chart-line"></i> Graphs</a>
<a href="users.php" class="list-group-item"><i class="bi bi-info-circle-fill"></i> User registeration request</a>
<a href="#" class="list-group-item"><i class="bi bi-paint-bucket"></i> Unauthorised access</a>
<?php
	}
	elseif($_SESSION['user_type']=='user'){
?>
<?php
	}
}
 ?>
</div>
				
			</div>
			<!-- col -->
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-12">
						<?php include_once('success_message.php');?>
					</div>
				</div>
				<!-- ROW -->

				

			</div>
			<!-- col -->
		</div>
		<!-- row -->
	</div>
	<!-- container -->
</body>
</html>