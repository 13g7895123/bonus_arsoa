<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
          <div class="section-mini">

          <div class="section-item text-left">
           
          </div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 mb130" role="main">
                  <h1 class="h3-3d font-libre"><strong>加入會員方式</strong></h1>
                  
                  <hr class="mt-0 mb40">
					
					<div class="progress-item wow fadeInRight" data-wow-delay=".2s" style="border-top: 0;">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="progress-item-num font-libre">1.</div>
                    </div>
                    <div class="col-sm-9">
                      <div class="progress-item-title">透過官方Line聯繫加入</div>
                      <div class="fs18 text-grey">加入、聯繫安露莎官方Line，我們將傳送表格資料給您並協助您加入。</div>
						
					<div class="row text-center mt-5">
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/20yearsold.png"></button>
						  </div>
                        <div class="project-info-descr">年滿20歲</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
                        <?php if (FC_Line > ''){ ?>
                              <a href="<?=FC_Line?>" target="_blank">
                        <?php } ?>
							<button class="like-btn" data-toggle="modal" data-target="#arsoaline"><img src="<?=base_url()?>public/images/arsoaline.png"></button>
							<?php if (FC_Line > ''){ ?>
                              </a>
                        <?php } ?>
						  </div>
                        <div class="project-info-descr">按我加入官方Line</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/writedown.png"></button>
						  </div>
                        <div class="project-info-descr">填寫申請書回傳</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/arsoa_join.png"></button>
						  </div>
                        <div class="project-info-descr">加入安露莎會員</div>
                      </div>
                    </div>
                  </div>
                    </div>
                  </div>
                </div>
				
				<div class="progress-item wow fadeInRight" data-wow-delay=".2s">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="progress-item-num font-libre">2.</div>
                    </div>
                    <div class="col-sm-9">
                      <div class="progress-item-title">填寫下方表單加入</div>
                      <div class="fs18 text-grey">送出資料後，我們會寄一封附有「加入申請書」的信到您的電子信箱，請您點選裡面的連結下載表單單印出填寫，因此，請確認信箱是否填寫正確。</div>
						
					<div class="row text-center mt-5">
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/20yearsold.png"></button>
						  </div>
                        <div class="project-info-descr">年滿20歲</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
							<button class="like-btn"><img src="<?=base_url()?>public/images/phoneform.png"></button>
						  </div>
                        <div class="project-info-descr">填寫下方表單<br>送出後收到E-mail</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/writedown.png"></button>
						  </div>
                        <div class="project-info-descr">填寫申請書回傳</div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="project-info-item">
                        <div class="project-info-title">
						  <button class="like-btn"><img src="<?=base_url()?>public/images/arsoa_join.png"></button>
						  </div>
                        <div class="project-info-descr">加入安露莎會員</div>
                      </div>
                    </div>
                  </div>
						
                    </div>
                  </div>
                </div>

                <form name="oForm" id="oForm" method="post" language="javascript" action="<?php echo base_url( 'member/join' ); ?>" class="clearfix">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
                    <fieldset>
                        <label for="uname"><small>＊</small>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label>
                        <input type="text" name="uname" id="uname" value="<?=$params['uname']?>" maxlength="25" placeholder="您的真實姓名">
                      </fieldset>
                    <fieldset>
                        <label for="mobile"><small>＊</small>手機號碼</label>
                        <input type="text" name="mobile" id="mobile" value="<?=$params['mobile']?>" maxlength="10" onkeyup="this.value=this.value.replace(/\D/g,'');" onafterpaste="this.value=this.value.replace(/\D/g, '')" placeholder="格式為09XXXXXXXX">
                      </fieldset>
                    <fieldset>
                        <label for="tel"><small></small>電&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;話</label>
                        <input type="text" name="tel" id="tel" value="<?=$params['tel']?>" maxlength="30" placeholder="格式如07-XXXXXXXX">
                      </fieldset>
                    <fieldset>
                        <label for="email"><small>＊</small>電子信箱</label>
                        <input type="text" name="email" id="email" value="<?=$params['email']?>" maxlength="100">
                      </fieldset>
                    <fieldset>
                        <label for="address"><small>＊</small>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址</label>
                        <div class="zipcode select-column3">
                          <select id="cityno" name="cityno" class="city" required="required">
                            <option value="">縣巿</option>
                            <?php foreach ($city as $citydata){ ?>
                                 <option value="<?=$citydata['cityno']?>" <?=($params['cityno']==$citydata['cityno'])?'selected':''?>><?=$citydata['citytitle']?></option>
                            <?php } ?>                                 
                          </select>
                          <select name="postal" id="postal" class="area">
                            <option value="">鄉鎮市區</option>                                                     
                            <?php if (!empty($town) && count($town) > 0){
                                      foreach ($town as $towndata){ ?>
                                           <option value="<?=$towndata['postal']?>" <?=($params['postal']==$towndata['postal'])?'selected':''?>><?=$towndata['towntitle']?></option>
                            <?php     }
                                  }
                                  ?>                   
                          </select> 
                          <input type="text" name="zip" id="zip" maxlength="3" readonly class="zip" value="<?=$params['postal']?>"  placeholder="郵遞區號">
                      </div>
                      </fieldset>
                    <fieldset>
                        <input type="text" name="address" id="address" value="<?=$params['address']?>" maxlength="60" placeholder="街道地址">
                      </fieldset>
                  
                    <div class="form-column">
                        <label for="ifMessage">以上填寫內容，會紀錄在此電腦　
                        <input type="radio" name="savejoindata" value="Y" checked="checked">
                        YES　
                        <input type="radio" name="savejoindata" value="N">
                        NO </label>
                      </div>
                    <?php if (1==2){ ?>
                      <p class="form-column">
                        <input type="checkbox" name="iagree" id="iagree" value="Y">
                        <label for="IAgree">我同意<a href="<?php echo base_url( 'copyright' ); ?>" target="_blank"  class="button-terms">會員條款</a>及<a href="<?php echo base_url( 'privacy_policy' ); ?>" target="_blank" title="隱私權政策">隱私權政策</a></label>
                      </p>
                    <?php } ?>
                    <p></p>
                    <input type="button" id="contact-submit" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');" class="form-button1 btn btn-block btn-outline-danger" value="送出">
                  </form>

                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <?=$this->block_service->load_html_footer(); ?>  
