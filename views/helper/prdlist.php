<?php
$shownum = 'N';                                   
$showcard = "";
$sUrl = "";
$chk_color = false;
  
//if ($this->session->userdata('use_cart') == 'Y'){
    if ($item["is_nogoods"] == 1){ // 缺貨中                           	   
    	  $showcard = "<a href=\"".base_url('order/cart')."\" alt=\"缺貨中\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-alert\"></i> 缺貨中</a>";
    }else{
     	  if ($item["is_visual"] == 0){
     	     if ($item["is_shop"] == 1){
     	        if ($this->front_order_model->check_cart($item["p_no"])){                                   	           
     	           $showcard = "<a href=\"".base_url('order/cart')."\" alt=\"檢視購物車\" class=\"btn btn-outline-info btn-sm\"><i class=\"icon ion-ios-cart\"></i> 檢視購物車 (".$this->front_order_model->check_cart_prd_num($item["p_no"]).")</a>";
     	           $shownum = 'Y';
     	        }else{
     	           $shownum = 'Y';
     	        	  $showcard = "<a href=\"javascript:void(0)\" onclick=\"incar('P','".trim($item["p_no"])."',".$prdnum.");\" alt=\"加入購物車\" class=\"btn btn-outline-info btn-sm\"><i class=\"icon ion-ios-cart-outline\"></i> 放入購物車</a>";
              }
           }
        }
    }    
//}    

if ($item["is_view"] == 1){   //為真才可以點明細頁
    if ($item["is_visual"] == 1){ //為真到組合色盤
        $chk_color = true;
    }else{
        $sUrl = base_url('product/'.$item['p_no']);
    }
}

$prdinfo = '';
if ($item['w_unit'] > ''){
    $prdinfo = "內容量：".$item['w_unit'];
}
if ($item["is_visual"] == 0){ // 色盤組合圖 不出現售價 BP 
    if (FC_bpshow == "Y"){                                                     
        if ($prdinfo > ''){ $prdinfo .= "&nbsp;/&nbsp;"; }
        $prdinfo .= "BP：".number_format($item['pv']);
    }
    if ($prdinfo > ''){ $prdinfo .= "&nbsp;/&nbsp;"; }
    $prdinfo .= "建議售價：".number_format($item['c_price'])." 元";
}         
      
