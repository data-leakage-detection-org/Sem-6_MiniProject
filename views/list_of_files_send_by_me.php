<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("library.php");?>
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
	 </tr>
	</thead>
<tbody>			
<?php
	$self=$_SESSION['user_id'];	
	$sql="SELECT * FROM data_files WHERE sender_id='$self'";
	$result=mysqli_query($conn,$sql);
	if($result){
	   if(mysqli_num_rows($result)>0){
			$n=0;
	   		while($rows=mysqli_fetch_array($result)){
				$n++;
				$subject=$rows['subject'];
				$filename=$rows['file_name'];
				$filesize=$rows['file_size'];
				$userid=$rows['receiver_id'];
				$user=getusername($userid);
?>

<tr>
  <td><?=$n?></td>
  <td><?=$subject?></td>
  <td><?=$filename?></td>
  <td><?=$filesize?></td>
  <td><?=ucfirst($user)?></td>  
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