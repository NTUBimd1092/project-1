<?php require_once('Connections/cralwer.php'); ?>
<?php
mysql_query("SET NAMES 'utf8'");//修正中文亂碼問題
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
@session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
/*登入資料查詢*/
$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
$userid=$row_Login['id'];

/*登入帳號的金錢異動查詢*/
mysql_select_db($database_cralwer, $cralwer);
$query_AllTransaction = "SELECT * FROM money_change WHERE userid = $userid ORDER BY Link ASC";
$AllTransaction = mysql_query($query_AllTransaction, $cralwer) or die(mysql_error());
$row_AllTransaction = mysql_fetch_assoc($AllTransaction);
$totalRows_AllTransaction = mysql_num_rows($AllTransaction);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>作伙</title>
</head>

<body>
<a href="searchArea.php"  class="mytext">搜尋列表</a>
<a href="userPage.php" class="mytext">嗨！<?php echo $row_Login['name']; ?></a> 
<a href="<?php echo $logoutAction ?>">登出</a>
<?php echo $row_Login['id']; ?>
<hr />
全部異動紀錄：<br /><hr />
<?php do { 
/*關聯page_data與money_change*/
$Link=$row_AllTransaction['Link'];

mysql_select_db($database_cralwer, $cralwer);
$query_webinfo = "SELECT * FROM page_data WHERE Link = '$Link'";
$webinfo = mysql_query($query_webinfo, $cralwer) or die(mysql_error());
$row_webinfo = mysql_fetch_assoc($webinfo);
$totalRows_webinfo = mysql_num_rows($webinfo);
?>
  編號：<?php echo $row_AllTransaction['id']; ?><br />
  名稱：<?php echo $row_webinfo['house']; ?><br />
  連結：<a href="<?php echo $row_AllTransaction['Link']; ?>" target="_blank"><?php echo $row_AllTransaction['Link']; ?></a><br />
  日期：<?php echo $row_AllTransaction['date']; ?><br />
  金額：<?php echo $row_AllTransaction['money']; ?>$<br />
  <hr />
  <?php } while ($row_AllTransaction = mysql_fetch_assoc($AllTransaction)); ?>

</body>
</html>
<?php
mysql_free_result($AllTransaction);

mysql_free_result($webinfo);

mysql_free_result($Login);
?>
