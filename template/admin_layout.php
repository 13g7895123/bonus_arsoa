<?php
$admin_type = 'W';
if (isset($this->admin_session['admin_status'])){
   $admin_type = $this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/角色/KIND/傳回值","類型",$this->admin_session['admin_status']);  
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=FC_Web?> - 後端管理系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME="rating" CONTENT="General">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="private">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<?php    
$css_file = array('var'  => $this->config->item('ver_css'),
                  'file' => array_merge($this->config->item('admin_autoload_css'), $css = (isset($css)) ? $css : array()));

$css_name = urlencode(base64_encode(json_encode($css_file)));
?>
<link href="<?= base_url() . 'mini/admin_css/' . $css_name ?>.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery-latest.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="<?= base_url('public/css/colorbox.min.css')?>" rel="stylesheet" media="screen">
<script src="<?=base_url('public/admin/js/')?>wow.min.js"></script>
<script src="<?=base_url('public/admin/js/')?>classie.js"></script>
<!-- Meters graphs -->
<SCRIPT language=JavaScript>
var base_url = "<?=base_url()?>";
window.focus();
new WOW().init();
</SCRIPT>
<base target="_self">
</head>
<?php if ($web_page == 'login'){ ?>
<body class="sign-in-up">
<?php }else{ ?>          
  <body class="sticky-header" left-side-collapsed>
    <section>
    <!-- left side start-->
		<div class="left-side sticky-left-side">

			<!--logo and iconic logo start-->
			<div class="logo">
				<h1><a href="<?=base_url('wadmin/main')?>" title="後端管理系統"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/角色/KIND/傳回值","資料",$this->admin_session['admin_status'])?>後台</a></h1>
			</div>
			<div class="logo-icon text-center">
				<a href="<?=base_url('wadmin/main')?>" title="後端管理系統"><i class="lnr lnr-home"></i> </a>
			</div>

			<!--logo and iconic logo end-->
			<div class="left-side-inner">

			  <!--sidebar nav start-->
			  <?php
			  echo $this->block_service->admin_left($admin_type);			
			  ?>
				<!--sidebar nav end-->
				
			</div>
		</div>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<div class="header-section">
			 
			<!--toggle button start-->
			<a class="toggle-btn menu-collapsed"><i class="fa fa-bars"></i></a>
			<!--toggle button end-->
      
      
			<!--notification menu start -->
			<div class="menu-right">
				<div class="user-panel-top">  	
					<div class="profile_details_left">					    
							<div class="login_box" id="loginContainer" style="float:left;">
									<div class="search-box">
										<div id="sb-search" class="sb-search">
											<?php if ($admin_type == 'L'){ ?>
												        <form name="oFormsearch" method="post" language="javascript" action="<?php echo base_url( 'wadmin/member_line/list/U900' ); ?>" >
												        <input class="sb-search-input" placeholder="會員搜尋..." type="search" name="Search" id="Search">
											<?php }else{ ?>
												        <form name="oFormsearch" method="post" language="javascript" action="<?php echo base_url( 'wadmin/product/list/2000' ); ?>" >
												        <input class="sb-search-input" placeholder="產品搜尋..." type="search" name="Search" id="Search">
											<?php } ?>								
												<input class="sb-search-submit" type="submit" value="">
												<span class="sb-icon-search"> </span>
											</form>
										</div>
									</div>
										<!-- search-scripts -->
										<script src="<?=base_url('public/admin/js/')?>classie.js"></script>
										<script src="<?=base_url('public/admin/js/')?>uisearch.js"></script>
											<script>
												new UISearch( document.getElementById( 'sb-search' ) );
											</script>
										<!-- //search-scripts -->
							</div>
							<div class="clearfix"> </div>						   
					</div>
					<div class="profile_details">		
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<div class="profile_img" style="width:280px">	
										 <span style="background:url(<?=base_url('public/admin/images/1.jpg')?>) no-repeat center"> </span> 
										 <div class="user-name" style="float:left;">
											<p><?=$this->admin_session['admin_name']?><br>
											<?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/角色/KIND/傳回值","資料",$this->admin_session['admin_status'])?></p>
										 </div>
										 <div style="float:left;margin-left: -35px;">
										 <i class="lnr lnr-chevron-down"></i>
									    <i class="lnr lnr-chevron-up"></i></div>
										<div class="clearfix"></div>	
									</div>	
								</a>
								<ul class="dropdown-menu drp-mnu">
									<li> <a href="<?=base_url('wadmin/func/admin_modify')?>"><i class="fa fa-user"></i> 個人資料修改</a> </li> 									
									<li> <a href="<?=base_url('wadmin/logout')?>"><i class="fa fa-sign-out"></i> 離開管理平台</a> </li>
								</ul>
							</li>
							<div class="clearfix"> </div>
						</ul>
					</div>		
					<div class="social_icons">		
					  <div style="float:right;">
					       <?php if (1==2){ ?>
					       <div style="float:left;">		 						
						          <div class="col-md-3 social_icons-left">
                        <span class="label btn_6 label-default">
						          	線上人數：1</span>
						          </div>					
					       </div>	
					       <?php } ?>
					       <div style="float:left;">		 						
						       <div class="col-md-3 social_icons-left twi">
						          <span class="label btn_6 label-primary">
						          IP: <?=$this->data['tracking']['ip']?></span>
						       </div>						
						     </div>						
						     <div style="float:left;">		 						
						        <div class="col-md-4 social_icons-left twi" style="width:130px">
						          <span class="label btn_8 label-success">
						        	  <SCRIPT src="<?=base_url('public/admin/js/')?>liveclock.js" type=text/javascript></SCRIPT>
						        	  <SCRIPT type=text/javascript>show_clock();</SCRIPT>      
						        	</span>
                    </div>      
                 </div>						
                 <div style="float:left;">
                    <a href="<?=$this->config->item('web_url')?>" target="_blank" title="<?=FC_Web?> 網站首頁"><span class="glyphicon glyphicon-th-large" aria-hidden=true></span></a>
                 </div>
					  </div>        
					</div>       	
					<div class="clearfix"></div>
				</div>
			  </div>
			
			</div>
    <style>
        canvas{
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>    
<?php } ?>          
<?=$content_for_layout;?>
<footer>
   <p>&copy <?=date('Y')?> <?=$this->config->item('FC_Company')?>. All Rights Reserved </p>
</footer>
</section>
<?php

$js_file = array('var'  => $this->config->item('ver_js'),
                 'file' => array_merge($this->config->item('admin_autoload_js'), $js = (isset($js)) ? $js : array()));                      
$js_name = urlencode(base64_encode(json_encode($js_file)));
    
?>
<script src="<?= base_url() . 'mini/admin_js/' . $js_name ?>.js" async="true"></script>
<?php    
_timer('*** HTML END ***');

$client_ip = $this->block_service->client_ip();

if (preg_match("/^192\.168\./",$client_ip) || $client_ip == '::1' || in_array($client_ip, config_item('company_ip'))) {   // 不是內部 IP 直接預覽     
    load_website($this->data['platform']);
    
    echo '<script>';
    echo 'console.group("System Info");console.log("執行時間：'.$this->benchmark->elapsed_time().'\n記憶體消耗量：'.$this->benchmark->memory_usage().'");console.groupEnd();';
    echo 'console.group("Timer Result");console.log("分段時間：'.str_replace("\n", '\n', _timer_text()).'");console.groupEnd();';
    echo '</script>';
    echo '<script>console.log("css：'.implode(',', $css_file['file']).'");</script>';
    echo '<script>console.log("js：'.implode(',', $js_file['file']).'");</script>';
}

?>
</body>
</html>