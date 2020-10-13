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
<html>

<head>
    <title>作伙</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="src/searchArea.js"></script>

    <script type="text/javascript">
        var WebName = '<?php echo $_POST['WebName']; ?>';
        var qtxt = '<?php echo $_POST['qtxt']; ?>'; //查詢房名、地址
        var moneyS = '<?php echo $_POST['moneyS']; ?>';
        var moneyE = '<?php echo $_POST['moneyE']; ?>';
        var orderby = '<?php echo $_POST['orderby']; ?>';
        var dict = '<?php echo $_POST['dict']; ?>';
		var userid='<?php echo isset($row_Login['id']) ? $row_Login['id'] : "";?>';

        $(document).ready(function() {
            var flag = 0;
            $.ajax({
                type: "POST",
                url: "get_data.php",
                data: {
                    'offset': 0,
                    'limit': 10,
                    'WebName': WebName,
                    'search': qtxt,
                    'moneyS': moneyS,
                    'moneyE': moneyE,
                    'orderby': orderby,
                    'dict': dict,
					'userid':userid
                },
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                success: function(data) {
                    $('#DataList').append(data);
                    flag += 10;
                },
                error: function(e) {
                    console.log('error', e)
                }
            });

            $(window).scroll(function() {
                last = $("body").height() - $(window).height() - 100
                if ($(window).scrollTop() >= last) {
                    $.ajax({
                        type: "POST",
                        url: "get_data.php",
                        data: {
                            'offset': flag,
                            'limit': 10,
                            'WebName': WebName,
                            'search': qtxt,
                            'moneyS': moneyS,
                            'moneyE': moneyE,
                            'orderby': orderby,
                            'dict': dict,
							'userid':userid
                        },
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success: function(data) {
                            $('#DataList').append(data);
                            flag += 10;
                        },
                        error: function(e) {
                            console.log('error', e)
                        }
                    });
                }
            });
        });
    </script>

    <style>
        body {
            font-family: 微軟正黑體;
            background-color: #EFEFEF;
        }

        /* .container-fluid {
            overflow: hidden;
        } */

        .sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            background-color: #D0B392;
            height: 200px;
            padding: 10px;
            z-index: 1;
        }
    </style>
</head>

<body onLoad="window_onload();">
    <section class="myBody">

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
        <div class="container-fluid p-0">
            <!-- sticky search area -->
            <div class="sticky">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">

                        <form method='POST' action="searchArea.php" name="form1" style="background:none">
                            <table class="table table-sm table-borderless searchTitle">
                                <thead>
                                    <tr>
                                        <th colspan="4">區域搜尋</th>
                                        <th colspan="1"><a href="maps.php">Map</a></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="qtxt" id="qtxt" value="<?php echo isset($_POST['qtxt']) ? $_POST['qtxt'] : ""; ?>" placeholder="輸入房屋名稱或地址..."></input>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btnGo" id="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">房屋租金</td>
                                        <td>房屋來源</td>
                                        <td colspan="2" >排序方式</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <select name="moneyS" class="form-control">
                                                <option value="<?php echo isset($_POST['moneyS']) ? $_POST['moneyS'] : ""; ?>" selected><?php echo isset($_POST['moneyS']) && $_POST['moneyS'] != "" ? $_POST['moneyS'] : "不限"; ?></option>
                                                <option value="">不限</option>
                                                <option value="5000">5000</option>
                                                <option value="10000">10000</option>
                                                <option value="20000">20000</option>
                                                <option value="30000">30000</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="moneyE" class="form-control">
                                                <option value="<?php echo isset($_POST['moneyE']) ? $_POST['moneyE'] : ""; ?>" selected><?php echo isset($_POST['moneyE']) && $_POST['moneyE'] != "" ? $_POST['moneyE'] : "不限"; ?></option>
                                                <option value="">不限</option>
                                                <option value="5000">5000</option>
                                                <option value="10000">10000</option>
                                                <option value="20000">20000</option>
                                                <option value="30000">30000</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="WebName" class="form-control">
                                                <option value="<?php echo isset($_POST['WebName']) ? $_POST['WebName'] : ""; ?>" selected><?php echo isset($_POST['WebName']) && $_POST['WebName'] != "" ? $_POST['WebName'] : "全部"; ?></option>
                                                <option value="">全部</option>
                                                <option value="信義房屋">信義房屋</option>
                                                <option value="永慶房屋">永慶房屋</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="orderby" class="form-control">
                                                <option value="<?php echo isset($_POST['orderby']) ? $_POST['orderby'] : "house"; ?>" selected><?php echo isset($_POST['orderby']) ? $_POST['orderby'] : "house"; ?></option>
                                                <option value="house">房屋來源</option>
                                                <option value="money">房屋租金</option>
                                                <option value="date">刊登時間</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="dict" class="form-control">
                                                <option value="<?php echo isset($_POST['dict']) ? $_POST['dict'] : "ASC"; ?>" selected><?php echo isset($_POST['dict']) ? $_POST['dict'] : "ASC"; ?></option>
                                                <option value="ASC">ASC</option>
                                                <option value="DESC">DESC</option>
                                            </select>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

            <div id="DataList" class="append"></div>
            <button id="myBtn" class="btn btn-dark backToTop" onClick="topFunction()"><i class="fa fa-arrow-up" aria-hidden="true"></i></button>
        </div>
    </section>

    <!-- footer -->
    <div class="footer">
        <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
    </div>

    <script>
        /**  back to top **/
        var mybutton = document.getElementById("myBtn");
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

</body>

</html>
<?php
mysql_free_result($Login);
?>