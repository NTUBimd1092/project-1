<script src="src/get_data.js"></script>
<?php
function Query($offset, $limit, $WebName, $search, $moneyS, $moneyE, $orderby, $dict, $userid, $city, $town, $square)
{
    require_once('Connections/cralwer.php');
    mysql_select_db($database_cralwer, $cralwer);
    mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題

    $SqlWhere = "";
    if (isset($WebName) && $WebName != "") {
        $SqlWhere .= " AND `WebName` = '{$WebName}'";
    }

    if (isset($search) && $search != "") {
        $SqlWhere .= " AND (`house` like '%{$search}%' OR `adress` like '%{$search}%')";
    }

    if (isset($moneyS) && $moneyS != "") {
		switch($moneyS){
			case "0 AND 5000":
				$SqlWhere .= " AND `money` <= '5000'";
			break;
			case "10Thousand":
				$SqlWhere.="AND (`money` BETWEEN '5000' AND '10000') ";	
			break;
			case "20Thousand":
				$SqlWhere.="AND (`money` BETWEEN '10000' AND '20000') ";	
			break;
			case "30Thousand":
				$SqlWhere.="AND (`money` BETWEEN '20000' AND '30000') ";	
			break;
			case "40Thousand":
				$SqlWhere.="AND (`money` BETWEEN '30000' AND '40000') ";	
			break;
			case "50Thousand":
				$SqlWhere.="AND (`money` BETWEEN '40000' AND '50000') ";	
			break;
			case "60Thousand":
				$SqlWhere.="AND (`money` BETWEEN '50000' AND '60000') ";	
			break;
			case "70Thousand":
				$SqlWhere .= " AND `money` >= '60000'";
			break;
			default:
				$SqlWhere .= " AND `money` >= '{$moneyS}'";
			break;
		}
    }

    if (isset($moneyE) && $moneyE != "") {
        $SqlWhere .= " AND `money` <= '{$moneyE}'";
    }

	if (isset($city) && $city != "") {
		switch ($city){
			case '臺北市':
				$SqlWhere .= " AND (`adress` Like '臺北%' OR `adress` Like '台北%')";
			break;
			case '臺中市':
				$SqlWhere .= " AND (`adress` Like '臺中%' OR `adress` Like '台中%')";
			break;
			case '臺南市':
				$SqlWhere .= " AND (`adress` Like '臺南}%' OR `adress` Like '台南%')";
			break;
			case '臺東縣':
				$SqlWhere .= " AND (`adress` Like '臺東%' OR `adress` Like '台東%')";
			break;
			default:
				$SqlWhere .= " AND `adress` Like '{$city}%'";
			break;
		}
	}
	
	if (isset($town) && $town != "") {
		switch($town){
			case '臺東市':
				$SqlWhere .= " AND (`adress` Like '%臺東市%' or `adress` Like '%台東市%')";
			break;
			default:
				$SqlWhere .= " AND `adress` Like '%{$town}%'";
			break;	
		}
       //$SqlWhere .= " AND `adress` Like '%{$town}%'";
	}
	if(isset($square) && $square!=""){
		switch($square){
			case "10坪以下":
				$SqlWhere.="AND (`square_meters` <='10') ";	
			break;
			case "10-20坪":
				$SqlWhere.="AND (`square_meters` BETWEEN '10' AND '20') ";	
			break;
			case "20-30坪":
				$SqlWhere.="AND (`square_meters` BETWEEN '20' AND '30') ";	
			break;
			case "30-40坪":
				$SqlWhere.="AND (`square_meters` BETWEEN '30' AND '40') ";	
			break;
			case "40-50坪":
				$SqlWhere.="AND (`square_meters` BETWEEN '40' AND '50') ";	
			break;
			case "50坪以上":
				$SqlWhere.="AND (`square_meters` >='50') ";	
			break;
		}

	}
	if(isset($orderby) && $orderby!=""){
		switch($orderby){
			case "房屋來源":
				$orderby="house";
			break;
			case "刊登日期":
				$orderby="date";
			break;
			case "房屋租金":
				$orderby="money";
			break;
			default:
				$orderby="house";
			break;
		}
	}

	if(isset($dict) && $dict!=""){
		switch($dict){
			case "由大到小":
				$dict="DESC";
			break;
			case "由小到大":
				$dict="ASC";
			break;
			default:
				$dict="DESC";
			break;
		}
	}


	$query = "SELECT * FROM `page_data` where (1=1) {$SqlWhere} ORDER BY `{$orderby}` {$dict} LIMIT {$limit} OFFSET {$offset}";
	$data = mysql_query($query, $cralwer) or die(mysql_error());
	$row = mysql_fetch_assoc($data);
	$Rowcount=mysql_num_rows($data);
	if($Rowcount=="0"){
		echo "無資料!";
	}else{
		do{
			$query_subscribe = "SELECT COUNT(*) countSubscribe FROM `subscription` WHERE `userid` = '{$userid}' AND `Link` = '{$row['Link']}'";
			$subscribeCount = mysql_query($query_subscribe, $cralwer) or die(mysql_error());
			$row_subscribeCount=mysql_fetch_assoc($subscribeCount);
			$selectedFav = '<img class="favorite" id="' . $row["Link"] . '" src="images/selectedFav.png" width="20px" onClick="Favorate(this,' . $userid . ')">';
			$favorite = '<img class="favorite" id="' . $row["Link"] . '" src="images/favorite.png" width="20px" onClick="Favorate(this,' . $userid . ')">';
			$mystr = $row_subscribeCount['countSubscribe']>="1" ? $selectedFav : $favorite;
			$Is_Delete=$row['Is_Delete']=='Y'?"<span class=\"badge badge-danger\" >已下架</span>":"";
			if (isset($userid) AND $userid!="") {
				echo '
				<div class="row justify-content-center">
					<div class="col-12 col-sm-10 col-md-8 col-lg-6">
						<table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
							<tr>
								<td rowspan="4" width="30%" class="text-center align-middle">
									<img class="imageSize" src="' . $row['images'] . '">	
								</td>
								<th colspan="2" width="50%" class="houseName">' .$Is_Delete. $row['house'] . '</th>
								<td rowspan="4" width="2%" class="text-center align-top">'.
								// ($subscribeCount>=1 ? '<img class="favorite" id="' . $row["Link"] . '" src="images/selectedFav.png" width="20px" onClick="Favorate(this,' . $userid . ')">' : '<img class="favorite" id="' . $row["Link"] . '" src="images/favorite.png" width="20px" onClick="Favorate(this,' . $userid . ')">')
								$mystr
								.'</td>
								<td width="18%" class="text-center align-middle houseInfo">來自：' . $row['WebName'] . '</td>
							</tr>
		
							<tr>
								<td colspan="2">' . $row['adress'] . '</td>
								<td rowspan="2" id="Price" class="text-center align-middle housePrice">' . number_format($row['money']) . '</td>
							</tr>
		
							<tr>
								<td class="align-middle houseInfo">坪數：' . $row['square_meters'] . '</td>
								<td class="align-middle houseInfo">形式：' . $row['pattern'] . '</td>
							</tr>
		
							<tr>
								<td class="align-middle houseInfo">樓層：' . $row['floor'] . '</td>
								<td class="align-middle houseInfo">類型：' . $row['house_type'] . '</td>
								<td>
									<a class="btn btn-block btn-sm btnGo" target="_blank" href="' . $row['Link'] . '">查看更多</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			';
			} else {
				echo '
				<div class="row justify-content-center">
					<div class="col-12 col-sm-10 col-md-8 col-lg-6">
						<table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
							<tr>
								<td rowspan="4" width="30%" class="text-center align-middle"><img class="imageSize" src="' . $row['images'] . '"></td>
								<th colspan="2" width="50%" class="houseName">' .$Is_Delete. $row['house'] . '</th>
								<td rowspan="4" width="2%" class="text-center align-top"></td>
								<td width="18%" class="text-center align-middle houseInfo">來自：' . $row['WebName'] . '</td>
							</tr>
		
							<tr>
								<td colspan="2">' . $row['adress'] . '</td>
								<td rowspan="2" id="Price" class="text-center align-middle housePrice">' . number_format($row['money']) . '</td>
							</tr>
		
							<tr>
								<td class="align-middle houseInfo">坪數：' . $row['square_meters'] . '</td>
								<td class="align-middle houseInfo">形式：' . $row['pattern'] . '</td>
							</tr>
		
							<tr>
								<td class="align-middle houseInfo">樓層：' . $row['floor'] . '</td>
								<td class="align-middle houseInfo">類型：' . $row['house_type'] . '</td>
								<td>
									<a class="btn btn-block btn-sm btnGo" target="_blank" href="' . $row['Link'] . '">查看更多</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			';
			}
		}while($row=mysql_fetch_assoc($data));
	}
}
if (isset($_POST['offset']) and isset($_POST['limit'])) {
    /*設定參數*/
    Query($_POST['offset'], $_POST['limit'], $_POST['WebName'], $_POST['search'], $_POST['moneyS'], $_POST['moneyE'], $_POST['orderby'], $_POST['dict'], $_POST['userid'],$_POST['city'],$_POST['town'],$_POST['square']);
}

