<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>


        <div class="section-mini section-content section-centered full-height">
          <div class="section-item">
            <div class="container">
              <div class="img404"><img src="<?=base_url()?>public/images/404.png" alt="404" class="img-fluid" /></div>
              <h1 class="fs36 font-libre"><strong>我們無法找到您要找的頁面。</strong></h1>
              <div class="pt-1 pb-1 text-grey fs18">錯誤代碼：404<br>
				  <?=FC_Web?>幫您導回首頁喔</div>
              <a href="<?=base_url()?>" class="btn btn-primary btn-sm mt40">回首頁 <i class="icon ion-ios-arrow-right"></i></a>
            </div>
          </div>

        </div>


      </div>
      <?=$this->block_service->load_html_footer(); ?>  
     
    </div>
<script language="javascript" type="text/javascript">
    var second = 0;
    function countTime() {
        second++;
        if (second == 10) {
            location.href = base_url;
        }
        setTimeout("countTime()", 1000)
    }
    countTime();
</script>