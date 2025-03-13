<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

         <div class="section-mini">

          <div class="section-item text-left"></div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-10 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong><?=$brand_title?></strong></h1>
                  <div class="news-info mb30">
                    
                  </div>

                  <div class="article-content article-news mb65">
                    <!--<p class="mb-0">請注意：本區非折扣區 </p>-->
					  <div class="article-author mb65 border-top-0">
					    <table class="table table-striped table-hover text-center">
						       <thead>
                            <tr>
                              <th class="text-left">產品名稱</th>
                              <th>BP</th>
                              <th>建議售價</th>
                              <th>訂購</th>
                            </tr>
							    </thead>
                         <tbody>
                      <?php 
                          $prdnum = 0;
                          foreach ($list_data as $key => $item)
                          {
                                   $prdnum++;
                                   $shownum = 'N';                                   
                                   $showcard = "";
                                   
                                   if ($item["is_nogoods"] == 1){ // 缺貨中                           	   
                                   	   $showcard = "<a href=\"javascript:void(0\" alt=\"缺貨中\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-alert\"></i>　缺貨中</a>";
                                   }else{
                                   	  if ($item["is_visual"] == 0){
                                   	     if ($item["is_shop"] == 1){
                                   	        if ($this->front_order_model->check_cart($item["p_no"])){                                   	           
                                   	           $showcard = "<a href=\"".base_url('order/cart')."\" alt=\"檢視購物車\" class=\"btn btn-outline-info btn-sm\"><i class=\"icon ion-ios-cart\"></i>　已購 (".$this->session->userdata('prd_session')[trim($item["p_no"])].")</a>";
                                   	        }else{
                                   	           $shownum = 'Y';
                                   	        	  $showcard = "<a href=\"javascript:void(0)\" onclick=\"incar('P','".trim($item["p_no"])."',".$prdnum.");\" alt=\"加入購物車\" class=\"btn btn-outline-info btn-sm\"><i class=\"icon ion-ios-cart-outline\"></i>　購買</a>";
                                            }
                                         }
                                      }
                                   }                                   
                                   ?>                                   
                                   <tr>
                                     <td class="text-left"><?=$item['p_name']?></td>
                                     <td><?=number_format($item['pv'])?></td>
                                     <td><?=number_format($item['c_price'])?> 元</td>
                                     <td><?=$showcard?>
                                       <input name="num_<?=$prdnum?>" id="num_<?=$prdnum?>" type="hidden" class="input-num" title="數量" value="1" maxlength="2"></td>
                                   </tr>
                     <?php } ?>     
                          </tbody>
                        </table>
					     </div>                    
                  </div>
              <!--
                  <div class="row mb30">
                    <div class="col-sm-6 mb30">                  
                    </div>
                    <div class="col-sm-6 mb30 text-right-sm">
                      <ul class="social social-rounded social-follow">
                        <li class="social-title">分享至：</li>
                        <?php $this->block_service->share(base_url('category/'.$prdtype),$brand_title,$prdtype); ?>
                      </ul>
                    </div>
                  </div>
                  -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>
