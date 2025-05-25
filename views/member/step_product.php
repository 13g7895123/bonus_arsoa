<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<script src="<?=base_url()?>public/js/member.js?20211227"></script>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
        <form name="oForm" id="oForm" method="post">	
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							 
         
         <div class="section-mini">

          <div class="section-item text-left">		  
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-12 mb130" role="main">
                  <!-- <h1 class="h2-3d font-libre"><strong>以<?=$join_name[$arsoa_join_data['jointype']]?>方式登錄</strong></h1> -->
					
									<div class="bs-stepper">
                    <!-- <div class="bs-stepper-header" role="tablist">
                        <div class="step active" data-target="#logins-part">
							<button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger"> <span class="bs-stepper-circle">1</span> <span class="bs-stepper-label">選購商品</span> </button>
						</div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
							<button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">2</span> <span class="bs-stepper-label">紅利兌換</span> </button>
						</div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
							<button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">3</span> <span class="bs-stepper-label">確認資料、付款</span> </button>
						</div>
					</div> -->
                    <div class="bs-stepper-content">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger"></div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger"></div>
                      </div>
                  </div>
					
            <?php if ($maxamt > 0){ ?>      
            <!-- <div class="col-md-12">
                <p class=" text-center" id="amtmsg">
                	整張單需滿 <span style="color:red"><?=number_format($maxamt)?></span> 元可登錄
                </p>            					              
            </div> -->
            <?php } ?>					                
				    <div class="row">
					  <?php 
					        $total = 0;
					        if ($pckpro1){ 		
					  	        ?>
					  					<div class="col-md-12">
											  <div class="card mb-3">
            					        <div class="card-header">
											<div style="float:left"><h4 class="mb-0">請選擇1個專案</h4></div>
											<!-- <div style="float:left">&nbsp;<?php if ($pckpro1_selcnt > 0 && $pckpro1_count > 1){ echo '<font color=red>請選擇'.$pckpro1_selcnt.'個專案</font>'; } ?></div> -->
										</div>
            					        <div class="card-body">					  					
															<div class="table-responsive">
																 <input type="hidden" name="pckpro_check" value="<?=$pckpro1_checkbox?>">
            									   <table class="table table-striped mb-2 text-center">
            									   	<?php
            									   	$colspan_num = 1;
            									   	switch ($arsoa_join_data['jointype']) {
																	    case 4:
																	        $colspan_num = 2;
																	        ?>
																				<thead class="thead-dark">
																					<tr>
																						<th colspan=2>選專案</th>                          
																						<th>首簽當期贈品</th>  
																						<th>首簽後<br>每滿 6 個月循環總贈品</th>																																
																						<th>每月宅配<br>金額</th>
																					</tr>
																				</thead>
																			<tbody> 
																	        <?php
																	        break;
																	    case 5:
																	        $colspan_num = 1;
																	        ?>
																	        <thead class="thead-dark">
            									              <tr>
            									                <th colspan=2>選專案 ( 一次 3 期 / 6 個月為一完整循環 )</th>                          
            									                <th>每期贈品</th>              									                
            									                <th>每期宅配金額</th>
            									              </tr>
            									            </thead>
            									            <tbody> 
																	        <?php	
																	        break;	
																	    case 6:
																	        $colspan_num = 1;
																	        ?>
																	        <thead class="thead-dark">
            									              <tr>
            									                <th colspan=2>選專案</th>                          
            									                <th>建議售價</th>  
            									                <th style="min-width: 158px;">數量</th>																																
            									                <th>金額</th>
            									              </tr>
            									            </thead>
            									            <tbody> 
																	        <?php	
																	        break;	    															        
																	    default:
																	        if ($pckpro1_checkbox){   
																	        ?>
																	        <thead class="thead-dark">
            									              <tr>
            									              	<th>選專案</th> 
            									                <th>品名</th>                          
            									                <th>建議售價</th>  
            									                <th style="min-width: 158px;">數量</th>																																
            									                <th>金額</th>
            									              </tr>
            									            </thead>
            									            <tbody>   																	        
																	        <?php	
																	        }else{
																	        ?>
																	        <thead class="thead-dark">
            									              <tr>
            									                <th>品名</th>                          
            									                <th>建議售價</th>  
            									                <th style="min-width: 158px;">數量</th>																																
            									                <th>金額</th>
            									              </tr>
            									            </thead>
            									            <tbody>   																	        
																	        <?php	
																	       }																        
																	}
            									   	foreach ($pckpro1 as $key => $item){ 
            									   		       $prdtotal = $item['price']*$item['qty'];
            									   		       $i_checked = '';
            									   		       if ($this->front_join_model->check_cart($arsoa_join_pckpro,1,trim($item["p_no"]))){
            									          	      $total += $prdtotal;
            									          	      $useamt += $prdtotal;
            									          	      $i_checked = ' checked';
            									          	 }else{            									          	 	
            									          	      if ($pckpro1_checkbox){   
            									          	      	  if (!$arsoa_join_pckpro[1]){
            									          	      	  	  if ($item['issel']){
            									          	          	      $total += $prdtotal;
            									          	          	      $useamt += $prdtotal;
            									          	                  $i_checked = ' checked';  
            									          	              }   
            									          	      	  }
            									          	      }else{
            									          	          if ($item['issel']){
            									          	          	  $total += $prdtotal;
            									          	          	  $useamt += $prdtotal;
            									          	              $i_checked = ' checked';  
            									          	          }
            									          	      }
            									          	 }
            									          	 ?>
            									              <tr>
            									              	<?php
            									              	if ($pckpro1_checkbox){
            									              		  ?>
            									              		  <td><input type="checkbox" name="sel_prd[]" id="sel_prd" onclick="checkProductSelection(this)" value="<?=trim($item['p_no'])?>" <?=$i_checked?>></td>
            									              		  <?php
            									              	}
            									              	?>
            									                <td nowrap="nowrap" class="text-left"><?=$this->block_service->load_join_product(trim($item['p_no']),trim($item['p_name']),$item['price']); ?></td>        
            									                <?php
            									   							switch ($arsoa_join_data['jointype']) {
																							    case 4:
																							        ?>
																							        <td><?=$item['firstgive']?></td>
            									                				<td><?=$item['aftergive']?></td>
            									                				<td><?=number_format($prdtotal)?> 元</td>
																							        <?php
																							        break;
																							    case 5:
																							        ?>
																							        <td><?=$item['everygive']?></td>            									                				
            									                				<td><?=number_format($prdtotal)?> 元/<?=$item['everybp']?></td>
																							        <?php	
																							        break;																        
																							    default:
																							        ?>
																							        <td><?=number_format($item['price'])?></td>
            									                				<td><?=$item['qty']?></td>
            									                				<td><?=number_format($prdtotal)?> 元</td>
																							        <?php																	        
																							}    									                
            									                ?>
            									              </tr>
            									    <?php 
            									    } ?>   
            									            </tbody> 
            									    <?php
            									    /*        
															  						<tr>
															  						  <td colspan="<?=$colspan_num?>" nowrap="nowrap" class="text-left">&nbsp;</td>
															  						  <td>&nbsp;</td>
															  						  <th>合計：</th>
															  						  <td><?=number_format($total)?> 元</td>
					  									  						</tr>
            									            </tbody>
            									    */ ?>         
            									   </table>
															  </div>
            					        </div>
            					      </div>
					  					</div>
					  <?php } ?>
					  <?php if ($pckpro2){ ?>
					  					<?php if ($maxamt > 0 && 1 == 2){ ?>
					  					          <div class="col-md-12">
            					              <p class=" text-center" id="amtmsg">
            					              	<?php if ($arsoa_join_data['jointype'] == '3'){ ?>
            					              	    需購買 <span id="maxamt" style="color:red"><?=number_format($maxamt)?></span> 元，
            					              	   	已購 <span id="useamt" style="color:red"><?=number_format($useamt)?></span> 元，自選產品需購 <span id="mamt" style="color:red"><?=number_format($maxamt -$useamt)?></span> 元
            					              	<?php } ?>   	
            					              </p>            					              
            					          </div>
            					<?php } ?>
					  					<div class="col-md-12" id="datafirst">
											  <div class="card mb-3">
            					      <div class="card-header">											          
											          <div class="row">											          	
            					            <div class="col-md-6 align-self-center">
            					                <h4 class="mb-0">自選產品 
            					                	<?php if ($arsoa_join_data['jointype'] == '3' && date('Y-m-d H:i:s') > '2022-10-31 16:00:00'){ 
            					                	          echo '<span style="font-size:16px;color:red">（需搭配的宅配單請至右方下拉選擇）</span>';
            					                        }?></h4>
            					            </div>              					   
            					            
            					            <div class="col-md-2 text-right align-self-center"> <a href="javascript:void(0);" class="" onclick="pckpro_protype_change(2,'cart');" title="檢視自選產品購物車"><i class="ico ion-ios-cart" style="font-size:32px"></i> <span class="badge badge-danger badge-pill" id="show_prd_num1">0</span></a> </div>
            					            <div class="col-md-4 form-group mb-0 align-self-center">
            					                <div class="custom_select">
            					                     <select class="form-control select-active" name="pckpro_protype" id="pckpro_protype">            					                    
            					                     	   <?php 
            					                     	         $first_protype = '';
            					                     	         foreach ($pckpro2_protype as $key => $item){ 
            					                     	         	        if ($first_protype == ''){
            					                                            $first_protype = $item;
            					                                        } 
            					                                        echo '<option value="'.$item.'">'.$item.'</option>';
            					                               }
            					                               echo '<option value="cart">檢視自選產品購物車</option>';
            					                         ?>            					                         
            					                     </select>
            					                </div>
            					            </div>            					                
            					            </div>
												       </div>
            					         <div class="card-body">            					
            					             <table class="table table-striped table-hover text-center" id="pckpro_list"></table>
            					         </div>
            					     </div>
					  					</div>
					  <?php } ?>
					</div>
					
					<div class="form-group col-md-12" id="error_msg"></div> 
										
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="btn-group" role="group" aria-label="">	
								<a href="javascript:void(0);" id="submitbutton" onclick="joinToCart();" class="btn btn-outline-secondary">
									<i class="icon ion-ios-cart"></i>	
									<span>加入購物車</span>
								</a>
								<a href="<?=base_url('order/cart')?>" class="btn btn-outline-secondary">
									<i class="icon ion-ios-search"></i>
									<span>檢視購物車</span>									
								</a>	  
								<a href="<?=base_url('member/main')?>" class="btn btn-outline-secondary">
									<i class="icon ion-ios-pricetag"></i>
									<span>繼續選購其他商品</span>
								</a> 
								
							</div>
						</div>
					</div>
                </div>
				  
				  
				  
				  <div class="col-md-12 mb130">
					  <hr class="mt-0 mb70">
		<p></p><p>備註：</p>

