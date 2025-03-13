<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
         
        <div class="section-mini">

          <div class="section-item text-left d-none d-sm-block">
            
          </div>

          <div class="section-item text-left">
            <div class="container">
				
				    <?php $this->block_service->load_reward_cart($mp); ?>				 
				   
              <div class="row">
                <div class="col-md-8 mb130" role="main">
                  <h2 class="font-libre"><strong><?=$prddata['p_name']?></strong></h2>					
					        <h1 class="text-right"><span class="text-danger"><?=number_format($prddata['m_mp'])?></span>點</h1>
					        <hr class="mt-0 mb40">
                  <div class="container">
                    <div class="slide-body">
                      <div class="row">
					            <?php if ($prddata['body'] > ''){ ?>
                    	          <?=$prddata['body']?>
                    	<?php }else{ ?>
                                <p class="lead"><?=$prddata['pro_desc']?></p>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-1 d-none d-xl-block"></div>
                <aside role="complementary" class="aside col-xl-3 col-md-4 mb130">
                    <div class="mb65 text-center">
                      <img src="<?=base_url($this->block_service->prd_img(sprintf("%08d",substr($prddata['p_no'], 1))))?>" alt="<?=$prddata['p_name']?>" class="img-fluid mb20" />
                    </div>
                </aside>
              </div>
			      	<div class="row">
			      		<div class="col-md-12 text-center">
			      		<div class="col-12 text-center my-5">
			      	  	<a class="btn btn-primary mr-4" href="<?=base_url('reward/category')?>"><i class="icon ion-ios-arrow-left"></i>　重新挑選</a>　
			            <a class="btn btn-primary mr-4"
			            <?php
			            if ($this->front_order_model->check_cart($prddata["p_no"])){                                   	           
 	                   $showcard = " href=\"".base_url('order/cart')."\" alt=\"檢視購物車\" >已放入購物車 ";
 	                }else{
 	                	 $showcard = " href=\"javascript:void(0)\" onclick=\"incar('M','".trim($prddata["p_no"])."',1);\" alt=\"我要兌換\" >我要兌換 ";
                  }
                  echo $showcard;
			      	    ?>	 <i class="icon ion-ios-arrow-right"></i></a>
			      	    <input name="num_1" id="num_1" type="hidden" value="1">
			      		</div>
			      		</div>
			      	</div>
            </div>
          </div>
        </div>
      </div>
      <?=$this->block_service->load_html_footer(); ?>            
</div>