if ($ptype == 'L'){    	 
?>
                  <div class="col-lg-12 col-12" role="main">					  
					          <div class="article-author mb65 border-0">
                       <div class="row">
                         <div class="col-md-5 col-sm-12 text-center">
                           <div><?php if ($sUrl > ''){ ?>
                                  <a href="<?=$sUrl?>" title="<?=$item['p_name']?>">
                                <?php } ?>
                                <img src="<?=base_url()?><?=$this->block_service->prd_img($item['p_no'])?>" class="img-fluid" alt="<?=$item['p_name']?>"
                                     onerror="this.src='<?=base_url('public/images/default_arsoa.png')?>';">
                                <?php if ($sUrl > ''){ ?>
                                     </a>
                                <?php } ?>
                           </div>
                         </div>
                         <div class="media-body col-md-7 col-sm-12">
                           <h4 class="article-author-name mb-5"><?php 
                           if ($sUrl > ''){ ?>
                             <a href="<?=$sUrl?>" title="<?=$item['p_name']?>">
                           <?php } 
                           if (substr_count($item['p_name'],'-')>0) {
                               $prd_name = explode('-',$item['p_name']);
                               echo $prd_name[0];
                               echo '<br>';
                               echo $prd_name[1];
                           }else{
                               echo $item['p_name'];
                           }?>
                           <?php if ($sUrl > ''){ ?>
                             </a>
                           <?php } ?></h4>                           
                           <?php if ($item['p_title1'] > ''){ ?>
                                     <h5 class="text-info"><?=$item['p_title1']?></h5>
                                     <div class="article-author-descr"><?=$item['p_title2']?></div>                           
                           <?php }else{ ?>                           
                                     <h5 class="text-info"><?=$item['pro_title1']?></h5>
                                     <div class="article-author-descr"><?=$item['pro_title2']?></div>
                           <?php } ?>
						               <?php if ($prdinfo > ''){ ?>
                                  <div class="border-top border-bottom my-3 py-2">						                                     
                                    <?=$prdinfo?>
                                  </div>						            
                           <?php } ?>
						               
			                     <?php // 會員才會出現加入購物車按鈕
			                       //  if ($this->session->userdata('use_cart') == 'Y'){
			                             if (!$chk_color){
                                     //  if (isset($this->session->userdata('member_session')['c_no']) && $this->session->userdata('member_session')['c_no'] > '') {
                                           ?>
                                           <div class="row">
                                            <div class="col-6">	  
                                              <?php if ($shownum == 'Y'){ ?>
                                                <div id="cartnum_<?=$prdnum?>">
                                                   <a href="javascript:void(0)" onclick="ChangeProductNum('Minus', '<?=$prdnum?>', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
                                                   <input name="num_<?=$prdnum?>" id="num_<?=$prdnum?>" onKeyUp="value=value.replace(/[^0123456789]/g,'')" readonly unselectable="on" type="text" class="input-num" title="數量" value="1" maxlength="2">
                                                   <a href="javascript:void(0)" onclick="ChangeProductNum('Add', '<?=$prdnum?>', '99');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a>
                                                 </div>
                                              <?php } ?>
                                            </div>
                                            <div class="col-6">
                                              <?=$showcard?>
                                            </div>	
                                           </div> 
                          <?php      //  } 
                                //  }   
                               } ?>
                         </div>
                       </div>
                    </div>
                  </div>   
                  <?php if ($chk_color){ 
                    $pdata = $this->block_service->prd_color($item["p_no"]);                   
                    $type_na = '';
                    foreach ($pdata as $key => $citem)
                    {            
                         $cprdnum = $prdnum."".sprintf("%03d",$key); 
                         
                         $shownum = 'N';
                        // if ($this->session->userdata('use_cart') == 'Y'){
                             if ($citem["Is_nogoods"] == 1){ // 缺貨中                           	   
                                 $showcard = "<a href=\"".base_url('order/cart')."\" alt=\"缺貨中\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-alert\"></i> 缺貨中</a>";
                             }else{                          	  
                              	     if ($citem["is_shop"] == 1){
                              	        if ($this->front_order_model->check_cart($citem["s_p_no"])){                                   	           
                              	           $showcard = "<a href=\"".base_url('order/cart')."\" alt=\"檢視購物車\" class=\"btn btn-outline-info btn-sm mt-3\"><i class=\"icon ion-ios-cart\"></i> 檢視購物車 (".$this->session->userdata('prd_session')[trim($citem["s_p_no"])].")</a>";
                              	           $shownum = 'Y';
                              	        }else{
                              	           $shownum = 'Y';
                              	        	 $showcard = "<a href=\"javascript:void(0)\" onclick=\"incar('P','".trim($citem["s_p_no"])."',".$cprdnum.");\" alt=\"加入購物車\" class=\"btn btn-outline-info btn-sm mt-3\"><i class=\"icon ion-ios-cart-outline\"></i> 放入購物車</a>";
                                       }
                                    }                             
                             }
                        // }
                         if ($type_na <> $citem['type_na']){
                             if ($key > 0){
                                 echo '</div></div>';
                             }
                             $prd_class = explode('.',$citem['type_na']);      
                             ?>
                                <div class="col-lg-12 col-12" role="main">
					                       <h4 class="mb45"><?=$prd_class[1]?></h4>
                                  <div class="row">
                             <?php
                          } ?>
					                <div class="col-lg-4 col-md-6 mb-5">
						                <div class="media">
                               <div class="article-author-photo mr20">
                                 <div><img src="<?=base_url()?><?=$this->block_service->prd_img($citem['s_p_no'])?>" class="img-fluid" alt="<?=$item['p_name']?>"
                                         onerror="this.src='<?=base_url('public/images/default_arsoa.png')?>';"> </div>
                               </div>
                               <div class="media-body">
                                 <h4 class="article-author-name" style="margin-bottom: 2rem;"><?php
                                 if (substr_count($citem['p_name'],'-')>0) {
                                     $prd_name = explode('-',$citem['p_name']);
                                     echo $prd_name[0];
                                     echo '<br>';
                                     echo $prd_name[1];
                                 }else{
                                     echo $citem['p_name'];
                                 }?></h4>
                                 <div class="border-top border-bottom my-3 py-2">BP：<?=number_format($citem['pv'])?><br>建議售價：<?=number_format($citem['c_price'])?> 元 </div>
						                     <div class="col-sm-12 mb-3">	  
						                      <?php 
						                      //if (isset($this->session->userdata('member_session')['c_no']) && $this->session->userdata('member_session')['c_no'] > '') { 
						                        ?>
						                            <?php if ($shownum == 'Y'){ ?>                                            
                                               <a href="javascript:void(0)" onclick="ChangeProductNum('Minus', '<?=$cprdnum?>', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
                                               <input name="num_<?=$cprdnum?>" id="num_<?=$cprdnum?>" onKeyUp="value=value.replace(/[^0123456789]/g,'')" readonly unselectable="on" type="text" class="input-num" title="數量" value="1" maxlength="2">
                                               <a href="javascript:void(0)" onclick="ChangeProductNum('Add', '<?=$cprdnum?>', '99');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a>
                                        <?php } ?>						                            
							                          <?=$showcard?>
							                    <?php
							                    // } 
							                    ?>      
						                     </div>
                               </div>
                            </div>
					                </div>
					         <?php 
					            $type_na = $citem['type_na'];
					            } ?>					          
					           </div>
					         </div>                    
                  <?php } ?>  
<?php }else{ ?>
   
          <div class="row border py-35 my-5">
                      
                      <div class="media-body col-md-12 col-sm-12">
                        <h4 class="article-author-name mt-3">
                        	      <?php if ($sUrl > ''){ ?>
                                  <a href="<?=$sUrl?>" title="<?=$item['p_name']?>">
                                <?php } ?><?=$item['p_name']?>
                                <?php if ($sUrl > ''){ ?>
                                      </a>
                                <?php } ?>      </h4>
						               <?php if ($prdinfo > ''){ ?>
                                  <div class="border-top border-bottom my-3 py-2">						                                     
                                    <?=$prdinfo?>
                                  </div>						            
                           <?php } ?>
						             
						                 <div class="row">
						                 <div class="col-md-auto col-sm-12 mb-3">	  
						                            <?php if ($shownum == 'Y'){ ?>
                                                <div id="cartnum_<?=$prdnum?>">
                                                   <a href="javascript:void(0)" onclick="ChangeProductNum('Minus', '<?=$prdnum?>', '1');" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
                                                   <input name="num_<?=$prdnum?>" id="num_<?=$prdnum?>" onKeyUp="value=value.replace(/[^0123456789]/g,'')" readonly unselectable="on" type="text" class="input-num" title="數量" value="1" maxlength="2">
                                                   <a href="javascript:void(0)" onclick="ChangeProductNum('Add', '<?=$prdnum?>', '99');" title="增加" class="button-icon-light"><i class="ion-plus"></i></a>
                                                 </div>
                                              <?php } ?>
						                 </div>
						                 <div class="col-md-6 col-sm-12 mb-3">
						                 	          <?=$showcard?>						                 
						                 </div>						             
						             </div>
                      </div>
          </div>
 
<?php } ?>