<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
    <div class="section-mini">

          <div class="section-item text-left">
           			  
          </div>
        
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 mb130" role="main">
                  <h1 class="h3-3d font-libre"><strong>忘記密碼</strong></h1>
                  
                  <hr class="mt-0 mb40">                  
                  <h5 class="mb45">請輸入您註冊的電子信箱，我們將發送密碼重設信至您的電子信箱，點擊信中網址即可重設密碼。</h5>
                  <?php if ( !empty( $error_message ) ): ?>
						          <div class="log-input">
								          <div class="log-input-center" >
                                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                          </div>
						          </div>
                  <?php endif; ?>
                  <form name="oForm" method="post" language="javascript" action="<?php echo base_url( 'member/forget' ); ?>" class="mb50 wow fadeInUp" data-wow-delay=".3s">
						      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
						        <font color=red>提醒您，請於60分鐘內重設密碼，超過60分鐘請再次申請重設密碼信。</font>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group mb30"><input type="email" class="form-control" name="email" id="email" placeholder="請填入電子信箱" required/></div>
                      </div>
                    </div>
                    <div class="row">
                    
						           <div class="col-md-12"><input type="submit" class="btn btn-dark btn-block" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');"  value="取得新密碼"></div>
					  
					           </div>
                  </form>

                </div>
                
              </div>
            </div>
          </div>

        </div>


      </div>

       
      <?=$this->block_service->load_html_footer(); ?>  
</div>