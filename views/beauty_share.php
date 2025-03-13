<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>

        <div class="section">
  <div class="section-item">
    <div class="container wow fadeInUp" data-wow-delay=".2s">
      <h3 class="fs36 mb120">我要分享</h3>
      <form name="oform" id="oform" class="text-left" method="post" action="<?=base_url('beauty/save')?>" autocomplete="off" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="row">
          <div class="col-sm-4 mb30">
            <label class="label-custom">暱稱</label>
            <input type="text" name="nickname" id="nickname" class="form-control form-control-custom" value="" maxlength="10" placeholder="限10字元" />
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">真實姓名</label>
            <input type="text" name="uname" id="uname" class="form-control form-control-custom" value="" maxlength="20" placeholder="您的真實姓名" />
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">性別</label>
            <select name="sex" id="sex" class="form-control form-control-custom">
              <option value="">請選擇…</option>
			     	<?php
					$sex_list = "";
					foreach ($set['sex'] as $value) {
						$sex_list .= "<option value=\"".$value."\"";
						if ($sex==$value) $sex_list .= " selected";
						$sex_list .= ">".$value."</option>\n";
					}
					echo $sex_list;
				?>
            </select>
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">年齡</label>
            <input type="text" name="age" id="age" class="form-control form-control-custom" value="" maxlength="2" onKeyUp="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g, '')" placeholder="限填數字" />
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">電子信箱</label>
            <input type="text" name="email" id="email" class="form-control form-control-custom" value="" maxlength="100" />
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">職業</label>
            <select name="job" id="job" class="form-control form-control-custom">
              <option value="">請選擇…</option>
              <?php
				      	$job_list = "";
				      	foreach ($set['job'] as $value) {
				      		$job_list .= "<option value=\"".$value."\"";
				      		if ($job==$value) $job_list .= " selected";
				      		$job_list .= ">".$value."</option>\n";
				      	}
				      	echo $job_list;
				      ?>
            </select>
          </div>
          <div class="col-sm-12 mb30">
            <label class="label-custom">地址</label>
            <div class="zipcode">
            <select id="cityno" name="cityno" class="form-control form-control-custom mr-4 city" required="required">
                            <option value="">縣巿</option>
                            <?php foreach ($city as $citydata){ ?>
                                 <option value="<?=$citydata['cityno']?>" <?=($params['cityno']==$citydata['cityno'])?'selected':''?>><?=$citydata['citytitle']?></option>
                            <?php } ?>                                 
                          </select>                    
                          <select name="postal" id="postal" class="form-control form-control-custom mr-4 area">
                            <option value="">鄉鎮市區</option>                                                     
                            <?php if (count($town) > 0){
                                      foreach ($town as $towndata){ ?>
                                           <option value="<?=$towndata['postal']?>" <?=($params['postal']==$towndata['postal'])?'selected':''?>><?=$towndata['towntitle']?></option>
                            <?php     }
                                  }
                                  ?>                   
                          </select>                 
                          <input type="text" name="zip" id="zip" maxlength="3" readonly class="form-control form-control-custom zip" placeholder="郵遞區號">
             </div>              
            <input type="text" name="address" id="address" class="form-control form-control-custom mt-4" value="" maxlength="100" placeholder="街道" />
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">膚質</label>
            <select name="skin" id="skin" class="form-control form-control-custom">
              <option value="">請選擇…</option>
              	<?php
			        		$skin_list = "";
			        		foreach ($set['skin'] as $value) {
			        			$skin_list .= "<option value=\"".$value."\"";
			        			if ($skin==$value) $skin_list .= " selected";
			        			$skin_list .= ">".$value."</option>\n";
			        		}
			        		echo $skin_list;
			        	?>
            </select>
          </div>
          <div class="col-sm-8 mb30">
            <label class="label-custom">使用效果</label>
			    <?php
				$i = 1;
				$effect_list = "";
				foreach ($set['effect'] as $value) {
					$effect_list .= "
					<div class=\"form-check form-check-inline\">
					  <input name=\"effect[]\" class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox".$i."\" value=\"".$value."\"";
					  //foreach ($set['effect'] as $value2) if ($value2==$value) $effect_list .= " checked=\"checked\" ";
					   $effect_list .= ">
					  <label class=\"form-check-label\" for=\"inlineCheckbox".$i."\">".$value."</label>
					</div>";
					$i++;
				}
				echo $effect_list;
			  ?> </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">推薦品牌</label>
            <select name="prd_class1" id="prd_class1" class="form-control form-control-custom">
              <option value="">請選擇品牌…</option>
              <?php foreach ($class as $item){ ?>
				                <option value="<?=$item['classid']?>"><?=$item['classtitle']?></option>
				      <?php } ?>          
            </select>
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">&nbsp;</label>
            <div id="pid_list">
                <select name="prd_class2" id="prd_class2" class="form-control form-control-custom">
                  <option value="">請選擇商品…</option>
                </select>
            </div>
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">上傳圖片(檔案格式：<span class="text-danger">jpg, jpeg</span>)</label>			
                <div class="row mb-2">
                  <div class="col-12">
                    <div class="custom-file">
                      <input type="file" name="files1" id="files1" accept=".jpg,.jpge">
                      
                    </div>
                  </div>
                </div>                
          </div>
          <div class="col-sm-12 mb30">
            <label class="label-custom">主旨</label>
            <input type="text" name="subject" id="subject"  class="form-control form-control-custom" value="" maxlength="20" placeholder="主旨" />
          </div>
          <div class="col-sm-12 mb30">
            <label class="label-custom">分享內容</label>
            <textarea name="content" id="content"  rows="9" cols="30" class="form-control form-control-custom" placeholder="請輸入內容，限300字內" maxlength="300"></textarea>
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">驗證碼</label>
            <input name="ct_captcha" id="ct_captcha"  type="text" class="form-control form-control-custom" value="" maxlength="6">
          </div>
          <div class="col-sm-4 mb30">
            <label class="label-custom">點按驗證碼圖像可換另一組驗證碼</label>
            <img id="siimage" style="border: 1px solid #000; margin-right: 15px;cursor:pointer" src="" alt="CAPTCHA Image" class="getsecurimage" align="left" />            
          </div>
        </div>
        <div class="col-sm-12 mb30">
	         <?=$remark['epostbody']?>           
            <hr>
        </div>
        <div class="mt40 text-center">
          <button type="button" class="btn btn-link fs18 text-black text-underline mr-4" id="contact-submit">送出分享</button>
          <button type="button" class="btn btn-link fs18 text-black text-underline" onClick="location.href='<?=base_url('beauty')?>'">其他美麗分享</button>
        </div>
        <input type="hidden" name="action" value="Share" />
      </form>
    </div>
  </div>
