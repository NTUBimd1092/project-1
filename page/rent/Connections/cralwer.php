<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$url = parse_url(getenv("CLEARDB_CYAN_URL"));

$hostname_cralwer  = $url["host"];
$username_cralwer = $url["user"];
$password_cralwer = $url["pass"];
$database_cralwer = substr($url["path"], 1);

$cralwer=mysqli_connect($hostname_cralwer,$username_cralwer,$password_cralwer) or die ("無法開啟Mysql資料庫連結"); //建立mysql資
mysqli_query($cralwer,"SET CHARACTER SET UTF8");

?>