<?php require_once('Connections/crawler.php'); ?>
<?php
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
	
  $logoutGoTo = "index.php";
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

$maxRows_page_data = 10;
$pageNum_page_data = 0;
if (isset($_GET['pageNum_page_data'])) {
  $pageNum_page_data = $_GET['pageNum_page_data'];
}
$startRow_page_data = $pageNum_page_data * $maxRows_page_data;

mysql_select_db($database_crawler, $crawler);
$query_page_data = "SELECT * FROM page_data ORDER BY id ASC";
$query_limit_page_data = sprintf("%s LIMIT %d, %d", $query_page_data, $startRow_page_data, $maxRows_page_data);
$page_data = mysql_query($query_limit_page_data, $crawler) or die(mysql_error());
$row_page_data = mysql_fetch_assoc($page_data);

if (isset($_GET['totalRows_page_data'])) {
  $totalRows_page_data = $_GET['totalRows_page_data'];
} else {
  $all_page_data = mysql_query($query_page_data);
  $totalRows_page_data = mysql_num_rows($all_page_data);
}
$totalPages_page_data = ceil($totalRows_page_data/$maxRows_page_data)-1;

$colname_session = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_session = $_SESSION['MM_Username'];
}
mysql_select_db($database_crawler, $crawler);
$query_session = sprintf("SELECT * FROM menber WHERE account = %s", GetSQLValueString($colname_session, "text"));
$session = mysql_query($query_session, $crawler) or die(mysql_error());
$row_session = mysql_fetch_assoc($session);
$totalRows_session = mysql_num_rows($session);
?><!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<title>產業報告資訊整合平台</title>
</head>
<body>
<div class="row">
  <div class="col-md-4"><a href="login.php">登入</a></div>
  <div class="col-md-4">
  <table class="table">
  <th colspan="3"><p align="center">產業報告資訊整合平台</p>
    </th>
  <tr>
  <td></td>
  <td>產業報告名稱</td> 
  <td>下載</td>
  </tr>
  <?php 
  $x=0;
  do { ?>
    <tr>
      <td><?php echo ++$x;?></td>
      <td><?php echo $row_page_data['pdf']; ?></td>     
      <td><a href="#">下載</a></td>
    </tr>
    <?php } while ($row_page_data = mysql_fetch_assoc($page_data)); ?>
  </table>
  </div>
  <div class="col-md-4"><p>您好：<?php echo $row_session['account']; ?></p>
  <a href="<?php echo $logoutAction ?>">登出</a>
  </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysql_free_result($page_data);

mysql_free_result($session);
?>