<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

      <div class="section-mini">
      <?php if (!empty($beauty_banner)){ ?>
          <div class="section-item text-left">
            <div class="article-carousel-promo a-article-promo-carousel owl-carousel owl-theme nav-inside nav-square nav-white-orange">          
              <?php                   
              foreach ($beauty_banner as $key => $banner){                                        
                       ?>
                       <div class="article-promo-item" alt="<?=$banner['title']?>" style="background-image: url(<?=base_url()?>public/func/<?=$banner['field1']?>);">
                         <div class="container">
                           <div class="row">
                             <div class="col-xl-12 text-center">
                               <!--<div class="article-item-category-dark"><?=$banner['field3']?></div>-->
                               <h2 class="h2-3d font-libre mb-4 text-grey"><strong><a href="<?=$banner['aurl']?>" onclick="tracker('f', '<?php echo $banner['id']; ?>');"  title="<?=$banner['title']?>"><?=$banner['title']?></a></strong></h2>
                               <!--<div class="article-carousel-promo-detail"><?=$banner['descr']?></div>-->
                               <!--<div class="mt70"><a href="<?=$banner['aurl']?>" onclick="tracker('f', '<?php echo $banner['id']; ?>');"  class="btn btn-outline-light"><?=$banner['field2']?><i class="icon ion-ios-arrow-right"></i></a></div>-->
                             </div>
                           </div>
                         </div>
                       </div>
              <?php 
              } ?>              
            </div>
          </div>
      <?php } ?>
      <div class="mt-3 mb-5">
			 <div class="mx-auto text-center"><?=$banner['descr']?><br><span class="text-info">※美麗分享區投稿文，須經公司審核後與本人聯繫是否刊登照片，才會公開您的分享文章。</span></div></div>    
      <div class="section-item text-left">
        <div class="container">
          <div class="row">
            <div class="col-md-8 mb130" role="main">
              <h3>其他美麗分享</h3>
              <p class="mb-5">看看使用安露莎產品美麗的水水們分享些什麼</p>
              <div class="article-list-listing">
				
					<?php	foreach ( $list['rows'] as $item ){
					          $imgsrc = base_url('public/images/default_arsoa.png');
					          if ($item['Files'] > ''){
					              $imgsrc = base_url('public/beauty/'.$item['Files']);
					          }
					   ?>
						<div class="article-item">
						  <div class="row">
							<div class="col-md-3 col-sm-12">
							  <div class="zooming"><img src="<?=$imgsrc?>" alt="" class="img-fluid"
							   onerror="this.src='<?=base_url('public/images/default_arsoa.png')?>';"><br>
								<br>
							  </div>
							</div>
							<div class="col-md-9 col-sm-12">
							  <div class="article-item-title font-libre"><?=htmlspecialchars($item['subject'])?></div>
							  <div class="article-item-info"><?=htmlspecialchars($item['nickname'])?><?php
							  if ($item['skin'] > ''){
							      echo " / ".htmlspecialchars($item['skin']);
							  }
							  ?></div>
							  <div class="article-item-descr text-grey"><?=preg_replace('/<([^<>]*)>/', '&lt;\1&gt;', preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "",$item['content']))?></div>
							</div>
						  </div>
						</div>
					<?php } ?> 
              </div>
        
              <?php
              $this->block_service->PJ_ToUrlPageUrl(base_url('beauty/'),$PageSize,$Page,$PageCount,$RecordCount);
              ?>        
        
              </div>
         
              <div class="col-lg-1 d-none d-xl-block"></div>

                <aside role="complementary" class="aside col-xl-3 col-md-4 mb130">
                  <div class="mb65">
                    <a href="<?php echo base_url('beauty/share'); ?>" class="bnr sponsored">
                      <div class="bnr-photo zooming"><img src="<?=base_url()?>public/images/pic142.jpg" alt="徵求你的美麗分享" /></div>
                      <div class="bnr-content">
                        <div class="inside">
                          <div class="bnr-title-sub text-uppercase">Share your Ex.</div>
                          <div class="bnr-title text-uppercase font-libre">徵求你的美麗分享</div>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="mb60">
                    <h4 class="mb-3"><strong>分享至：</strong></h4>                    
                    <ul class="social social-rounded social-follow">
                      <?php $this->block_service->share(base_url('beauty'),'美麗分享','beauty'); ?>
                    </ul>
                  </div>
                </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
       
      <?=$this->block_service->load_html_footer(); ?>  
</div>