<?php

$url = parse_url(getenv("CLEARDB_CYAN_URL"));

$hostname_cralwer  = $url["host"];
$username_cralwer = $url["user"];
$password_cralwer = $url["pass"];
$database_cralwer = substr($url["path"], 1);

$con = mysqli_connect($hostname_cralwer, $username_cralwer, $password_cralwer, $database_cralwer); 
include "encrypt.php";
$myimage="images/".$_POST['images'];
$test = "UPDATE user SET image="."'".encryptthis($myimage,$key)."'"." WHERE id=".$_POST['id'];
mysqli_query($con, $test);
move_uploaded_file($_FILES["file"]["tmp_name"], $path);

?>