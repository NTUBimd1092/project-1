<?php require_once('Connections/cralwer.php'); ?>
<?php
mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
  $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
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
$maxRows_Login = 10;
$pageNum_Login = 0;
if (isset($_GET['pageNum_Login'])) {
  $pageNum_Login = $_GET['pageNum_Login'];
}
$startRow_Login = $pageNum_Login * $maxRows_Login;

$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$query_limit_Login = sprintf("%s LIMIT %d, %d", $query_Login, $startRow_Login, $maxRows_Login);
$Login = mysql_query($query_limit_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);

if (isset($_GET['totalRows_Login'])) {
  $totalRows_Login = $_GET['totalRows_Login'];
} else {
  $all_Login = mysql_query($query_Login);
  $totalRows_Login = mysql_num_rows($all_Login);
}
$totalPages_Login = ceil($totalRows_Login/$maxRows_Login)-1;
$userid = $row_Login['id'];

/*此帳號訂閱查詢*/
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_webinfo = 10;
$pageNum_webinfo = 0;
if (isset($_GET['pageNum_webinfo'])) {
  $pageNum_webinfo = $_GET['pageNum_webinfo'];
}
$startRow_webinfo = $pageNum_webinfo * $maxRows_webinfo;

mysql_select_db($database_cralwer, $cralwer);
$query_webinfo = "SELECT * FROM page_data where Link IN(SELECT Link FROM subscription where userid='$userid')";
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

