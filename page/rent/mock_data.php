<?php require_once('Connections/cralwer.php'); ?>
<?php
mysql_query("SET NAMES 'utf8'");//修正中文亂碼問題
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

mysql_select_db($database_cralwer, $cralwer);
$query_page_data = "SELECT * FROM page_data";
$page_data = mysql_query($query_page_data, $cralwer) or die(mysql_error());
$row_page_data = mysql_fetch_assoc($page_data);
$totalRows_page_data = mysql_num_rows($page_data);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<title>測試頁</title>
      <link rel="icon" href="images/logo.ico" type="image/x-icon">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style>
	body{
	overflow-x: hidden;
	}
	body::-webkit-scrollbar {
	}
	.TopButton{
	position: fixed;bottom:2%;right:2%; background:#000000; color:#FFFFFF; padding:10px; border-radius: 5px; font: '微軟正黑體'
	}
    </style>

<script>
		var counter=10;
        $(window).scroll(function () {
			last=$("body").height()-$(window).height()-100
            if ($(window).scrollTop() >= last) {
			    appendData();
			}
        });


    </script>
</head>
<body>
<div class="row">	
  <div class="col-md-12">.col-md-12</div>
</div>
<div class="row">
	<div id="myScroll" class="col-12" >
        <?php 
		$i=0;
		do{ 
			 $dataList[$i]=array($row_page_data['id'],$row_page_data['WebName'],$row_page_data['images'],$row_page_data['Link'],$row_page_data['house'],$row_page_data['adress'],$row_page_data['money'],$row_page_data['house_type'],$row_page_data['floor'],$row_page_data['square_meters'],$row_page_data['pattern'],$row_page_data['date']);
			 $i++; 
		} while ($row_page_data = mysql_fetch_assoc($page_data));
		?>
        <script>
        var dataList=<?php echo json_encode($dataList);?>
        </script>
        <?php 
		for($ii=0;$ii<=9;$ii++){
		?>
         <table align="center" class="order-table" id="customers">
            <tr>
              <td rowspan="4" width="25%" align="center"><img width="150px" height="100px" src="<?php echo $dataList[$ii][2]; ?>"></td>
              <td colspan="2" width="38%" align="left" style="font-size:20px"><?php echo $dataList[$ii][4]; ?></td>

                <td rowspan="4" width="2%" valign="top">
                    <input type="image" src="images/favorite.png" width="20px" >
                    </td>
              <td width="20%" align="center">來自：<?php echo $dataList[$ii][1]; ?></td>
              <td width="15%" align="center" style="color:#00CC33">
			  </td>
            </tr>
            <tr>
              <td colspan="2"><?php echo $dataList[$ii][5]; ?></td>
              <td rowspan="2" align="center" style="font-size:26px"><?php echo $dataList[$ii][6]; ?></td>
              <td align="center" style="color:#FF0000">
              </td>
            </tr>
            <tr>
              <td>坪數：<?php echo $dataList[$ii][9]; ?></td>
              <td>形式：
                <?php echo $dataList[$ii][10];?>
              </td>
              <td align="center">PRICE</td>
            </tr>
            <tr>
              <td>樓層：<?php echo $dataList[$ii][8]; ?></td>
              <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
              <td align="center"><button class="more">
                  <a href="<?php echo $dataList[$ii][3]; ?>" target="_blank">查看更多</a>
                </button></td>
              <td align="center">PRICE</td>
            </tr>
          </table>
        
        <?php }?>
  
          <script>
			function appendData() {			 
				var id =dataList[counter][0];
				var WebName=dataList[counter][1];
				var images=dataList[counter][2];
				var Link=dataList[counter][3];
				var house=dataList[counter][4];
				var adress=dataList[counter][5];
				var money=dataList[counter][6];
				var house_type=dataList[counter][7];
				var floors=dataList[counter][8];
				var square=dataList[counter][9];
				var pattern=dataList[counter][10];
				var date=dataList[counter][11];
				var table='';
				table+='<table align="center" class="order-table" id="customers"><tr><td rowspan="4" width="25%" align="center"><img width="150px" height="100px" src="'+images+'"></td><td colspan="2" width="38%" align="left"style="font-size:20px">'+house+'</td><td rowspan="4" width="2%" valign="top"><input type="image" src="images/favorite.png" width="20px"></td><td width="20%" align="center">來自：'+WebName+'</td><td width="15%" align="center" style="color:#00CC33"></td></tr><tr><td colspan="2">'+adress+'</td><td rowspan="2" align="center" style="font-size:26px">'+money+'</td><td align="center" style="color:#FF0000"></td></tr><tr><td>坪數：'+square+'</td><td>形式：'+pattern+'</td><td align="center">PRICE</td></tr><tr><td>樓層：'+floors+'</td><td style="color:rgb(227, 73, 73, 0.9)">特色：</td><td align="center"><button class="more"><a href="'+Link+'"target="_blank">查看更多</a></button></td><td align="center">PRICE</td></tr></table>'
				$('#myScroll').append(table);
				counter++;		
			}
          </script>
          
          
       
	</div>
</div>
<button  class="TopButton" onClick="TopFunction()">向上</button>
<script>
function TopFunction() {
  $(window).scrollTop("0");
  
}
</script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  
</body>
</html>
<?php
mysql_free_result($page_data);
?>
