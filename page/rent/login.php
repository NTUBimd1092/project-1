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
    $Pass_query = "SELECT account,password from `user` where account='$loginUsername'";
    $Pass_Select = mysql_query($Pass_query, $cralwer) or die(mysql_error());
    $row_pass = mysql_fetch_assoc($Pass_Select);
    if ($_POST['password'] == decryptthis($row_pass['password'], $key)) {
        $password = $row_pass['password'];
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
            background-image: url('images/loginBackground.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md navbar-dark myHeader">
        <a class="navbar-brand" href="home.php">
            <img src="images/WhiteIcon.png" width="28" class="d-inline-block align-top">
            作伙
        </a>
    </nav>

    <!-- container -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-4">
                <form class="formContainer" action="<?php echo $loginFormAction; ?>" name="login" method="POST">

                    <!-- 驗證帳號密碼是否正確 -->
                    <?php $_GET['check'] = isset($_GET['check']) ? $_GET['check'] : "";
                    if ($_GET['check'] == 'err') { ?>
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="sr-only">Error:</span>
                            帳號或密碼錯誤
                        </div>
                    <?php } ?>

                    <section class="title">
                        <img src="images/BrownIcon.png" alt="logo" class="HomeIcon"> | 登入尋找喜歡的房！
                    </section>

                    <div class="form-group">
                        <label for="EmailAddress"><b>電子郵件&nbsp;|&nbsp;Email&nbsp;Address</b></label>
                        <input class="form-control" type="email" name="account" id="email" placeholder="xxxxx@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="Password"><b>密碼&nbsp;|&nbsp;Password</b></label>
                        <input class="form-control" type="password" name="password" id="pwd" placeholder="輸入密碼" required>
                    </div>

                    <a href="" style="float:right; font-size: 10px; color: red;">忘記密碼&nbsp;|&nbsp;Forget Password?</a>

                    <div class="form-group">
                        <label for="CAPTCHA"><b>驗證碼&nbsp;|&nbsp;CAPTCHA</b></label>
                        <table>
                            <tr>
                                <td width="70%"><input class="form-control" id="captcha" type="text" placeholder="輸入驗證碼" required></td>
                                <td width="30%" style="padding-left:5px"><canvas id="canvas" width="125" height="40"></canvas></td>
                            </tr>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-block btnGo">登入！</button>
                    <small class="form-text text-muted">還沒加入作伙嗎？<b><a href="register.php">註冊</a></b></small>

                </form>
            </div>
        </div>
    </div>

    <script src="src/captcha.js"></script>
</body>

</html>
<?php
mysql_free_result($user);
?>