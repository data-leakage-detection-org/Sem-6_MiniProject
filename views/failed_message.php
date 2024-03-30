<?php 
	if(isset($_SESSION['failed_message'])){
		if(strlen($_SESSION['failed_message'])>0){
?>
		<div class="alert alert-danger">
			<h6><?=$_SESSION['failed_message']?></h6>
		</div>
<?php
	$_SESSION['failed_message']='';
	    }
	}
 ?>