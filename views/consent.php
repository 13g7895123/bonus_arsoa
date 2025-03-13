<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        <form class="form-horizontal upload_form" name="oForm" id="oForm" method="post" action="<?=base_url('consent/save/'.$charge_data['checkcode'])?>" data-toggle="validator" role="form">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="section-mini">			
          <div class="section-item text-center"> 
             <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <h1 class="h2-3d font-libre">
                                        <strong><?=$consent_data['c_title']?></strong>
                                    </h1>
                                    <div class="news mb10 text-left" style="text-align: left;font-size:18px;">親愛的 <?=$this->session->userdata('line_display_name')?> 您好：</div>
                                    <?php if ($consent_data['c_desc'] > ''){ ?>
                                        <div class="news mb10 text-left" style="text-align: left;font-size:18px;"><?=$consent_data['c_desc']?></div>
                                    <?php } ?>
                                    <div class="mb-4">
                                    	
                                    	    <div class="col-md-12" style="border:1px #ccc solid;padding: 20px;text-align: left;">
                                                      <p><?=str_replace(array("\n"),'<br>',$consent_data['c_body'])?></p>
                                          </div>                                                      						                                  
							                            <div style="margin-top: 18px;">
							                              <input type="checkbox" value='Y' name="agree" id="agree" required>   <?=$consent_data['c_config']['agree_desc']?>
							                            </div>
                                    </div>
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
                                                  <input type="submit" id="contact-submit" class="btn btn-outline-danger btn-block" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');" value="同意送出">
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
<script>
<?php if ($submit){ ?>	
var btn = document.querySelector("#contact-submit"); // 選取你的按鈕
let countDown = 30; // 設定倒數的秒數

btn.disabled = true; // 首先使按鈕失效
$("#contact-submit").val(''+countDown+'秒後才可以按同意'); // 設定按鈕的文字

let countDownInterval = setInterval(() => {
  countDown--; // 每秒減少倒數的秒數
  if (countDown > 0) {
    $("#contact-submit").val(''+countDown+'秒後才可以按同意'); // 設定按鈕的文字
  } else {
    clearInterval(countDownInterval); // 如果倒數已經結束，則清除間隔並恢復按鈕的狀態    
    $("#contact-submit").val('同意送出');
    btn.disabled = false;
  }
}, 1000); // 每1000毫秒（即1秒）執行一次

<?php } ?>
</script>