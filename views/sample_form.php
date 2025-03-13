<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        <form class="form-horizontal upload_form" id="oForm" action="<?=base_url('sample/form_save/'.$query)?>" method="post" data-toggle="validator" role="form">    	         	
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="section-mini">			
          <div class="section-item text-center"> 
             <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <h1 class="h2-3d font-libre">
                                        <strong><?=$sample_data['s_title']?></strong>
                                    </h1>
                                    <?php if ($sample_data['s_desc'] > ''){ ?>
                                             <div class="news-info mb30 text-left"><?=$sample_data['s_desc']?></div>
                                    <?php } ?>        
                                    <div class="mb-4">
                                        <div class="container">
                                           <div class="mb-20 text-left">
                                                <h5>請填寫申請索取試用組相關資訊</h5>
                                           </div>
                                        
                                           <div class="row">
                                              <div class="form-group col-md-3">
                                                 <input type="text" class="form-control" required <?=$disabled?> name="uname" id="uname" value="<?php if (isset($params['uname'])){ echo $params['uname'];}?>" maxlength="25" placeholder="姓名 *">
                                              </div>
							                                <div class="form-group col-md-3">
                                                  <div class="custom_select">
                                                      <select class="form-control select-active" <?=$disabled?> name="sex" id="sex" required>
                                                          <option value="">請選擇性別 *</option>
                                                          <option value="女" <?php if (isset($params['sex']) && $params['sex'] == '女'){ echo ' selected'; }?>>女</option>
                                                          <option value="男" <?php if (isset($params['sex']) && $params['sex'] == '男'){ echo ' selected'; }?>>男</option>
                                                      </select>
                                                  </div>
                                              </div>                            
							                                <div class="form-group col-md-3">
                                                   <?php
                                                   $bdisabled = '';
                                                   if ($disabled == ' disabled'){
                                                   	   $bdisabled = 'Y';
                                                   }
							                                	   $dparams = array(
			  	                                                        'TheDateField' => 'bday', 
			  	                                                        'TheDateValue' => (isset($params['bday'])) ? $params['bday'] : '',
			  	                                                        'placeholder'  => '生日 *',
			  	                                                        'class'        => 'form-control',
			  	                                                        'Required'     => 'Y',
			  	                                                        'width'        => 0,
			  	                                                        'disabled'     => $bdisabled
			  	                                                        );			  	                
                                                            $this->ui->PJ_JInputDate('date',$dparams);          
							                                	   ?>
                                              </div>		
                                              <div class="form-group col-md-3">					
                                              	  <input required class="form-control" <?=$disabled?> type="text" name="tel" id="tel" value="<?php if (isset($params['tel'])){ echo $params['tel'];}?>" onKeyUp="value=value.replace(/[^0123456789#-]/g,'')" placeholder="行動電話 *"> 
                                              </div>			  
                                          </div>				
                                                                                       
							                            <div class="row">
							                            	<div class="col-md-6">
							                            		<div class="form-group">
                                                            <div class="custom_select">
                                                                <select id="cityno" name="cityno" <?=$disabled?> class="form-control select-active" required>
                                                                  <option value="">請選擇縣市 *</option>
                                                                  <?php foreach ($city as $citydata){ ?>
                                                                       <option value="<?=$citydata['cityno']?>" <?=(isset($params['city']) && $params['city']==$citydata['citytitle'])?'selected':''?>><?=$citydata['citytitle']?></option>
                                                                  <?php } ?>                                 
                                                                </select>
                                                            </div>
                                                        </div>
							                            	</div>
							                            	<div class="col-md-6">
							                            		<div class="form-group">
                                                            <div class="custom_select">
                                                                <select class="form-control select-active" <?=$disabled?> name="postal" id="postal" required>
                                                                    <option value="">請選擇行政區 *</option>                                                     
                                                        <?php if (!empty($town) && count($town) > 0){
                                                                  foreach ($town as $towndata){ ?>
                                                                       <option value="<?=$towndata['postal']?>" <?=(isset($params['postal']) && $params['postal']==$towndata['postal'])?'selected':''?>><?=$towndata['towntitle']?></option>
                                                        <?php     }
                                                              }
                                                              ?>
                                                                </select>
                                                                <input type="hidden" name="zip" id="zip" value="<?=(isset($params['postal'])) ? $params['postal'] : ''?>">
                                                            </div>
                                                        </div>
							                            	</div>
							                            </div>
                            
                                          <div class="form-group">
                                              <input type="text" class="form-control" <?=$disabled?> name="address" id="address" value="<?=(isset($params['address'])) ? $params['address'] : ''?>" maxlength="60" required placeholder="詳細地址 *">
                                          </div>   
                                          
                                          <div class="mb-20 text-left">
                                                  <h5>
                                                  	<?php if (count($sample_data['sample_data']) > 1){
                                                  		        echo '請選擇試用組';
                                                  		    }else{
                                                  		    	  echo '試用組';
                                                  		    }
                                                    ?></h5>
                                          </div>							
                                          <div class="card bg-light mb-3">                                          	 
                                                <div class="card-body">
                                                   <div class="row mb-2">
                                                       <div class="col-md-12 text-left form-check">
                                                  <?php                                                  
                                                    foreach ($sample_data['sample_data'] as $key => $item){
                                                    	       if ($key > 0){
                                                    	       	   echo '<br>';
                                                    	       }
                                                    	       echo "&nbsp;";
                                                    	       if (count($sample_data['sample_data']) > 1){
                                                    	       	   echo '<input class="form-check-input" type="radio" name="sel_sample" required id="sel_'.$key.'" value="'.$item['title'].'">';
                                                                 echo '<label class="form-check-label" for="sel_'.$key.'">';
                                                    	       }   
                                                    	       echo "&nbsp;";                           
                                                    	       echo $item['title'];                                           
                                                    	       echo '</label>';          	       
                                                    }
                                                  ?>  
                                                      </div>
                                                   </div>                                                
                                                </div>
							                            </div> 
							                            
                                          <?php 
                                             if (substr($query,0,1) == 'S'){ // 業務推薦的 
                                          ?>                                 	
                     	   	                   <div class="mb-20 text-left">
                                                  <h5>推薦人</h5>
                                              </div>							
                                              <div class="row">
                                                <div class="form-group col-md-6">
                                                  <input type="text" class="form-control" <?=$disabled?> required name="referrer_name" id="referrer_name" value="<?=(isset($params['referrer_name'])) ? $params['referrer_name'] : ''?>" maxlength="10" placeholder="推薦人姓名 *">
                                                </div>                            
							                                  <div class="form-group col-md-6">
                                                  <input type="text" class="form-control" <?=$disabled?> required name="referrer_c_no" id="referrer_c_no" value="<?=(isset($params['referrer_c_no'])) ? $params['referrer_c_no'] : ''?>" maxlength="10" placeholder="推薦人會員編號 *">
                                                </div>
							                                </div> 
                     	   	                <?php
                     	   	                  }
                     	   	                ?>
                     	   	                                                             
                                          <div class="row">
						                                 <div class="col-md-12">  
                                                        
                                                        <label for="Privacy" class="custom-checkbox">
                                                        	<input type="checkbox" name="iagree" id="iagree" required value="Y">
                                                        	 &nbsp;
                                                        	 我已閱讀並同意<a class="privacy"
                                                            href="<?=base_url('privacy_policy')?>" target="_blank">安露莎隱私權政策</a>及個資保護聲明內容所有條款。                                                 
                                                        </label>
                                                                            
                                             </div>
				  	                              </div>  
				  	                                                              
                                        </div>
                                    </div>
                                    <hr class="mt-0 mb-4">
                                    <div class="form-group col-md-12" id="error_msg" class="errors"></div>
                                    <?php 
                                          $submit = false;
                                          if (isset($view) && $view){ ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit_preview">內容檢視 無法送出</button>     
                                    <?php }else{  
                                  	          if ($preview){ ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit_preview">後台預覽 無法送出</button>    
                                    <?php    }else{ 
                                    	            $submit = true;
                                    	            ?>
                                                  <button type="button" class="btn btn-outline-danger btn-block" id="contact-submit">送出表單</button>
                                    <?php    } 
                                          }?>      
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
<?php if ($submit){ ?>
<script>
	
function isValidDate(dateString){
        // First check for the pattern

        var regex_date = /^\d{4}\/\d{1,2}\/\d{1,2}$/;
        if (/-/.test(dateString)){        
            regex_date = /^\d{4}-\d{1,2}-\d{1,2}$/;
        }
              
        if(!regex_date.test(dateString)){
            return false;
        }
        
        // Parse the date parts to integers

        var parts   = dateString.split("/");
        if (/-/.test(dateString)){       
            parts   = dateString.split("-");	
        }
        var day     = parseInt(parts[2], 10);
        var month   = parseInt(parts[1], 10);
        var year    = parseInt(parts[0], 10);

        // Check the ranges of month and year

        if( (year < 1000) || (year > 3000) || (month == 0) || (month > 12) ){
            return false;
        }
        
        // Set dates for each month and adjust for leap years

        var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
        if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)){
            monthLength[1] = 29;
        }

        // Check the range of the day

        return day > 0 && day <= monthLength[month - 1];
}	
	
