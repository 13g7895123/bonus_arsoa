<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
    <div class="section-mini">

          <div class="section-item text-left">
            <!--<div class="article-promo">
              <div class="article-promo-item" style="background:url(img/member_bg.jpg) center; min-height: 20.375rem;">
              </div>
            </div>
			  
			  <div class="breadcrumb"><div class="container">
				  <a href="index.php" title="首頁">首頁</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="javascript:;" title="會員專區">會員專區</a>　<i class="icon ion-ios-arrow-right"></i>　<a href="member_forget.html" title="忘記密碼">忘記密碼</a></div>
				  </div>-->
			  
          </div>
        
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-lg-12 mb130" role="main">
                  <h1 class="h3-3d font-libre"><strong>重設密碼</strong></h1>
                  
                  <hr class="mt-0 mb40">                  
                  <h5 class="mb45"><?=$reset_msg;?></h5>
                  <?php if ( !empty( $error_message ) ): ?>
						          <div class="log-input">
								          <div class="log-input-center" >
                                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                          </div>
						          </div>
                  <?php endif; ?>
                  <form name="oForm" method="post" id="passwordreset-form" language="javascript" action="" class="mb50 wow fadeInUp" data-wow-delay=".3s">
						      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">													      
						      <input name="m" type="hidden" value="<?=$m;?>" />
						      <input name="v" type="hidden" value="<?=$v;?>" />
						         <div class="col-sm-12 mb30">
                       <label class="label-custom">請輸入新密碼</label>
                       <input type="password" name="new_password" class="form-control form-control-custom" maxlength="20" required placeholder="密碼為 6 個字元的英文字母、數字，但不含空白鍵及標點符號。請注意：英文字母大小寫有別。" />
                     </div>
                     <div class="col-sm-12 mb30">
                       <label class="label-custom">請再次輸入您的新密碼</label>
                       <input type="password" name="chk_password" class="form-control form-control-custom" maxlength="20" required placeholder="" />
                     </div>
                    <div class="row">
                    
						           <div class="col-md-12"><input type="submit" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');" class="btn btn-dark btn-block" value="送出"></div>
					  
					           </div>
                  </form>

                </div>
                
              </div>
            </div>
          </div>

        </div>


      </div>

       
      <?=$this->block_service->load_html_footer(); ?>  
</div>


<script language="JavaScript" type="text/JavaScript">
<!--
  function Form_check(obj){
      var cError="很抱歉，您尚未輸入完成！\n\n";
      var bErrorFlag=false;
      var focusObj;    
      if (obj.new_password.value.length == 0){
          cError=cError+" 新密碼\n";
          if ( focusObj == null ) focusObj = obj.new_password;
          bErrorFlag=true;
      }else{
      	  if (obj.new_password.value.length < 6){
             cError=cError+" 新密碼請超過6個字元\n";
             if ( focusObj == null ) focusObj = obj.new_password;
             bErrorFlag=true;
          }
      }
      if (obj.chk_password.value.length == 0){
          cError=cError+" 確認新密碼\n";
          if ( focusObj == null ) focusObj = obj.chk_password;
          bErrorFlag=true;
      }
      if (obj.new_password.value.length > 0 && obj.chk_password.value.length > 0){
          if (obj.new_password.value != obj.chk_password.value){
          	  cError=cError+" 新密碼和確認新密碼不相同\n";
             if ( focusObj == null ) focusObj = obj.new_password;
             bErrorFlag=true;
          }
      }
      if (bErrorFlag){
          alert(cError);
          focusObj.focus();
          return false;
      }
      return true;
}
//-->
</script>