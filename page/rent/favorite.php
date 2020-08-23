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
$totalPages_Login = ceil($totalRows_Login / $maxRows_Login) - 1;
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
$totalPages_webinfo = ceil($totalRows_webinfo / $maxRows_webinfo) - 1;

$queryString_webinfo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_webinfo") == false &&
      stristr($param, "totalRows_webinfo") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_webinfo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_webinfo = sprintf("&totalRows_webinfo=%d%s", $totalRows_webinfo, $queryString_webinfo);

//刪除訂閱
@$deluid = base64_decode($_GET['userid']);
@$delLink = base64_decode($_GET['Link']);
if ((isset($_GET['del'])) && ($_GET['del'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `crawler`.`subscription` WHERE `subscription`.`userid` ='$deluid' AND `subscription`.`Link` ='$delLink'");
  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($deleteSQL, $cralwer) or die(mysql_error());
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <title>作伙</title>
  <meta charset="utf-8">
  <link rel="icon" href="images/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="src/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      font-family: 微軟正黑體;
      background-color: #EFEFEF;
    }
  </style>
</head>

<body>
  <section class="myBody">

    <!-- navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top myHeader">
      <a class="navbar-brand" href="home.php">
        <img src="images/WhiteIcon.png" width="28" class="d-inline-block align-top">
        作伙
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
          <?php if ($totalRows_Login > 0) { // 登入後顯示 
          ?>
            <li class="nav-item"><a class="nav-link" href="searchArea.php">搜尋列表</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">登出</a></li>
          <?php } // Show if recordset not empty 
          ?>
        </ul>
      </div>
    </nav>

    <!-- account data -->
    <div class="container-fluid">
      <div class="accountBg">
        <table class="table table-borderless table-sm accountData col-10 col-sm-8 col-md-6 col-lg-4">
          <tr>
            <th rowspan="2"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></th>
            <th><a href="favorite.php"><?php echo $totalRows_webinfo ?> </a></th>
            <th><a href="priceFluctuation.php">(num)</a></th>
            <th><a href="#">(num)</a></th>
          </tr>

          <tr>
            <td><a href="favorite.php">已收藏</a></td>
            <td><a href="priceFluctuation.php">價格異動</a></td>
            <td><a href="#">為您推薦</a></td>
          </tr>
        </table>
      </div>

      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
          <?php if ($totalRows_webinfo > 0) { // Show if recordset not empty 
          ?>
            <?php do { ?>
              <table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
                <tr>
                  <td rowspan="4" width="25%" class="text-center align-middle"><img class="imageSize" src="' . $row['images'] . '"></td>
                  <th colspan="2" width="38%" class="houseName"><?php echo $row_webinfo['house']; ?></th>
                  <td rowspan="4" width="2%" class="text-center align-top"><img class="favorite" id="favorite" src="images/favorite.png" width="20px"></td>
                  <td width="20%" class="text-center align-middle houseInfo">來自：<?php echo $row_webinfo['WebName']; ?></td>
                </tr>

                <tr>
                  <td colspan="2"><?php echo $row_webinfo['adress']; ?></td>
                  <td rowspan="2" id="Price" class="text-center align-middle housePrice"><?php echo number_format($row_webinfo['money']); ?></td>
                </tr>

                <tr>
                  <td class="align-middle houseInfo">坪數：<?php echo $row_webinfo['square_meters']; ?></td>
                  <td class="align-middle houseInfo">形式：<?php echo $row_webinfo['pattern']; ?></td>
                </tr>

                <tr>
                  <td class="align-middle houseInfo">樓層：<?php echo $row_webinfo['floor']; ?></td>
                  <td class="align-middle houseInfo">特色：</td>
                  <td>
                    <a class="btn btn-block btn-sm btnGo" href="<?php echo $row_webinfo['Link']; ?>">查看更多</a>
                  </td>
                </tr>
              </table>
            <?php } while ($row_webinfo = mysql_fetch_assoc($webinfo)); ?>
          <?php } else {
            echo '<h2>立即收藏喜愛的房源</h2>';
          } ?>
        </div>

      </div>
    </div>
  </section>


  <!-- footer -->
  <div class="footer">
    <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
  </div>

</body>

</html>

<?php
mysql_free_result($webinfo);
mysql_free_result($Login);
?>