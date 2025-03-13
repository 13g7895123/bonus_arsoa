<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        <form class="form-horizontal upload_form" name="oForm" id="oForm" method="post" action="<?=base_url('lottery/information_save/'.$charge_checkcode)?>" data-toggle="validator" role="form" onSubmit="return Form_check(this);">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="section-mini">			
          <div class="section-item text-center"> 
             <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <h1 class="h2-3d font-libre">
                                        <strong><?=$lottery_data['lot_title']?></strong>
                                    </h1>
                                    <div class="news mb30 text-center">親愛的 <?=$this->session->userdata('line_display_name')?> 您好，您已抽中《<?=$charge_check['lot_item']['title']?>》，請填寫收件資料。</div>
                                    <div class="mb-4">
                                       <div class="container">
                                        	
                                        	<div class="card-body">
                                                <div class="row mb-3">
                                                   <div class="col-md-6">                                        	
                                                      <label class="label-custom text-left">姓名</label>    
                                                      <input type="text" class="form-control" style="padding: 8px;" id="name" name="name" maxlength="10" placeholder="真實姓名" required value="<?php if (isset($c_name)){ echo $c_name; }?>" />
                                                   </div>                                           
                                                   <div class="col-md-6">                                        	
                                                      <label class="label-custom text-left">手機號碼</label>
                                                      <input type="text" class="form-control" style="padding: 8px;" id="mobile" name="mobile" maxlength="10" placeholder="手機號碼" required value="<?php if (isset($c_mobile)){ echo $c_mobile; }?>" />
                                                   </div>                                                      
							                                   </div> 
							                            </div>
							                            <div class="card-body">
                                                <div class="row mb-3">
                                                   <div class="col-md-3">
                                                      <label class="label-custom text-left">收件地址</label>    
                                                      <select id="cityno" name="cityno" class="form-control select-active">
                                            					  <option value="">請選擇縣市 *</option>
                                            					  <?php foreach ($city as $citydata){ ?>
                                            					       <option value="<?=$citydata['cityno']?>" <?=(isset($cityno) && $cityno ==$citydata['cityno'])?'selected':''?>><?=$citydata['citytitle']?></option>
                                            					  <?php } ?>                                 
                                            					</select>
                                                   </div>                                           
                                                   <div class="col-md-3">
                                                   	<label class="label-custom text-left">&nbsp;</label>    
                                                   	  <select class="form-control select-active" name="postal" id="postal">
                                                      <option value="">請選擇行政區 *</option>                                                     
                                       								<?php if (!empty($town) && count($town) > 0){
                                       								          foreach ($town as $towndata){ ?>
                                       								               <option value="<?=$towndata['postal']?>" <?=(isset($c_postal) && $c_postal==$towndata['postal'])?'selected':''?>><?=$towndata['towntitle']?></option>
                                       								<?php     }
                                       								      }
                                       								      ?>
                                       								     </select>
                                       								     <input type="hidden" name="zip" id="zip" value="<?php if (isset($c_postal)){ echo $c_postal; }?>">
                                                   </div>     
                                                   <div class="col-md-6">                                        	
                                                      <label class="label-custom text-left">&nbsp;</label>
                                                      <input type="text" class="form-control" name="c_addr" id="c_addr" value="<?=$c_addr?>" maxlength="60" required placeholder="地址">
                                                   </div>                                           
							                                   </div> 
							                            </div>
							                         </div>   
                                    </div>
                                    <input type="submit" class="btn btn-outline-danger btn-block" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');" value="資料送出">
                                    
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        <?=$this->block_service->load_html_footer(); ?>  
     </div>     
</div>
<script>
$(document).ready(function() { 
   $('#cityno').change(function(){                 
       ChangeCity('cityno','postal','zip','c_addr','','');
   });
   $('#postal').change(function(){                 
       ChangeTown('cityno','postal','zip','c_addr');
   });
   $("#contact-submit").click(function(){         
      check_data();
   });
});


function Form_check(obj){      
        var err=0;
        var errmsg = ''; 
        var focusstr = '';      
    
        if ($('input[name=name]').val() == ''){
            errmsg = '姓名';                
            focusstr = 'name';
        }
        if ($('input[name=mobile]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '手機號碼';                
            if (focusstr ==''){ focusstr = 'mobile'; }
        }     
               
        //if ($('#cityno').val() == '') { 
        //     if (errmsg > ''){ errmsg = errmsg + '\n' }
        //     errmsg = errmsg + '縣巿';                
        //     if (focusstr ==''){ focusstr = 'cityno'; }   
        //}
        //if ($('#postal').val() == '') { 
        //     if (errmsg > ''){ errmsg = errmsg + '\n' }
        //     errmsg = errmsg + '鄉鎮市區';                
        //     if (focusstr ==''){ focusstr = 'postal'; }   
        //}
        if ($('input[name=c_addr]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '地址';                
            if (focusstr ==''){ focusstr = 'c_addr'; }   
        }else{
        	  if ($('input[name=c_addr]').val().length < 10){
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '收件地址未正確輸入';                
                if (focusstr ==''){ focusstr = 'c_addr'; }   
            }
        }      
      
        if (errmsg> ''){
             $('#'+focusstr).focus();
            alert("請輸入收件資料的以下欄位\n\n" + errmsg);            
            return false;
        }else{            
            return true;
	     }
       
}
</script>