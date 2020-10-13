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
mysql_query("SET NAMES 'utf8'"); //資料亂碼
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
@session_start();
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
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <!-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> -->
    <title>作伙</title>
    <link rel="canonical" href="https://letswrite.tw/google-map-api-marker-custom/">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 微軟正黑體;
            background-color: #EFEFEF;
            /* 禁止頁面滾動 */
            height: 100%;
            overflow: hidden;
        }

        #DataList {
            /* position: absolute; */
            bottom: 0;
            z-index: 1;
        }

        #map {
            position: absolute;
            /* header + searchArea 's height = 170 */
            margin-top: 170px;
            z-index: 0;
        }
    </style>
    <link rel="shortcut icon" href="images/BrownIcon.png" />

    <!-- Google Tag Manager-->
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
                <?php if ($totalRows_Login == 0) { // 尚未登入顯示
                ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">註冊</a></li>
                <?php } // Show if recordset empty 
                ?>

                <?php if ($totalRows_Login > 0) { // 登入後顯示 
                ?>
                    <li class="nav-item active"><a class="nav-link" href="userPage.php"><b>嗨！<?php echo $row_Login['name']; ?></b></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $logoutAction ?>">登出</a></li>
                <?php } // Show if recordset not empty 
                ?>
            </ul>
        </div>
    </nav>


    <!-- container -->
    <div class="container-fluid">
        <div class="mapSearchBg">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                    <form method='GET' action="maps.php" name="form1" style="background:none">
                        <table class="table table-sm table-borderless searchTitle">
                            <thead>
                                <tr>
                                    <th colspan="5">
                                        <a href="searchArea.php" style="color:black; text-decoration:none; font-weight:500;">區域搜尋 |</a> 地圖搜尋
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="qtxt" id="qtxt" value="<?php echo isset($_GET['qtxt']) ? $_GET['qtxt'] : ""; ?>" placeholder="輸入房屋名稱或地址..."></input>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btnGo"><i class="fa fa-search" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Tag Manager (noscript)-->
    <div id="map" class="embed-responsive embed-responsive-16by9">
    </div>
    <!-- 將 YOUR_API_KEY 替換成你的 API Key 即可 -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzA3f6KHEpViCBcLFSWS3a2ywVr3fCIvY&callback=initMap" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyAzA3f6KHEpViCBcLFSWS3a2ywVr3fCIvY"></script>
    <!-- map -->
    <script type="text/javascript">
        //放DataTable資料的全域變數
        //抓出地址資料
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                panControl: false,
                zoomControl: false, //可以通過單击縮放按钮来縮放地圖
                mapTypeControl: true,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false,
                rotateControl: false,
                scrollwheel: false, //scrollwheel(是否允許使用者對地圖物件使用滑鼠滾輪)
                gestureHandling: 'greedy' //關閉地圖滾輪縮放
            });
            var myinfo;
            myinfo = new google.maps.InfoWindow;
            navigator.geolocation.getCurrentPosition(function(position) {
                var initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
                map.setZoom(18);
                myinfo.setPosition(initialLocation);
                myinfo.setContent('你在這裡！');
                myinfo.open(map);

                var qtxt = '<?php isset($_GET['qtxt']) ? $_GET['qtxt'] : ""; ?>'; //查詢房名、地址
                $(document).ready(function() {

                    $.ajax({
                        type: "POST",
                        url: "get_data _map.php",
                        data: {
                            'mylat': position.coords.latitude,
                            'mylng': position.coords.longitude,
                            'search': qtxt
                        },
                        async: true,
                        dataType: 'json',
                        success: function(response) {
                            var tr_str = "";
                            for (var i in response) {
                                tr_str =
                                    // '<div class="row justify-content-center">' +
                                    '<div class="listTable">' +
                                    '<table class="table table-sm initialism table-borderless card">' +
                                    '<tr>' +
                                    '<td rowspan="3" class="text-center align-middle">' + "<img class='mapImage' src=\"" + response[i].Images + "\">" + '</td>' +
                                    '<th colspan="2" class="houseName">' + response[i].Name + '</th>' +
                                    '</tr>' +

                                    '<tr>' +
                                    '<td class="align-middle houseInfo">坪數：' + response[i].SquareFeet + '</td>' +
                                    '<td class="align-middle houseInfo">類型：' + response[i].HouseType + '</td>' +
                                    '</tr>' +

                                    '<tr>' +
                                    '<td class="align-middle houseInfo">樓層：' + response[i].Floor + '</td>' +
                                    '<td class="align-middle houseInfo">來自：' + response[i].WebName + '</td>' +
                                    '</tr>' +
                                    '</table>'
                                // + '</div>'
                                $('#DataList').append(tr_str);

                                var marker = new google.maps.Marker({
                                    position: {
                                        lat: parseFloat(response[i].Lat),
                                        lng: parseFloat(response[i].Lng)
                                    },
                                    map: map,
                                    animation: google.maps.Animation.DROP,
                                    icon: 'images/marker.png',
                                    label: {
                                        // text: response[i].HouseType + '\n' + 'NT$' + response[i].Money,
                                        text: 'NT$\n' + response[i].Money,
                                        color: "white",
                                        fontSize: "12.5px",
                                        fontWeight: "bold"
                                    }
                                });

                                var infowindow = new google.maps.InfoWindow({
                                    content: "<a href=\"" + response[i].Link + "\" target=_blank><img src=\"" + response[i].Images + "\" width=\"150px\" height=\"100px\"><br>" +
                                        response[i].Name + "<br>" + response[i].Address + "</a>"
                                });

                                google.maps.event.addListener(marker, 'click', function() {
                                    infowindow.open(map, marker);
                                });
                            }

                        },
                        error: function(e) {
                            alert('查無資料！');
                            //alert(e.responseText);
                            console.log('error', e)
                        }
                    }); //$.ajax(
                }); //$(document).ready(function() {

            }, function(positionError) {
                map.setCenter(new google.maps.LatLng(25.033671, 121.564427));
                map.setZoom(12);
            });
            google.maps.event.addDomListener(window, 'load', initialize);

            function initialize() {

            }
        }
    </script>

    <div class="dataArea">
        <table class="table table-borderless listTable">
            <tr>
                <td>
                    <span id="DataList"></span>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
<?php
mysql_free_result($Login);

?>
