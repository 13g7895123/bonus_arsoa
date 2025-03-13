<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        
        <div class="section-mini">			
          <div class="section-item text-center">          	
            <div class="container">				   
            	<div class="row justify-content-center">
				       <div class="col-md-12" role="main"> 
                   <h1 class="h2-flash font-abril mb65">安露莎官方Line</h1>
                
                   <blockquote class="blockquote blockquote-status text-center my-3">
                     <div class="font-libre">會員綁定</div>
                   </blockquote>                                                   
                
                   <div class="col-lg-12 text-center">
                       <div style="text-align:center;font-size:24px;vertical-align: middle;word-break: break-all;" id="errormsg">
                          <?php if ($view == 'F'){?>
                           <img src="<?= base_url()?>public/images/loading1.gif">
                          <?php } ?>
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
</div>

<script>
window.onload = function() {
    const defaultLiffId = "<?=$line_liff_url?>";
    let myLiffId = "";
    myLiffId = defaultLiffId;
    initializeLiffOrDie(myLiffId);
};

function initializeLiffOrDie(myLiffId) {
    if(myLiffId) {
        initializeLiff(myLiffId);
    }
}

function initializeLiff(myLiffId) {
    liff
        .init({
            liffId: myLiffId
        })
        .then(() => {
            initializeApp();
        })
        .catch((err) => {

        });
}

function initializeApp() {
   /* if(!liff.isInClient()) {
        alert('請使用Line開啟');
        var liffurl = 'https://line.me/R/ti/p/<?=$this->config->item('line_bot_basic_id')?>';      
        document.location.href=liffurl;
   }
    else
    */
        if(!liff.isLoggedIn()) {        
            liff.login({ redirectUri: "<?= base_url()?>line/liff<?=$dev?>/<?=$query?>/S" });            
        }
        else {  
        	  /*        
            liff.getFriendship().then(data => {                
                if( !data.friendFlag  ) {
                    liff.openWindow({
                        url: 'https://line.me/R/ti/p/<?=$this->config->item('line_bot_basic_id')?>',
                        external: false
                    });
                }
                else {          
                */
                    liff.getProfile().then(function(profile) {       
                        var user = liff.getDecodedIDToken();
                        var email = user.email;
                        
                        $.ajax({
                            type: "POST",
                            url: '<?= base_url()?>line/receive/<?=$dev?>',
                            data: {
	    		                     	"userId" : profile.userId,
	    		                     	"email": user.email,
	    		                     	"query": '<?=$query?>'
	    		                     },
                            dataType: 'json',
                            async: true,
                            beforeSend: function( xhr ) {
                        
                            },
                            success: function(data){                                
                                document.getElementById("errormsg").innerHTML = '<div class="form-group" style="font-size:24px;line-height: 40px;text-align:center;">'+data.msg+'<br><br></div>';
                                var maxs = 0;
                                if (data.success) {
                                    if (data.goline == 'Y'){
                                    	  setTimeout("openw()",5000);
                                    }else{
                                    	  window.location = data.goline;
                                    }    
                                }                                                    
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR);
                            }
                        });
                    }).catch(function(error) {
       
                    });           
              /*  }           
            });*/
      } 
}
function openw()
{
 liff.openWindow({
    url: 'https://line.me/R/ti/p/<?=$this->config->item('line_bot_basic_id')?>',
    external: false
 });
 window.close();
 open(location, '_self').close();
 liff.closeWindow();
} 
</script>