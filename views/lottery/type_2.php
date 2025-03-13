<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?=$lottery_data['lot_title']?> | <?=FC_Web?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Cache-Control" content="no-transform">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="layoutmode" content="standard">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="renderer" content="webkit">
		<meta name="wap-font-scale" content="no">
		<meta content="telephone=no" name="format-detection">
		<meta http-equiv="Pragma" content="no-cache">

		<script type="text/javascript">
			var _htmlFontSize = (function() {
				var clientWidth = document.documentElement ? document.documentElement.clientWidth : document.body.clientWidth;
				if(clientWidth > 640) clientWidth = 640;
				document.documentElement.style.fontSize = clientWidth * 1 / 16 + "px";
				return clientWidth * 1 / 16;
			})();
			var base_url = '<?=base_url()?>';
			var checkcode = '<?=$lottery_data['checkcode']?>';
			
		</script>
		<link rel="stylesheet" type="text/css" href="<?=base_url('public/lottery/2/css/base.min.css')?>"/>

	</head>

	<body class="main_box" style="<?php 	   	      
	      if ($lottery_data['lot_config']['background_color'] > ''){
		        echo 'background-color:#'.$lottery_data['lot_config']['background_color'].';';
		    } 
	      if ($lottery_data['lot_bg_img'] > ''){
		        echo 'background: url(\''.base_url('public/func/'.$lottery_data['lot_bg_img']).'\') center top;';
		    } 
	  ?>">
		<div class="row">
	      <p style="text-align: center; padding: 20px 20px 0;"><img src="<?=base_url('public/images/logo.png')?>" style="max-width: 150px;"></p>
		    <h2 class="lotto_title" style="margin-bottom: 20px;"><?=$lottery_data['lot_title']?></h2>			
	  </div>
	
		<div class="box">
			<div class="bg_in">
				<div class="title">•&nbsp;刮獎區&nbsp;•</div>
			</div>
			<div class="content">
				<div id="mask_img_bg"></div>
				<img id="redux" src="<?=base_url('public/func/'.$lottery_data['lot_img'])?>" />				
			</div>
			<div class="box_text">
				<?=$lottery_data['lot_desc']?>
			</div>
		</div>
		<div class="show" id="show">
			
		</div>
		
		<div class="mask"></div>
		
		<input type="hidden" name="send" id="send" value="N">
		
<script type="text/javascript" src="<?=base_url('public/lottery/2/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/lottery/2/js/jquery.eraser.js')?>" ></script>
<script type="text/javascript">			
			$(window).load(function  () { 
				$('#redux').eraser( {
					  size: 30,  
				    completeRatio: .6,
				    completeFunction: showResetButton 
				});
				function showResetButton(){
					$(".main_box .show,.main_box .mask").fadeIn(300);
				}
				$(".main_box .mask,.main_box .show .close,.main_box .show .btn").click(function  () {
					$(".main_box .show,.main_box .mask").fadeOut(300)
				})
			})
			
			
function whichAward(){		     		   
		   if ($("#send").val() == 'N'){
		   	   $("#send").val('Y');
		       $.ajax({
               type: "POST",
               url: base_url+'lottery/award/'+checkcode,
               dataType: 'json',               
               success: function(data){               	   
               	   $("#mask_img_bg").html('<img class="show_food" src="'+data.image+'">');
               	   $("#show").html(data.showhtml);               	   
               }
           });				       
		   }
		   /*
		    $.ajax({
               type: "POST",
               url: base_url+'lottery/whichaward/'+checkcode,
               data: {
	    		        	  "dtype": dtype,
	    		        	  "deg": kdeg
	    		           },
               dataType: 'json',               
               success: function(data){
               	   if (dtype == 'A'){      	       
               	       $("#lottory_msg").html(data.msg);
               	       $("#lottery_class").attr('class', 'inner KinerLotteryBtn no-start');
               	   }else{               	   	   
                       deg = data.deg;                    
                   }
               }
          });		
        */  
}

		</script>
		
	</body>

</html>