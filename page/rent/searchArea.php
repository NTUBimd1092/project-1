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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_page_data = 10;
$pageNum_page_data = 0;
if (isset($_GET['pageNum_page_data'])) {
  $pageNum_page_data = $_GET['pageNum_page_data'];
}
$startRow_page_data = $pageNum_page_data * $maxRows_page_data;

if (@$_POST[SquareMeter] = NULL) {
  $_POST[SquareMeter] = "%s";
}

/*搜尋所有資料 半成*/
mysql_select_db($database_cralwer, $cralwer);
@$query_page_data = "SELECT * FROM page_data WHERE `house` LIKE '%$_POST[search]%'
or `adress` LIKE '%$_POST[search]%' or `WebName` LIKE '%$_POST[search]%' ORDER BY `money` DESC";
$query_limit_page_data = sprintf("%s LIMIT %d, %d", $query_page_data, $startRow_page_data, $maxRows_page_data);
$page_data = mysql_query($query_limit_page_data, $cralwer) or die(mysql_error());
$row_page_data = mysql_fetch_assoc($page_data);

if (isset($_GET['totalRows_page_data'])) {
  $totalRows_page_data = $_GET['totalRows_page_data'];
} else {
  $all_page_data = mysql_query($query_page_data);
  $totalRows_page_data = mysql_num_rows($all_page_data);
}
$totalPages_page_data = ceil($totalRows_page_data / $maxRows_page_data) - 1;

/*登入者訊息*/
$colname_Login = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Login = $_SESSION['MM_Username'];
}
mysql_select_db($database_cralwer, $cralwer);
$query_Login = sprintf("SELECT * FROM `user` WHERE account = %s", GetSQLValueString($colname_Login, "text"));
$Login = mysql_query($query_Login, $cralwer) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
$userid= $row_Login['id'];

