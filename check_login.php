<?php 
if(isset($_SESSION['is_login'])){
  if($_SESSION['is_login']=='loggedIn'){
?>
 <?php if(isset($_SESSION['profile'])){ ?>  
	  <li class="nav-item">
		<img src="assets/profiles/<?=$_SESSION['profile']?>" style="width: 40px; height:40px; border-radius: 100%;">    
	  </li>
	<?php } ?>
 <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="views/dashboard.php"><?=strtoupper($_SESSION['username'])?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="views/logout.php">
    	<i class="bi bi-box-arrow-right"></i> Logout</a>
  </li>  
<?php }else{?>
 <li class="nav-item">
      <a class="nav-link active" aria-current="page" href="views/login.php"><i class="bi bi-box-arrow-in-left"></i> Login</a>
</li>  
<?php }}else{?>
 <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="views/login.php"><i class="bi bi-box-arrow-in-left"></i> Login</a>
  </li>  
<?php }?> 