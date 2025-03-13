<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
       <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>

         <div class="section-mini">

          <div class="section-item text-left">
         
          </div>

          <div class="section-item text-left mb130 mt-1">
            <div class="container">
				
              <div class="">
                <div class="row justify-content-center">
                  <div class="col-lg-10 col-10" role="main">
                    
					          <div class="article-author mb65 border-top-0">
                      <div class="row">                          
					             <?=$this->block_service->prdlist(1,$prddata); ?>
					            </div>
					          </div>  
                    <div class="article-content article-news mb65">
                    	<?php if ($prddata['body'] > ''){ ?>
                    	          <?=$prddata['body']?>
                    	<?php }else{ ?>
                                <p class="lead"><?=$prddata['pro_desc']?></p>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-10 col-10 mb130" role="main">                  
                  <div class="row mb30">
                    <div class="col-sm-6 mb30">
                    <?php if (1==2){ ?>                    
                      <ul class="tags nav">
                        <li><a href="#" class="btn btn-outline-secondary btn-xs">最新消息</a></li>
                        <li class="active"><a href="#" class="btn btn-outline-secondary btn-xs">媒體報導</a></li>
                        <li><a href="#" class="btn btn-outline-secondary btn-xs">肌膚保養</a></li>
                      </ul>                    
                    <?php } ?>
                    </div>
                    <div class="col-sm-6 mb30 text-right-sm">
                      <ul class="social social-rounded social-follow">
                        <li class="social-title">分享至：</li>
                        <?php $this->block_service->share(base_url('product/'.$prddata['p_no']),$prddata['p_name'],$prddata['p_no']); ?>
                      </ul>
                    </div>
                  </div>
                  <?php if ($prddata['body'] > ''){ ?>
                  
                     <?=$this->block_service->prdlist(2,$prddata,'E'); ?>
                  
                  <?php } ?> 
                  <?php if (1==2 && !empty($other_prddata)){ ?>
                           <h4 class="mb45">同類商品</h4>
                           <div class="row">
                           <?php
                           foreach ($other_prddata as $item){
                           ?>
                             <div class="col-md-4 grid-item category-product">
                               <div class="article-item mb70">
                                 <div align=center class="wow fadeInDown" data-wow-delay=".2s" data-wow-offset="150"><a href="<?=base_url('product/'.$item['p_no'])?>" title="<?=$item['p_name']?>"><img src="<?=base_url()?><?=$this->block_service->prd_img($item['p_no'])?>" width=250 alt="<?=$item['p_name']?>" class="img-fluid" /></a></div>                        
                                 <h6 align=center><a href="<?=base_url('product/'.$item['p_no'])?>" class="text-dark" title="<?=$item['p_name']?>"><?=$item['p_name']?></a></h6>
                               </div>
                             </div> 
                           <?php     }  ?>
                           </div>
                <?php     }  ?>
                  <hr class="mt-0 mb70">
					        <a href="<?=$category_url?>" class="btn btn-dark">回上頁</a>
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