function Favorate($Link, $userid)
{
    require_once('Connections/cralwer.php');
    mysql_select_db($database_cralwer, $cralwer);
    mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題

    $query = "SELECT * FROM `subscription` where (1=1) AND `userid`='{$userid}' AND `Link`='{$Link}'";
    $data = mysql_query($query, $cralwer) or die(mysql_error());
    $totalRows = mysql_num_rows($data);
    if ($totalRows == 0) {
        $insert = "INSERT `subscription` VALUES('{$userid}', '{$Link}')";
        mysql_query($insert, $cralwer) or die(mysql_error());
		echo 'Insert';
    } else {
        $delete = "DELETE FROM `crawler`.`subscription` WHERE `subscription`.`userid` = '{$userid}' AND `subscription`.`Link` = '{$Link}'";
        mysql_query($delete, $cralwer) or die(mysql_error());
		echo 'Delete';
    }
}

function register($UserName, $UserAccount, $Image, $UserPwd){
	require_once('Connections/cralwer.php');
    mysql_select_db($database_cralwer, $cralwer);
	mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
	$query="SELECT * FROM `user` where (1=1) AND `account`='{$UserAccount}'";
    $data = mysql_query($query, $cralwer) or die(mysql_error());
	$totalRows = mysql_num_rows($data);
	if ($totalRows == 0) {	
		include 'encrypt.php'; //加解密檔
		$mypwd=encryptthis($UserPwd, $key);
		$myUserName=encryptthis($UserName, $key);
		$myImage=encryptthis($Image, $key);
		$insert="INSERT INTO `crawler`.`user` (
			`account` ,
			`password` ,
			`name` ,
			`image` 
			)
			VALUES (
				'{$UserAccount}', '{$mypwd}', '{$myUserName}', '{$myImage}'
			);
			";
        mysql_query($insert, $cralwer) or die(mysql_error());
		echo 'Register'; 
    } else {
        echo 'Login';
    }
}