</div>
<script>
$(document).ready(function() { 
   $('#cityno').change(function(){                 
       ChangeCity('cityno','postal','zip','address','');
   });
   $('#postal').change(function(){                 
       ChangeTown('cityno','postal','zip','address');
   });
   $("#contact-submit").click(function(){     
      check_data();
   });
});
function check_data() {          
        var err=0;
        var errmsg = ''; 
        var focusstr = '';      
    
        if ($('input[name=uname]').val() == ''){
            errmsg = '暱稱';                
            focusstr = 'uname';
        }
        if ($('input[name=mobile]').val() == ''){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '手機號碼';                
            if (focusstr ==''){ focusstr = 'mobile'; }
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
        /*
        if (typeof($('input[name=iagree]:checked').val()) === "undefined"){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '未同意會員條款';                
            if (focusstr ==''){ focusstr = 'iagree'; }   
        }
        */
        if (errmsg> ''){
             $('#'+focusstr).focus();
            alert("請輸入以下欄位\n\n" + errmsg);            
        }else{            
            $.ajax({            
                url: base_url + "member/join_save",      
                type: 'POST',
                data: jQuery('#oForm').serialize(),
            dataType: 'json',
             success: function(data){	   	    
	     		              // console.log(data);
	     		               if (data.status){
	     		                   location.href = base_url+'webmsg/JOIN';
	     		               }else{
	     		                   alert(data.errmsg);
	     		               }
	     	             }
	           });
	     }
       
}
</script>