<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>

         <div class="section-mini">

          <div class="section-item text-left">
            <div class="article-promo">
              <div class="article-promo-item" style="background:url(<?=base_url('public/images/news_bg.jpg')?>) center; min-height: 20.375rem;">
              </div>
            </div>
			  
			  <div class="breadcrumb"><div class="container">
				  <a href="<?=base_url('')?>" title="首頁">首頁</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="<?=base_url('member/main')?>" title="會員專區">會員專區</a>　
				  <i class="icon ion-ios-arrow-right"></i>　<a href="<?=base_url('member/news')?>"><?=$title?></a></div>
				  </div>
			  
          </div>

          <div class="section-item text-left mb130">
            <div class="container">
              <div class="">
                <div class="row justify-content-center">
                  <div class="col-lg-8 col-10" role="main">
                    <h1 class="h2-3d font-libre"><strong><?=$data['title']?></strong></h1>
                    <div class="news-info mb70">
                      <div class="row">
                        
                        <div class="col-sm-6 col-md-3">
                          <div class="news-info-item">
                            <div class="news-info-title">發佈於</div>
                            <div class="news-info-descr"><?=$this->block_service->PF_FD($data['d1'])?></div>
                          </div>
                        </div>                        
                      </div>
                    </div>

                    <div class="article-content article-news mb65" id="news_content">                      
                      <p><?=$data['descr']?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-8 col-10 mb130" role="main">              
                  <?php if (!empty($other_list)){ ?>
                  
                  <h4 class="mb45">相關訊息</h4>
                  <div class="row">
                    <?php foreach ($other_list as $key => $odata){ ?>
                    <div class="col-md-6 grid-item category-product">
                      <div class="article-item mb70">                                                
                        <div class="article-item-title"><a href="<?=base_url('member/info/'.$newstype.'/'.$odata['id'])?>" title="<?=$odata['title']?>"><?=$odata['title']?></a></div>
                        <div class="article-item-date text-grey"><?=$this->block_service->PF_FD($odata['d1'])?></div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <?php } ?>
                  <hr class="mt-0 mb70">
					        <a href="<?=base_url('member/news')?>" class="btn btn-dark">回上頁</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>
<script>
$(document).ready(function () {        
  //修正影片寬高 
  $("p").each(function () {
      var videoSource = $(this).find('iframe').attr('src');
      if (videoSource != "") {
          var _p = $(this).find('iframe').parent('p');
          $(_p).html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="' + videoSource + '" frameborder="0" allowfullscreen></iframe></div>');
      }
  });
});    
</script>