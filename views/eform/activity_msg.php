<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
        <div class="section-mini">			
           <div class="section-item text-center"> 
              <div class="container">
              	 <h3 class="nav-toggle-title"><?=$activity_data['act_title']?></h3>                  
                            <?php if ($activity_data['act_desc'] > ''){ 
                            	  	        echo '<div class="text-center">';
                            	  	        echo $activity_data['act_desc'];
                            	  	        echo '</div>';
                            	  	    }
                            	  ?>
                            <div class="row justify-content-center">                            	  
                                <div class="col-md-9 mb130 mt-lg-5" role="main">
                                    <div class="card mb-3">
                                        <div class="card-body text-info"><h3><?=$msg;?> </h3></div>
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