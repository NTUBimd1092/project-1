<?php require_once('Connections/cralwer.php'); ?>
<?php
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>作伙</title>
  <link rel="icon" href="images/logo.ico" type="image/x-icon">
  <style>
    body {
      font-family: 微軟正黑體;
      background-image: url('images/HomeBackground.jpg');
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
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

    .container {
      padding: 10px;
      border: 3px solid white;
      border-radius: 10px;
      background-color: white;
      width: 280px;
      text-align: center;
      vertical-align: middle;
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -110px 0 0 -150px;
      z-index: -1;

      /*
      display:flex;
      align-items:center;
      justify-content:center;
      */

    }

    .select {
      width: 250px;
      height: 25px;
      margin: 8px;
      padding: 1.5px;
      font-family: Arial, 微軟正黑體;
    }

    .search {
      width: 250px;
      height: 30px;
      margin: 10px;
      color: white;
      font-size: 13px;
      font-family: 微軟正黑體;
      background-color: rgb(126, 83, 34, 0.75);
    }
  </style>

</head>

<body>
  
    <div class="header">
      <span><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></span>
      <span>作伙</span>
      <div class="headerRight">
        <?php if ($totalRows_Login > 0) { // Show if recordset not empty 
        ?>
          <a href="userPage.php" style="border:1px solid white; border-radius:2px;">嗨！<?php echo $row_Login['name']; ?></a>
        <?php } // Show if recordset not empty 
        ?>
        <a href="searchArea.php">搜尋列表</a>
        <?php if ($totalRows_Login > 0) { // Show if recordset not empty 
        ?>
          <a href="<?php echo $logoutAction ?>">登出</a>
        <?php } // Show if recordset not empty 
        ?>

        <?php if ($totalRows_Login == 0) { // Show if recordset empty 
        ?>
          <a href="login.php">登入</a>
          <a href="register.php" style="border:1.5px solid white; border-radius:3px;">註冊</a>
        <?php } // Show if recordset empty 
        ?>
      </div>
    </div>
  <form action="searchArea.php" method="post">
    <div class="container">
      <div style="margin-bottom: 18px;">
        <img src="images/BrownIcon.png" alt="logo" class="HomeIcon">
        <span valign="center" style="font-size:22px; font-weight:bold; color:rgb(126, 83, 34, 0.75)"> | 找到最適合您的家</span>
      </div>

      <div>
    
        <input type="text" class="select"  name="search" style="padding:3px; width: 240px;" placeholder="輸入地段、路名、商圈" required>
        <br>
        <select name="PriceRange" class="select">
          <option value="" disabled selected>選擇價格區間</option>
          <option value="5Thousand">5000元以下</option>
          <option value="10Thousand">5000-10000元</option>
          <option value="20Thousand">10000-20000元</option>
          <option value="30Thousand">20000-30000元</option>
          <option value="40Thousand">30000-40000元</option>
          <option value="50Thousand">40000-50000元</option>
          <option value="60Thousand">50000-60000元</option>
          <option value="70Thousand">60000元以上</option>
        </select>
        <br>
        <select name="SquareMeter" class="select">
          <option value="" disabled selected>選擇坪數區間</option>
          <option value="10">10坪以下</option>
          <option value="20SquareMeter">10-20坪</option>
          <option value="30SquareMeter">20-30坪</option>
          <option value="40SquareMeter">30-40坪</option>
          <option value="50SquareMeter">40-50坪</option>
          <option value="60SquareMeter">50坪以上</option>
        </select>
        <br>
        <button type="submit" class="search" style="border:none">找房子！</button>
      </div>
    </div>

  </form>
</body>

</html>
<?php
mysql_free_result($Login);
?>