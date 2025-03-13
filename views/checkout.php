<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

      <div class="section-mini">

        <div class="section-item text-left">          
			      <div class="container">			  
			      </div>
			      <?=$this->block_service->load_order_step(2); ?> 			  			  
        </div>

         <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-12 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>資料填寫</strong></h1>
					      <span class="text-danger" id="fid">(*為必填欄位)</span>
                <div class="news-info mb30"></div>				
				    <div class="mb65">					  
                  <form name="form1" method="post" action="<?=base_url('order/pay')?>">					  
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>_pay" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="paytype" id="paytype" value="">   
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">訂購會員：</label>
                          <div class="col-sm-9">
                             <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?=$this->session->userdata('member_session')['c_no']?> <?=$this->session->userdata('member_session')['c_name']?>">
                          </div>
                      </div>                      
					       <div class="form-group row">
						      <label for="inputPassword" class="col-sm-3 col-form-label"><span class="text-danger">*</span>收件人資訊：<button type="button" class="btn btn-secondary btn-sm" onclick="set_address(0);" id="add_addr" style="display:none"><i class="icon ion-plus"></i> 增加新地址</button></label>
                        <div class="col-sm-9"><span id="addr_msg" style="color:red"></span>
                            <div class="row col-12 btn-group btn-group-toggle no-gutters p-0" data-toggle="buttons" id="set_addr_list">                                                        	 
                            </div>                            
                            <div class="row col-12 btn-group btn-group-toggle no-gutters p-0" id="addr_more" style="display:none">
                              <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                 <a href="javascript:addrmore('A');" class="btn btn-secondary btn-block rounded" id="addr_more_show"><i class="icon ion-arrow-up-b"></i>　Close</a>
                              </div>
                            </div>
                        </div>
					      </div>
					      <?php
					      $inemail = $this->session->userdata('member_session')['e_mail'];
					      if ($email > ''){
					      	$inemail = trim($email);
					      }
					      ?> 
						    <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label"><span class="text-danger"></span>電子郵件信箱：</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" maxlength="60" required placeholder="電子郵件信箱" value="<?=$inemail?>">
                            <input type="checkbox" name="save_email" id="save_email" value="Y"> 記住電子郵件信箱 &nbsp;<span style="color:red" id="email_msg"></span>
                          </div>
                      </div>
                <?php if (1==2){ ?>      
						    <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label"><span class="text-danger">*</span>付款人身份證字號：</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="idno" required maxlength="10" name="idno" placeholder="付款人身份證字號">
                            <span style="color:red" id="idno_msg"></span>
                          </div>
                      </div>						 
                <?php } ?>                  
               </form>
				       <p>※填寫電子郵件信箱者，將可收到本訂單的資訊。<br>※請您正確填寫以上的訂單資料，填寫無誤後請選擇付款方式。</p>	
				  </div>
			<div class="mb65" style="margin-top: -35px;">
			<div class="table-responsive">
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
                    <td><?=$p_num?></td>
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
                   </tr>
                   <?php
              } 
              ?>
           </tbody>
         </table>
		  </div>

