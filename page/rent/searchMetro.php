<?php require_once('Connections/cralwer.php'); ?>
<?php
session_start();
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

$maxRows_page_data = 10;
$pageNum_page_data = 0;
if (isset($_GET['pageNum_page_data'])) {
  $pageNum_page_data = $_GET['pageNum_page_data'];
}
$startRow_page_data = $pageNum_page_data * $maxRows_page_data;

mysql_select_db($database_cralwer, $cralwer);
$query_page_data = "SELECT * FROM page_data";
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

$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);

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
      position: absolute;
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

    .searchDiv {
      background-color: #D0B392;
      color: #000000;
      font-size: 16px;
      width: 100%;
      height: 150px;
      position: fixed;
      position: absolute;
      top: 45px;
      left: 0;
    }

    .searchCondition {
      width: 80%;
      text-align: center;
      position: relative;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .searchCondition a {
      text-decoration: none;
      font-size: 20px;
      padding: 0px 5px;
    }

    .searchCondition a:link {
      text-decoration: none;
      color: black;
    }

    .searchCondition a:visited {
      text-decoration: none;
      color: black;
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

    select {
      border: none;
      outline: none;
      background: transparent;
    }

    .select {
      width: 100px;
      height: 30px;
      margin: 5px;
      padding: 1.5px;
      text-align-last: center;
      font-family: Arial, 微軟正黑體;
      border: #D0B392;
    }

    .search {
      width: 60px;
      height: 30px;
      margin: 3px;
      color: white;
      font-size: 12px;
      font-family: 微軟正黑體;
      border: rgb(126, 83, 34, 0.85);
      border-radius: 5px;
      background-color: rgb(126, 83, 34, 0.85);
    }

    .resultDiv {
      top: 50%;
      left: 50%;
      margin: 10px auto;
      transform: translateY(35%);
      -webkit-transform: translateY(35%);
    }

    table {
      width: 750px;
      padding: 5px 10px;
      background-color: #FFFFFF;
      color: #726A6A;
      border: 1px solid #FFFFFF;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 10px;
      line-height: 20px;
      font-size: 14px;
    }

    th {
      padding: 5px 10px;
      color: rgb(114, 106, 106, 0.9);
    }

    td {
      padding: 5px 10px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
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
      margin-top: 60px;
      margin-bottom: 80px;
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
      position: fixed;
      bottom: 0;
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
    </div>
  </div>

  <div class="searchDiv">
    <div class="searchCondition">
      <span><a href="searchArea.php">區域搜尋</a>
        &nbsp;|&nbsp;
        <a href="searchMetro.php"><b>捷運搜尋</b></a>
        &nbsp;|&nbsp;
        <a href="searchDestination.php">目的搜尋</a>
        &nbsp;|&nbsp;
        <img width="25px" src="images/map.png">
      </span>
      <br>
      <form action="searchArea.php">
        <input type="text" class="input" placeholder="善導寺站">
        <button type="submit" class="search">搜尋</button>
      </form>

      <select name="priceRange" class="select">
        <option value="">房屋租金</option>
        <option value="5Thousand">5000元以下</option>
        <option value="10Thousand">5000-10000元</option>
        <option value="20Thousand">10000-20000元</option>
        <option value="30Thousand">20000-30000元</option>
        <option value="40Thousand">30000-40000元</option>
        <option value="50Thousand">40000-50000元</option>
        <option value="60Thousand">50000-60000元</option>
        <option value="70Thousand">60000元以上</option>
      </select>

      <select name="rentType" class="select">
        <option value="">房屋類型</option>
        <option value="wholeFloor">整層住家</option>
        <option value="independentStudio">獨立套房</option>
        <option value="subletStudio">分租套房</option>
        <option value="room">雅房</option>
        <option value="other">其他</option>
      </select>

      <select name="housingPattern" class="select">
        <option value="">房屋格局</option>
        <option value="oneRoom">1房</option>
        <option value="twoRoom">2房</option>
        <option value="threeRoom">3房</option>
        <option value="fourRoom">4房</option>
        <option value="fiveOrMore">5房以上</option>
      </select>

      <select name="SquareMeter" class="select">
        <option value="">房屋坪數</option>
        <option value="10SquareMeter">10坪以下</option>
        <option value="20SquareMeter">10-20坪</option>
        <option value="30SquareMeter">20-30坪</option>
        <option value="40SquareMeter">30-40坪</option>
        <option value="50SquareMeter">40-50坪</option>
        <option value="60SquareMeter">50坪以上</option>
      </select>

      <select name="otherCondition" class="select">
        <option value="">其他條件</option>
      </select>

    </div>

    <?php do { ?>
      <div class="resultDiv">

        <table align="center">
          <tr>
            <td rowspan="4" width="25%" align="center"><img width="150px" height="100px" src="<?php echo $row_page_data['images']; ?>"></td>
            <th colspan="2" width="38%" align="left" style="font-size:20px"><?php echo $row_page_data['house']; ?></th>
            <td rowspan="4" width="2%" valign="top"><img src="images/favorite.png" alt="like" class="favorite"></td>
            <td width="20%" align="center">來自：<?php echo $row_page_data['WebName']; ?></td>
            <td width="15%" align="center">PRICE</td>
          </tr>

          <tr>
            <td colspan="2"><?php echo $row_page_data['adress']; ?></td>
            <td rowspan="2" align="center" style="font-size:26px"><?php echo $row_page_data['money']; ?></td>
            <td align="center">PRICE</td>
          </tr>

          <tr>
            <td>坪數：<?php echo $row_page_data['square_meters']; ?></td>
            <td>形式：
              <?php echo substr($row_page_data['pattern'], 0, 1); ?>房
              <?php echo substr($row_page_data['pattern'], 1, 1); ?>廳
              <?php echo substr($row_page_data['pattern'], 2, 1); ?>衛
              <?php echo substr($row_page_data['pattern'], 3, 1); ?>室
            </td>
            <td align="center">PRICE</td>
          </tr>

          <tr>
            <td>樓層：<?php echo $row_page_data['floor']; ?></td>
            <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
            <td align="center"><button class="more"><a href="<?php echo $row_page_data['Link']; ?>" target="_blank">查看更多</a></button></td>
            <td align="center">PRICE</td>
          </tr>
        </table>

      </div>

    <?php } while ($row_page_data = mysql_fetch_assoc($page_data)); ?>
    <div class="pages" style="color:#7E5322">
      <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, max(0, $pageNum_page_data - 1), $queryString_page_data); ?>"><b>上一頁</a>&nbsp;|&nbsp;<a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, min($totalPages_page_data, $pageNum_page_data + 1), $queryString_page_data); ?>">下一頁</b></a>
    </div>

  </div>

  <div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>

</body>

</html>

<?php
mysql_free_result($page_data);
mysql_free_result($Login);
?>