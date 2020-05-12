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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "from2")and (@$_POST['password']==@$_POST['repassword'])) {
  $insertSQL = sprintf("INSERT INTO `user` (account, password, name, phone, birth) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['account'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['birth'], "date"));

  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($insertSQL, $cralwer) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_cralwer, $cralwer);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $cralwer) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>作伙</title>
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <style>
        body {
            font-family: 微軟正黑體;
            background-image: url('images/RegisterBackground.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .header {
            background-color: rgb(126, 83, 2, 0.75);
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
            margin: -275px 0 10px -160px;
            z-index: -1;
        }

        .content {
            width: 280px;
            height: 20px;
            margin: 5px;
            font-family: Arial, 微軟正黑體;
        }

        .register {
            width: 285px;
            height: 30px;
            margin: 5px;
            color: white;
            font-size: 13px;
            font-family: 微軟正黑體;
            background-color: rgb(126, 83, 2, 0.75);
        }

        .login {
            font-size: 12.5px;
            color: #666666;
            padding: 5px;
        }

        .login a {
            color: #666666;
        }

        .login a:link {
            color: #666666;
        }

        .login a:visited {
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
            <div align="center" style="margin-bottom: 18px;">
                <img src="images/BrownIcon.png" alt="logo" class="HomeIcon">
                <span style="font-size:22px; font-weight:bold; color:rgb(126, 83, 2, 0.75)"> | 加入作伙，找一個家</span>
            </div>
            <form action="<?php echo $editFormAction; ?>" name="from2" method="POST">
              <label for="EmailAddress"
                    style="margin:0px 10px; font-size: 12.5px;"><b>電子郵件 | Email Address</b></label>
             <input type="email" class="content" name="account" style="padding:3px;" placeholder="xxxxx@gmail.com" required>
              <br>
                <label for="Password" style="margin:0px 10px; font-size: 12.5px;"><b>密碼|Password</b></label>
            <input type="password" class="content" name="password" style="padding:3px;" placeholder="輸入密碼" required>
            <br>
                <label for="Password"
                    style="margin:0px 10px; font-size: 12.5px;"><b>重新輸入密碼|CheckPassword</b></label>
            <input type="password" class="content" name="repassword" style="padding:3px;" placeholder="重新輸入密碼" required>
             <br>
                <label for="uname" style="margin:0px 10px; font-size: 12.5px;"><b>姓名|Name</b></label>
            <input type="text" class="content" name="name" style="padding:3px;" placeholder="Zachary Walton" required>
                            <br>
                <label for="phone"
                    style="margin:0px 10px; font-size: 12.5px;"><b>電話|PhoneNumber</b></label>
            <input type="tel" pattern="[0-9]{10}" name="phone" class="content" style="padding:3px;" placeholder="0912345678"required>
            <br>
                <label for="phone"
                    style="margin:0px 10px; font-size: 12.5px;"><b>電話|PhoneNumber</b></label>
            <input type="date" class="content" name="birth" style="height: 25px; width: 285px;" placeholder="您的生日" required>
            <br>
                <label for="CAPTCHA" style="margin:0px 10px; font-size: 12.5px;"><b>驗證碼&nbsp;|&nbsp;CAPTCHA</b></label>
                <br>
                <table>
                    <tr>
                        <td><input id="captcha" type="text"
                                style="padding:3px; margin:3px; width: 140px; height: 20px; font-family: Arial, 微軟正黑體;"
                                placeholder="輸入驗證碼" required></td>
                        <td><canvas id="canvas" width="125" height="40"></canvas></td>
                    </tr>
                </table>
            <button type="submit" class="register">註冊！</button><br />
            <input type="hidden" name="MM_insert" value="from2" />       
            </form>
            <hr />
                <br />
                <div class="login">
                    <span>已經是會員了嗎？</span>
                    <a href="login.php">登入</a>
                </div>
</div>
        
 <script src="captcha.js"></script>   
</body>
</html>
<?php
mysql_free_result($user);
?>