<?php if (count($sumdetail['comp']) > 0 || count($sumdetail['birth']) > 0){ ?>
<hr>				  
<div class="row">
	<?php if (count($sumdetail['comp']) > 0){ 
		        echo $this->block_service->act('show','comp',$sumdetail['comp']);		        
	      } 
	      if (count($sumdetail['birth']) > 0){ 
	        	echo $this->block_service->act('show','birth',$sumdetail['birth']);	        	
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
      <th scope="row">前期紅利</th>
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
                         break;                
                    case '1':
                         $total_amt += $this->session->userdata('FC_freight');
                         echo "NT $".$this->session->userdata('FC_freight');
                         break;                     
                    case '2':                         
                         if ($this->session->userdata( 'sfreight') == '1'){
                             echo "NT $".$this->session->userdata('FC_freight');
                             $total_amt += $this->session->userdata('FC_freight');
                         } 
                         if ($this->session->userdata( 'sfreight') == '2'){
                             echo "紅利 ".$this->session->userdata('FC_freight_mp');
                         }
                         break;                     
          }
          ?>
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
						  <a href="<?=base_url('order/cart')?>" class="btn btn-outline-secondary"><i class="icon ion-arrow-left-a"></i>　回上一頁</a>
						  <?php if ($total_amt == 0){ ?>
						            <a href="javascript:void(0);" onclick="document.form1.paytype.value='F';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_pay');Form_check();" class="btn btn-outline-secondary">紅利積點兌換　<i class="icon ion-ios-paper"></i></a>
						  <?php }else{ 
						           if (1==2){?>                          
                        <a href="javascript:void(0);" onclick="document.form1.paytype.value='W';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_pay');Form_check();" class="btn btn-outline-secondary">網路ATM　<i class="icon ion-android-globe"></i></a>                                                
						        <?php } ?>    		
						            <?php if (date('Y-m-d H:i:s') <= '2024-06-28 16:00:00'){ ?>
						                 <a href="javascript:void(0);" onclick="document.form1.paytype.value='A';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_pay');Form_check();" class="btn btn-outline-secondary">實體 ATM　<i class="icon ion-grid"></i></a> 
						        <?php } ?>    		
						            <a href="javascript:void(0);" onclick="document.form1.paytype.value='C';chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_pay');Form_check();" class="btn btn-outline-secondary">信用卡付款　<i class="icon ion-ios-paper"></i></a>
						            
						  <?php } ?>  
            </div>
					</div>
        </div>

</form>
                  <hr class="mt-0 mb70">           
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?=$this->block_service->load_html_footer(); ?>  
</div>

<!-- Modal -->
<div class="modal fade" id="setaddressmodel" tabindex="-1" role="dialog" aria-labelledby="addaddModalLabel" aria-hidden="true">
  <form name="set_Form" id="set_Form" class="text-left" method="post">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="setaddressmodel_title">增加新地址</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人姓名：<span style="color:red" id="addr_name_msg"></span></label>
                  <div class="col-sm-12">                       
                       <input type="hidden" name="addr_more_chk" id="addr_more_chk" value="N">							
                       <input type="hidden" name="addr_id" id="addr_id" value="0">							
                       <input type="hidden" name="addr_num" id="addr_num" value="0">							
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
                       <input type="text" class="form-control" name="addr_name" id="addr_name" value="<?php if (isset($params['c_name'])){ echo $params['c_name']; }?>" maxlength="10" placeholder="收件人姓名">
                  </div>
            </div>
					  <div class="form-group row">
						  <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人地址：<span style="color:red" id="addr_addr_msg"></span></label>
                     <div class="form-group col-md-4">
                        <select id="addr_cityno" name="addr_cityno" class="form-control" required="required">
                            <option value="">縣巿</option>
                            <?php foreach ($city as $citydata){ ?>
                                 <option value="<?=$citydata['cityno']?>"><?=$citydata['citytitle']?></option>
                            <?php } ?>                                 
                        </select>
                     </div>
                     <div class="form-group col-md-4">
                        <select name="addr_postal" id="addr_postal" class="form-control">
                          <option value="">鄉鎮市區</option>                                                     
                          <?php if (isset($params['town']) && count($params['town']) > 0){
                                    foreach ($params['town'] as $towndata){ ?>
                                         <option value="<?=$towndata['postal']?>"><?=$towndata['towntitle']?></option>
                          <?php     }
                                }
                                ?>                   
                        </select>   
                      </div>
                      <div class="form-group col-md-4">
                          <input type="text" name="addr_zip" id="addr_zip" readonly maxlength="3" value="<?php if (isset($params['postal'])){ echo $params['postal']; }?>" readonly class="form-control" placeholder="郵遞區號">
                      </div>
						            <div class="form-group col-sm-12">
                          <input type="text" class="form-control" name="addr_address" id="addr_address" value="<?php if (isset($params['address'])){ echo $params['address']; }?>" maxlength="40" placeholder="詳細地址">
                        </div>
                        </div>
						            <div class="form-group row">
                          <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人聯絡電話：<span style="color:red" id="addr_tel_msg"></span></label>
                          <div class="col-sm-12">
                          <input type="text" class="form-control" name="addr_tel" id="addr_tel" maxlength="16" value="<?php if (isset($params['tel'])){ echo $params['tel']; }?>"  placeholder="收件人聯絡電話" onKeyUp="value=value.replace(/[^\d\#\-\(\)]/g,'')">
                        </div>
                      </div>
		  				        <div class="form-group row">
                          <p class="form-column">
							               我們重視您的隱私：<a href="<?=base_url('copyright')?>" target="_blank" class="button-terms">會員條款</a>及<a href="<?=base_url('privacy_policy')?>" target="_blank" title="隱私權政策">隱私權政策</a></p>
						          <p class="form-column">
                        <input type="checkbox" name="addr_set" id="addr_set" value="Y">
                        <label for="IAgree">設定該地址為預設地址</label>
                      </p>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="contact-submit">確認</button>
      </div>
    </div>
  </div>
  </form>
</div>

<script language="JavaScript" type="text/JavaScript">
$(document).ready(function() { 
   $('#addr_cityno').change(function(){                 
       ChangeCity('addr_cityno','addr_postal','addr_zip','addr_address','');
   });
   $('#addr_postal').change(function(){                 
       ChangeTown('addr_cityno','addr_postal','addr_zip','addr_address');
   });
   $("#contact-submit").click(function(){         
      check_data();
   });
});

function get_set_address(aid)
{   
        $.ajax({
             url: base_url+"order/set_address/"+aid,                
             type: "GET",
             dataType: "json",
             success: function(data){        
                  console.log(data);                                 
                  $( "#addr_name" ).val(data.params.c_name);
                  $( "#addr_tel" ).val(data.params.tel);                  
                  $( "#addr_cityno").val(data.params.cityno);  
                  $( "#addr_id" ).val(data.params.aid);
                  ChangeCity('addr_cityno','addr_postal','addr_zip','addr_address',data.params.postal);
                  $("#addr_zip").val(data.params.postal);  
                  $( "#addr_address" ).val(data.params.address);                  
                  
                  if (data.params.sort == '0'){
                      $("input[name='addr_set']").prop("checked", true);
                  }else{
                      $("input[name='addr_set']").prop("checked", false); 
                  }
             }
        });       
}

function set_address(aid){    
  $( "#addr_name_msg" ).html('');
  $( "#addr_addr_msg" ).html('');
  $( "#addr_tel_msg" ).html('');
  if (aid == 0){
      $( "#addr_name" ).val('');
      $( "#addr_tel" ).val('');
      $( "#addr_id" ).val('0');
      $("input[name='addr_set']").prop("checked", false); 
      //$( "#addr_address" ).val('');                  
      $( "#setaddressmodel_title" ).html('增加新地址');
  }else{
      $( "#setaddressmodel_title" ).html('地址修改');
      get_set_address(aid);
  }  
  $("#setaddressmodel").modal('show');    
}


function check_data() {           
        var err=0;
        var errmsg = ''; 
        var focusstr = '';      
        if ($('input[name=addr_name]').val() == ''){            
            $( "#addr_name_msg" ).html('未填寫完成');
            focusstr = 'addr_name';
        }
        if ($('#addr_cityno').val() == '') { 
             $( "#addr_addr_msg" ).html('未填寫完成');
             if (focusstr ==''){ focusstr = 'addr_cityno'; }   
        }
        if ($('#addr_postal').val() == '') { 
             $( "#addr_addr_msg" ).html('未填寫完成');
             if (focusstr ==''){ focusstr = 'addr_postal'; }   
        }
        if ($('input[name=addr_address]').val() == ''){
            $( "#addr_addr_msg" ).html('未填寫完成');    
            if (focusstr ==''){ focusstr = 'addr_address'; }   
        }
        if ($('input[name=addr_tel]').val() == ''){
            $( "#addr_tel_msg" ).html('未填寫完成');
            if (focusstr ==''){ focusstr = 'addr_tel'; }
        }             
        if (focusstr> ''){
             $('#'+focusstr).focus();
        }else{
            chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');
            $.ajax({
                url: base_url + "order/set_address_save",
                type: "POST",
                dataType: "json",
                data: jQuery('#set_Form').serialize(),
                success: function(data){	   	    
	     		               console.log(data);
	     		               if (data.status){
	     		                   order_set_address(data.addr_id);
	     		                   $('#setaddressmodel').modal('hide');  
	     		               }else{
	     		                   alert(data.errmsg);
	     		               } 
	     	        }
	          });
	      }
       
}
function order_set_address(aid){
         $.getJSON(base_url+"order/set_address_show/"+aid, function(data)
         {
              console.log(data);
              if (data.addr_num >= 6){
	     		        $("#add_addr").css('display','none'); 
	     		    }else{
	     		        $("#add_addr").css('display','block'); 
	     		    }
	     		    $( "#addr_num" ).val(data.addr_num);	     		    
              $( "#set_addr_list" ).html(data.html);
              if ($( "#addr_num" ).val() > 3){
                  $("#addr_more").css('display','block');    
                  if (aid == 0){
                      addrmore('N'); 
                  }                       
              } 
         });  
}
function addrmore(htype){                
         if ($("#addrid_4").is(':hidden') || htype == 'Y'){             
             for (var i = 4; i < 7; i++ ) {
                 if ($("#addrid_"+i).length > 0){
                     $("#addrid_"+i).css('display','block');              
                 }
             }
             $( "#addr_more_chk" ).val('N');
             $( "#addr_more_show" ).html('<i class="icon ion-arrow-up-b"></i>　Close');          		
	       }else{		
	           for (var i = 4; i < 7; i++ ) {
                 if ($("#addrid_"+i).length > 0){
                     $("#addrid_"+i).css('display','none');              
                 }
             }
             $( "#addr_more_chk" ).val('Y');
             $( "#addr_more_show" ).html('<i class="icon ion-arrow-down-b"></i>　More');	           
         }         
};

</script>  
<?php 
$GLOBALS['injava'] = "<script>
window.onload = function() {order_set_address(0);};
</script>";
?>
<script>
function Form_check(){         
         var focusstr = '';      
         $( "#email_msg" ).html('');
         $( "#addr_msg" ).html('');
         if ($('input[name=addr_num]').val() == '0'){
            $( "#addr_msg" ).html('收件人資訊未設定！');
            if (focusstr ==''){ focusstr = 'addr_msg'; }
         }         
         if ($('input[name=email]').val() > ''){            
            if (!/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( $('input[name=email]').val() )){
               $( "#email_msg" ).html('電子郵件信箱格式有誤');
               if (focusstr ==''){ focusstr = 'email'; }
            }      
         }
         if (focusstr> ''){
         	   if (focusstr  == 'addr_msg'){
         	       $('html,body').animate({scrollTop:$('#fid').offset().top}, 100);              
         	   }else{
                 $('#'+focusstr).focus();             
             }
         }else{          
             document.form1.submit();
         }
}

function del_address(aid)
{
	    if (confirm('確定是否刪除收件人資訊?')){
	       $.getJSON(base_url+"order/set_address_del/"+aid, function(data)
         {
              order_set_address(0);                 
         });  
      }
}
</script>
