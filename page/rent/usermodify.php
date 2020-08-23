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

/* 資料修改 */
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modify")) {
    $updateSQL = sprintf(
        "UPDATE `user` SET account=%s, password=%s, name=%s, phone=%s, birth=%s, subscribe=%s WHERE id=%s",
        GetSQLValueString($_POST['account'], "text"),
        GetSQLValueString($_POST['password'], "text"),
        GetSQLValueString($_POST['name'], "text"),
        GetSQLValueString($_POST['phone'], "text"),
        GetSQLValueString($_POST['birth'], "date"),
        GetSQLValueString($_POST['subscribe'], "text"),
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
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>作伙</title>
    <meta charset="utf-8">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/usermodify.css">
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' rel='stylesheet'>
    </link>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- 更改頭像DIALOG -->
    <link rel="stylesheet" href="src/uploadDialog.css">
    <script src="src/uploadDialog.js"></script>
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
    <nav class="navbar navbar-dark navbar-fixed-top myHeader">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">
                    <img src="images/WhiteIcon.png" width="28" class="d-inline-block align-top" alt="logo">
                </a>
                <a class="navbar-brand" style="font-size: 23px;" href="home.php">作伙</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">

                    <?php if ($totalRows_Login > 0) { // 登入後顯示 
                    ?>
                        <li><a href="searchArea.php">搜尋列表</a></li>
                        <li><a href="<?php echo $logoutAction ?>">登出</a></li>
                    <?php } // Show if recordset not empty 
                    ?>

                </ul>
            </div>

        </div>
    </nav>

    <!-- account data -->
    <div class="container-fluid">
        <div class="accountBg">
            <table class="accountData text-center">
                <tr>
                    <th rowspan="2"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></th>
                    <th class="text-center"><?php echo $totalRows_favorite ?></th>
                    <th class="text-center">(num)</th>
                    <th class="text-center">(num)</th>
                </tr>

                <tr>
                    <td>已收藏</td>
                    <td>價格異動</td>
                    <td>為您推薦</td>
                </tr>
            </table>
        </div>

        <!-- modify table -->
        <div class="col-12 col-md-4 col-sm-4"></div>
        <div class="col-12 col-md-4 col-sm-4 userBg">
            <table class="table table-sm dataTable">
                <thead>
                    <tr>
                        <td align="center"><img width="55px" height="55px" style="border-radius:50%" src="images/<?php echo $row_Login['image']; ?>"></td>
                        <td style="vertical-align:middle">
                            <form id="form">
                                <label class="btn btn-light btn-lg btn-block">
                                    <input id="upload_img" style="display:none;" onclick="changePic();">
                                    <i class="fa fa-photo"></i> 更改頭像
                                </label>
                            </form>
                        </td>
                    </tr>
                </thead>


                <form action="<?php echo $editFormAction; ?>" method="POST" name="modify">
                    <tbody>
                        <tr>
                            <input type="hidden" name="id" value="<?php echo $row_Login['id']; ?>">
                            <th>姓名</th>
                            <td><input class="form-control" name="name" type="text" value="<?php echo $row_Login['name']; ?>"></td>
                        </tr>

                        <tr>
                            <th>生日</th>
                            <td><input class="form-control" type="date" name="birth" value="<?php echo $row_Login['birth']; ?>"></td>
                        </tr>

                        <tr>
                            <th>電話</th>
                            <td><input class="form-control" type="number" name="phone" value="<?php echo $row_Login['phone']; ?>"></td>
                        </tr>

                        <tr>
                            <th>電子郵件</th>
                            <td><input class="form-control" type="email" name="account" value="<?php echo $row_Login['account']; ?>"></td>
                        </tr>

                        <tr>
                            <th>密碼</th>
                            <td><input class="form-control" type="text" name="password" value="<?php echo $row_Login['password']; ?>"></td>
                        </tr>

                        <tr>
                            <th>訂閱通知</th>
                            <td>
                                <!-- 判斷是否訂閱 -->
                                <?php if ($row_Login['subscribe'] == "是") { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="subscribe" value="是" checked="checked">是
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="subscribe" value="否">否
                                    </label>
                                <?php } ?>

                                <?php if ($row_Login['subscribe'] == "否") { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="subscribe" value="是">是
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="subscribe" value="否" checked="checked">否
                                    </label>
                                <?php } ?>
                            </td>
                        </tr>

                    </tbody>
            </table>

            <table class="table table-borderless">
                <tr>
                    <td align="right"><button class="btn btnGo" onclick="javascript:location.href='userPage.php'">取消變更</button></td>
                    <td>
                        <button class="btn btnGo" type="submit">儲存變更</button>
                        <input type="hidden" name="MM_update" value="modify">
                    </td>
                </tr>
            </table>

            </form>

        </div>
        <div class="col-12 col-md-4 col-sm-4"></div>
    </div>

    <div class="footer">
        <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon">作伙</a>
    </div>


    <script>
        var selectedImages = [];

        function changePic() {

            $.FileDialog({
                "accept": "image/*"
            }).on("files.bs.filedialog", function(event) {
                selectedImages.push(event.files[0].name);

                var form = document.getElementById("form");
                var formData = new FormData(form);
                formData.append("images", selectedImages[0]);
                formData.append("id", "<?php echo $row_Login['id']; ?>");
                var ajax = new XMLHttpRequest();
                ajax.open("POST", "uploadDialog.php", false);
                ajax.send(formData);
                window.location.reload();
            });

        }

        // function submitForm() {
        //     var form = document.getElementById("form");
        //     var formData = new FormData(form);
        //     // formData.append("images[0]", selectedImages);
        //     formData.append("images", selectedImages[0]);
        //     // alert(selectedImages[0]);
        //     var ajax = new XMLHttpRequest();
        //     ajax.open("POST", "Http.php", true);
        //     ajax.send(formData);

        //     return false;
        // }
    </script>
</body>

</html>
<?php
mysql_free_result($Login);

mysql_free_result($favorite);
?>