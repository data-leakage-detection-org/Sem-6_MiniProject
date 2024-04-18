<?php require_once("../server/connect.php"); ?>
<?php require_once("../session.php"); ?>
<?php
$otp = 0;
$errmessage='';
if(isset($_SESSION['otp'])){
    $otp = $_SESSION['otp'];
}

//DO NOT DELETE
if(isset($_SESSION['forgot']))
{
    // var_dump($_SESSION['forgot']);
}
//DO NOT DELETE
if(isset($_SESSION['register_email']))
{
    // echo $_SESSION['register_email'];
}

if(isset($_POST['confirmOTP'])){
    $enteredOTP = $_POST['otp'];
    if($enteredOTP == $otp)
    {
        unset($_SESSION['otp']);
        if(isset($_SESSION['user_id'])){ ///this
            header('location:change_password.php'); //this
        }
        else
        {
            if(isset($_SESSION['forgot']))
            {
                unset($_SESSION['forgot']);
                header('location:change_password.php');
            } //this
            else //this
            {
                // unset($_SESSION['forgot']);
                header('location:register.php'); //this
            }
        }
        //DO NOT DELETE ANYTHING

    }
    else
    {
        $errmessage = '<div class="alert alert-danger">OTP is incorrect!</div>';
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
    <div class="container" style="padding-top:12%">
        <div style="width:50%;margin:auto;border:1px solid black;padding:2.5%;border-radius:10px">
        <h2 class="text-center">OTP confirmation</h2><br>
        <div>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="mb-3">
                <label for="email">Enter OTP:</label>
                <input type="number" name="otp" class="form-control" required>
            </div>
            <?php echo $errmessage ?>
            <div class="mb-3 text-center">
                <button type="submit" name="confirmOTP" class="btn btn-primary">Confirm OTP</button>
            </div>
        </form>
        </div>
        </div>
            </div> 
    </body>
</html>