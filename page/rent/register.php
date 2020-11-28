<?php require_once('Connections/cralwer.php'); ?>
<?php
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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "from2") and (@$_POST['password'] == @$_POST['repassword'])) {
    include 'encrypt.php'; //加解密檔
    $insertSQL = sprintf(
        "INSERT INTO `user` (account, password, name, phone, image) VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString($cralwer, $_POST['account'],"text"),
        GetSQLValueString($cralwer, encryptthis($_POST['password'], $key), "text"),
        GetSQLValueString($cralwer, encryptthis($_POST['name'], $key), "text"),
        GetSQLValueString($cralwer, encryptthis($_POST['phone'], $key), "text"),
        GetSQLValueString($cralwer, encryptthis("images\avatar.png", $key), "text")
        );

    mysqli_select_db( $cralwer,$database_cralwer);
    $Result1 = mysqli_query($cralwer,$insertSQL);

    $insertGoTo = "login.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

mysqli_select_db( $cralwer,$database_cralwer);
$query_user = "SELECT * FROM `user`";
$user = mysqli_query($cralwer,$query_user);
$row_user = mysqli_fetch_assoc($user);
$totalRows_user = mysqli_num_rows($user);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>作伙</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 微軟正黑體;
            background-image: url('images/RegisterBackground.jpg');
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding-bottom: 30px;
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md navbar-dark myHeader">
        <a class="navbar-brand" href="index.php">
            <img src="images/WhiteIcon.png" width="28" class="d-inline-block align-top">
            作伙
        </a>
    </nav>

    <!-- container -->
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-12 col-sm-10 col-md-8 col-lg-4">
                <form class="formContainer RegisterFormMargin" action="<?php echo $editFormAction; ?>" name="from2" method="POST">
                    <section class="title">
                        <img src="images/BrownIcon.png" alt="logo" class="HomeIcon"> | 加入作伙，找一個家
                    </section>

                    <div class="form-group">
                        <label for="EmailAddress"><b>電子郵件&nbsp;|&nbsp;Email&nbsp;Address</b></label>
                        <input class="form-control" type="email" name="account" id="email" placeholder="xxxxx@gmail.com" required>
                    </div>

                    <div class="form-group">
                        <label for="Password"><b>密碼&nbsp;|&nbsp;Password</b></label>
                        <input class="form-control" type="password" name="password" id="password" onblur="checkpas1();" placeholder="輸入密碼" required>
                    </div>

                    <div class="form-group">
                        <label for="Password"><b>重新輸入密碼&nbsp;|&nbsp;CheckPassword</b></label>
                        <input class="form-control" type="password" name="repassword" id="repassword" onChange="checkpas();" placeholder="重新輸入密碼" required>
                    </div>

                    <div class="form-group">
                        <label for="uname"><b>姓名&nbsp;|&nbsp;Name</b></label>
                        <input class="form-control" type="text" name="name" placeholder="ex:Zachary Walton" required>
                    </div>

                    <div class="form-group">
                        <label for="phone"><b>電話&nbsp;|&nbsp;PhoneNumber</b></label>
                        <input class="form-control" type="tel" pattern="[0-9]{10}" name="phone" placeholder="ex:0912345678" required>

                    </div>

                    <div class="form-group">
                        <label for="CAPTCHA"><b>驗證碼&nbsp;|&nbsp;CAPTCHA</b></label>
                        <table>
                            <tr>
                                <td width="70%"><input class="form-control" id="captcha" type="text" placeholder="輸入驗證碼" required></td>
                                <td width="30%" style="padding-left:5px"><canvas id="canvas" width="125" height="40"></canvas></td>
                            </tr>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-block btnGo" onclick="checkpas2();">註冊！</button>
                    <small class="form-text text-muted">已經是會員了嗎？<b><a href="login.php">登入</a></b></small>
                    <input type="hidden" name="MM_insert" value="from2" />
                </form>
            </div>

        </div>
    </div>

    <script src="src/captcha.js"></script>
    <script>
        //確認兩個密碼框中是否一致
        $(".tip").hide();

        function checkpas1() { //當第一個密碼框失去焦點時，觸發checkpas1事件
            var pas1 = document.getElementById("password").value;
            var pas2 = document.getElementById("repassword").value; //獲取兩個密碼框的值
            if (pas1 != pas2 && pas2 != "") //此事件當兩個密碼不相等且第二個密碼是空的時候會顯示錯誤資訊
                $(".tip").show();
            else
                $(".tip").hide(); //若兩次輸入的密碼相等且都不為空時，不顯示錯誤資訊。
        }

        function checkpas() { //當第一個密碼框失去焦點時，觸發checkpas2件
            var pas1 = document.getElementById("password").value;
            var pas2 = document.getElementById("repassword").value; //獲取兩個密碼框的值
            if (pas1 != pas2) {
                $(".tip").show(); //當兩個密碼不相等時則顯示錯誤資訊
            } else {
                $(".tip").hide();
            }
        }

        function checkpas2() { //點選提交按鈕時，觸發checkpas2事件，會進行彈框提醒以防無視錯誤資訊提交
            var pas3 = document.getElementById("password").value;
            var pas4 = document.getElementById("repassword").value;
            if (pas3 != pas4) {
                alert("兩次輸入的密碼不一致！");
                return false;
            }
        }
    </script>
</body>

</html>
<?php
mysqli_free_result($user);
?>