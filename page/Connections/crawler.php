<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_crawler = "localhost";
$database_crawler = "crawler";
$username_crawler = "root";
$password_crawler = "";
$crawler = mysql_pconnect($hostname_crawler, $username_crawler, $password_crawler) or trigger_error(mysql_error(),E_USER_ERROR); 
?>