</div>
  </div>
       
      <?=$this->block_service->load_html_footer(); ?>  
</div>

<script>
$(document).ready(function() {
	// init controller
	var controller = new ScrollMagic.Controller();
	
	// build scenes
	new ScrollMagic.Scene({triggerElement: '.section-mini', triggerHook: 1, duration: '200%'})
		  .setTween('.article-promo-item', {backgroundPosition: '50% 100%', ease: Linear.easeNone})
		  .addTo(controller);	
});
</script>
<script language="javascript">
$(document).ready(function() { 
   $('#cityno').change(function(){                 
       ChangeCity('cityno','postal','zip','address','');
   });
   $('#postal').change(function(){                 
       ChangeTown('cityno','postal','zip','address');
   });
   $('#prd_class1').change(function(){                 
       Changeprd_class1();
   });   
   $("#contact-submit").click(function(){     
      check_data();
   });
});

function Changeprd_class1()
{
        $('#prd_class2').empty().append($('<option></option>').val('').text('請選擇商品…'));        
        var prd_class1 = $.trim($('#prd_class1 option:selected').val());        
        if (prd_class1.length != 0)
        {
            $.getJSON('<?=base_url('base/prd_class2/')?>'+ prd_class1, function(data)
            {
                $.each(data, function(i, item){
                    $('#prd_class2').append($('<option></option>').val(item.classtitle).text(item.classtitle));
                });
            });      
        }
}

$(document).ready(function(){    	
	$(document).on("click", '.getsecurimage', function() {			
		loc = '<?=base_url('base/securimage_jpg')?>?'+new Date().getTime(); 	
		$('#siimage').attr('src',loc); 		
		return false;		
	});	
	$.ajax({
		url: base_url + "base/ini_se",
		type: "GET",
		datatype:"text",
		success: function(data){
			$('.getsecurimage').click();
		}
	});
});	

