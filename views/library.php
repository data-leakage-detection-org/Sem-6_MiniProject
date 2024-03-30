<?php 
function get_attempt($id){
  global $conn;
  $user_id=$_SESSION['user_id'];
  $sql="SELECT * FROM attempts WHERE file_id='$id' AND user_id='$user_id'";
  $result=mysqli_query($conn, $sql);
  $record = mysqli_fetch_array($result);
  return $record['attempt'];
}
function mark_attempt($id){
  global $conn;
  $user_id=$_SESSION['user_id'];
  $sql="SELECT * FROM attempts WHERE file_id='$id' AND user_id='$user_id'";
  $result=mysqli_query($conn, $sql);
  $record = mysqli_fetch_array($result);
  $attempt = $record['attempt']-1;
  mysqli_query($conn, "UPDATE attempts SET attempt='$attempt' WHERE file_id='$id' AND user_id='$user_id'");
  if($attempt==0){
    mysqli_query($conn, "UPDATE users SET blocked='1' WHERE id='$user_id' LIMIT 1");      
  }
}
function check_attempts($id){
  global $conn;
  $user_id=$_SESSION['user_id'];
  $sql="SELECT * FROM attempts WHERE file_id='$id' AND user_id='$user_id'";
  $result=mysqli_query($conn, $sql);
  $record = mysqli_num_rows($result);
  if($record > 0){    
  }
  else{
  mysqli_query($conn, "INSERT INTO attempts(user_id, file_id)VALUES('$user_id', '$id')");
  }
}

function getusername($userid){
    global $conn;  
	$sql="SELECT * FROM users WHERE id='$userid' LIMIT 1";
	$result=mysqli_query($conn,$sql);
	$rows=mysqli_fetch_array($result);
	return $rows['username'];
} 
function getuser($userid){
    global $conn;  
  $sql="SELECT * FROM users WHERE id='$userid' LIMIT 1";
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_array($result);
  return $row;
} 
function getfiledetail($fileid){
global $conn;
  $data="";
$sql="SELECT * FROM data_files WHERE id='$fileid' LIMIT 1";
$result=mysqli_query($conn,$sql);
if($result){
   if(mysqli_num_rows($result)>0){
            while($rows=mysqli_fetch_array($result)){
               $subject=$rows['subject'];
               $filename=$rows['file_name'];
               $f=$rows['file_size'];
               $filesize=round($rows['file_size'],2)."Mb";

               if($filesize==0){
                $filesize=round(($f*1024),3)."Kb";
               }
               $data.="
      <strong>Subject:</strong> $subject <br>
      <strong>File Name:</strong> $filename <br>
      <strong>File Size:</strong> $filesize
               ";
            }
   }
   else{
    $data.="not found";
   }
}
else{
  $error=mysqli_error($conn);
    $data.="
<div class='alert alert-danger'>
  <strong>Failed:</strong>
  dberror:$error
</div>
    ";
  }
  return $data;
}
?>