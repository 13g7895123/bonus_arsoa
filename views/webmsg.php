<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

       
        <div class="section-mini">

        

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 mb130" role="main">
                  <strong><h1 class="h3-3d font-libre">網站訊息</h1></strong>
                  
                  <hr class="mt-0 mb40">

                  <h5 class="mb25"><?=str_replace("\\n", "<br>",$msg)?></h5>
                  <br>
                  <h5 class="mb25"><a href="<?php echo site_url(); ?>">回首頁</a></h5>
                </div>
                
              </div>
            </div>
          </div>

        </div>


      </div>
       
      <?=$this->block_service->load_html_footer(); ?>  
</div>