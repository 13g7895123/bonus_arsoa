<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<style>
#radioBtn .notActive{    
    color: #3276b1;    
    background-color: #fff;
}
</style>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

      <div class="section-mini">

        <div class="section-item text-left">          
			      <div class="container">			  
			      </div>
			      <?=$this->block_service->load_order_step(1); ?> 			  			  
        </div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-12 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>檢視購物車</strong></h1>
                  <div class="news-info mb30">
                    
                  </div>
					

                  <div class="mb65">
					  <div class="table-responsive">
<form name="form1" method="post" action="<?=base_url('order/cart')?>" >					  
<?php if ($cart_data){ ?> 
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>_cart" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" name="edit" id="edit" value="Y">   
	    
					<table class="table table-striped mb-2 text-center">
            <thead class="thead-dark">
              <tr>
                <th>產品名稱</th>
                <th>單價</th>
                <th style="min-width: 158px;">數量</th>
                <th>小計</th>
                <th>BP小計</th>
                <th>兌換紅利</th>
                <th>加贈紅利</th>
                <th>刪除</th>
              </tr>
            </thead>
            <tbody>
              <?php            
              $prdnum = 0;                            
              foreach ($cart_data as $key => $item){ 
                   $prdnum++;
                   $p_num = $this->front_order_model->check_cart_prd_num(trim($item["p_no"]));                                      
              ?>
              <tr>
                <td nowrap="nowrap" class="text-left"><?=$item['p_name']?></td>
                <td><?php
                if ($item['c_price'] > 0){
                    echo number_format($item['c_price']);
                }?></td>
                <td class="form-group">          		    
                  <a href="javascript:void(0)" onclick="ChangeProductNum('Minus', '<?=$prdnum?>', '1');change_cart('P',<?=$prdnum?>);" title="減少" class="button-icon-light"><i class="ion-minus"></i></a>
                  <input name="num_<?=$prdnum?>" id="num_<?=$prdnum?>" type="text" class="input-num" onKeyUp="value=value.replace(/[^0123456789]/g,'')" readonly unselectable="on" title="數量" value="<?=$p_num?>" maxlength="2">
                  <a href="javascript:void(0)" onclick="ChangeProductNum('Add', '<?=$prdnum?>', '<?=$item["maxqty"]?>');change_cart('P',<?=$prdnum?>);" title="增加" class="button-icon-light"><i class="ion-plus"></i></a>                  
                  <input type="hidden" name="p_no_<?=$prdnum?>" id="p_no_<?=$prdnum?>" value="<?=trim($item['p_no'])?>">
                  <input type="hidden" name="price_<?=$prdnum?>" id="price_<?=$prdnum?>" value="<?=$item['c_price']?>">
                  <input type="hidden" name="m_mp_<?=$prdnum?>" id="m_mp_<?=$prdnum?>" value="<?=$item['m_mp']?>">
                  <input type="hidden" name="p_mp_<?=$prdnum?>" id="p_mp_<?=$prdnum?>" value="<?=$item['p_mp']?>">
          		  </td>
                <td><?php
                if ($item['c_price'] > 0){
                    $total_price = $item['c_price'] * $p_num;                    
                    echo number_format($total_price);
                }?></td>
                <td><?php
                if ($item['pv'] > 0){
                    $total_pv = $item['pv'] * $p_num;
                    echo number_format($total_pv);
                }?></td>
                <td><?php
                if ($item['m_mp'] > 0){
                    $total_m_mp = $item['m_mp'] * $p_num;
                    echo number_format($total_m_mp);
                }?></td>
                <td><?php
                if ($item['p_mp'] > 0){
                    $total_p_mp = $item['p_mp'] * $p_num;
                    echo number_format($total_p_mp);
                }?></td>
                <td><input type="checkbox" name="del_prd[]" id="del_prd[]" value="<?=trim($item['p_no'])?>"
                     onclick="change_cart('P',<?=$prdnum?>);" ></td>
              </tr>
              <?php
              } 
              ?>
            </tbody>
          </table>
         
          <input type="hidden" name="p_num" id="p_num" value="<?=$prdnum?>">     
</div>

<?php if (count($sumdetail['comp']) > 0 || count($sumdetail['birth']) > 0){ ?>
<hr>				  
<div class="row">
	<?php if (count($sumdetail['comp']) > 0){ 
		        echo $this->block_service->act('cart','comp',$sumdetail['comp']);
	      } 
	      if (count($sumdetail['birth']) > 0){ 
		        echo $this->block_service->act('cart','birth',$sumdetail['birth']);	        	
	      } ?>
</div>
<?php } ?>


<div class="row">	
	<div class="col-md-5">
		<table class="table text-right">
  <thead>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">BP</th>
      <th scope="col">建議售價</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">A類</th>
      <td><?=number_format($sumdetail['a_pv'])?></td>
      <td><?=number_format($sumdetail['a_amt'])?></td>
      </tr>
    <tr>
      <th scope="row">B類</th>
      <td><?=number_format($sumdetail['b_pv'])?></td>
      <td><?=number_format($sumdetail['b_amt'])?></td>
      </tr>
    <tr>
      <th scope="row">合計</th>
      <td><?=number_format($sumdetail['a_pv']+$sumdetail['b_pv'])?></td>
      <td><?=number_format($sumdetail['u_amt'])?></td>
      </tr>
  </tbody>
</table>
	</div>

<?php
//$sumdetail['is_freight'] = 2;
if ($sumdetail['is_freight'] <> '0'){  // 抓運費
    if (empty($this->session->userdata('FC_freight'))){
        $this->front_order_model->set_freight();
    }
    if ($this->session->userdata( 'sfreight') == '2'){
        $sumdetail['m_mp'] += $this->session->userdata('FC_freight_mp');
        $sumdetail['mp'] -= $this->session->userdata('FC_freight_mp');
    }
}
?>					  
<div class="col-md-4">
		<table class="table text-right">
  <thead>
    <tr>
		<th colspan="2" scope="col">紅利點數</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row" class="text-info font-weight-bold">前期紅利</th>
      <td class="text-info font-weight-bold"><?=number_format($sumdetail['bf_mp'])?></td>
      </tr>
    <tr>
      <th scope="row">+ 回饋紅利</th>
      <td><?=number_format($sumdetail['r_mp'])?></td>
      </tr>
    <tr>
      <th scope="row">+ 加贈紅利</th>
      <td><?=number_format($sumdetail['p_mp'])?></td>
      </tr>
    <tr>
      <th scope="row">- 兌換紅利</th>
      <td><?=number_format($sumdetail['m_mp'])?></td>
    </tr>
    <tr>
      <th scope="row">= 目前結餘</th>
      <td><?=number_format($sumdetail['mp'])?></td>
    </tr>
  </tbody>
</table>
	</div>
					  <div class="col-md-3">
		<table class="table text-right">
  <thead>
    <tr>
      <th colspan="2" scope="col">交易金額</th>
      </tr>
  </thead>
  <?php
  $total_amt = $sumdetail['amt'];
  ?>
  <tbody>
    <tr>
      <th scope="row">合計</th>
         <td><?=number_format($total_amt)?></td>
      </tr>
      <tr>
        <th scope="row">運費</th>
        <td>
          <?php                   
          switch ($sumdetail['is_freight']) {
                    case '0':
                         echo "NT $0";
                         $sfreight = 0;
                         break;                
                    case '1':
                         $total_amt += $this->session->userdata('FC_freight');
                         echo "NT $".$this->session->userdata('FC_freight');
                         $sfreight = 1;
                         break;                     
                    case '2':
                         $s1 = ' notActive';
                         $s2 = ' notActive';
                         $sfreight = '';
                         if (!empty($this->session->userdata( 'sfreight'))){
                             if ($this->session->userdata( 'sfreight') == '1'){
                                 $s1 = ' active';
                                 $total_amt += $this->session->userdata('FC_freight');
                                 $sfreight = 1;
                             } 
                             if ($this->session->userdata( 'sfreight') == '2'){
                                 $s2 = ' active';
                                 $sfreight = 2;
                             }
                         }
                         ?>
                         <div class="input-group">
    			               	<div id="radioBtn" class="btn-group">
    			               		<a class="btn btn-primary btn-sm<?=$s1?>" data-toggle="sfreight" data-title="1">NT $<?=$this->session->userdata('FC_freight')?></a>    			             		
    			               		<a class="btn btn-primary btn-sm<?=$s2?>" data-toggle="sfreight" data-title="2">紅利 <?=$this->session->userdata('FC_freight_mp')?> 點</a>
    			               	</div>    	
    			               	<span style="color:red" id="sfreight_msg"></span>		     
    			               </div>                       
                         <?php                         
                         break;                     
          }
          ?>
          <input type="hidden" name="sfreight" id="sfreight" value="<?=$sfreight?>">
        </td>
      </tr>     
      <tr>
         <th scope="row">總金額</th>
         <td><?=number_format($total_amt)?></td>
      </tr>
  </tbody>
</table>
	</div>
	
				    </div>
					<div class="text-right">
						<div class="btn-group" role="group" aria-label="Basic example">
						  <a href="<?=base_url('reward')?>" class="btn btn-outline-secondary">兌換紅利商品　<i class="icon ion-pricetags"></i></a>
							<a href="<?=base_url('#products')?>" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　繼續選購</a>
              <button type="button" onclick="document.form1.edit.value='E';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_cart');Form_check('N');" class="btn btn-outline-secondary">更改數量</button>
              <?php if ($sumdetail['mp'] < 0){ ?>
                        <a href="javascript:void(0);" id="submitbutton" class="btn btn-outline-secondary" style="color:red">紅利點數不足 <?=number_format(-$sumdetail['mp'])?> 點</a>
              <?php }else{ ?> 
                        <a href="javascript:void(0);" onclick="document.form1.edit.value='S';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_cart');Form_check('Y');" id="submitbutton" class="btn btn-outline-secondary">我要結帳　<i class="icon ion-ios-calculator"></i></a>
              <?php } ?>     
            </div>
					</div>

<?php }else{ ?> 
          <h5 class="text-info">購物車中無產品。</h5>
          </div>
	
				    </div>
          <div class="text-right">
						<div class="btn-group" role="group" aria-label="Basic example">
							<a href="<?=base_url('reward')?>" class="btn btn-outline-secondary">兌換紅利商品　<i class="icon ion-pricetags"></i></a>
							<a href="<?=base_url('#products')?>" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　繼續選購</a>
						</div>
					</div>							  
<?php } ?> 
</form>
       </div>
