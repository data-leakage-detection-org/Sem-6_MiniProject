<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("library.php"); ?>
<?php 
 if(isset($_POST['share_key'])){
 	$fileid=$_POST['fileid'];
$sql="UPDATE key_requests SET status='shared' WHERE status='pending' AND file='$fileid' LIMIT 1";
mysqli_query($conn,$sql);
 }
 
 if(isset($_POST['decline'])){
     $fileid=$_POST["fileid"];
     $requestby=$_POST["requestby"];
$sql="UPDATE key_requests SET status='rejected' WHERE file='$fileid' AND request_by_user='$requestby' LIMIT 1";
mysqli_query($conn,$sql);     
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

<table class='table table-bordered bg-white my-3'>
<thead>
  <tr>
     <th>Sr No</th>
     <th>Request By</th>
     <th>File</th>
     <th>Status</th>     
  </tr>
</thead>
<tbody>
<?php 
	$self=$_SESSION['user_id'];
	$sql="SELECT * FROM key_requests WHERE request_to_user='$self'";
	$result=mysqli_query($conn,$sql);
?>
<?php 
		$n=0;
        while($rows=mysqli_fetch_array($result)){
     		$n++;
            $requestby=$rows['request_by_user'];
            $fileid=$rows['file'];
            $request_label=$rows['status'];            
		    $username=getusername($requestby);
		    $file_detail=getfiledetail($fileid);
?>

<tr>
    <td><?=$n?></td>
    <td><?=$username?></td>
    <td><?=$file_detail?></td>
    <td>

<?php  if($request_label=="pending"){ ?>
<form action="<?=$_SERVER['PHP_SELF']?>" method='post'>
      <input type='hidden' name='fileid' value='<?=$fileid?>'>
      <input type='submit' name='share_key' value='Share Key' class='btn btn-primary'>
 </form>
         <hr>
 <form action="<?=$_SERVER['PHP_SELF']?>" method='post'>
      <input type='hidden' name='fileid' value='<?=$fileid?>'>
      <input type='hidden' name='requestby' value='<?=$requestby?>'>
      <input type='submit' name='decline' value='Decline' class='btn btn-primary'>
 </form>
<?php }else if($request_label=="rejected"){ ?>
	Rejected
<?php } else if($request_label == "shared"){ ?>
	Shared
<?php } ?>    	


    </td>
 </tr>

<?php } ?>


</tbody>
</table>

			
		</div>
	</div>
</div>	
</body>
</html>