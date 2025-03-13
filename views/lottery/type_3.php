<?php
//echo "<pre>".print_r($lottery_data,true)."</pre>";
//exit;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=$lottery_data['lot_title']?> | <?=FC_Web?></title>
	<link rel="stylesheet" href="<?=base_url('public/lottery/3/css/public.css')?>?23">
	<script type="text/javascript" src="<?=base_url('public/lottery/2/js/jquery.min.js')?>"></script>
	<script src="<?=base_url('public/lottery/3/js/easing.min.js')?>"></script>
	<script src="<?=base_url('public/lottery/3/js/mejs.js')?>"></script>
	<style>
		.machine{width: 8.77333rem;height: 11.52rem;background: url("<?=base_url('public/lottery/3/img/machine_bg.png')?>");background-size: cover;position: absolute;top: 55%;left: 50%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);}
		.rotate_box dd{width: 32%; height: 3.46667rem;margin-right: 2%;float: left;background: url("<?=base_url('public/func/'.$lottery_data['lot_img'])?>");background-size: cover;}		
		@media (max-width: 768px) {
  #machine{
      top: 50%;
  }
}
	</style>	
	<script>
		var base_url = '<?=base_url()?>';
			var checkcode = '<?=$lottery_data['checkcode']?>';
	</script>		
</head>
<body class="main_box" style="<?php 	   	      
	      if ($lottery_data['lot_config']['background_color'] > ''){
		        echo 'background-color:#'.$lottery_data['lot_config']['background_color'].';';
		    } 
	      if ($lottery_data['lot_bg_img'] > ''){
		        echo "background: url('".base_url('public/func/'.$lottery_data['lot_bg_img'])."') center top;";
		    } 
	  ?>">
	<section>
		<div class="row" align=center>
			<p style="padding: 20px;" align=center>
				<img src="<?=base_url('public/images/logo.png')?>" style="max-width: 150px;">
			</p>
			<h2 class="lotto_title" style="margin-bottom: 20px;"><?=$lottery_data['lot_title']?></h2>			
		</div>

		<div class="machine">
			<dl class="rotate_box clear">
				<dd></dd>
				<dd></dd>
				<dd></dd>
			</dl>
			<div id="pr">
			    <a class="poiner" href="">
			    	<img src="<?=base_url('public/lottery/3/img/poiner.png')?>" alt="">
			    </a>
			    <a class="rotate_btn" href="javascript: void(0);">
			    	<img src="<?=base_url('public/lottery/3/img/rocker.png')?>" alt="">
			    </a>
			</div>    
			<div id="msg" align=center><?=$lottery_data['lot_desc']?></div>

		</div>
	</section>
	<div class="mask">
		<img src="<?=base_url('public/lottery/3/img/alert_img.png')?>" alt="">
	</div>

</body>
</html>
<script>
	
	$(function () {
 
    var the_hei = parseInt($('.rotate_btn').css('height'));
    var rotateDd = $('.rotate_box dd');
    var ddHei = rotateDd.height();
    var prizeList_num = <?=($lottery_data['lot_num']-1)?>;
    rotateDd.css('backgroundSize', '100% ' + prizeList_num * ddHei + 'px');

    $('.rotate_btn').click(function () {
        var _this = $(this); 
        $( "#pr" ).remove();
        if (!_this.hasClass('act')) {
            !_this.addClass('act');
            methods.star_animate.call(this);
            
            $.ajax({
               type: "POST",
               url: base_url+'lottery/award/'+checkcode,
               dataType: 'json',               
               success: function(data){               	   
               	         if (data.status == 'Y') {   
                               $('.rotate_box dd').rotate([data.award,data.award,data.award], function () {
                               	  $('#msg').html(data.showhtml);
                               }) 
                         }else{ 
                              $('.rotate_box dd').rotate(methods.getRandom(11), function () {
            									    $('#msg').html(data.showhtml);
            									    $('.mask').show().click(function () {
            									        $(this).hide();
            									    })
            									})
                         }
               }
            });
        }
    })

    $.fn.extend({
        rotate: function (num, callback) {
            var zjNum = num;
            $(this).each(function (index) {
                var f = $(this);
                setTimeout(function () {
                    f.animate(
                        {backgroundPositionY: -(ddHei * prizeList_num * 5 + zjNum[index] * ddHei)},
                        {
                            duration: 3000 + index * 500,
                            easing: 'easeInOutCirc',
                            complete: function () {
                                if (index === 2) {
                                    $('.rotate_btn').removeClass('act');
                                    if (callback) {
                                        setTimeout(function () {
                                            callback();
                                        }, 1)
                                    }
                                }
                                f.css('backgroundPositionY', -(zjNum[index] * ddHei))
                            }
                        }
                    )
                }, index * 1)
            })
        }
    })

    var methods = {
        star_animate: function () {
            var _this = $(this);

            _this.animate({
                height: the_hei / 2
            }, 100, 'linear');

            _this.animate({
                height: the_hei
            }, 1000, 'easeOutBounce');

        },
        getRandom: function (num) {
            var arr = [],
                _num = 3;
            do {
                var val = Math.floor(Math.random() * num);
                if (arr.indexOf(val) < 0) {
                    arr.push(val);
                    _num--
                }
            }
            while (_num > 0);
            return arr
        },
        getDataIndex: function (val) {
            var prizeMsg = val,
                _index,
                arr = [];
            for (var i = 0; i < prizeList_num; i++) {
                $.each(prizeList[i], function () {
                    if (prizeList[i]['prizeid'] === prizeMsg['prizeid']) {
                        _index = i;
                    }
                })
            }
            for (var y = 0; y < 3; y++) {
                arr.push(_index);
            }
            return arr;
        }
    }

})
</script>