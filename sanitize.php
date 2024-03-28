<?php 
function sanitize($data){
	return htmlentities($data, ENT_QUOTES);
}
?>