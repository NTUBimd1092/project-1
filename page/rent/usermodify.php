<?php require_once('Connections/cralwer.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modify")) {
  $updateSQL = sprintf(
    "UPDATE `user` SET image=%s, account=%s, password=%s, name=%s, phone=%s, birth=%s WHERE id=%s",
    GetSQLValueString($_FILES["file"]["name"], "text"),
    GetSQLValueString($_POST['account'], "text"),
    GetSQLValueString($_POST['password'], "text"),
    GetSQLValueString($_POST['name'], "text"),
    GetSQLValueString($_POST['phone'], "text"),
    GetSQLValueString($_POST['birth'], "date"),
    GetSQLValueString($_POST['id'], "int")
  );

  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($updateSQL, $cralwer) or die(mysql_error());

  $updateGoTo = "userPage.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

    .container {
      padding: 20px 10px;
      border: 1px solid white;
      border-radius: 5px;
      background-color: #FFFFFF;
      width: 500px;
      height: 330px;
      vertical-align: middle;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -30%);
      z-index: -1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .containter table {
      width: 70%;
      border-collapse: collapse;
      vertical-align: center;
    }

    .container th {
      font-size: 14px;
      border-bottom: 1px solid #ddd;
      padding: 5px 10px;
    }

    .container td {
      border-bottom: 1px solid #ddd;
      padding: 5px 10px;
    }

    .disperse {
      text-align: justify;
      text-justify: distribute-all-lines;
      text-align-last: justify;
    }

    .disperse::after {
      content: ".";
      display: inline-block;
      width: 100%;
      visibility: hidden;
      height: 0;
      overflow: hidden;
    }

    .modifyData {
      width: 230px;
      height: 20px;
      padding: 3px 5px;
      margin: 0 5px;
      border: 1px solid #707070;
      border-radius: 3px;
    }

    .cancel {
      font-size: 13px;
      width: 85px;
      margin-right: 5px;
      color: white;
      background-color: rgb(126, 83, 34, 0.85);
      border: 1px solid rgb(126, 83, 34, 0.85);
      border-radius: 5px;
      font-family: 微軟正黑體;
    }

    .cancel a {
      text-decoration: none;
    }

    .cancel a:link {
      text-decoration: none;
      color: white;
    }

    .cancel a:visited {
      text-decoration: none;
      color: white;
    }

    .saveChange {
      font-size: 13px;
      width: 60px;
      margin-left: 5px;
      color: white;
      background-color: rgb(126, 83, 34, 0.85);
      border: 1px solid rgb(126, 83, 34, 0.85);
      border-radius: 5px;
      font-family: 微軟正黑體;
    }

    .saveChange a {
      text-decoration: none;
    }

    .saveChange a:link {
      text-decoration: none;
      color: white;
    }

    .saveChange a:visited {
      text-decoration: none;
      color: white;
    }

    .footer {
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
      position: absolute;
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
      <a href="login.php" style="border:1px solid white; border-radius:2px;">登出</a>
    </div>
  </div>

  <div class="accountData">
    <table>
      <tr>
        <th rowspan="2"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></th>
        <td>FAVORITES</td>
        <td>VARIATION</td>
        <td>RECOMMEND</td>
      </tr>

      <tr>
        <td>已收藏</td>
        <td>價格異動</td>
        <td>為您推薦</td>
      </tr>
    </table>
  </div>

  <div class="container">
    <form action="<?php echo $editFormAction; ?>" method="POST" name="modify" enctype="multipart/form-data">
      <table>
        <tr>
          <td align="center"><img style="width:50px" src="images/<?php echo $row_Login['image']; ?>"></td>
          <td style="padding:0 15px">
            <input type="file" name="file" id="file" value="<?php echo $row_Login['image']; ?>" required>
            <input name="id" type="hidden" value="<?php echo $row_Login['id']; ?>">
            <?php
            if (!empty($_FILES["file"]["tmp_name"])) {
              @move_uploaded_file(
                $_FILES["file"]["tmp_name"],
                @"images/" . $_FILES["file"]["name"]
              );
            } else {
              $_FILES["file"]["tmp_name"] = $row_Login['image'];
            }
            ?>
          </td>

        </tr>
        <tr><input type="hidden" name="id" value="<?php echo $row_Login['id']; ?>" />
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">姓名</th>
          <td style="color: #707070"><input class="modifyData" name="name" type="text" value="<?php echo $row_Login['name']; ?>" /></td>

        </tr>

        <tr>
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">生日</th>
          <td style="color: #707070"><input class="modifyData" type="date" name="birth" value="<?php echo $row_Login['birth']; ?>" /></td>

        </tr>

        <tr>
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">電話</th>
          <td style="color: #707070"><input class="modifyData" type="number" name="phone" value="<?php echo $row_Login['phone']; ?>" /></td>

        </tr>

        <tr>
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">帳號(信箱)</th>
          <td style="color: #707070"><input class="modifyData" type="email" name="account" value="<?php echo $row_Login['account']; ?>" /></td>

        </tr>

        <tr>
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">密碼</th>
          <td style="color: #707070"><input class="modifyData" type="text" name="password" value="<?php echo $row_Login['password']; ?>" /></td>
        </tr>

        <tr>
          <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">訂閱通知</th>
          <td style="color: #707070">
            <form>
              <input type="radio" name="suscribe" value="yes">
              <label for="yes">是</label>
              <input type="radio" name="suscribe" value="no">
              <label for="no">否</label>
            </form>
          </td>
        </tr>
        <tr>
          <td colspan=" 2" style="text-align:center; border:none; padding-top:10px">
            <button class="cancel" style="padding: 5px"><a href="userPage.php">回個人資料</a></button>
            <button class="saveChange" style="padding: 5px" type="submit">儲存</button>
            <input type="hidden" name="MM_update" value="modify" />
          </td>
        </tr>
      </table>
    </form>
  </div>

  <div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>

</body>

</html>

<?php
mysql_free_result($Login);
?>