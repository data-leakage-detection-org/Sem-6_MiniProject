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
			<div class="col-sm-6">
				<div class="card my-2">
					<div class="card-body">
<?php 
$userid=$_SESSION['user_id'];
if(isset($_POST['password']))
{
	header('location:change_password.php');

}
if(isset($_POST['update'])){		
		$username=$_POST['username'];	

		if(!empty($username) && !empty($mobile) && !empty($cpassword))
		{		
			$sql="UPDATE users SET username='$username', gender='$gender', mobile='$mobile' WHERE id='$userid' LIMIT 1";
			$result=mysqli_query($conn,$sql);
			if($result)
			{
				$_SESSION['username']=$username;
       			echo "<div class='alert alert-success'><strong> Successfully updated.</strong></div>";
			}
		else
		{
			echo "Failed to update information.";
		}              
		}
		else
		{ 
			echo " <div class='alert alert-danger'><strong>Failed: </strong> Please fill in all fields. </div>";
		}
}

$sql="SELECT * FROM users WHERE id='$userid' LIMIT 1";
$result=mysqli_query($conn,$sql);     
$rows=mysqli_fetch_array($result);
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
		<label for="username">Username</label>
		<input type="text" name="username" class="form-control" value="<?=$rows['username']?>" autofocus>
	</div>

	<div class="mb-3">
		<label for="mobile">Mobile</label>
		<input type="number" name="mobile" class="form-control" value="<?=$rows['mobile']?>">
	</div>

	<div class="mb-3">
		<label for="gender">Gender</label>
		<div class="form-check form-check-inline">
		  <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="male" <?php if($rows['gender']=="male"){echo "checked";}?>>
		  <label class="form-check-label" for="inlineRadio1">Male</label>
		</div>
		<div class="form-check form-check-inline">
		  <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="female" <?php if($rows['gender']=="female"){echo "checked";}?>>
		  <label class="form-check-label" for="inlineRadio2">Female</label>
		</div>
		<div class="form-check form-check-inline">
		  <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="other" <?php if($rows['gender']=="other"){echo "checked";}?>>
		  <label class="form-check-label" for="inlineRadio3">Other</label>
		</div>
	</div>

	<div class="mb-3 text-center">
		<input type="submit" name="update" value="Save changes" class="btn btn-primary">
	</div>

	<div class="mb-3 text-center">
		<button type="submit" name="password" class="btn btn-primary">Change password</button>
	</div>
	
</form>

						
					</div>					
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card my-2">

<div class="text-center">
<?php 
if(isset($_SESSION['profile'])){
	if($_SESSION['profile'] == 'user_profile.jpg'){
?>
<img 
	src="../assets/profiles/user_profile.jpg" 
	style="width:120px; height: 120px; border-radius: 50%;"/>
<?php
	}
	else{
?>
<img 
	src="../assets/profiles/<?=$_SESSION['profile']?>" 
	style="width:120px; height: 120px; border-radius: 50%;"/>	
<?php
	}
}
else{
?>
<img 
	src="../assets/profiles/user_profile.jpg" 
	style="width:120px; height: 120px; border-radius: 50%;"/>
<?php
	}
 ?>
</div>

					<div class="card-body">

<?php
// upload

if(isset($_POST['upload'])){
	$files = $_FILES['profile'];
	if(in_array( strtolower( $files['type'] ), ['image/jpeg', 'image/jpg', 'image/png'])){
		$path="../assets/profiles/".$files['name'];
		$ext=pathinfo($path, PATHINFO_EXTENSION);
		$name = md5(mt_rand(1, 10000)).".$ext";		
		$query="UPDATE users SET profile='$name' WHERE id='$userid' LIMIT 1";		
		$result= mysqli_query($conn, $query);
		if($result){
			$path="../assets/profiles/".$name;
			move_uploaded_file($files['tmp_name'], $path);
			$_SESSION['profile']=$name;
			$url=$_SERVER['PHP_SELF'];
			header("Location:$url");
			exit();
		}
		else{
			echo mysqli_error($conn);
		}
	}	
	else{
		echo "<div class='text-danger'>Please select only jpeg, jpg, png files</div>";
	}
}

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
<div class="input-group mb-2">
  <input type="file" name="profile" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" required>  
</div>						

<div class="mb-2 text-center">
	<input type="submit" name="upload" value="Change profile picture" class="btn btn-primary">
</div>
</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>