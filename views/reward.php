<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
         <div class="section-mini pt-0">

          <div class="section-item text-left d-none d-sm-block">
         
          </div>
		
          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-12" role="main">
                  <h1 class="h2-3d font-libre"><strong>紅利兌換專區</strong></h1>
					<hr class="mt-0 mb-3">
					</div>
				</div>
			  </div>
			  
			  <div class="container mb-3">
				  <div class="row">
					  <div class="col-12 px-0 text-center text-md-right">
						  <h5>您的總點數為：<span class="text-danger font-weight-bold"><?=number_format($mp)?></span> 點</h5>
					  </div>
				  </div>
			  </div>
					

        <div class="container mt100 mb130">
          <div class="slide-body">
			  	 <div class="row">
						<h3 class="mb-3">紅利點數兌換說明</h3>
						<div class="wrapArea">
              <p><?=$remark?></p>
              <p>&nbsp;</p>
              <p class="form-column text-center">
               
              <?php if ($show == 'N'){ ?>
               <form name="LoginForm" method="post" language="javascript" action="<?php echo base_url( 'reward/read' ); ?>">
      			  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					         <div align="center">
					             <input TYPE="button" id="button1" onClick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');document.LoginForm.submit();" class="btn btn-outline-danger btn-lg" value="我同意" />
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
              <?php }else{ ?>
                    <a href="<?=base_url('reward/category')?>" class="btn btn-outline-danger btn-lg">來去兌換</a>
              <?php } ?>    
              </p>
              <br>
             </div>
					</div>
                </div>
              </div>
			<br>

			

                
          </div>
        </div>


      </div>
      <?=$this->block_service->load_html_footer(); ?>            
</div>