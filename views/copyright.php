<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
        <div class="section-mini">			

          <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">
                <?php if ($web_page == 'member_copyright'){ ?>
                       <div class="col-md-12 mb130 mt-lg-5" role="main">
                <?php }else{ ?>
                       <div class="col-md-9 mb130 mt-lg-5" role="main">
                <?php } ?>
                  <h1 class="h2-3d font-libre"><strong>安露莎版權聲明</strong></h1>                  

                  
                     <?php if ($web_page == 'member_copyright'){ ?>
                        <form name="LoginForm" method="post" language="javascript" action="<?php echo base_url( 'member/copyright' ); ?>">
						            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							 
						            <input type="hidden" name="copyright" value="Y">
                        <div class="col-lg-12 mb130" role="main">
                        <h5 class="text-info">在使用組織專區時請您仔細閱讀本條款，以免觸犯版權（您必須同意才可以使用本區功能）</h5>
                        <br>
                     <?php }else{ ?>
                         <div class="news-info mb30">                    
                         </div>
                         <div class="mb65">    
                     <?php } ?>     
					           <div class="mb65"><?=$remark?></div>
					           <?php if ($web_page == 'member_copyright'){ ?>
					             <div align="center">
					             <input TYPE="button" id="button1" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');document.LoginForm.submit();" class="btn btn-outline-info btn-sm" value="我同意" />
					             &nbsp;
					             <a href="<?=base_url('member/logout')?>" alt="不同意" class="btn btn-outline-info btn-sm"> 不同意</a>
					             </div>
					            </form> 
<script type='text/javascript'>   
var time=10000;//設定倒數10秒   
function DisableEnable(objid){   
    if(time<=0){   
        document.getElementById(objid).disabled=false;   
        document.getElementById(objid).value = "我同意";
    }else{   
        document.getElementById(objid).disabled = true;   
        document.getElementById(objid).value = (time/1000) + "  秒";   
        setTimeout("DisableEnable('" + objid + "')",1000);   
     }   
     time-=1000;    
}   
DisableEnable('button1');
</script> 
					      <?php } ?>
                  </div>

                  <hr class="mt-0 mb70">

                </div>

                <?php if ($web_page != 'member_copyright'){ ?>
                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                 
                 <?=$this->block_service->help_menu('copyright'); ?>
				  
                </aside>
                <?php } ?>
              </div>
            </div>
          </div>

        </div>
      </div>
      
      <?=$this->block_service->load_html_footer(); ?>      
      
</div>