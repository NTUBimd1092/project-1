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
<!DOCTYPE html>
<html lang="en">

<head>
    <title>作伙</title>
    <meta charset="utf-8">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        if('serviceWorker' in navigator){
            console.log("Will service worker register?");
            navigator.serviceWorker.register('service-worker.js').then(function(reg){
                console.log("Yes it did.");
            }).catch(function(err){
                console.log("Err:",err);
            });
        }
    </script>
    <style>
        body {
            font-family: 微軟正黑體;
            background-image: url('images/HomeBackground.jpg');
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ml-auto">
                <?php if ($totalRows_Login == 0) { // 尚未登入顯示
                ?>
                    <li class="nav-item"><a class="nav-link" href="searchArea.php">搜尋列表</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">註冊</a></li>
                <?php } // Show if recordset empty 
                ?>

                <?php if ($totalRows_Login > 0) { // 登入後顯示 
                ?>
                    <li class="nav-item active"><a class="nav-link" href="userPage.php"><b>嗨！<?php include 'encrypt.php'; echo decryptthis($row_Login['name'],$key); ?></b></a></li>
                    <li class="nav-item"><a class="nav-link" href="searchArea.php">搜尋列表</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">登出</a></li>
                <?php } // Show if recordset not empty 
                ?>
            </ul>
        </div>
    </nav>


    <!-- container -->
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-8 col-sm-8 col-md-5 col-lg-4">
                <form class="formContainer" action="searchArea.php" method="post">
                    <section class="title">
                        <img src="images/BrownIcon.png" alt="logo" class="HomeIcon"> | 找到最適合您的家
                    </section>
                    <div class="form-group">
                        <input type="text" class="form-control inputSearch" name="search" placeholder="輸入地段、路名、商圈" required>
                        <select class="form-control" style="margin-bottom: 10px;">
                            <option value="" disabled selected>選擇價格區間</option>
                            <option value="0 AND 5000">5000元以下</option>
                            <option value="10Thousand">5000-10000元</option>
                            <option value="20Thousand">10000-20000元</option>
                            <option value="30Thousand">20000-30000元</option>
                            <option value="40Thousand">30000-40000元</option>
                            <option value="50Thousand">40000-50000元</option>
                            <option value="60Thousand">50000-60000元</option>
                            <option value="70Thousand">60000元以上</option>
                        </select>

                        <select class="form-control">
                            <option value="" disabled selected>選擇坪數區間</option>
                            <option value="0 AND 10">10坪以下</option>
                            <option value="20SquareMeter">10-20坪</option>
                            <option value="30SquareMeter">20-30坪</option>
                            <option value="40SquareMeter">30-40坪</option>
                            <option value="50SquareMeter">40-50坪</option>
                            <option value="60SquareMeter">50坪以上</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-block btnGo">找房子！</button>
                </form>
            </div>

        </div>

    </div>


</body>

</html>
<?php
mysql_free_result($Login);
?>