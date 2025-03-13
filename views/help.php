<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
        <div class="section-mini">			

             <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5" role="main">
                  <h1 class="h2-3d font-libre"><strong>問與答</strong></h1>
                  <div class="news-info mb30">
                    
                  </div>

                  <div class="mb65">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                      <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#menu1"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",1)?></a> </li>
					            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu2"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",2)?></a> </li>
                      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu3"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",3)?></a> </li>
                      <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu4"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",4)?></a> </li>
					  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#menu5"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",5)?></a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">                      
                    <?php for ($i = 1;$i<=5;$i++){ ?>
                      <div class="tab-pane container active" id="menu<?=$i?>">
                        <div class="mb65 mt30">
                          <h3 class="mb-3"><?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/問題類型/KIND/傳回值","資料",$i)?></h3>
                          <div id="accordion">
                            <?php foreach ($help[$i] as $key => $item){ ?>
                               <div class="card">
                                 <div class="card-header" id="headingOne">
                                   <h5 class="mb-0">
                                     <button class="btn btn-link pl-0" data-toggle="collapse" data-target="#collapse_<?=$item['id']?>" aria-expanded="true" aria-controls="collapse_<?=$item['id']?>">
                                     <?=$item['title']?></button>
                                   </h5>
                                 </div>
                                 <div id="collapse_<?=$item['id']?>" class="collapse" aria-labelledby="heading_<?=$item['id']?>" data-parent="#accordion">
                                   <div class="card-body">
						         	              <?=$item['body']?>
						         	             </div>
                                 </div>
                               </div>
                            <?php } ?>  
                          </div>
                        </div>
                      </div>  
                    <?php } ?>    
                   
                   
                    </div>
					  
					  
					  

                  </div>
                  <hr class="mt-0 mb70">
				  
                </div>
                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">                 
                 <?=$this->block_service->help_menu('help'); ?>				  
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>      
      <?=$this->block_service->load_html_footer(); ?>            
</div>