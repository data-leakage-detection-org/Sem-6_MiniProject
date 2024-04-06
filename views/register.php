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
<body class="login_background">
	<?php include_once("menubar.php"); ?>

	<div class="container">
		<div class="row my-5">
			<div class="col-sm-4 mx-auto">
				<div class="card">
					<div class="card-body">
<?php
	$errmessage='';
	if(isset($_SESSION['error_message']))
	{
		$errmessage = $_SESSION['error_message'];
	}
	if(isset($_POST['register'])){
		$username=sanitize($_POST['username']);
		$email = '';
		// $email=sanitize($_POST['email']); commented this
		if(isset($_SESSION['register_email'])) //this
		{
			$email = $_SESSION['register_email']; //this
		} //this
		$password=sanitize($_POST['password']);
		$cpassword=sanitize($_POST['cpassword']);
		$result = mysqli_query($conn,"SELECT * from users WHERE username='$username'");
		if(mysqli_num_rows($result)>0){
			$_SESSION['error_message']='<div class="alert alert-danger">Username already exists</div>';
			header('location:register.php');
			exit();
		}
		// $result = mysqli_query($conn,"SELECT * from users WHERE email='$email'"); commented this
		// if(mysqli_num_rows($result)>0){
		// 	$_SESSION['error_message']='<div class="alert alert-danger">Email already exists</div>';
		// 	header('location:register.php');
		// 	exit();
		// } commented this
		if(empty($username)){
			echo "Username is required.";
			exit();
		}
		// if(empty($email)){ commented this
		// 	echo "Email id is required.";
		// 	exit();
		// } commented this
		if(empty($password)){
			echo "Password is required.";
			exit();
		}
		if(empty($cpassword)){
			echo "Confirm password is required.";
			exit();
		}
		if($cpassword != $password){
			echo "Passwords do not match.";
			exit();
		}		
		$result=mysqli_query($conn, "INSERT INTO users(username, email, password)VALUES('$username', '$email', '$password')");
		if($result){
			unset($_SESSION['register_email']);
			unset($_SESSION['error_message']); //this
			// unset($_SESSION['forgot']); DO NOT DELETE
			$_SESSION['success_message']="Account creation successful. Please wait for admin approval.";
			header("Location:login.php");
			exit();			
		}
		else{
			echo "Something wrong, try again.";
		}
	}
 ?>
						<form action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
							<div class="mb-2">
								<label for="username">Username</label>
								<input type="text" name="username" class="form-control" required autofocus>
							</div>
							<!-- <div class="mb-2"> commented this
								<label for="email">Email id</label>
								<input type="text" name="email" class="form-control" required>
							</div> commmented this -->
							<div class="mb-2">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" required>
							</div>

							<div class="mb-2">
								<label for="cpassword">Confirm Password</label>
								<input type="password" name="cpassword" class="form-control" required>
							</div>

							<div class="mb-2 text-center">
								<input type="submit" name="register" value="Register" class="btn btn-primary">
							</div>

							<?php echo $errmessage ?>

							<div class="mb-2 text-center">
								<a href="login.php" class="text-decoration-none">Already have an account?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- row -->
	</div>
</body>
</html>