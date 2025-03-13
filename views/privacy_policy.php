<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
        <div class="section-mini">			

          <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5" role="main">
                  <h1 class="h2-3d font-libre"><strong>安露莎隱私權政策</strong></h1>
                  <div class="news-info mb30">
                    
                  </div>

                   <div class="mb65"><?=$remark?></div>

                  <hr class="mt-0 mb70">

                </div>

                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                 
                 <?=$this->block_service->help_menu('privacy_policy'); ?>
				  
                </aside>
              </div>
            </div>
          </div>

        </div>
      </div>
      
      <?=$this->block_service->load_html_footer(); ?>      
      
</div>