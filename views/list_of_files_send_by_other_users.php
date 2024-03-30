<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("library.php"); ?>
<?php 
function  keyRequestStatus($fileid, $asker){
	global $conn;
	$sql="SELECT * FROM key_requests WHERE file='$fileid' AND request_by_user='$asker'";
	$result=mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		$row=mysqli_fetch_array($result);
		return $row;
	}
	else{
		return [];
	}
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
		<div class="col-sm-12">

<table class='table table-bordered my-5 bg-white'>
	<thead>
	 <tr>
	    <th>Sr No</th>
	    <th>Subject</th>
	    <th>File name</th>
	    <th>file size</th>
	    <th>User(To)</th>    
	    <th>Action</th>
	 </tr>
	</thead>
<tbody>			
<?php
	$self=$_SESSION['user_id'];	
	$sql="SELECT * FROM data_files WHERE sender_id != '$self'";
	$result=mysqli_query($conn,$sql);
	if($result){
	   if(mysqli_num_rows($result)>0){
			$n=0;
	   		while($rows=mysqli_fetch_array($result)){
				$n++;
				$id=$rows['id'];
				$subject=$rows['subject'];
				$filename=$rows['file_name'];
				$filesize=$rows['file_size'];
				$userid=$rows['receiver_id'];
				$user=getusername($userid);
				$status = keyRequestStatus($id, $_SESSION['user_id']);
?>

<tr>
  <td><?=$n?></td>
  <td><?=$subject?></td>
  <td><?=$filename?></td>
  <td><?=$filesize?></td>
  <td><?=ucfirst($user)?></td> 
  <td>
  	<a href="download.php?id=<?=$id?>" class="btn btn-primary mb-2">Download</a>  
 <?php 
 	if(sizeof($status)>0){
 		if($status['status']=='pending'){
 			echo "Pending";
 		}
 		else if($status['status'] == 'shared'){
?>
Shared (<?=$status['secret_key']?>)
<?php 			
 		}
 		else if($status['status'] == 'rejected'){
 			echo "Rejected";
 		}
 	}
 	else{
 		?>
<a href="ask_for_key.php?id=<?=$id?>" class="btn btn-info mb-2">Ask for secret key</a>
<?php 		
 	}
  ?>	
  	
  </td> 
</tr>

<?php } ?>

</tbody>
</table>

<?php }else{ ?>

<div class='alert alert-danger'>
  <strong>Failed:</strong>
  No users found.
</div>

 <?php    } } else{ ?>

<div class='alert alert-danger'>
  <strong>Failed:</strong>
</div>

<?php } ?>
		</div>
		<!-- col -->
	</div>
	<!-- row -->
</div>
<!-- container -->
</body>
</html>