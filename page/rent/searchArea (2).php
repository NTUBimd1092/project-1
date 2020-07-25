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
      <script type="text/javascript">
        function window_onload(){
            setTimeout(function(){
                $(window).scrollTop("0");
            },200);	
        }
        var WebName="";

        $(document).ready(function(){
            var flag=0;
            $.ajax({
                type:"POST",
                url:"get_data.php",
                data:{
                    'offset':0,
                    'limit':10,
                    'WebName':WebName
                },
                contentType:"application/x-www-form-urlencoded; charset=utf-8",
                success:function(data){
                    $('#DataList').append(data);
                    flag +=10;
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
                            'WebName':WebName
                        },
                        success:function(data){
                            $('#DataList').append(data);
                            flag+=10;
                        }
                    });		
                }
            });
			
        });

        function TopFunction() {
          $(window).scrollTop("0");
        }       
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
		.TopFrom{
		position:relative;
		top:0;
		left:25%;
		right:25%;
		background:#999999;
		border-radius:10px;
		height:100px;
		width:400px;
		margin-top:10px;
		padding:20px;
		}
    </style>
</head>
<body onLoad="window_onload();">
<div class="TopFrom">

	<form method='POST'>
	<button  id='WebName' name='WebName' type="submit" value="永慶房屋">永慶房屋</button>
	<button class="btnb">條件2</button>
	<button>條件3</button>
	<button>條件4</button>
	<button>排序一</button>
	<button>排序二</button>
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
