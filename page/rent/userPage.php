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
/* 登入訊息 */
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

/* 訂閱訊息 */
mysql_select_db($database_cralwer, $cralwer);
$query_favorite = "SELECT * FROM subscription WHERE userid = $userid";
$favorite = mysql_query($query_favorite, $cralwer) or die(mysql_error());
$row_favorite = mysql_fetch_assoc($favorite);
$totalRows_favorite = mysql_num_rows($favorite);
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

        input[type=button] {
            background-color: rgb(126, 83, 34, 0.85);
            border: none;
            border-radius: 5px;
            color: white;
            width: 25%;
            padding: 5px 10px;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

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
                    <th><a href="favorite.php"><?php echo $totalRows_favorite ?> </a></th>
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

        <!-- data table -->
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4 userBg">
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <td colspan="2" align="center"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th>姓名</th>
                            <td><?php echo $row_Login['name']; ?></td>
                        </tr>

                        <tr>
                            <th>生日</th>
                            <td><?php echo $row_Login['birth']; ?></td>
                        </tr>

                        <tr>
                            <th>電話</th>
                            <td><?php echo $row_Login['phone']; ?></td>
                        </tr>

                        <tr>
                            <th>電子郵件</th>
                            <td><?php echo $row_Login['account']; ?></td>
                        </tr>

                        <tr>
                            <th>密碼</th>
                            <td>********</td>
                        </tr>

                        <tr>
                            <th>訂閱通知</th>
                            <td><?php echo $row_Login['subscribe']; ?></td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center"><input type="button" onclick="javascript:location.href='usermodify.php'" value="修改資料"></input></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
    </div>

</body>

</html>
<?php
mysql_free_result($Login);

mysql_free_result($favorite);
?>