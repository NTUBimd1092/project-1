<?php

$hostname_cralwer = "localhost";
$database_cralwer = "id15333885_crawler";
$username_cralwer = "id15333885_root";
$password_cralwer = "Rentxu.61i6u;6";
$con = mysqli_connect($hostname_cralwer, $username_cralwer, $password_cralwer, $database_cralwer); 
include "encrypt.php";
$myimage="images/".$_POST['images'];
$test = "UPDATE `user` SET image="."'".encryptthis($myimage,$key)."'"." WHERE id=".$_POST['id'];
mysqli_query($con, $test);
move_uploaded_file($_FILES["file"]["tmp_name"], $path);

?>