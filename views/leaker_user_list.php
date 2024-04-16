<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
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
<div class="container">
	<div class="row">
		<div class="col-sm-12">
<table class='table table-bordered bg-white my-5'>
	<thead>
	   <tr>
	        <th>Sr No</th>	        
	        <th>File Details</th>
	        <th>Leaker</th>	        	        
	   </tr>
	</thead>
	<tbody>
<?php 
	$sql="SELECT * FROM leakers ORDER BY id DESC";
	$result=mysqli_query($conn,$sql);
	if($result){
	     if(mysqli_num_rows($result)>0){
			$n=0;
	        while($rows=mysqli_fetch_array($result)){
	          	$n++;
	          	$id=$rows['id'];
	            $userid=$rows['user_id'];
	            $subject=$rows['subject'];
	            $fileid=$rows['file_id'];
	            $secretkey=$rows['secret_key'];              
				$user=getuser($userid);
				$file_detail=getfiledetail($fileid);
?>   
<tr>
  <td><?=$n?></td>
  <td><?=$file_detail?></td>
  <td>
	<strong>Username:</strong> <?=$user['username']?><br/>
	<strong>Email:</strong> <?=$user['email']?><br/>
	<strong>Mobile:</strong> <?=$user['mobile']?><br/>	
	<?php if($user['blocked']=="0"){ ?>
		<a href="block_user.php?id=<?=$user['id']?>" class="btn btn-info mb-1">Block</a>
		<a href="remove_user.php?id=<?=$user['id']?>" class="btn btn-danger mb-1">Remove</a>
	<?php }else if($user["blocked"]=="1"){ ?>
		<a href="unblock_user.php?id=<?=$user['id']?>" class="btn btn-warning mb-1">Unblock</a>
	<?php } ?>
  </td>  
</tr>         
<?php } }  } ?>

</tbody>
</table>

		</div>
		<!-- col -->
	</div>
	<!-- row -->
</div>
<!-- container -->
</body>
</html>