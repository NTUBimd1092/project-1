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
	WHERE (1=1) AND ABS(lat-{$mylat})<=0.1 AND ABS(lng-{$mylng})<=0.1 {$SqlWhere}
	ORDER BY lat DESC
	LIMIT 0 , 15";

	$data = mysql_query($query, $cralwer) or die(mysql_error());
	$row = mysql_fetch_array($data);
	$datacount=mysql_num_rows($data);
		
	do{
		$Id = urlencode($row['id']);
		$Name=urlencode($row['house']);
		$Lat = $row['lat'];
		$Lng = $row['lng'];
		$Money = $row['money'];
		$Address = urlencode($row['adress']);
		$Images= $row['images'];
        $Link = $row['Link']; 
        $SquareFeet = $row['square_meters'];
        $HouseType = $row['house_type'];
        $Floor = $row['floor'];
        $WebName = $row['WebName'];
	
		$return_arr[] = array("Id" => $Id,
						"Name" => $Name,
						"Lat" => $Lat,
						"Lng" => $Lng,
						"Money" => $Money,
						"Address" => $Address,
						"Images" => $Images,
                        "Link" => $Link,
                        "SquareFeet" => $SquareFeet,
                        "HouseType" => $HouseType,
                        "Floor" => $Floor,
                        "WebName" => $WebName
						);
	}while($row = mysql_fetch_array($data));
	$json = json_encode($return_arr);
	echo urldecode($json);
	//echo json_encode($return_arr);
	
}
if (isset($_POST['mylat']) and isset($_POST['mylng'])) {
    /*設定參數*/
    Query($_POST['mylat'], $_POST['mylng'] ,$_POST['search']);
}

?>