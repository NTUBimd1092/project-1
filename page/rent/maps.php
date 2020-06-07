<?php require_once('Connections/cralwer.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
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
mysql_query("SET NAMES 'utf8'");//資料亂碼
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

/*資料清單*/
mysql_select_db($database_cralwer, $cralwer);
$query_page_data = "SELECT * FROM page_data";
$page_data = mysql_query($query_page_data, $cralwer) or die(mysql_error());
$row_page_data = mysql_fetch_assoc($page_data);
$totalRows_page_data = mysql_num_rows($page_data);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>作伙</title>
    <link rel="canonical" href="https://letswrite.tw/google-map-api-marker-custom/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
      #map {
        background: #CCC;
		font-family: 微軟正黑體;
		font-size:36px;
		}
      /*google map css*/

    body {
      font-family: 微軟正黑體;
      background-color: #EFEFEF;
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
	position: relative;
      background-color: rgb(126, 83, 34);
      color: white;
      font-size: 25px;
      width: 100%;
      height: 45px;
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
	#map{ 
	 width:95%;
	 margin-left:2.5%;
	 margin-top:2%;
	 margin-bottom:2%;
	 border:rgb(126, 83, 34) solid;
	 border-radius: 10px;
	 border-width:10px;
	}
  </style>

    
<link rel="shortcut icon" href="images/BrownIcon.png"/>
    <!-- Google Tag Manager-->
  </head>
  <body> 
    <div class="header">
    <span>
      <a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a>
      <a href="home.php">作伙</a>
    </span>

    <div class="headerRight">
      <a href="userPage.php" style="border:1px solid white; border-radius:2px;">嗨!<?php echo $row_Login['name'];?></a>
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
      </span><br>
      <br>
<input id="address" type="textbox"  class="input"  placeholder='地址'>
<input id="submit"  class="search" type="button" value="搜尋">
<div class="select"></div>
</div>
<!-- Google Tag Manager (noscript)-->


	<div id="map"  class="embed-responsive embed-responsive-16by9">重新整理</div>

    <!-- 將 YOUR_API_KEY 替換成你的 API Key 即可 -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWONkZ5unzdAAcQM5XRH_ojvnFTEwlTps&callback=initMap" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyAWONkZ5unzdAAcQM5XRH_ojvnFTEwlTps"></script>

    <!-- map -->
<script>
  function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), { 
	styles:[
	  {
		"featureType": "administrative.land_parcel",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "administrative.neighborhood",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "poi",
		"elementType": "labels.text",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "road",
		"elementType": "labels",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  },
	  {
		"featureType": "water",
		"elementType": "labels.text",
		"stylers": [
		  {
			"visibility": "off"
		  }
		]
	  }
	]
  });
  //抓自己的位置 預設為台北101
  //標出自己得位置 
	var myinfo;
	myinfo = new google.maps.InfoWindow;
  navigator.geolocation.getCurrentPosition(function(position) {
    var initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    map.setCenter(initialLocation);
    map.setZoom(14);
	myinfo.setPosition(initialLocation);
	myinfo.setContent('你在這裡!');
	myinfo.open(map);
  }, function(positionError) {
    map.setCenter(new google.maps.LatLng(25.033671, 121.564427));
    map.setZoom(12);
  });
 
  
  var geocoder = new google.maps.Geocoder();
  var marker,i;
  //用地址轉經緯度 標出來 一輪極限10次
  <?php	$counter = 0; $max = 10; do{?>
   var address ='<?php echo $row_page_data['adress']; ?>';
	geocoder.geocode({'address': address}, function(results, status) {
		if (status === 'OK') {
			var marker = new google.maps.Marker({
				position:results[0].geometry.location,
				map: map, 
				animation: google.maps.Animation.DROP,
				label:{
					text: "$<?php echo $row_page_data['money']; ?>",
					color: "#4682B4",
					fontSize: "30px",
					fontWeight: "bold"
				}				
			});
			var infowindow = new google.maps.InfoWindow({
				content: '<a href="<?php echo $row_page_data['Link']; ?>" target=_blank><img src="<?php echo $row_page_data['images']; ?>" width="150px" height="100px" ><br><?php echo $row_page_data['house']; ?></br><?php echo $row_page_data['adress']; ?></a>'
			});			
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			});
			<?php $counter++;?>
	}else {
		alert('Geocode was not successful for the following reason: ' + status);
		}
	});

	<?php } while ($row_page_data = mysql_fetch_assoc($page_data)and ($counter < $max)); ?>

	 google.maps.event.addDomListener(window, 'load', initialize);
}


    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWONkZ5unzdAAcQM5XRH_ojvnFTEwlTps&callback=initMap">
    </script>
<div align="left" style=" height: auto; position: relative; background:#CCCCCC; padding:10px;">
	<div style="background:#FFFFFF; padding:5px;border-radius:10px;">
    	<img width="150px" height="100px" src="<?php echo $row_page_data['images']; ?>"><br>
		<?php echo $row_page_data['house']; ?><br>
		<?php echo $row_page_data['adress']; ?><br>
		<?php echo $row_page_data['money']; ?><br>
		<?php echo $row_page_data['house_type']; ?><br>
		<?php echo $row_page_data['floor']; ?><br>
		<?php echo $row_page_data['square_meters']; ?><br>
		<?php echo $row_page_data['pattern']; ?>
    </div>
</div>
  <div class="footer">
    <span><a href="home.php"><img src="images/WhiteIcon.png" alt="logo" class="HomeIcon"></a></span>
    <span><a href="home.php">作伙</a></span>
  </div>
</body>
</html>
<?php
mysql_free_result($Login);

mysql_free_result($page_data);
?>
