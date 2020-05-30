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
/*登入訊息*/
$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
$userid=$row_Login['id'];

/*訂閱訊息*/
mysql_select_db($database_cralwer, $cralwer);
$query_favorite = "SELECT * FROM subscription WHERE userid = $userid";
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
            padding: 10px;
            border: 1px solid white;
            border-radius: 5px;
            background-color: #FFFFFF;
            width: 500px;
            height: 320px;
            vertical-align: middle;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -28%);
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
            padding: 5px 20px;
        }

        .container td {
            border-bottom: 1px solid #ddd;
            padding: 5px 20px;
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

        .changeData {
            font-size: 14px;
            width: 80px;
            color: white;
            background-color: rgb(126, 83, 34, 0.85);
            border: 1px solid rgb(126, 83, 34, 0.85);
            border-radius: 5px;
            font-family: 微軟正黑體;
        }

        .changeData a {
            text-decoration: none;
        }

        .changeData a:link {
            text-decoration: none;
            color: white;
        }

        .changeData a:visited {
            text-decoration: none;
            color: white;
        }

        .footer {
            background-color: rgb(126, 83, 34);
            color: white;
            font-size: 25px;
            width: 100%;
            height: 45px;
            position: fixed;
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

        .mytext {
            /*搜尋列表,登出的樣式*/
            border: 1px solid white;
            border-radius: 2px;
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
            <a href="userPage.php" class="mytext">嗨！<?php echo $row_Login['name']; ?></a>
            <a href="searchArea.php">搜尋列表</a>
            <a href="<?php echo $logoutAction ?>">登出</a>
        </div>

    </div>

    <div class="accountData">
        <table>
            <tr>
                <th rowspan="2"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></th>
                <td><a href="favorite.php"><?php echo $totalRows_favorite ?> </a></td>
              <td>VARIATION</td>
                <td>RECOMMEND</td>
            </tr>

            <tr>
                <td><a href="favorite.php">已收藏</a></td>
                <td>價格異動</td>
                <td>為您推薦</td>
            </tr>
        </table>
    </div>

    <div class="container">
        <table>
            <tr>
                <td colspan="2" align="center"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">姓名</th>
                <td style="color: #707070"><?php echo $row_Login['name']; ?></td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">生日</th>
                <td style="color: #707070"><?php echo $row_Login['birth']; ?></td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">電話</th>
                <td style="color: #707070"><?php echo $row_Login['phone']; ?></td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">電子郵件</th>
                <td style="color: #707070"><?php echo $row_Login['account']; ?></td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">密碼</th>
                <td style="color: #707070">******</td>
            </tr>

            <tr>
                <th style="text-align:justify; text-justify:distribute-all-lines; text-align-last:justify">訂閱通知</th>
                <td style="color: #707070">是</td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:center; border:none; padding-top:10px"><button class="changeData" style="padding: 5px"><a href="usermodify.php">修改資料</a></button></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
        <span><a href="home.php">作伙</a></span>
    </div>

</body>

</html>

<?php
mysql_free_result($Login);

mysql_free_result($favorite);
?>