<script src="<?=base_url()?>public/js/member_join.js?20211227"></script>
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
                  <h1 class="h2-3d font-libre"><strong>以<?=$join_name[$arsoa_join_data['jointype']]?>方式入會</strong></h1>
					
						<div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#logins-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger"> <span class="bs-stepper-circle">1</span> <span class="bs-stepper-label">選購商品</span> </button>
                      </div>
                        <div class="line"></div>
                        <div class="step active" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">2</span> <span class="bs-stepper-label">紅利兌換</span> </button>
                      </div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">3</span> <span class="bs-stepper-label">確認資料、付款</span> </button>
                      </div>
                      </div>
                    <div class="bs-stepper-content">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger"></div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger"></div>
                      </div>
                  </div>
					                  
                  <div class="row">
            					          <div class="col-md-12">
            					              <p class="text-danger text-center">您選購商品的紅利點數為：<span class="text-danger font-weight-bold"><?=number_format($pckpro_mp)?></span> 點</p>            					              
            <?php if ($pckpro3){ ?>      				    					
            					           <table class="table table-bordered">
            					              <thead>
            					                <tr class="bg-light">
            					                  <th scope="col">產品名稱</th>
            					                  <th scope="col">數量</th>
            					                </tr>
            					               </thead>
            					              <tbody>
            					                <?php foreach ($pckpro3 as $key => $item){
            					                	          ?>
            					                	          <tr>
            					                						  <td><?=$item['p_name']?></td>
            					                						  <td><?=$item['qty']?></td>
            					                						</tr>            					                	          
            					                	          <?php            					                	
            					                	    } ?>
            					              </tbody>
            					            </table>            					          
            <?php   } ?>
                              </div>
            		 </div>
					  <?php if ($pckpro4){ ?>
					  <div class="row">
					  					<div class="col-md-12" id="datafirst">
											  <div class="card mb-3">
            					      <div class="card-header">
											          <div class="row">
            					            <div class="col-md-6 align-self-center">
            					                <h4 class="mb-0">可兌換的紅利商品 <span class="text-danger"><?=number_format($pckpro_total_mp)?> 點數</span></h4>
            					            </div>            					          
            					                      <div class="col-md-2 text-right align-self-center"> <a href="javascript:void(0);" class="" onclick="pckpro_protype_change(4,'cart');" title="檢視自選紅利商品"><i class="ico ion-ios-cart" style="font-size:32px"></i> <span class="badge badge-danger badge-pill" id="show_prd_num1">0</span></a> </div>
            					                      <div class="col-md-4 form-group mb-0 align-self-center">
            					                          <div class="custom_select">
            					                               <select class="form-control select-active" name="pckpro_protype" id="pckpro_protype">            					                    
            					                               	   <?php 
            					                               	         $first_protype = '';
            					                               	         foreach ($pckpro4_protype as $key => $item){ 
            					                               	         	        if ($first_protype == ''){
            					                                                      $first_protype = $item;
            					                                                  } 
            					                                                  echo '<option value="'.$item.'">'.$item.'</option>';
            					                                         }
            					                                         echo '<option value="cart">檢視自選紅利商品</option>';
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
					  </div>					
					  <?php } ?>
					  
					
					<div class="form-group col-md-12" id="error_msg"></div> 
										
					<div class="row">
					  <div class="col-md-12 text-right">
						  <div class="btn-group" role="group" aria-label="">							  
							  <a href="<?=base_url('member_join/product')?>" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　回上頁</a> 
							  <a href="javascript:void(0);" id="submitbutton" onclick="check_data();" class="btn btn-outline-secondary">下一步　<i class="icon ion-ios-calculator"></i></a> 
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
		
		  <?=$this->block_service->member_join_modal()?>
</form>
      <?=$this->block_service->load_html_footer(); ?>  
</div>

    <a id="shoppingcart" class="pt-2" href="javascript:void(0);" onclick="pckpro_protype_change(3,'cart');" title="檢視自選紅利商品">
	  <i class="ico ion-ios-cart" style="font-size:32px"></i>
    <span class='badge badge-warning' id="lblCartCount"> 0 </span></a>
    	
<script>
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var check_step = 'reward';
pckpro_num(4);        
pckpro_protype_change(4,$("#pckpro_protype" ).val());      	
$(document).ready(function() {
	  $( "#pckpro_protype" ).change(function() {   
             pckpro_protype_change(4,$("#pckpro_protype" ).val());            
    });
});    
</script>