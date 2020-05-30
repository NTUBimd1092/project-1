<?php require_once('Connections/cralwer.php'); ?>
<?php
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_webinfo = 10;
$pageNum_webinfo = 0;
if (isset($_GET['pageNum_webinfo'])) {
  $pageNum_webinfo = $_GET['pageNum_webinfo'];
}
$startRow_webinfo = $pageNum_webinfo * $maxRows_webinfo;

mysql_select_db($database_cralwer, $cralwer);
$query_webinfo = "SELECT * FROM page_data where Link IN(SELECT Link FROM subscription where userid='7')";
$query_limit_webinfo = sprintf("%s LIMIT %d, %d", $query_webinfo, $startRow_webinfo, $maxRows_webinfo);
$webinfo = mysql_query($query_limit_webinfo, $cralwer) or die(mysql_error());
$row_webinfo = mysql_fetch_assoc($webinfo);

if (isset($_GET['totalRows_webinfo'])) {
  $totalRows_webinfo = $_GET['totalRows_webinfo'];
} else {
  $all_webinfo = mysql_query($query_webinfo);
  $totalRows_webinfo = mysql_num_rows($all_webinfo);
}
$totalPages_webinfo = ceil($totalRows_webinfo/$maxRows_webinfo)-1;

$queryString_webinfo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_webinfo") == false && 
        stristr($param, "totalRows_webinfo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_webinfo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_webinfo = sprintf("&totalRows_webinfo=%d%s", $totalRows_webinfo, $queryString_webinfo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<body>
<?php do { ?>
  <?php echo $row_webinfo['id']; ?><br />
<?php echo $row_webinfo['WebName']; ?><br />
<?php echo $row_webinfo['house']; ?><br />

  <?php } while ($row_webinfo = mysql_fetch_assoc($webinfo)); ?>
<a href="<?php printf("%s?pageNum_webinfo=%d%s", $currentPage, min($totalPages_webinfo, $pageNum_webinfo + 1), $queryString_webinfo); ?>">下一頁</a>
</body>
</html>
<?php
mysql_free_result($webinfo);
?>
