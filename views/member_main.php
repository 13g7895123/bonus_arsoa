<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini pt-0">
          <div class="section-item text-left d-none d-sm-block"></div>
           <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-12" role="main">
                  <h1 class="h2-3d font-libre"><strong>會員專區</strong></h1>
					<hr class="mt-0 mb-3">
					</div>
				</div>
			  </div>
			  
			  <div class="container">
				  <div class="row">
                <div class="col-md-8" role="main">
                  <div class="mb65"> 
                    <div class="container mt100">
                <div class="slide-body">
                  
                  
					
					<form name="admin_Form" id="admin_Form" method="post" language="javascript">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
					<!--年度進貨資枓查詢 start-->
				  <div class="mb65" id="admin_report" style="display: none;">
                    <h4>年度進貨資枓查詢</h4>
                    
                      <h5>進貨年度</h5>
                      <div class="form-row">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y10'); ?>
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('年度進貨資枓查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--年度進貨資枓查詢 end-->
					</form>
					<div class="row no-gutters partner-bordered justify-content-center" id="admin_main">
					<?php
					if ($this->session->userdata('member_session')['line_user_id'] > '') {       
              ?>
              <div class="alert alert-success" role="alert" style="font-size: 1.25rem;width:100%;">
                   親愛的 <?=$this->session->userdata('member_session')['c_name']?> 您好：<br>會員帳號 <?=$this->session->userdata('member_session')['c_no']?> 已成功綁定 安露莎官方Line！
                   <?php                   
                   if ($this->session->userdata('member_session')['line_follow'] == 'disable') {       
                       echo '<br>';
                       echo '<font color=red>請到 <a href="https://line.me/ti/p/'.$this->config->item('line_bot_basic_id').'" target="_blank"><u>安露莎官方Line</u></a> 加入好友，或解除封鎖，才可接收專屬於您的優惠通知訊息 。</font>';
                   }
                   ?>
              </div>              
              <?php
          }else{
          	//  if ($this->session->userdata('member_session')['c_no'] == '000000' || $this->session->userdata('member_session')['d_posn'] == 55){
          	  	  $line_url = 'https://liff.line.me/'.$this->config->item('line_liff_url').'/m_'.$this->session->userdata('member_session')['bind_code'];      
          	  	  $itarget = '';
          	  	  if ($platform == 'MOBILE'){
          	  	  	  $itarget = ' target="_blank" ';
          	  	  }
          	  ?>
          	  <div class="alert alert-success" role="alert">
		     				<div class="row" style="margin-right: 0px; margin-left: 0px;">
		     				   <div class="col-md-8">
                         <h4 class="alert-heading">親愛的 <?=$this->session->userdata('member_session')['c_name']?> 您好：</h4>
                         <h5>您尚未綁定 安露莎官方Line 帳號！</h5>
                    <hr>						
		     						<h5 class="mb-2 text-danger">提醒您：請立即綁定將可以收到專屬於您的優惠通知訊息。</h5>		     						
		     					</div>
		     					<div class="col-md-4 text-center">
		     						<h5><a href="<?=$line_url?>" <?=$itarget?>><u>立即點選綁定</u></a></h5>
		     						<a href="<?=$line_url?>" <?=$itarget?>><img src="<?=base_url('reg?c='.$line_url)?>" class="img-fluid" width="180"></a>
		     						<br>
		     						掃描 QrCode 立即綁定
		     					</div>
		     				</div>
               </div>
          	  <?php
          	//  }
          }
					?>
					<div class="col-3 partner-item" style="max-width: 50%; flex: 0 0 50%;">
						<span class="inside">
							<a href="javascript:void(0);" onclick="go_class();" style="color: #e4024b;"><i class="fas fa-cart-arrow-down fa-4x mb-3"></i></a><br><h4 class="my-2">訂購商品</h4>
						</span>
					  </div>
					<div class="col-3 partner-item" style="max-width: 50%; flex: 0 0 50%;">
						<span class="inside">
							<a href="<?php echo base_url( 'reward' ); ?>" style="color: #e4024b;"><i class="fas fa-gifts fa-4x mb-3"></i></a><br><h4 class="my-2">紅利兌換專區</h4>
						</span>
					  </div>
                    <div class="col-3 partner-item" style="max-width: 50%; flex: 0 0 50%;">
						<span class="inside">
							<a href="<?php echo base_url( 'sale' ); ?>" style="color: #e4024b;"><i class="fas fa-piggy-bank fa-4x mb-3"></i></a><br><h4 class="my-2">當月販促活動</h4>
						</span>
					  </div>
					  <div class="col-3 partner-item" style="max-width: 50%; flex: 0 0 50%;">
						<span class="inside">
							<a href="<?php echo base_url( 'member/news' ); ?>" style="color: #e4024b;"><i class="far fa-newspaper fa-4x mb-3"></i></a><br><h4 class="my-2">最新情報</h4>
						</span>
					  </div>
                  </div>
                </div>
              </div>
                    
                  </div>
                  
                </div>

                <div class="col-lg-1 d-none d-xl-block"></div>

                <aside role="complementary" class="aside col-xl-3 col-md-3">
					
				  <div class="mt100 mb75">
                 <?=$this->block_service->member_right_menu('N'); ?>   
					</div>
                </aside>
              </div>
<div class="section pp-scrollable" id="products">
		<div class="slide-bg">
			<div class="inside"></div>
		</div>
		<div class="container" id="main_class">
			<div class="slide-body">
				<?=$this->block_service->class_main(); ?>   
			</div>
		</div>
</div>
			  </div>                
          </div>
        </div>
      </div>
      <?=$this->block_service->load_html_footer(); ?>  
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="newsmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: 0px solid #ffffff;">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="newsmodal_body" id="newsmodal_body" style="margin-top:-36px;">
      </div>    
      <div class="modal-footer" style="border-top: 0px solid #ffffff;margin-top:-30px;">  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>

<script>
function  go_class(){   
   $('html,body').animate({scrollTop:$('#main_class').offset().top}, 1000);
}

function show_report(report_title)
{   
    
    chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');   
    
        var params=$('#admin_Form').serialize();     
        console.log(params);        
        //$( "#newsmodal_title" ).html(report_title);        
        $("#newsmodal").modal('show');    
        $( "#newsmodal_body" ).html('<p><center style="font-size:20px"><img src="'+base_url+'public/images/loading.gif"> 資料讀取中，請稍後。</center></p>');
        
        $.ajax({
             url: base_url+"report",                
             type: "POST",
             dataType: "json",
             data:params,
             success: function(data){                       
                  $( "#newsmodal_body" ).html(data.bodyhtml);           
             }
        });       
}


function report_A(){
  
 // $( "#admin_main").hide();
  
  $( "#admin_report" ).show();     
  
  if (platform == "DESKTOP"){ 
      $('html,body').animate({scrollTop:$('#admin_Form').offset().top}, 1000);
  }
}
</script>
