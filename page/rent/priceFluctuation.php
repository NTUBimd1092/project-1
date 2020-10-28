<?php require_once('Connections/cralwer.php'); ?>
<?php
mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
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
/*登入資料查詢*/
$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
$userid=isset($row_Login['id'])?$row_Login['id']:"";
$Link=isset($_POST['Link'])?$_POST['Link']:"";
mysql_select_db($database_cralwer, $cralwer);
$query_subscrption = "SELECT *
FROM `subscription` SB
LEFT JOIN `money_change` MC ON SB.Link = MC.Link
WHERE userid = '$userid' AND SB.Link='https://www.sinyi.com.tw/rent/houseno/C210102'
order by SB.Link DESC
LIMIT 0 , 30";
$subscrption = mysql_query($query_subscrption, $cralwer) or die(mysql_error());
$row_subscrption = mysql_fetch_assoc($subscrption);
$totalRows_subscrption = mysql_num_rows($subscrption);

?>




<!DOCTYPE html>
<html>

<head>
    <title>作伙</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="src/echarts.min.js"></script>
    <style>
        body {
            font-family: 微軟正黑體;
            background-color: #EFEFEF;
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
                        <li class="nav-item active"><a class="nav-link" href="userPage.php"><b>嗨！<?php echo $row_Login['name']; ?></b></a></li>
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
                        <th><a href="favorite.php">(num)</a></th>
                        <th><a href="#">(num)</a></th>
                        <th><a href="#">(num)</a></th>
                    </tr>

                    <tr>
                        <td><a href="favorite.php">已收藏</a></td>
                        <td><a href="priceFluctuation.php">價格異動</a></td>
                        <td><a href="#">為您推薦</a></td>
                    </tr>
                </table>
            </div>

            <!-- <div class="">
                <br>
                無價格異動資料</div>
            <hr />
            全部異動紀錄：<br />
            <hr /> -->
            <div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <div class="subscribedItems">
                            <table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
                                <tr>
                                    <td rowspan="4" width="30%" class="text-center align-middle"><img class="imageSize" src=""></td>
                                    <th colspan="2" width="50%" class="houseName"></th>
                                    <td rowspan="4" width="2%" class="text-center align-top"><img class="favorite" id="favorite" src="images/favorite.png" width="20px"></td>
                                    <td width="18%" class="text-center align-middle houseInfo">來自：</td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                    <td rowspan="2" id="Price" class="text-center align-middle housePrice"></td>
                                </tr>

                                <tr>
                                    <td class="align-middle houseInfo">坪數：</td>
                                    <td class="align-middle houseInfo">形式：</td>
                                </tr>

                                <tr>
                                    <td class="align-middle houseInfo">樓層：</td>
                                    <td class="align-middle houseInfo">類型：</td>
                                    <td>
                                        <a class="btn btn-block btn-sm btnGo" href="">查看更多</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="5" align="center">
                                        <div id="main" style="width:550px; height:300px;"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- <div id="main" style="width:600px; height:400px;"></div> -->
                <?php
                do {
                    $Id = $row_subscrption['id'];
                    $Money = $row_subscrption['money'];
                    $Link = $row_subscrption['Link'];
                    $Datetime = $row_subscrption['date'];

                    $return_arr[] = array(
                        "Money" => $Money,
                        "MyDate" => $Datetime
                    );
                } while ($row_subscrption = mysql_fetch_assoc($subscrption));
                $json = json_encode($return_arr);

                ?>
                <script type="text/javascript">
                    // 初始化
                    var myChart = echarts.init(document.getElementById('main'));
                    var response = <?php echo $json; ?>;
                    var Datedata = new Array();
                    var Moneydata = new Array();
                    for (var i in response) {
                        Moneydata.push(response[i].Money);
                        Datedata.push(response[i].MyDate);
                    }

                    // 指定圖表的配置項和數據
                    option = {
                        xAxis: {
                            type: 'category',
                            data: Datedata
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [{
                            data: Moneydata,
                            type: 'line'
                        }]
                    };

                    // 使用剛指定的配置項和數據顯示圖表。
                    myChart.setOption(option);
                </script>
                <?php

                ?>
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
mysql_free_result($subscrption);
?>
