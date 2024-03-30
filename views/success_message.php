<?php 
	if(isset($_SESSION['success_message'])){
		if(strlen($_SESSION['success_message'])>0){
?>
		<div class="alert alert-danger">
			<h6><?=$_SESSION['success_message']?></h6>
		</div>
<?php
	$_SESSION['success_message']='';
	}
	}
 ?>