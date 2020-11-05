<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cralwer = "localhost";
$database_cralwer = "crawler";
$username_cralwer = "root";
$password_cralwer = "xu.61i6u;6";
$cralwer = mysql_pconnect($hostname_cralwer, $username_cralwer, $password_cralwer) or trigger_error(mysql_error(),E_USER_ERROR); 
?>