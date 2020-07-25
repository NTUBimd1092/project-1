<?php require_once('Connections/cralwer.php'); ?>
<?php 
mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
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

mysql_select_db($database_cralwer, $cralwer);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $cralwer) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}


include 'encrypt.php';

if (isset($_POST['account'])) {
  $loginUsername = $_POST['account'];
  $Pass_query="SELECT account,password from `user` where account='$loginUsername'";
  $Pass_Select = mysql_query($Pass_query, $cralwer) or die(mysql_error());
  $row_pass=mysql_fetch_assoc($Pass_Select);
  if($_POST['password']==decryptthis($row_pass['password'],$key)){
    $password=$row_pass['password'];
  }
  
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php?check=err";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cralwer, $cralwer);

  $LoginRS__query = sprintf(
    "SELECT account, password FROM `user` WHERE account=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"),
  	GetSQLValueString($password, "text")
  );

  $LoginRS = mysql_query($LoginRS__query, $cralwer) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup = "";

    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    header("Location: " . $MM_redirectLoginSuccess);
  } else {
    header("Location: " . $MM_redirectLoginFailed);
  }
}
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
      text-align: center;
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

    .HomeIcon {
      height: 25px;
      padding-top: 8px;
      padding-right: 3px;
      padding-left: 8px;
    }

    .container {
      padding: 20px;
      margin: 10px;
      border: 3px solid white;
      border-radius: 10px;
      background-color: white;
      width: 300px;
      vertical-align: middle;
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -150px 0 0 -160px;
      z-index: -1;
    }

    .content {
      width: 280px;
      height: 20px;
      margin: 5px;
      font-family: Arial, 微軟正黑體;
    }

    .login {
      width: 285px;
      height: 30px;
      margin: 5px;
      color: white;
      font-size: 13px;
      font-family: 微軟正黑體;
      background-color: rgb(126, 83, 34, 0.85);
    }

    .register {
      font-size: 12.5px;
      color: #666666;
      padding: 5px;
    }

    .register a {
      color: #666666;
    }

    .register a:link {
      color: #666666;
    }

    .register a:visited {
      color: #666666;
    }
  </style>

</head>

<body>
  
  <div class="header">
    <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a>
    <a href="home.php">作伙</a>
  </div>

  <div class="container">
  <div>
  <?php 
	// $asdf="SELECT account,password FROM `user` where account='kkbox@s.s'";
  // $qwer = mysql_query($asdf, $cralwer) or die(mysql_error());
  // $row = mysql_fetch_assoc($qwer);
  // echo $row['password'];

  ?>
  </div>
    <div align="center" style="margin-bottom: 18px;">
      <img src="images/BrownIcon.png" alt="logo" class="HomeIcon">
      <span style="font-size:22px; font-weight:bold; color:rgb(126, 83, 34, 0.85)"> | 登入尋找喜歡的房！</span>
    </div>
    <form action="<?php echo $loginFormAction; ?>" name="login" method="POST">
      <div>
        <label for="EmailAddress" style="margin:0px 10px; font-size: 12.5px;"><b>電子郵件&nbsp;|&nbsp;Email&nbsp;Address</b></label>
        <input type="email" name="account" id="email" class="content" style="padding:3px;" placeholder="xxxxx@gmail.com" required>
        <br>
        <label for="Password" style="margin:0px 10px; font-size: 12.5px;"><b>密碼&nbsp;|&nbsp;Password</b></label>
        <input type="password" name="password" id="pwd" class="content" style="padding:3px;" placeholder="輸入密碼" required>
        <br>
        <label for="CAPTCHA" style="margin:0px 10px; font-size: 12.5px;"><b>驗證碼&nbsp;|&nbsp;CAPTCHA</b></label>
        <a href="" style="float:right; font-size: 10px; color: red;">忘記密碼&nbsp;|&nbsp;Forget Password?</a>
        <br>
        <table>
          <tr>
            <td><input id="captcha" type="text" style="padding:3px; margin:3px; width: 140px; height: 20px; font-family: Arial, 微軟正黑體;" placeholder="輸入驗證碼" required></td>
            <td><canvas id="canvas" width="125" height="40"></canvas></td>
          </tr>
        </table>
        <?php $_GET['check']= isset($_GET['check'])?$_GET['check']:"";
if($_GET['check']=='err'){?><div  align="center"style="color:#FF0000;  border: 1px solid  #FF0000;"><?php echo'帳號或密碼錯誤';?></div><?php }?>

        <button type="submit" class="login" style="border:none">登入！</button>
        <br>
    </form>

    <div class="register">
      <span>還沒加入作伙嗎？</span>
      <a href="register.php">註冊</a>
    </div>
  </div>
  </div>

  </form>

  <script src="captcha.js"></script>
</body>

</html>
<?php
mysql_free_result($user);
?>