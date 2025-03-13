<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>

        <div class="section-mini section-content section-centered full-height">
          <div class="section-item">
            <div class="container">
              <div class="img404"><img src="<?=base_url('public/images/maintain.png')?>" alt="網站維護中！" class="img-fluid" /></div>
              <h1 class="fs36 font-libre"><strong>網站維護中！</strong></h1>
              <div class="pt-1 pb-1 text-grey fs18">2022/03/01 09:00 開放使用
              <br>
				      敬請期待！！</div>
              <a href="<?=base_url()?>" class="btn btn-primary btn-sm mt40">回首頁 <i class="icon ion-ios-arrow-right"></i></a>
            </div>
          </div>

        </div>


      </div>
      <?=$this->block_service->load_html_footer(); ?>  
</div>
