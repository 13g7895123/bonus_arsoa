<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
           <?=$this->block_service->load_html_header(); ?>

           <div class="section-mini">

          <div class="section-item text-left">            
          </div>

           <div class="section-item text-left mt-5">
            <div class="container">
				<div class="row mb-3">
					<div class="col-lg-6 px-0 text-center text-md-left py-2 pl-3"></div>
					  
						</div>
              <div class="row">
                <div class="col-md-9 mb130" role="main">
                  <h1 class="h2-3d font-libre mb-0"><strong>商德規範</strong></h1>
                  <div class="news-info mb30"></div>
					<p>(註：您必須安裝Adobe Reader 5.0版以上，才可以閱讀此區)</p>
				    <div class="mb65">
                    <table class="table table-striped mb-5 text-center">
                        <thead>
                        <tr>
                            <th>項次</th>
                            <th class="text-left">文件名稱</th>
                            <th>下載</th>
                          </tr>
                      </thead>
                        <tbody>
                           <?php        
                           if (!empty($admin_law_list)){       
                                   $dn = 0;
                                   foreach ($admin_law_list as $key => $down){     
                                       $dn++;
                                       $darray = array('do' => 'downfile', 'folder' => 'func', 'id' => $down['id'], 'filename' => $down['field1'], 'filename_old' => $down['field1_name']);                                       
                                       $url_data = base64_encode(json_encode($darray));
                                       $link = base_url('down/file?f='.$url_data);            
                              ?>              
                                <tr>
							                    <td><?=$dn?></td>
							                    <td class="text-left"><?=$down['title']?></td>
							                    <td><a href="<?=$link?>" target="_blank"><i class="icon ion-document" style="font-size: 1.5rem;"></i></a></td>
                                </tr>
                             <?php }
                            }   ?>           
                      </tbody>
                      </table>
                  </div>

                  <hr class="mt-0 mb-5">
                    <?=$admin_law['epostbody']?>
				          <hr class="my-5">					

                </div>
              
              <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">                  
				         <?=$this->block_service->member_right_menu('admin'); ?>				   
				         
				         <?=$this->block_service->admin_right_menu('law'); ?>				   
                 
                 <?=$this->block_service->member_right_prdclass(); ?>				  	  
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>