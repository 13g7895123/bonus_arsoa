<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
        
         <div class="section-mini">
           <div class="section-item text-left">
             <div class="container">              
               <div class="row">
               	
                  <div class="col-lg-6 mb130" role="main">
                
                  <h1 class="h3-3d font-libre"><strong>會員登入</strong></h1>
                  <hr class="mt-0 mb40">
                  <?php if ($canshow == 'Y'){ ?>
                      <div class="log-input">
								          <div class="log-input-center" >
                                <div class="alert alert-danger" role="alert" style="font-size: 1.25rem;"><?=$err_msg?></div>
                          </div>
						          </div>
                  <?php }else{ ?>
                              <h5 class="mb45">請輸入您的會員編號以及密碼登入</h5>                  
                              <?php if ( !empty( $error_message ) ): ?>
						                      <div class="log-input">
								                      <div class="log-input-center" >
                                            <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                                      </div>
						                      </div>
                              <?php endif; ?>
                              <form name="oForm" method="post" action="<?=$action?>" class="mb40 wow fadeInUp" data-wow-delay=".3s">
					    	                 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">						     
					    	                 <input type="hidden" name="rdurl"" id="rdurl" value="<?=$rdurl?>">						     
                                 <div class="row">
                                     <div class="col-sm-12">
                                       <div class="form-group mb30"><input type="text" name="account" id="account" maxlength="20" class="form-control" required placeholder="帳　號（會員編號）" /></div>
                                     </div>
                                     <div class="col-sm-12">
                                       <div class="form-group mb30"><input type="password" name="password" id="password" maxlength="20" class="form-control" required placeholder="密　碼" /></div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-5"><a href="<?php echo base_url( 'member/forget' ); ?>" class="btn btn-secondary btn-block mb30">忘記密碼</a></div>
						                         <div class="col-md-7"><input type="submit" onclick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');" name="loginchk" class="btn btn-primary btn-block mb30" value="登入"></div>
					                       </div>
					                     </form>
					                     <?php 
					                           //if (!empty($this->session->userdata('line_login')) && $this->session->userdata('line_login') == 'Y'){ 
					                           ?>
                                         <hr class="mt-0 mb40">                                         
                                         <h5 class="mb45">當您的會員帳號已成功綁定 <a href="https://line.me/ti/p/<?=$this->config->item('line_bot_basic_id')?>" target="_blank">官方Line</a> 可使用 Line 登入</h5>             
                                         <div class="row">
                                               <div class="col-sm-12">
                                               	   <div class="btn-line-wrap center"><a class="size-" href="<?=base_url('line/login')?>"><img src="<?=base_url('public/images/icon-line.svg')?>" /> 使用 LINE 登入</a></div>
                                             	 </div>
						                             </div>            
						                   <?php //} 
						                    ?>
                   <?php } ?>                
                </div>
                
                <div class="col-lg-1 d-none d-xl-block"></div>				  
				            <div class="col-lg-5 mb130" role="main">
                        <h1 class="h3-3d font-libre"><strong>新會員登錄</strong></h1>                  
                        <hr class="mt-0 mb40">
                        <h5 class="mb45">歡迎加入安露莎，即可享受方便快速的購物流程，瀏覽過往訂單記錄，並不定時獨享會員優惠。</h5>
                        <div class="row">                    
					                 <div class="col-md-7"><a href="<?=base_url( 'member_join')?>" class="btn btn-dark btn-block">新會員登錄</a>
					              </div>
					          </div>                  
                </div>   
                                             
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>