<hr class="mt-0 mb70">
<div class="row">             
<div class="col-md-12">
		<p><?=$cart_remark?></p>
	</div>
                  
 </div>                  
                  

                  

                  

                </div>

              </div>
            </div>
          </div>

        </div>


      </div>
       
      <?=$this->block_service->load_html_footer(); ?>  
</div>
<?php 
echo '<!--';
echo $this->session->userdata('temp_no');
echo '-->';
?>
<script>
function Form_check(jchk){         
         
         var focusstr = '';               
         $( "#sfreight_msg" ).html('');
         if (jchk == 'Y'){
             if ($('input[name=sfreight]').val() == ''){
                $( "#sfreight_msg" ).html('運費未選擇');
                if (focusstr ==''){ focusstr = 'sfreight'; }
             }
         }
         if (focusstr> ''){
             $('#'+focusstr).focus();             
         }else{          
             document.form1.submit();
         }
}

$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    change_cart('F',0);
});

function change_cart(ctype,pnum){
    $('#submitbutton').attr('disabled', true);
    $("#submitbutton").attr("onclick","");
    $("#submitbutton").css("color","red");
    $("#submitbutton").html('<-訂單有變動需按更改數量才可結帳');	     
}
</script>
<!--<?=$this->session->userdata('temp_no')?>-->