$queryString_page_data = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (
      stristr($param, "pageNum_page_data") == false &&
      stristr($param, "totalRows_page_data") == false
    ) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_page_data = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_page_data = sprintf("&totalRows_page_data=%d%s", $totalRows_page_data, $queryString_page_data);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//新增訂閱
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "favorite")) {
  $insertSQL = sprintf("INSERT INTO subscription (userid, Link) VALUES (%s, %s)",
                       GetSQLValueString($_POST['userid'], "int"),
                       GetSQLValueString($_POST['Link'], "text"));

  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($insertSQL, $cralwer) or die(mysql_error());

  $insertGoTo = "searchArea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
//刪除訂閱
@$deluid=base64_decode($_GET['userid']);
@$delLink=base64_decode($_GET['Link']);
if ((isset($_GET['del'])) && ($_GET['del'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `crawler`.`subscription` WHERE `subscription`.`userid` ='$deluid' AND `subscription`.`Link` ='$delLink'");
  mysql_select_db($database_cralwer, $cralwer);
  $Result1 = mysql_query($deleteSQL, $cralwer) or die(mysql_error());
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>作伙</title>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="icon" href="images/logo.ico" type="image/x-icon">
  <style>
    body {
      font-family: 微軟正黑體;
      background-color: #EFEFEF;
    }
	body::-webkit-scrollbar {
    display: none;
	}
    .header {
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
      position: fixed;
      position: absolute;
      top: 0;
      left: 0;
    }

    .header a {
      text-decoration: none;
    }

    .header a:link {
      text-decoration: none;
      color: white;
    }

    .header a:visited {
      text-decoration: none;
      color: white;
    }

    .headerRight {
      float: right;
      font-size: 15px;
      line-height: 40px;
      padding-top: 3px;
      padding-right: 15px;
      color: white;
    }

    .headerRight a {
      text-decoration: none;
      font-size: 16px;
      padding: 3px 8px;
    }

    .headerRight a:link {
      text-decoration: none;
      color: white;
    }

    .headerRight a:visited {
      text-decoration: none;
      color: white;
    }

    .headerRight a:hover {
      color: rgb(126, 83, 34, 0.85);
      background-color: white;
      border-radius: 3px;
    }

    .HomeIcon {
      height: 25px;
      padding-top: 8px;
      padding-right: 3px;
      padding-left: 8px;
    }

    .searchDiv {
      background-color: #D0B392;
      color: #000000;
      font-size: 16px;
      width: 100%;
      height: 150px;
      position: fixed;
      position: absolute;
      top: 45px;
      left: 0;
    }

    .searchCondition {
      width: 80%;
      text-align: center;
      position: relative;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .searchCondition a {
      text-decoration: none;
      font-size: 20px;
      padding: 0px 5px;
    }

    .searchCondition a:link {
      text-decoration: none;
      color: black;
    }

    .searchCondition a:visited {
      text-decoration: none;
      color: black;
    }

    .input {
      width: 470px;
      height: 28px;
      margin: 5px 3px;
      padding: 1.5px 8px;
      font-family: Arial, 微軟正黑體;
      border: 0 none;
      border-radius: 5px;
    }

    select {
      border: none;
      outline: none;
      background: transparent;
    }

    .select {
      width: 100px;
      height: 30px;
      margin: 5px;
      padding: 1.5px;
      text-align-last: center;
      font-family: Arial, 微軟正黑體;
      border: #D0B392;
    }

    .search {
      width: 60px;
      height: 30px;
      margin: 3px;
      color: white;
      font-size: 12px;
      font-family: 微軟正黑體;
      border: rgb(126, 83, 34, 0.85);
      border-radius: 5px;
      background-color: rgb(126, 83, 34, 0.85);
    }

    .resultDiv {
      top: 50%;
      left: 50%;
      margin: 10px auto;
      transform: translateY(35%);
      -webkit-transform: translateY(35%);
    }

    table {
      width: 750px;
      padding: 5px 10px;
      background-color: #FFFFFF;
      color: #726A6A;
      border: 1px solid #FFFFFF;
      border-collapse: separate;
      border-spacing: 0;
      border-radius: 10px;
      line-height: 20px;
      font-size: 14px;
    }

    th {
      padding: 5px 10px;
      color: rgb(114, 106, 106, 0.9);
    }

    td {
      padding: 5px 10px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    .favorite {
      width: 20px;
      padding-top: 5px;
    }

    .more {
      width: 75%;
      padding: 3px;
      color: white;
      font-size: 12px;
      font-family: 微軟正黑體;
      border: rgb(126, 83, 34, 0.85);
      background-color: rgb(126, 83, 34, 0.85);
    }

    .more a {
      text-decoration: none;
    }

    .more a:link {
      text-decoration: none;
      color: white;
    }

    .more a:visited {
      text-decoration: none;
      color: white;
    }

    .pages {
      text-align: center;
      margin-top: 60px;
      margin-bottom: 80px;
    }

    .pages a {
      text-decoration: none;
    }

    .pages a:link {
      text-decoration: none;
      color: #7E5322;
    }

    .pages a:visited {
      text-decoration: none;
      color: #7E5322;
    }

    .footer {
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
      position: fixed;
      bottom: 0;
      left: 0;
    }

    .footer a {
      text-decoration: none;
    }

    .footer a:link {
      text-decoration: none;
      color: white;
    }

    .footer a:visited {
      text-decoration: none;
      color: white;
    }
  </style>
    <script>
		var counter=0;
        $(window).scroll(function () {
            if ($(window).scrollTop() == $(document).height() - $(window).height() && counter < 2) {
                appendData();
            }
        });
        function appendData() {
            var html = '';
            for (i = 0; i < 10; i++) {
                html += '<p class="dynamic">Dynamic Data :  This is test data.<br />Next line.</p>';
            }
            $('#myScroll').append(html);
			counter++;
			
			if(counter==2)
			$('#myScroll').append('<button id="uniqueButton" style="margin-left: 50%; background-color: powderblue;">Click</button><br /><br />');
        }
    </script>
</head>

<body>

  <div class="header">
    <span>
      <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a>
      <a href="home.php">作伙</a>
    </span>

    <div class="headerRight">
      <a href="userPage.php" style="border:1px solid white; border-radius:2px;">嗨！<?php echo $row_Login['name']; ?></a>
      <a href="searchArea.php">搜尋列表</a>
      <a href="<?php echo $logoutAction ?>">登出</a>
    </div>
  </div>

  <div class="searchDiv">
    <div class="searchCondition">
      <span text-align="left">
        <a href="searchArea.php"><b>區域搜尋</b></a>
        &nbsp;|&nbsp;
        <a href="searchMetro.php">捷運搜尋</a>
        &nbsp;|&nbsp;
        <a href="searchDestination.php">目的搜尋</a>
        &nbsp;|&nbsp;
        <a href="maps.php">
        <img width="25px" src="images/map.png">
        </a>
      </span>
      <br>
      <form action="searchArea.php" method="post">
        <input type="text" class="input" name="search" class="light-table-filter" data-table="order-table" placeholder="Search..." value="<?php echo @$_POST['search'];?>">
        <button type="submit" class="search">搜尋</button>
      </form>

	<form action="searchArea.php" method="post">
      <select name="priceRange"  class="select" >
        <option value="">房屋租金</option>
        <option value="0 AND 5000">5000元以下</option>
        <option value="10Thousand">5000-10000元</option>
        <option value="20Thousand">10000-20000元</option>
        <option value="30Thousand">20000-30000元</option>
        <option value="40Thousand">30000-40000元</option>
        <option value="50Thousand">40000-50000元</option>
        <option value="60Thousand">50000-60000元</option>
        <option value="70Thousand">60000元以上</option>
      </select>

      <select name="rentType" class="select">
        <option value="">房屋類型</option>
        <option value="wholeFloor">整層住家</option>
        <option value="independentStudio">獨立套房</option>
        <option value="subletStudio">分租套房</option>
        <option value="room">雅房</option>
        <option value="other">其他</option>
      </select>

      <select name="housingPattern" class="select">
        <option value="">房屋格局</option>
        <option value="oneRoom">1房</option>
        <option value="twoRoom">2房</option>
        <option value="threeRoom">3房</option>
        <option value="fourRoom">4房</option>
        <option value="fiveOrMore">5房以上</option>
      </select>

      <select name="SquareMeter" class="select">
        <option value="">房屋坪數</option>
        <option value="10SquareMeter">10坪以下</option>
        <option value="20SquareMeter">10-20坪</option>
        <option value="30SquareMeter">20-30坪</option>
        <option value="40SquareMeter">30-40坪</option>
        <option value="50SquareMeter">40-50坪</option>
        <option value="60SquareMeter">50坪以上</option>
      </select>

      <select name="otherCondition" class="select">
        <option value="">其他條件</option>
      </select>
      </form>
      <div align="center">共搜尋出：<?php echo $totalRows_page_data;?>筆</div>
    </div>

    <?php if ($totalRows_page_data > 0) { // Show if recordset not empty 
    ?>
      <?php do {
        $Link = $row_page_data['Link'];
		$house_name= $row_page_data['house'];
		
		/*金額異動資料表 訂閱愛心用*/
        mysql_select_db($database_cralwer, $cralwer);
        $query_money_change = "SELECT * FROM money_change WHERE Link = '$Link'";
        $money_change = mysql_query($query_money_change, $cralwer) or die(mysql_error());
        $row_money_change = mysql_fetch_assoc($money_change);
        $totalRows_money_change = mysql_num_rows($money_change);
		
		mysql_select_db($database_cralwer, $cralwer);
		$query_sinyi = "SELECT * FROM page_data WHERE WebName = '信義房屋' && house='$house_name'";
		$sinyi = mysql_query($query_sinyi, $cralwer) or die(mysql_error());
		$row_sinyi = mysql_fetch_assoc($sinyi);
		$totalRows_sinyi = mysql_num_rows($sinyi);
		
		mysql_select_db($database_cralwer, $cralwer);
		$query_yungching = "SELECT * FROM page_data WHERE WebName = '永慶房屋' && house='$house_name'";
		$yungching = mysql_query($query_yungching, $cralwer) or die(mysql_error());
		$row_yungching = mysql_fetch_assoc($yungching);
		$totalRows_yungching = mysql_num_rows($yungching);
		
		mysql_select_db($database_cralwer, $cralwer);
		$query_subscription = "SELECT * FROM subscription WHERE userid = '$userid' && Link='$Link'";
		$subscription = mysql_query($query_subscription, $cralwer) or die(mysql_error());
		$row_subscription = mysql_fetch_assoc($subscription);
		$totalRows_subscription = mysql_num_rows($subscription);
				
      ?>
        <div class="resultDiv">
          <table align="center" class="order-table" id="customers">
            <tr>
              <td rowspan="4" width="25%" align="center"><img width="150px" height="100px" src="<?php echo $row_page_data['images']; ?>"></td>
              <th colspan="2" width="38%" align="left" style="font-size:20px"><?php echo $row_page_data['house']; ?></th>

                <td rowspan="4" width="2%" valign="top"><?php if ($totalRows_subscription == 0) { // Show if recordset empty ?>
				 <form action="<?php echo $editFormAction; ?>" name="favorite" method="POST">
                    <input type="image" src="images/favorite.png" width="20px" >
                    <input name="userid" value="<?php echo $row_Login['id']; ?>" type="hidden">
                    <input name="Link" value="<?php echo $row_page_data['Link']; ?>" type="hidden">
                    <input type="hidden" name="MM_insert" value="favorite">
                   </form>
                    <?php } /*Show if recordset emptye*/else{?><a href="searchArea.php?del=1&userid=<?php echo base64_encode($row_Login['id']);?>&Link=<?php echo base64_encode($row_page_data['Link']);?>"><img src="images/selectedFav.png" width="20px" ></a><?php } ?></td>

              <td width="20%" align="center">來自：<?php echo $row_page_data['WebName']; ?></td>
              <td width="15%" align="center" style="color:#00CC33">
			  <?php 
			  if($row_sinyi['money'] == $row_page_data['money'] || $row_sinyi['money']==0){echo 'PRICE';}else{?>信義：<?php echo $row_sinyi['money']-$row_page_data['money']; ?>$<?php }?>
			  </td>
            </tr>
            <tr>
              <td colspan="2"><?php echo $row_page_data['adress']; ?></td>
              <td rowspan="2" align="center" style="font-size:26px"><?php echo $row_page_data['money']; ?></td>
              <td align="center" style="color:#FF0000">
			  <?php 
			  if($row_yungching['money'] == $row_page_data['money'] || $row_yungching['money']==0 ){echo 'PRICE';}else{?>永慶：<?php echo $row_yungching['money']-$row_page_data['money']; ?>$<?php }?>
              </td>
            </tr>
            <tr>
              <td>坪數：<?php echo $row_page_data['square_meters']; ?></td>
              <td>形式：
                <?php echo $row_page_data['pattern'];?>
              </td>
              <td align="center">PRICE</td>
            </tr>
            <tr>
              <td>樓層：<?php echo $row_page_data['floor']; ?></td>
              <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
              <td align="center"><button class="more">
                  <a href="<?php echo $row_page_data['Link']; ?>" target="_blank">查看更多</a>
                </button></td>
              <td align="center">PRICE</td>
            </tr>
          </table>
        </div>
      <?php } while ($row_page_data = mysql_fetch_assoc($page_data)); ?>
      <div class="pages" style="color:#D1B390;">
        <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, max(0, $pageNum_page_data - 1), $queryString_page_data); ?>">上</b></a>
        <?php for ( $i=-3 ; $i<0 ; $i++ ){?>
         <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, max(0, $pageNum_page_data + $i), $queryString_page_data); ?>">
		 <?php if($pageNum_page_data+$i>=0){echo $pageNum_page_data +$i+1;}?>
         </a><?php }?>
         <span><?php echo $pageNum_page_data+1;?></span>
		<?php for ( $i=1 ; $i<3 ; $i++ ){?>
         <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, min($totalPages_page_data, $pageNum_page_data + $i), $queryString_page_data); ?>"><?php echo  $pageNum_page_data + $i+1;?></a><?php }?>
         <a href="<?php printf("%s?pageNum_page_data=%d%s", $currentPage, min($totalPages_page_data, $pageNum_page_data + 1), $queryString_page_data); ?>">下</b></a>
      </div>
    <?php } else { ?><h1>
        <div class="pages" style="color:#7E5322"><?php echo "查無資料"; ?></div>
      </h1> <?php } // Show if recordset not empty 
            ?>



  </div>

  <div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>

</body>

</html>

<?php
mysql_free_result($page_data);
mysql_free_result($Login);
@mysql_free_result($sinyi);
@mysql_free_result($yungching);
@mysql_free_result($subscription);
@mysql_free_result($money_change);
?>