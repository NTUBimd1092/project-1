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
	<script src="JS/jquery-3.5.1.min.js"></script>
	<script src="JS/SearchArea.js"></script>
      <script type="text/javascript">
        
        var WebName='<?php echo $_POST['WebName'];?>';
		var qtxt ='<?php echo $_POST['qtxt'];?>';//查詢房名、地址
		var moneyS='<?php echo $_POST['moneyS'];?>';
		var moneyE='<?php echo $_POST['moneyE'];?>';
		var orderby='<?php echo $_POST['orderby'];?>';
		var dict='<?php echo $_POST['dict'];?>';

        $(document).ready(function(){
            var flag=0;
            $.ajax({
                type:"POST",
                url:"get_data.php",
                data:{
                    'offset':0,
                    'limit':10,
                    'WebName':WebName,
					'search':qtxt,
					'moneyS':moneyS,
					'moneyE':moneyE,
					'orderby':orderby,
					'dict':dict
                },
                contentType:"application/x-www-form-urlencoded; charset=utf-8",
                success:function(data){
                    $('#DataList').append(data);
                    flag +=10;
                },
                error:function(e){
                    console.log('error' ,e)
                }
            });	
            
            $(window).scroll(function(){
                last=$("body").height()-$(window).height()-100
                if($(window).scrollTop() >= last){
                    $.ajax({
                        type:"POST",
                        url:"get_data.php",
                        data:{
                            'offset':flag,
                            'limit':10,
							'WebName':WebName,
							'search':qtxt,
							'moneyS':moneyS,
							'moneyE':moneyE,
							'orderby':orderby,
							'dict':dict
                        },
                        contentType:"application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            $('#DataList').append(data);
                            flag+=10;
                        },
                        error:function(e){
                            console.log('error' ,e)
                        }
                    });		
                }
            });			
        });
        
	</script>
	<style>
		.display{
		display:none;
		}
        body{
        overflow-x: hidden;
        background-color: #EFEFEF;
        }
        body::-webkit-scrollbar {
        }
        .TopButton{
        position: fixed;bottom:2%;
		right:2%; 
		background:#000000;
		color:#FFFFFF; 
		padding:10px; 
		border-radius:5px; 
		font: '微軟正黑體';
        }        
		.blog-post{
			border-bottom:solid 4px black;
			margin:-bottom:20xp;
		}
		.blog-post h1{
			font-size:40px;
		}
		.blog-post p{
			font-size:30px;
		}
		.TopForm{
		position: fixed;
		top:0;
		left:5%;
		right:5%;
		border:solid #000000;
		background: #CCCCCC;
		border-radius:10px;
		width:400px;
		margin-top:10px;
		padding:20px;
		display:none;
		}
		.btnquery{
		position:fixed;
		top:10px;
		left:10px;
		}
    </style>
</head>
<body onLoad="window_onload();">
<button class="btnquery">查詢框</button>
<div class="TopForm" id="TopForm">
<a href="home.php"><div style="background: #00FF66;border-radius:30px; font:'微軟正黑體';" align="center">Home.php</div></a>
	<form method='POST' action="mock_data01.php" name="form1">
    <input type="text" value="<?php echo isset($_POST['qtxt'])?$_POST['qtxt']:"";?>" name="qtxt" id="qtxt" placeholder=" 查詢房屋標題或地址..."></input>
    <br>
    <font>房屋源：</font>
    <select name="WebName">
<option value="<?php echo isset($_POST['WebName'])?$_POST['WebName']:"";?>" selected><?php echo isset($_POST['WebName'])&& $_POST['WebName']!=""?$_POST['WebName']:"請選擇";?></option>
		<option value="">全部</option>
    	<option value="信義房屋">信義房屋</option>
        <option value="永慶房屋">永慶房屋</option>
    </select>
    <div>
    <font>價格範圍：</font>
    <select name="moneyS">
		<option value="<?php echo isset($_POST['moneyS'])?$_POST['moneyS']:"";?>" selected><?php echo isset($_POST['moneyS'])&& $_POST['moneyS']!=""?$_POST['moneyS']:"請選擇";?></option>
        <option value="">不限</option>
    	<option value="10000">10000</option>
        <option value="20000">20000</option>
        <option value="30000">30000</option>
    </select>$~
    <select name="moneyE">
		<option value="<?php echo isset($_POST['moneyE'])?$_POST['moneyE']:"";?>" selected><?php echo isset($_POST['moneyE'])&& $_POST['moneyE']!=""?$_POST['moneyE']:"請選擇";?></option>
        <option value="">不限</option>
        <option value="10000">10000</option>
        <option value="20000">20000</option>
        <option value="30000">30000</option>
    </select>$
    </div>
    <div>
    	<font>排序</font>
        <select name="orderby" >
        <option value="<?php echo isset($_POST['orderby'])?$_POST['orderby']:"house";?>" selected><?php echo isset($_POST['orderby'])?$_POST['orderby']:"house";?></option>
 			<option value="house">house</option>       
        	<option value="money">money</option>
            <option value="date">date</option>
        </select>
        <select name="dict">
        	<option value="<?php echo isset($_POST['dict'])?$_POST['dict']:"ASC";?>" selected><?php echo isset($_POST['dict'])?$_POST['dict']:"ASC";?></option>
        	<option value="ASC">ASC</option>
            <option value="DESC">DESC</option>
        </select>
    </div>
    
    <button type="submit" >送出</button>
    </form>
</div>
<div id="DataList" class="append"></div>


<button  class="TopButton" onClick="TopFunction()">向上</button>
<script>
</script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  
</body>
</html>
