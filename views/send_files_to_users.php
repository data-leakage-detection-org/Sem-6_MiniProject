<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("../sanitize.php"); ?>
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
<div class="card my-4">
	<div class="card-body">		
<?php
 if(isset($_POST['send_file'])){
     	$userid=sanitize($_POST['userid']);
     	$senderid=sanitize($_SESSION['user_id']);
     	$subject=sanitize($_POST['subject']);

     	$filename=$_FILES['file']['name'];
     	$file_tmpname=$_FILES['file']['tmp_name'];
     	$filesize=$_FILES['file']['size']/(1024*1024);
     	$url="../assets/files/$filename";
		$ext=pathinfo($url, PATHINFO_EXTENSION);


if(!empty($subject) && !empty($filename) && !empty($userid))
{
     	if($filesize>10){
echo "
<div class='alert alert-warning'>
<strong>Failed:</strong>
File size must be less than 10 mb.
</div>
";
     	}
     	else{

        if( strtolower($ext) == "pdf" ){

			
     		$secretkey=mt_rand(1000,9999);


    $filename=md5(mt_rand(1,10000)).".$ext";
    $url="../assets/files/$filename";

// $date_time=date("Y-m-d H:i:s");
$sql="INSERT INTO data_files(
subject,
file_name,
file_size,
sender_id,
receiver_id,
secret_key
)VALUES
(
  '$subject',
  '$filename',
  '$filesize',
  '$senderid',
  '$userid',
  '$secretkey'
)
";

$result=mysqli_query($conn,$sql);
if($result){

if(move_uploaded_file($file_tmpname,$url)){
echo "
<div class='alert alert-success'>
 <strong>Success:</strong>
 File Successfully sent.
</div>
";
}
else{
    $sql1="DELETE FROM send_files WHERE file_name='$filename' AND id='$userid' LIMIT 1";
    $resutl1=mysqli_query($conn,$sql1);
    if($result1){
         echo "
<div class='alert alert-success'>
 <strong>Failed:</strong>
 File upload failed:
</div>
";
    }
    else{
        	$error=mysqli_error($conn);
echo "
<div class='alert alert-success'>
 <strong>Failed:</strong>
 dberror: $error
</div>
";
    }
}

}
else{
	$error=mysqli_error($conn);
echo "
<div class='alert alert-success'>
 <strong>Failed:</strong>
 dberror: $error
</div>
";
}

}
else{
  echo "
  <font size='4'>
  Please select proper file, only PDF files are allowed.
  ";
}
    
     	}
}
else{
	echo "
<div class='alert alert-warning'>
<strong>Failed:</strong>
Fill up data
</div>
	";
}
     }
?>


				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
						<div class="form-group mb-2">
								<label for="user">Select Recipient's Username</label>
<select name='userid' class='form-control' required>
<option></option>								
<?php								
$self=$_SESSION['user_id'];
$sql="SELECT * FROM users WHERE admin_active='1' AND id<>'$self' AND blocked='0' ORDER BY username ASC";
$result=mysqli_query($conn,$sql);
if($result){	
    if(mysqli_num_rows($result)>0){
           	while($rows=mysqli_fetch_array($result)){
           		$userid=$rows['id'];;
           		$username=$rows['username'];
?>           		
<option value='<?=$userid?>'><?=$username?></option>
<?php           		
           	}
           	}
           	}	
?>		
</select>					
						</div>


						<div class="form-group mb-2">
								<label for="subject">Subject</label>
								<input type="text" name="subject" class="form-control" required>
						</div>

						<div class="form-group mb-2">
							<label for="file">File</label>
							<input type="file" name="file" class="form-control" required>
						</div>

						<div class="form-group text-center mb-2">
							<input type="submit" name="send_file" value="Send" class="btn btn-primary">
						</div>
				</form>	
		
	</div>
</div>							
		</div>
	</div>
</div>
</body>
</html>