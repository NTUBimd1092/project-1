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
    <link rel="stylesheet" href="src/twzipcode.css">
    <link rel="stylesheet" href="src/jquery.scrolltop.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-twzipcode@1.7.14/jquery.twzipcode.min.js"></script>
    <!-- <script src="src/searchArea.js"></script> -->

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
        .custom-scrolltop {
            background-color:rgb(126, 83, 34, 0.85) !important;
            font-size: 1.5em;
            line-height: 40px;
            border-radius: 50%;
        }

    </style>
</head>

<body>
    <section class="myBody">

        <!-- navbar -->
        <nav class="navbar navbar-expand-md navbar-dark myHeader">
            <a class="navbar-brand" href="index.php">
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
                        <li class="nav-item active"><a class="nav-link" href="userPage.php"><b>嗨！<?php include 'encrypt.php'; echo decryptthis($row_Login['name'],$key); ?></b></a></li>
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
                                        <th colspan="5">
                                            區域搜尋 <a href="maps.php" style="color:black; text-decoration:none; font-weight:500;"> | 地圖搜尋</a>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="qtxt" id="qtxt" value="<?php echo isset($_POST['qtxt']) ? $_POST['qtxt'] : ""; ?>" placeholder="輸入房屋名稱或地址..."></input>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btnGo" id="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </td>

                                        <td colspan="2">
                                            <div id="twzipcode_ADV" name="twzipcode_ADV" class="form-inline"></div>        
                                            <script>
                                                $("#twzipcode_ADV").twzipcode({
                                                    zipcodeIntoDistrict: true, // 郵遞區號自動顯示在地區
                                                    css: ["city form-control w-50", "town form-control w-50"], // 自訂 "城市"、"地區" class 名稱 
                                                    countyName: "city", // 自訂城市 select 標籤的 name 值
                                                    districtName: "town" // 自訂地區 select 標籤的 name 值
                                                });
                                                
                                            </script>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">房屋租金</td>
                                        <td>坪數</td>
                                        <td>房屋來源</td>
                                        <td colspan="2">排序方式</td>
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
                                                <option value="40000">40000</option>
                                                <option value="50000">50000</option>
                                                <option value="60000">60000</option>
                                                <option value="70000">70000</option>
                                                <option value="80000">80000</option>
                                                <option value="90000">90000</option>
                                                <option value="100000">100000</option>
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
                                                <option value="40000">40000</option>
                                                <option value="50000">50000</option>
                                                <option value="60000">60000</option>
                                                <option value="70000">70000</option>
                                                <option value="80000">80000</option>
                                                <option value="90000">90000</option>
                                                <option value="100000">100000</option>
                                            </select>
                                        </td>
                                        <td>
                                        <select name="square" class="form-control">
                                            <option value="<?php echo isset($_POST['square']) ? $_POST['square'] : ""; ?>" selected><?php echo isset($_POST['square']) && $_POST['square'] != "" ? $_POST['square'] : "不限"; ?></option>
                                            <option value="">不限</option>
                                            <option value="10坪以下">10坪以下</option>
                                            <option value="10-20坪">10-20坪</option>
                                            <option value="20-30坪">20-30坪</option>
                                            <option value="30-40坪">30-40坪</option>
                                            <option value="40-50坪">40-50坪</option>
                                            <option value="50坪以上">50坪以上</option>
                                        </select>
                                        </td>
                                        <td>
                                            <select id="WebName" name="WebName" class="form-control">
                                                <option value="<?php echo isset($_POST['WebName']) ? $_POST['WebName'] : ""; ?>" selected><?php echo isset($_POST['WebName']) && $_POST['WebName'] != "" ? $_POST['WebName'] : "全部"; ?></option>
                                                <option value="">全部</option>
                                                <option value="信義房屋">信義房屋</option>
                                                <option value="永慶房屋">永慶房屋</option>
                                                <option value="591網">591網</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="orderby" class="form-control">
                                                <option value="<?php echo isset($_POST['orderby']) ? $_POST['orderby'] : "house"; ?>" selected><?php echo isset($_POST['orderby']) ? $_POST['orderby'] : "house"; ?></option>
                                                <option value="房屋來源">房屋來源</option>
                                                <option value="房屋租金">房屋租金</option>
                                                <option value="刊登時間">刊登時間</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="dict" class="form-control">
                                                <option value="<?php echo isset($_POST['dict']) ? $_POST['dict'] : "ASC"; ?>" selected><?php echo isset($_POST['dict']) ? $_POST['dict'] : "ASC"; ?></option>
                                                <option value="由小到大">由小到大</option>
                                                <option value="由大到小">由大到小</option>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://code.jquery.com/jquery-3.1.0.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="src/jquery.scrolltop.js"></script>

    <script>
        (function($){

            $.scrolltop({
                template: '<i class="fa fa-chevron-up"></i>',
                class: 'custom-scrolltop'
            });

        })(jQuery);

    </script>

</body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


        </div>
    </section>

    <!-- footer -->
    <div class="footer">
        <a href="index.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
    </div>
    <script type="text/javascript">
        var WebName = '<?php echo $_POST['WebName']; ?>';
        var qtxt = '<?php echo $_POST['qtxt']; ?>'; //查詢房名、地址
        var moneyS = '<?php echo $_POST['moneyS']; ?>';
        var moneyE = '<?php echo $_POST['moneyE']; ?>';
        var orderby = '<?php echo $_POST['orderby']; ?>';
        var dict = '<?php echo $_POST['dict']; ?>';
        var userid = '<?php echo isset($row_Login['id']) ? $row_Login['id'] : ""; ?>';
        var city ='<?php echo $_POST['city'];?>';
        var town='<?php echo $_POST['town'];?>';
        var square='<?php echo $_POST['square']; ?>';
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
                    'userid': userid,
                    'city':city,
                    'town':town,
                    'square':square
                },
                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                success: function(data) {
                    if(data.substr(-4)=="無資料!"){

                    }else{
                        $('#DataList').append(data);
                        flag += 10;
                    }

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
                            'userid': userid,
                            'city':city,
                            'town':town,
                            'square':square
                        },
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success: function(data) {
                            if(data.substr(-4)=="無資料!"){

                            }else{
                                $('#DataList').append(data);
                                flag += 10;
                            }
                            $('#twzipcode_ADV').twzipcode({
                                'countySel':city ,
                                'districtSel': town
                            });
                        },
                        error: function(e) {
                            console.log('error', e)
                        }
                    });
                }
            });
        });
 
    </script>

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
    <?php 
    if(isset($_POST['home'])&& $_POST['home']="home"){
        echo "<script>
        $('#submit').trigger('click');
        </script>";
    }
    ?>

</body>

</html>
<?php
mysql_free_result($Login);
?>