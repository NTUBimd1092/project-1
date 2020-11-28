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
    function GetSQLValueString($cralwer, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($cralwer, $theValue) : mysqli_escape_string($cralwer, $theValue);

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
/* 登入資料查詢 */
$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
    $colname_Login = $_SESSION['MM_Username'];
}
mysqli_select_db($cralwer,$database_cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($cralwer ,$colname_Login, "text"));
$Login = mysqli_query($cralwer,$query_Login);
$row_Login = mysqli_fetch_assoc($Login);
$totalRows_Login = mysqli_num_rows($Login);
$userid = isset($row_Login['id']) ? $row_Login['id'] : "";
$Link = isset($_GET['Link']) ? $_GET['Link'] : "";
mysqli_select_db( $cralwer, $database_cralwer);
$query_subscrption = "SELECT *
FROM `subscription` SB
LEFT JOIN `money_change` MC ON SB.Link = MC.Link
WHERE userid = '$userid' AND SB.Link='{$Link}'
order by SB.Link DESC
LIMIT 0 , 30";
$subscrption = mysqli_query( $cralwer,$query_subscrption);
$row_subscrption = mysqli_fetch_assoc($subscrption);
$totalRows_subscrption = mysqli_num_rows($subscrption);
$query_pageData = "SELECT * FROM `page_data` WHERE `Link`='{$Link}'";
$pageData = mysqli_query($cralwer,$query_pageData);
$row_pageData = mysqli_fetch_assoc($pageData);

/* 訂閱訊息 */
mysqli_select_db($cralwer,$database_cralwer);
$query_favorite = "SELECT * FROM subscription WHERE userid = $userid";
$favorite = mysqli_query($cralwer, $query_favorite);
$row_favorite = mysqli_fetch_assoc($favorite);
$totalRows_favorite = mysqli_num_rows($favorite);

/* 查詢價格異動總比數 */
mysqli_select_db( $cralwer,$database_cralwer);
$query_webinfo = "SELECT * FROM page_data where Link IN(SELECT Link FROM subscription where userid='$userid')";
$webinfo = mysqli_query( $cralwer, $query_webinfo);
$row_webinfo = mysqli_fetch_assoc($webinfo);

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
            <a class="navbar-brand" href="index.php">
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
                        <li class="nav-item active"><a class="nav-link" href="userPage.php"><b>嗨！<?php include 'encrypt.php'; echo decryptthis($row_Login['name'],$key);   ?></b></a></li>
                        <li class="nav-item"><a class="nav-link" href="searchArea.php?home=home">搜尋列表</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">登出</a></li>
                    <?php } // Show if recordset not empty 
                    ?>
                </ul>
            </div>
        </nav>

        <?php
        $sum = 0;
        do {
            $query_price = "SELECT COUNT(*) countPrice FROM `money_change` WHERE `Link` = '{$row_webinfo['Link']}'";
            $priceCount = mysqli_query( $cralwer,$query_price);
            $row_price = mysqli_fetch_assoc($priceCount);
            if ($row_price['countPrice'] > 1) {
                $sum += 1;
            }
        } while ($row_webinfo = mysqli_fetch_assoc($webinfo));
        ?>

        <!-- account data -->
        <div class="container-fluid">
            <div class="accountBg">
                <table class="table table-borderless table-sm accountData col-10 col-sm-8 col-md-6 col-lg-4">
                    <tr>
                        <th rowspan="2"><img width="55px" height="55px" style="border-radius:50%" src="<?php echo $row_Login['image']; ?>"></th>
                        <th><a href="favorite.php"><?php echo $totalRows_favorite ?></a></th>
                        <th><a href="#" id="price"></a></th>
                        <th><a href="#">0</a></th>
                    </tr>

                    <tr>
                        <td><a href="favorite.php">已收藏</a></td>
                        <td><a href="#">價格異動</a></td>
                        <td><a href="#">為您推薦</a></td>
                    </tr>
                </table>
            </div>

            <div>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 row justify-content-center">
                        <div class="subscribedItems">
                            <table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
                                <tr>
                                    <td rowspan="4" width="30%" class="text-center align-middle"><img class="imageSize" src="<?php echo $row_pageData['images']; ?>"></td>
                                    <th colspan="2" width="50%" class="houseName"><?php echo $row_pageData['house']; ?></th>
                                    <!-- <td rowspan="4" width="2%" class="text-center align-top"><img class="favorite" id="favorite" src="images/favorite.png" width="20px"></td> -->
                                    <td width="20%" class="text-center align-middle houseInfo">來自：<?php echo $row_pageData['WebName']; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="2"><?php echo $row_pageData['adress']; ?></td>
                                    <td rowspan="2" id="Price" class="text-center align-middle housePrice"><?php echo number_format($row_pageData['money']); ?></td>
                                </tr>

                                <tr>
                                    <td class="align-middle houseInfo">坪數：<?php echo $row_pageData['square_meters']; ?></td>
                                    <td class="align-middle houseInfo">形式：<?php echo $row_pageData['pattern']; ?></td>
                                </tr>

                                <tr>
                                    <td class="align-middle houseInfo">樓層：<?php echo $row_pageData['floor']; ?></td>
                                    <td class="align-middle houseInfo">類型：<?php echo $row_pageData['house_type']; ?></td>
                                    <td>
                                        <a class="btn btn-block btn-sm btnGo" href="<?php echo $row_pageData['Link']; ?>" target="_blank">查看更多</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="center">
                                        <div id="main" style="width:550px; height:300px;"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

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
                } while ($row_subscrption = mysqli_fetch_assoc($subscrption));
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

                    // 使用剛指定的配置項和數據顯示圖表f
                    myChart.setOption(option);
                </script>
                <?php

                ?>
            </div>
        </div>
    </section>

    <!-- footer -->
    <div class="footer">
        <a href="index.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
    </div>

    <script>
        document.getElementById('price').innerHTML = '<?php echo $sum; ?>';
    </script>

</body>

</html>
<?php
mysqli_free_result($Login);
mysqli_free_result($subscrption);
?>