//刪除訂閱
@$deluid=base64_decode($_GET['userid']);
@$delLink=base64_decode($_GET['Link']);
if ((isset($_GET['del'])) && ($_GET['del'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `crawler`.`subscription` WHERE `subscription`.`userid` ='$deluid' AND `subscription`.`Link` ='$delLink'");
  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($deleteSQL, $cralwer) or die(mysql_error());
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>作伙</title>
  <link rel="icon" href="images/logo.ico" type="image/x-icon">
  <style>
    body {
      font-family: 微軟正黑體;
      background-color: #EFEFEF;
    }

    .header {
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
      position: fixed;
      /*position: absolute;*/
      top: 0;
      left: 0;
    }

    .header a {
      text-decoration: none;
    }

    .header a:link {
      text-decoration: none;
      color: white;
    }

    .header a:visited {
      text-decoration: none;
      color: white;
    }

    .headerRight {
      float: right;
      font-size: 15px;
      line-height: 40px;
      padding-top: 3px;
      padding-right: 15px;
      color: white;
    }

    .headerRight a {
      text-decoration: none;
      font-size: 16px;
      padding: 3px 8px;
    }

    .headerRight a:link {
      text-decoration: none;
      color: white;
    }

    .headerRight a:visited {
      text-decoration: none;
      color: white;
    }

    .headerRight a:hover {
      color: rgb(126, 83, 34, 0.85);
      background-color: white;
      border-radius: 3px;
    }

    .HomeIcon {
      height: 25px;
      padding-top: 8px;
      padding-right: 3px;
      padding-left: 8px;
    }

    .accountData {
      background-color: #D0B392;
      color: #707070;
      font-size: 16px;
      width: 100%;
      height: 150px;
      position: fixed;
      position: absolute;
      top: 45px;
      left: 0;
      z-index: -1;
    }

    .accountData table {
      text-align: center;
      vertical-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .accountData th {
      font-size: 18px;
      padding: 0 25px;
    }

    .accountData td {
      padding: 0 25px;
    }

    .accountData a {
      text-decoration: none;
    }

    .accountData a:link {
      text-decoration: none;
      color: #707070;
    }

    .accountData a:visited {
      text-decoration: none;
      color: #707070;
    }

    .input {
      width: 470px;
      height: 28px;
      margin: 5px 3px;
      padding: 1.5px 8px;
      font-family: Arial, 微軟正黑體;
      border: 0 none;
      border-radius: 5px;
    }

    .resultDiv {
      top: 50%;
      left: 50%;
      margin: 10px auto;
      align-items: center;
      justify-content: center;
    }

    .resultDiv table {
      width: 750px;
      padding: 5px;
      background-color: #FFFFFF;
      color: #726A6A;
      border: 1px solid #FFFFFF;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 10px;
      line-height: 15px;
      font-size: 14px;
    }

    th {
      padding: 5px;
      color: rgb(114, 106, 106, 0.9);
      vertical-align: center;
    }

    td {
      padding: 5px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      vertical-align: center;
    }

    .favorite {
      width: 20px;
      padding-top: 5px;
    }

    .more {
      width: 75%;
      padding: 3px;
      color: white;
      font-size: 12px;
      font-family: 微軟正黑體;
      border: rgb(126, 83, 34, 0.85);
      background-color: rgb(126, 83, 34, 0.85);
    }

    .more a {
      text-decoration: none;
    }

    .more a:link {
      text-decoration: none;
      color: white;
    }

    .more a:visited {
      text-decoration: none;
      color: white;
    }

    .pages {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .pages a {
      text-decoration: none;
    }

    .pages a:link {
      text-decoration: none;
      color: #7E5322;
    }

    .pages a:visited {
      text-decoration: none;
      color: #7E5322;
    }

    .footer {
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
      position: absolute;
      left: 0;
    }

    .footer a {
      text-decoration: none;
    }

    .footer a:link {
      text-decoration: none;
      color: white;
    }

    .footer a:visited {
      text-decoration: none;
      color: white;
    }
  </style>

</head>

<body>

  <div class="header">
    <span>
      <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a>
      <a href="home.php">作伙</a>
    </span>

    <div class="headerRight">
      <a href="userPage.php" style="border:1px solid white; border-radius:2px;">嗨！<?php echo $row_Login['name']; ?></a>
      <a href="searchArea.php">搜尋列表</a>
      <a href="<?php echo $logoutAction ?>">登出</a> </div>
  </div>

  <div class="accountData">
    <table>
      <tr>
        <td rowspan="2"><img width="60px" height="60px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></td>
        <th><?php echo $totalRows_webinfo; ?> </th>
        <th><a href="priceFluctuation.php">0</a></th>
        <th>0</th>
      </tr>

      <tr>
        <td><a href="favorite.php">已收藏</a></td>
        <td><a href="priceFluctuation.php">價格異動</a></td>
        <td>為您推薦</td>
      </tr>
    </table>
  </div>

  <div style="margin-top:205px"></div>
    <div class="resultDiv">
      <?php if ($totalRows_webinfo > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <table align="center" id="customers" style="margin-top:10px">
          <tr>
            <td rowspan="4" width="25%" align="center" valign="center"><img width="160px" src="<?php echo $row_webinfo['images']; ?>"></td>
            <th colspan="2" width="38%" align="left" style="font-size:20px"><?php echo $row_webinfo['house']; ?></th>
            <td rowspan="4" width="2%" valign="top"><a href="favorite.php?del=1&userid=<?php echo base64_encode($row_Login['id']);?>&Link=<?php echo base64_encode($row_webinfo['Link']);?>"><img src="images/selectedFav.png" alt="like" class="favorite"></a></td>
            <td width="20%" align="center" style="font-size:12.5px">來自：<?php echo $row_webinfo['WebName']; ?></td>
            <td width="15%" align="center">PRICE</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo $row_webinfo['adress']; ?></td>
            <td rowspan="2" align="center" style="font-size:26px"><?php echo $row_webinfo['money']; ?></td>
            <td align="center">PRICE</td>
          </tr>
          <tr>
            <td>坪數：<?php echo $row_webinfo['square_meters']; ?></td>
            <td>形式：
              <?php echo $row_webinfo['pattern'];?>            </td>
            <td align="center">PRICE</td>
          </tr>
          <tr>
            <td>樓層：<?php echo $row_webinfo['floor']; ?></td>
            <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
            <td align="center">
              <button class="more">
              <a href="<?php echo $row_webinfo['Link'];?>" target="_blank">查看更多</a>
              </button>            </td>
            <td align="center">PRICE</td>
          </tr>
      </table>
        <?php } while ($row_webinfo = mysql_fetch_assoc($webinfo)); ?>
        <?php }else{echo '<div class="pages" style="color:#7E5322"><h2>你還沒有訂閱喔~!</h2></div>';}?>
    </div>





 

<div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>

</body>

</html>

<?php
mysql_free_result($webinfo);
mysql_free_result($Login);
?>