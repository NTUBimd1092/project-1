<script src="JS/jquery-3.5.1.min.js"></script>
<script src="JS/get_data.js"></script>
<?php
function Query($offset, $limit, $WebName, $search, $moneyS, $moneyE, $orderby, $dict){
  require_once('Connections/cralwer.php');
  mysql_select_db($database_cralwer, $cralwer);
  mysql_query("SET NAMES 'utf8'");//修正中文亂碼問題

  $SqlWhere="";
  if(isset($WebName) && $WebName!=""){$SqlWhere.=" AND `WebName` = '{$WebName}'";}
  
  if(isset($search) && $search!=""){$SqlWhere.=" AND (`house` like '%{$search}%' OR `adress` like '%{$search}%')";}
  
  if(isset($moneyS) && $moneyS!=""){$SqlWhere.=" AND `money` >= '{$moneyS}'";}
  
  if(isset($moneyE) && $moneyE!=""){$SqlWhere.=" AND `money` <= '{$moneyE}'";}
  
   
  $query="SELECT * FROM `page_data` where (1=1) {$SqlWhere} ORDER BY `{$orderby}` {$dict} LIMIT {$limit} OFFSET {$offset}";
  $data= mysql_query($query, $cralwer)or die(mysql_error());

  while($row =  mysql_fetch_array($data)){
    echo '
      <table  id="qDTable">
        <tr>
          <td rowspan="4" width="25%" align="center"><img width="150px" height="100px" src="'.$row['images'].'"></td>
          <td colspan="2" width="38%" align="left" style="font-size:20px">'.$row['house'].'</td>
          <td rowspan="4" width="2%" valign="top"><img class="favorite" id="favorite" src="images/favorite.png" width="20px" ></td>
          <td width="20%" align="center">來自：'.$row['WebName'].'</td>
          <td width="15%" align="center" style="color:#00CC33"></td>
        </tr>
        <tr>
          <td colspan="2">'.$row['adress'].'</td>
          <td rowspan="2" align="center" style="font-size:26px" id="Price">'.$row['money'].'</td>
          <td align="center" style="color:#FF0000"></td>
        </tr>
        <tr>
          <td>坪數：'.$row['square_meters'].'</td>
          <td>形式：'.$row['pattern'].'</td>
          <td align="center">PRICE</td>
        </tr>
        <tr>
          <td>樓層：'.$row['floor'].'</td>
          <td style="color:rgb(227, 73, 73, 0.9)">特色：</td>
          <td align="center"><button><a href="'.$row['Link'].'" target="_blank">查看更多</a></button></td>
          <td align="center">PRICE</td>
        </tr>
      </table>
    ';
  
  }

}
	if(isset($_POST['offset']) and isset($_POST['limit'])){
    /*設定參數*/
		Query($_POST['offset'], $_POST['limit'], $_POST['WebName'], $_POST['search'], $_POST['moneyS'], $_POST['moneyE'], $_POST['orderby'], $_POST['dict']);
	}

?>
