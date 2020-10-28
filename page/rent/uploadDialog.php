<?php

$hostname_cralwer = "localhost";
$database_cralwer = "crawler";
$username_cralwer = "root";
$password_cralwer = "xu.61i6u;6";
$con = mysqli_connect($hostname_cralwer, $username_cralwer, $password_cralwer, $database_cralwer); 

$test = "UPDATE user SET image="."'".$_POST['images']."'"." WHERE id=".$_POST['id'];
mysqli_query($con, $test);
move_uploaded_file($_FILES["file"]["tmp_name"], $path);

?>