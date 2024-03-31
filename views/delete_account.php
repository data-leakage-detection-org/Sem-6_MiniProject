<?php 
if(isset($_POST['home'])){
    header("Location:../index.php");
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
    <?php include_once("bootstrap.php"); ?>
</head>
<body class='text-center'>
    <h1>Account successfully deleted</h1>
    <form method="post">
        <button class='btn btn-primary' type='submit' name='home'>Back to home</button>
    </form>
</body>
</html>