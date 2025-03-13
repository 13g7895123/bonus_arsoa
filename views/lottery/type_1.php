<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?=$lottery_data['lot_title']?> | <?=FC_Web?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?=base_url('public/lottery/1/css/kinerLottery.css')?>">
<style>
.lottery_div {
    max-width:390px;
  }	
@media (min-width: 768px) {
  .lottery_div {
    width:100%
  }
}
</style>
<script>
	var base_url = '<?=base_url()?>';
	var deg = 0;
	var checkcode = '<?=$lottery_data['checkcode']?>';
</script>	
</head>
<body 
	<?php 
	      echo ' style="';
	      if ($lottery_data['lot_config']['background_color'] > ''){
		        echo 'background-color:#'.$lottery_data['lot_config']['background_color'].';';
		    } 
		    if ($lottery_data['lot_bg_img'] > ''){
		       // echo 'background: url(\''.base_url('public/func/'.$lottery_data['lot_bg_img']).'\') center top; height: 100%;';
		    } 
		    echo '"';
	?>
>
<div class="container" style="max-width: 528px;height: 1490px !important;margin: auto;<?php 	   
	      if ($lottery_data['lot_bg_img'] > ''){
		        echo 'background: url(\''.base_url('public/func/'.$lottery_data['lot_bg_img']).'\') center top; height: 100%;';
		    } 
	?>">
  <div class="row">
	      <p style="text-align: center; padding: 20px 20px 0;"><img src="<?=base_url('public/images/logo.png')?>" style="max-width: 150px;"></p>
		    <h2 class="lotto_title" style="margin-bottom: 20px;"><?=$lottery_data['lot_title']?></h2>			
	</div>
	
  <div id="box" class="box">
	   <div class="outer KinerLottery KinerLotteryContent"><img src="<?=base_url('public/func/'.$lottery_data['lot_img'])?>"></div>	
	   <div id="lottery_class" class="inner KinerLotteryBtn start"></div>	
  </div>
  <div id="lottory_msg">
     <div class="msgbox">
	       <div style="margin-top: 14px;"><?=$lottery_data['lot_desc']?></div>
	   </div>	
  </div>
</div>		
<script src="<?=base_url('public/lottery/1/js/zepto.min.js')?>"></script>
<script src="<?=base_url('public/lottery/1/js/kinerLottery.js')?>"></script>
</body>
</html>