function Login($myaccount, $mypassword){
	// require_once('Connections/cralwer.php');
    // mysql_select_db($database_cralwer, $cralwer);
	// mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
	// include 'encrypt.php';

	// if (isset($myaccount) {
	// 	$Pass_query = "SELECT account,password from `user` where account='$myaccount'";
	// 	$Pass_Select = mysql_query($Pass_query, $cralwer) or die(mysql_error());
	// 	$row_pass = mysql_fetch_assoc($Pass_Select);
	// 	if ($mypassword == decryptthis($row_pass['password'], $key)) {
	// 		$password = $row_pass['password'];
	// 	}

	// 	$MM_fldUserAuthorization = "";
	// 	$MM_redirectLoginSuccess = "home.php";
	// 	$MM_redirectLoginFailed = "login.php?check=err";
	// 	$MM_redirecttoReferrer = false;
	// 	mysql_select_db($database_cralwer, $cralwer);

	// 	$LoginRS__query = sprintf(
	// 		"SELECT account, password FROM `user` WHERE account=%s AND password=%s",
	// 		GetSQLValueString($myaccount, "text"),
	// 		GetSQLValueString($password, "text")
	// 	);

	// 	$LoginRS = mysql_query($LoginRS__query, $cralwer) or die(mysql_error());
	// 	$loginFoundUser = mysql_num_rows($LoginRS);
	// 	if ($loginFoundUser) {
	// 		$loginStrGroup = "";

	// 		//declare two session variables and assign them
	// 		$_SESSION['MM_Username'] = $loginUsername;
	// 		$_SESSION['MM_UserGroup'] = $loginStrGroup;

	// 		if (isset($_SESSION['PrevUrl']) && false) {
	// 			$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
	// 		}
	// 		header("Location: " . $MM_redirectLoginSuccess);
	// 	} else {
	// 		header("Location: " . $MM_redirectLoginFailed);
	// 	}
	// }

}

if (isset($_POST['Action'])) {
    switch ($_POST['Action']) {
        case "Favorate":
            Favorate($_POST['Link'], $_POST['userid']);
            break;

		case "register":
			register($_POST['UserName'],$_POST['UserAccount'],$_POST['Image'],$_POST['UserPwd']);
			break;
		
		case "Login":
			Login($_POST['account'],$_POST['password']);
		break;
	}
}

?>
