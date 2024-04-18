<?php require_once("../server/connect.php"); ?>
<?php require_once("../session.php"); ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);

$userid=-1;
if(isset($_SESSION['user_id']))
{
    $userid = $_SESSION['user_id'];
}
$result = mysqli_query($conn,"SELECT  * from users where id=$userid");
$username='';
$email='';
$errmessage='';
if(isset($_SESSION['error_message'])){
    $errmessage = $_SESSION['error_message'];
}
if(mysqli_num_rows($result)>0){
    $rows=mysqli_fetch_array($result);
    $username = $rows['username'];
    $email = $rows['email'];
}
// echo($username."  ".$email);

function OTPgenerator(){
    return rand(1,9)*pow(10,5) +
            rand(0,9)*pow(10,4) +
            rand(0,9)*pow(10,3) +
            rand(0,9)*pow(10,2) +
            rand(0,9)*pow(10,1) +
            rand(0,9)*pow(10,0);
}

if(isset($_SESSION['forgot']))
{
    // var_dump($_SESSION['forgot']);
}

if(isset($_POST['sendEmail'])){
    if(!isset($_SESSION['user_id']))
    {
        if(!isset($_SESSION['forgot']))
        {
            $email = $_POST['email'];
            if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"))>0) //this
            {
                $_SESSION['error_message'] = "<div class='alert alert-danger'>This email already has an account!</div>";
                header('location:sendEmail.php');
                exit();
            } 
        } 
        else
        {
            $email = $_POST['email'];
            if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='$email'"))==0) //this
            {
                $_SESSION['error_message'] = "<div class='alert alert-danger'>This email does not have an account!</div>";
                header('location:sendEmail.php');
                exit();
            }
        }
    }
    
    {
        // Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    // ^change this to 2 to get full verbose about what went wrong if something does

    $mail->isSMTP();                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                   // Enable SMTP authentication
    $mail->Username   = 'eschrodinger517@gmail.com'; // SMTP username
    $mail->Password   = 'eqewadisbelqwwja';          // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                    // TCP port to connect to

    // Recipients
    // $email = $_POST['email']; //this
    $mail->setFrom('no-reply@dld.com', 'no-reply');
    // $mail->addAddress($email, $username);
    $mail->addAddress($email, $username);

    $otp = OTPgenerator();
    $_SESSION['otp']=$otp;

    // Content
    $mail->isHTML(true);                       // Set email format to HTML
    $mail->Subject = 'Phpmailer OTP';
    if(!isset($_SESSION['user_id']))
    {
        $mail->Body    = 'This email has been sent using PHP<br>Your OTP to verify your email is '. $otp.
                        '<br>Do not share this OTP with anyone.';
        $mail->AltBody = 'This email has been sent using PHP. Your OTP to verify your email is '.$otp.
                        ' Do not share this OTP with anyone.';
    }
    else
    {
        $mail->Body    = 'This email has been sent using PHP<br>Your OTP to change password in DLD is '. $otp.
                        '<br>Do not share this OTP with anyone.';
        $mail->AltBody = 'This email has been sent using PHP. Your OTP to change password in DLD is '.$otp.
                        ' Do not share this OTP with anyone.';
    }
    
    // $sendresult = ;
    if($mail->send()){
        if(!isset($_SESSION['user_id'])){  //this
            $_SESSION['register_email'] = $email;
        }
        if(isset($_SESSION['error_message'])){
            unset($_SESSION['error_message']);
        } //this
        header('location:confirmOTP.php');
    }
    else
    {
        $errmessage = '<div class="alert alert-danger">Invalid email</div>';
    }
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
        <h2 class="text-center">Confirm email</h2><br>
        <div>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="mb-3">
                <label for="email">
                    <?php if(isset($_SESSION['user_id'])) { ?> <!-- this -->
                    An email containing an OTP to change the password will be sent to the following registered email address:
                    <?php } else { ?> <!-- this -->
                    An email containing an OTP to verify your account will be sent to the following email address: <!-- this -->
                    <?php } ?>
                </label>
                <input type="text" name="email" class="form-control" value="<?php echo $email ?>"
                <?php if(isset($_SESSION['user_id'])) { //this ?>
                disabled 
                <?php } //this ?> 
                >
            </div>
            <?php echo $errmessage ?>
            <div class="mb-3 text-center">
                <button type="submit" name="sendEmail" class="btn btn-primary">Send Email</button>
            </div>
        </form>
        </div>
        </div>
            </div>  
    </body>
</html>