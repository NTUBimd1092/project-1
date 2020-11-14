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

/* pages */
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_page_data = 10;
$pageNum_page_data = 0;
if (isset($_GET['pageNum_page_data'])) {
  $pageNum_page_data = $_GET['pageNum_page_data'];
}
$startRow_page_data = $pageNum_page_data * $maxRows_page_data;

mysql_select_db($database_cralwer, $cralwer);
@$query_page_data = "SELECT * FROM page_data WHERE `house` LIKE '%$_POST[search]%'
or `adress` LIKE '%$_POST[search]%' or `Webname` LIKE '%$_POST[search]%' and `square_meters` <= '$_POST[SquareMeter]'";
$query_limit_page_data = sprintf("%s LIMIT %d, %d", $query_page_data, $startRow_page_data, $maxRows_page_data);
$page_data = mysql_query($query_limit_page_data, $cralwer) or die(mysql_error());
$row_page_data = mysql_fetch_assoc($page_data);

if (isset($_GET['totalRows_page_data'])) {
  $totalRows_page_data = $_GET['totalRows_page_data'];
} else {
  $all_page_data = mysql_query($query_page_data);
  $totalRows_page_data = mysql_num_rows($all_page_data);
}
$totalPages_page_data = ceil($totalRows_page_data / $maxRows_page_data) - 1;

$queryString_page_data = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_page_data") == false &&
      stristr($param, "totalRows_page_data") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_page_data = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_page_data = sprintf("&totalRows_page_data=%d%s", $totalRows_page_data, $queryString_page_data);

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
$userid = $row_Login['id'];

/*登入帳號的金錢異動查詢*/
mysql_select_db($database_cralwer, $cralwer);
$query_favorite = "SELECT * FROM money_change WHERE userid = $userid ORDER BY Link ASC";
$favorite = mysql_query($query_favorite, $cralwer) or die(mysql_error());
$row_favorite = mysql_fetch_assoc($favorite);
$totalRows_favorite = mysql_num_rows($favorite);
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
      font-size: 16px;
      padding: 5px 20px;
    }

    .accountData td {
      padding: 5px 10px;
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
      width: 700px;
      padding: 5px;
      background-color: #FFFFFF;
      color: #726A6A;
      border: 1px solid #FFFFFF;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 10px;
      line-height: 18px;
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
        <th rowspan="2"><img width="60px" height="60px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></th>
        <td><a href="favorite.php">FAVORITES</a></td>
        <td><a href="priceFluctuation.php">VARIATION</a></td>
        <td>RECOMMEND</td>
      </tr>

      <tr>
        <td><a href="favorite.php">已收藏</a></td>
        <td><a href="priceFluctuation.php">價格異動</a></td>
        <td>為您推薦</td>
      </tr>
    </table>
  </div>

  <div style="margin-top:205px"></div>

  <?php do {
    /* 關聯page_data與money_change */
    $Link = $row_favorite['Link'];

    mysql_select_db($database_cralwer, $cralwer);
    $query_webinfo = "SELECT * FROM page_data WHERE Link = '$Link'";
    $webinfo = mysql_query($query_webinfo, $cralwer) or die(mysql_error());
    $row_webinfo = mysql_fetch_assoc($webinfo);
    $totalRows_webinfo = mysql_num_rows($webinfo);
  ?>
    <div class="resultDiv">
      <table align="center" id="customers">
        <tr>
          <td rowspan="4" width="30%" align="center" valign="center"><img width="160px" src="<?php echo $row_webinfo['images']; ?>"></td>
          <th colspan="2" width="43%" align="left" style="font-size:20px"><?php echo $row_webinfo['house']; ?></th>
          <td rowspan="4" width="2%" valign="top"><img src="images/selectedFav.png" alt="like" class="favorite"></td>
          <td width="25%" align="center" style="font-size:12px">來自：<?php echo $row_webinfo['WebName']; ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php echo $row_webinfo['adress']; ?></td>
          <td align="center" style="font-size:16px"><?php echo $row_webinfo['money']; ?></td>
        </tr>
        <tr>
          <td>坪數：<?php echo $row_webinfo['square_meters']; ?></td>
          <td>形式：
            <?php echo substr($row_webinfo['pattern'], 0, 1); ?>房
            <?php echo substr($row_webinfo['pattern'], 1, 1); ?>廳
            <?php echo substr($row_webinfo['pattern'], 2, 1); ?>衛
            <?php echo substr($row_webinfo['pattern'], 3, 1); ?>室
          </td>
          <td align="center" style="font-size:22px"><?php echo $row_webinfo['money']; ?></td>
        </tr>
        <tr>
          <td>樓層：<?php echo $row_webinfo['floor']; ?></td>
          <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
          <td align="center"><button class="more">
              <a href="<?php echo $row_favorite['Link']; ?>" target="_blank">查看更多</a>
            </button></td>
        </tr>
      </table>
    </div>
  <?php } while ($row_favorite = mysql_fetch_assoc($favorite)); ?>


  <div class="pages" style="color:#7E5322">
    <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, max(0, $pageNum_page_data - 1), $queryString_page_data); ?>"><b>上一頁</a>&nbsp;|&nbsp;<a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, min($totalPages_page_data, $pageNum_page_data + 1), $queryString_page_data); ?>">下一頁</b></a>
  </div>




  <!--<?php echo $row_Login['id']; ?>
  <hr />
  全部異動紀錄：<br />
  <hr />
  <?php do {
    /*關聯page_data與money_change*/
    $Link = $row_favorite['Link'];

    mysql_select_db($database_cralwer, $cralwer);
    $query_webinfo = "SELECT * FROM page_data WHERE Link = '$Link'";
    $webinfo = mysql_query($query_webinfo, $cralwer) or die(mysql_error());
    $row_webinfo = mysql_fetch_assoc($webinfo);
    $totalRows_webinfo = mysql_num_rows($webinfo);
  ?>
    編號：<?php echo $row_favorite['id']; ?><br />
    名稱：<?php echo $row_webinfo['house']; ?><br />
    連結：<a href="<?php echo $row_favorite['Link']; ?>" target="_blank"><?php echo $row_favorite['Link']; ?></a><br />
    日期：<?php echo $row_favorite['date']; ?><br />
    金額：<?php echo $row_favorite['money']; ?>$<br />
    <hr />
  <?php } while ($row_favorite = mysql_fetch_assoc($favorite)); ?> -->


  <div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>

</body>

</html>

<?php
mysql_free_result($favorite);
mysql_free_result($webinfo);
mysql_free_result($Login);
?>