<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php require_once("library.php"); ?>
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
	<div class="row my-5">
		<div class="col-sm-12">
<table class='table table-bordered bg-white'>
<thead>
  <tr>
		<th>Sr No</th>
		<th>User Name</th>
		<th>Email Id</th>
		<th>Activate account</th>		
  </tr>
</thead>
<tbody>
<?php

if(isset($_POST['activate'])){
  $userid=$_POST['userid'];
  echo $userid;  
 $sql="UPDATE users SET admin_active='1' WHERE admin_active='0' AND id='$userid' LIMIT 1";
	$result=mysqli_query($conn,$sql);
}
else if(isset($_POST['deactivate'])){
	  $userid=$_POST['userid'];	  
$sql="UPDATE users SET admin_active='0' WHERE admin_active='1' AND id='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);
}

$sql="SELECT * FROM users WHERE user_type='user' ORDER BY id DESC";
$result=mysqli_query($conn,$sql);
if($result){
       if(mysqli_num_rows($result)>0){
			$i=0;
			while($rows=mysqli_fetch_array($result)){
				$i++;
				$userid=$rows['id'];
				$username=$rows['username'];
				$email=$rows['email'];
				$admin_active=$rows['admin_active'];
				$usertype=$rows['user_type'];
				$user=getuser($userid);				
?>
<tr>
	<td><?=$i?></td>
	<td>
		<?=ucfirst($username)?>			<br/>
	<strong>Gender:</strong> <?=$rows['gender']?> <br/>
	<strong>Mobile:</strong> <?=$rows['mobile']?> <br/>
	</td>
	<td><?=ucfirst($email)?></td>
	<td>
<?php 
if($admin_active=="0"){
?>
<form action='<?=$_SERVER["PHP_SELF"]?>' method='post'>
    <input type='hidden' name='userid' value='<?=$userid?>'>
    <input type='submit' name='activate' value='Activate' class='btn btn-success mb-2'>
</form>
<?php
}
else if($admin_active=="1"){
?>
<form action='<?=$_SERVER["PHP_SELF"]?>' method='post'>
    <input type='hidden' name='userid' value='<?=$userid?>'>
    <input type='submit' name='deactivate' value='Deactivate' class='btn btn-danger mb-2'>
</form>
<?php
}
?>		

<?php if($user['blocked']=="0"){ ?>
		<a href="block_user.php?id=<?=$user['id']?>" class="btn btn-info mb-1">Block</a>
		<a href="remove_user.php?id=<?=$user['id']?>" class="btn btn-danger mb-1">Remove</a>
	<?php }else if($user["blocked"]=="1"){ ?>
		<a href="unblock_user.php?id=<?=$user['id']?>" class="btn btn-warning mb-1">Unblock</a>
	<?php } ?>

	</td>
</tr>
<?php

			}
			// while
		}
		// total records
}
?>
			
		</div>
	</div>
</div>
</body>
</html>