function check_data() {   
        var err=0;
        var errmsg = ''; 
        var focusstr = '';      
        if ($('input[name=nickname]').val() == ''){
            errmsg = '暱稱';                
            focusstr = 'nickname';
        }
        if ($('input[name=uname]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '真實姓名';                
            if (focusstr ==''){ focusstr = 'uname'; }
        }     
        if ($('#sex').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '性別';               
             if (focusstr ==''){ focusstr = 'sex'; } 
        }
        if ($('input[name=age]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '年齡';                
            if (focusstr ==''){ focusstr = 'age'; } 
        }  
        if ($('input[name=email]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '電子信箱';            
            if (focusstr ==''){ focusstr = 'email'; }   
        }else{
            if(!/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( $('input[name=email]').val() )){
               if (errmsg > ''){ errmsg = errmsg + '\n' }
               errmsg = errmsg + '電子信箱格式有誤';      
               if (focusstr ==''){ focusstr = 'email'; }             
            }
        } 
        if ($('#job').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '職業';                
             if (focusstr ==''){ focusstr = 'job'; }   
        }
        if ($('#cityno').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '縣巿';                
             if (focusstr ==''){ focusstr = 'cityno'; }   
        }
        if ($('#postal').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '鄉鎮市區';                
             if (focusstr ==''){ focusstr = 'postal'; }   
        }
        if ($('input[name=address]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '地址';                
            if (focusstr ==''){ focusstr = 'address'; }   
        }
        if ($('#skin').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '膚質';                
             if (focusstr ==''){ focusstr = 'skin'; }   
        }
        if ($("input[name='effect[]']:checked").length==0) {
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '使用效果';        
             if (focusstr ==''){ focusstr = 'inlineCheckbox1'; }   
        }
        if ($('#main_pid').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '品牌';                
             if (focusstr ==''){ focusstr = 'main_pid'; }   
        }
        if ($('#pid').val() == '') { 
             if (errmsg > ''){ errmsg = errmsg + '\n' }
             errmsg = errmsg + '商品';                
             if (focusstr ==''){ focusstr = 'pid'; }   
        }      
	      if (document.getElementById("files1").value.length==0) {
	     	     //msg = msg + "請上傳圖片\n";
	      } else {
	     	   var filelimit = /\.(jpg|jpeg)$/i;
	     	   var filesize = 1048576 * 5;	//5MB
	     	   if (!filelimit.test(document.getElementById("files1").value)) { errmsg = errmsg + "圖片-檔案格式應為jpg, jpeg\n"; }
	     	   if (document.getElementById("files1").files[0].size>filesize) { errmsg = errmsg + "圖片-檔案大小不得大於" + (filesize/1048576) + "MB\n"; }		
	      }        
        if ($('input[name=subject]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '主旨';              
             if (focusstr ==''){ focusstr = 'subject'; }    
        }
        if ($('input[name=content]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '分享內容';                
            if (focusstr ==''){ focusstr = 'content'; }    
        }
        if ($('input[name=ct_captcha]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '驗證碼';                
            if (focusstr ==''){ focusstr = 'ct_captcha'; }    
        }
        if (errmsg> ''){
             $('#'+focusstr).focus();
            alert("請輸入以下欄位\n\n" + errmsg);            
        }else{
            var formData = new FormData($('#oform')[0]);             
                $.ajax({
                url: base_url + "beauty/save",        
                type: "POST",
                dataType: "json",
	     	            data: formData, cache: false,contentType: false, 	
	     	     processData: false,
            success: function(data){	   	    
	     		               console.log(data);
	     		               if (data.status){
	     		                   location.href = base_url+'webmsg/SHARE';
	     		               }else{
	     		                   alert(data.errmsg);
	     		                   $('input[name=<?php echo $this->security->get_csrf_token_name(); ?>]').val(getCookie("csrf_cookie_name"));	     		               
	     		                   loc = '<?=base_url('base/securimage_jpg')?>?'+new Date().getTime(); 	
		                         $('#siimage').attr('src',loc); 		
	     		                   $('input[name=ct_captcha]').val('');
	     		               }
	     	             }
	          });
	     }
       
}
</script>