<!-- <script src="JS/jquery-3.5.1.min.js"></script> -->
<script src="src/get_data.js"></script>
<?php
function Query($offset, $limit, $WebName, $search, $moneyS, $moneyE, $orderby, $dict, $userid)
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
        $SqlWhere .= " AND `money` >= '{$moneyS}'";
    }

    if (isset($moneyE) && $moneyE != "") {
        $SqlWhere .= " AND `money` <= '{$moneyE}'";
    }


    $query = "SELECT * FROM `page_data` where (1=1) {$SqlWhere} ORDER BY `{$orderby}` {$dict} LIMIT {$limit} OFFSET {$offset}";
    $data = mysql_query($query, $cralwer) or die(mysql_error());

    while ($row =  mysql_fetch_array($data)) {
		if(isset($userid)){
			 echo '
			<div class="row justify-content-center">
				<div class="col-12 col-sm-10 col-md-8 col-lg-6">
					<table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
						<tr>
							<td rowspan="4" width="30%" class="text-center align-middle">
								<img class="imageSize" src="' . $row['images'] . '">	
							</td>
							<th colspan="2" width="50%" class="houseName">' . $row['house'] . '</th>
							<td rowspan="4" width="2%" class="text-center align-top">
							<img class="favorite" id="'.$row['Link'].'" src="images/favorite.png" width="20px" onClick="Favorate(this,'.$userid.')" >
							</td>
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
							<td class="align-middle houseInfo">特色：</td>
							<td>
								<a class="btn btn-block btn-sm btnGo" href="' . $row['Link'] . '">查看更多</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		';
		}else{
			 echo '
			<div class="row justify-content-center">
				<div class="col-12 col-sm-10 col-md-8 col-lg-6">
					<table id="qDTable" class="table table-sm initialism table-borderless bg-white card">
						<tr>
							<td rowspan="4" width="30%" class="text-center align-middle"><img class="imageSize" src="' . $row['images'] . '"></td>
							<th colspan="2" width="50%" class="houseName">' . $row['house'] . '</th>
							<td rowspan="4" width="2%" class="text-center align-top">
							
							</td>
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
							<td class="align-middle houseInfo">特色：</td>
							<td>
								<a class="btn btn-block btn-sm btnGo" href="' . $row['Link'] . '">查看更多</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		';
		}
    }
}
if (isset($_POST['offset']) and isset($_POST['limit'])) {
    /*設定參數*/
    Query($_POST['offset'], $_POST['limit'], $_POST['WebName'], $_POST['search'], $_POST['moneyS'], $_POST['moneyE'], $_POST['orderby'], $_POST['dict'], $_POST['userid']);
}

?>