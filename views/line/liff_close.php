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
                     <div class="font-libre">已成功綁定</div>
                   </blockquote>                                                  
                
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
        openw();
}
function openw()
{
 liff.openWindow({
    url: 'https://line.me/R/ti/p/<?=$this->config->item('line_bot_basic_id')?>',
    external: false
 });
 <?php if ($platform == 'mobile'){ ?>
 window.close(); 
 open(location, '_self').close();
 liff.closeWindow();
<?php } ?>
} 
</script>