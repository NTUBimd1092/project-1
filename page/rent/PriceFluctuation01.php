<?php require_once('Connections/cralwer.php'); ?>
<?php
mysql_query("SET NAMES 'utf8'"); 
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

$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);

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
	transform: translateY(138%);
	-webkit-transform: translateY(138%);
}
.noData {
	top: 50%;
	left: 50%;
	text-align: center;
	vertical-align: middle;
	margin-top: 20px;
	margin-left: -70px;
	position: absolute;
	color: #7E5322;
	font-size: 30px;
	font-family: 微軟正黑體;
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
            <li class="nav-item"><a class="nav-link" href="">登出</a></li>
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
mysql_free_result($Login);
?>