<ol>
	<li>請您於交易完成時，記下網購單號，以便追蹤查詢進度。</li>
	<li>本公司保留出貨與否權利。</li>
	<li>購滿建議售價2000元，或兌換紅利點數達4000點，即可免付運費100元(點)。</li>
	<li>為保障會員用卡安全，本公司僅接受訂貨人本人持有之信用卡。</li>
	<li>一但確定您要的贈品數量後，請按更改數量確認；否則將會造成資料的遺失。</li>
</ol>
<p></p>
	</div>
				  
              </div>
            </div>
          </div>

        </div>


      </div>
		
		<?=$this->block_service->class_main()?>
</form>
      <?=$this->block_service->load_html_footer(); ?>  
</div>


    <!-- <a id="shoppingcart" class="pt-2" href="javascript:void(0);" onclick="pckpro_protype_change(2,'cart');" title="檢視自選產品購物車"> -->
	<a id="shoppingcart" class="pt-2" title="檢視自選產品購物車" href="<?=base_url('order/cart')?>">
	  <i class="ico ion-ios-cart" style="font-size:32px"></i>
    <span class='badge badge-warning' id="lblCartCount"> <?=$this->front_order_model->check_cart_num()?> </span></a>
    	
<script>
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var check_step = 'product';
pckpro_num(2);
pckpro_protype_change(2,$('#pckpro_protype').val());
$(document).ready(function() {
	  $( "#pckpro_protype" ).change(function() {   
             pckpro_protype_change(2,$("#pckpro_protype" ).val());            
    });
});    


<?php if ($pckpro1_selcnt > 0){ ?>
$(document).ready(function() {	
   $('input[type=checkbox]').click(function() {
     sel_check(<?=$pckpro1_selcnt?>);
   });
});    
function sel_check(selcnt){
	  $("input[name='sel_prd[]']").attr('disabled', true);
    if ($("input[name='sel_prd[]']:checked").length >= <?=$pckpro1_selcnt?>) {
        $("input[name='sel_prd[]']:checked").attr('disabled', false);
    } else {
       $("input[name='sel_prd[]']").attr('disabled', false);
    }    
}
sel_check(<?=$pckpro1_selcnt?>);
<?php } ?>  
</script>