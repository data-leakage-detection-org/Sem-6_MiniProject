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
    <div class="container" style="padding-top:12%">
        <div style="width:50%;margin:auto;border:1px solid black;padding:2.5%;border-radius:10px">
        <h2 class="text-center">Change password</h2><br>
<?php
$userid=-1;
// if(isset($_SESSION['register_email']))
// {
    // echo $_SESSION['register_email'];
// }
if(isset($_SESSION['user_id']))
{
   $userid=$_SESSION['user_id']; 
}
elseif(isset($_SESSION['register_email']))
{
    // echo $_SESSION['register_email'];
    $email = $_SESSION['register_email'];
    $result = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
    $row = mysqli_fetch_array($result);
    $userid = $row['id'];
    // echo $userid;
}
if(isset($_POST['change_password'])){
    $password=$_POST['password'];
    $cpassword=$_POST['cpassword'];
    if(!empty($password) && !empty($cpassword))
    {
        if($password ==$cpassword)
        {
            $sql="UPDATE users SET password='$password' WHERE id='$userid' LIMIT 1";
            $result=mysqli_query($conn,$sql);
            if($result)
            {
                echo "<div class='alert alert-success'><strong>Success:</strong> Successfully updated.</div>";
                unset($_SESSION['register_email']);
                // unset($_SESSION['forgot']); DO NOT DELETE
            }
        }
        else
        {
            echo "<div class='alert alert-danger'><strong>Failed:</strong> Please re-enter password correctly.</div>";
        }
    }
    else
    {
        echo "<div class='alert alert-danger'><strong>Failed:</strong> Please fill in all the fields.</div>";
    }
}
?>
<div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <div class="mb-3">
		<label for="password">New Password:</label>
		<input type="password" name="password" class="form-control" required>
	</div>
    <div class="mb-3">
		<label for="cpassword">Confirm Password:</label>
		<input type="password" name="cpassword" class="form-control" required>
	</div>
    <br>
    <div class="mb-3 text-center">
		<button type="submit" name="change_password" class="btn btn-primary">Save</button>
	</div>
</form>
</div>
</div>
    </div>  
</body>
</html>

<!-- style="width:70%;margin:auto" -->