$(document).ready(function () {        

        $('#cityno').change(function(){                 
            ChangeCity('cityno','postal','zip','address','','請選擇行政區 *');
        });
        $('#postal').change(function(){                 
            ChangeTown('cityno','postal','zip','address');
            $('#address').focus();
        });   
       
        //提交前檢查
        $("#contact-submit").click(function () {            
            var focusstr = '';    
            var errmsg = '';   
            var viagree = $("input[name='iagree']").is(":checked");            
            $( "#error_msg" ).html( '' );
            if ($('input[name=uname]').val() == ''){
                errmsg = '姓名';                
                focusstr = 'uname';
            }
            if ($('#sex').val() == '') { 
            	  if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '性別';                
                if (focusstr ==''){ focusstr = 'sex'; }
            }
            if ($('input[name=bday]').val() == ''){
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '生日';                
                if (focusstr ==''){ focusstr = 'bday'; }
            }else{
            	   if( !isValidDate($('input[name=bday]').val()) ){
                     if (errmsg > ''){ errmsg = errmsg + '\n' }
                     errmsg = errmsg + '生日格式有誤';                
                     if (focusstr ==''){ focusstr = 'bday'; }
                 }
            }
            if ($('input[name=tel]').val() == ''){
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '行動電話';                
                if (focusstr ==''){ focusstr = 'tel'; }
            }     
            if ($('#cityno').val() == '') { 
                 if (errmsg > ''){ errmsg = errmsg + '\n' }
                 errmsg = errmsg + '縣巿';                
                 if (focusstr ==''){ focusstr = 'cityno'; }   
            }
            if ($('#postal').val() == '') { 
                 if (errmsg > ''){ errmsg = errmsg + '\n' }
                 errmsg = errmsg + '行政區';                
                 if (focusstr ==''){ focusstr = 'postal'; }   
            }
            if ($('input[name=address]').val() == ''){
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '地址';                
                if (focusstr ==''){ focusstr = 'address'; }   
            }else{
            	  if ($('input[name=address]').val().length < 10){
            	      if (errmsg > ''){ errmsg = errmsg + '\n' }
                    errmsg = errmsg + '地址未正確輸入';                
                    if (focusstr ==''){ focusstr = 'address'; }   
            	  }
            }
            <?php if (count($sample_data['sample_data']) > 1){ ?>
                      if ($('input[name=sel_sample]:checked').val() == undefined){
                      	  if (errmsg > ''){ errmsg = errmsg + '\n' }
                          errmsg = errmsg + '請選擇試用組';                
                          if (focusstr ==''){ focusstr = 'sel_sample'; }   
                      }
            <?php } ?>
                                                  		    
            
            <?php if (substr($query,0,1) == 'S'){ ?>  
            	  if ($('input[name=referrer_name]').val() == ''){
                    if (errmsg > ''){ errmsg = errmsg + '\n' }
                    errmsg = errmsg + '推薦人姓名';                
                    if (focusstr ==''){ focusstr = 'referrer_name'; }   
                }
                if ($('input[name=referrer_c_no]').val() == ''){
                    if (errmsg > ''){ errmsg = errmsg + '\n' }
                    errmsg = errmsg + '會員編號';                
                    if (focusstr ==''){ focusstr = 'referrer_c_no'; }   
                }                  	
            <?php } ?>  	
            
            if (!viagree){
            	   if (errmsg > ''){ errmsg = errmsg + '\n' }
                 errmsg = errmsg + '請閱讀並同意安露莎隱私權政策及個資保護聲明內容所有條款';                
                 if (focusstr ==''){ focusstr = 'iagree'; }   
            }
            if (errmsg> ''){
                $('#'+focusstr).focus();
                alert("請輸入以下欄位\n\n" + errmsg);            
            }else{            
                $.ajax({            
                    url: base_url + "sample/from_save/<?=$query?>",      
                    type: 'POST',
                    data: jQuery('#oForm').serialize(),
                dataType: 'json',
                 success: function(data){	   	    	     		              
	         		               if (data.status){
	         		                   alert(data.errmsg);
	         		                   location.href = data.next_url;
	         		               }else{	     		                   	         		                   
	         		                   $( "#error_msg" ).html( data.errmsg );
	         		                   if (data.focuskey > ''){
	         		                   	   $('#'+data.focuskey).focus();
	         		                   }
	         		                   $('input[name='+csrf_token_name+']').val(getCookie_join("csrf_cookie_name"));	         		                   
	         		               }
	         	             }
	               });
	         }                  
        });        
});
</script>
<?php } ?>