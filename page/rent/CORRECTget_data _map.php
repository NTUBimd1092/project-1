<?php

function Query($mylat,$mylng,$search)
{
    require_once('Connections/cralwer.php');
    mysql_select_db($database_cralwer, $cralwer);
    mysql_query("SET NAMES 'utf8'"); //修正中文亂碼問題
	
	$SqlWhere="";
	
	if (isset($search) && $search != "") {
        $SqlWhere .= " AND( `adress` LIKE '%{$search}%' OR `house` LIKE '%{$search}%' )";
    }

	$query = "
	SELECT *
	FROM page_data AS PD 
	LEFT JOIN localtion AS LA ON PD.id = LA.houseid 
	WHERE (1=1) AND ABS(lat-{$mylat})<=0.05 AND ABS(lng-{$mylng})<=0.05 {$SqlWhere}
	ORDER BY lat DESC
	LIMIT 0 , 15";

    $data = mysql_query($query, $cralwer) or die(mysql_error());
	$datacount=mysql_num_rows($data);
		
	while($row = mysql_fetch_array($data)){
		$Id = urlencode($row['id']);
		$Name=urlencode($row['house']);
		$Lat = $row['lat'];
		$Lng = $row['lng'];
		$Money = $row['money'];
		$Address = urlencode($row['adress']);
		$Images= $row['images'];
		$Link = $row['Link'];
	
		$return_arr[] = array("Id" => $Id,
						"Name" => $Name,
						"Lat" => $Lat,
						"Lng" => $Lng,
						"Money" => $Money,
						"Address" => $Address,
						"Images" => $Images,
						"Link" => $Link
						);
	}
	$json = json_encode($return_arr);
	echo urldecode($json);
	//echo json_encode($return_arr);
	
}
if (isset($_POST['mylat']) and isset($_POST['mylng'])) {
    /*設定參數*/
    Query($_POST['mylat'], $_POST['mylng'] ,$_POST['search']);
}

?>