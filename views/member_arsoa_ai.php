<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>
		  
		  
        <div class="section-mini">

         			

          <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-5" role="main">
                  <h1 class="h2-3d font-libre"><strong><?=$meta['title2']?></strong></h1>
				  <p>(註：您必須安裝Adobe Reader 5.0版以上，才可以閱讀此區)</p>
                  <div class="news-info mb30">
                    
                  </div>

                  <div class="mb65">
					<table class="table table-striped mb-5 text-center">
  <thead>
    <tr>
      <th>期別</th>
      <th class="text-left">標題</th>
      <th>下載</th>
      <th>閱讀</th>
    </tr>
  </thead>
  <tbody>
  <?php 
                    if ($list['total'] == 0) {
                        $searchstr = '目前尚無任何資料';
                        echo  "<tr><td colspan=4>".$searchstr."</td></tr>";
                    }else{
		                    $j=0;
		                    foreach ( $list['rows'] as $down ){
			                            $j++;	    
			                            $nn = $j + ($PageSize * ($Page-1))  ;
			                            
			                            $darray = array('do' => 'downfile', 'folder' => 'func', 'id' => $down['id'], 'filename' => $down['field1'], 'filename_old' => $down['field1_name']);
                                  $url_data = base64_encode(json_encode($darray));
                                  $link = base_url('down/file?f='.$url_data);            
			                            ?>
			                       <tr>
                               <td><?=$down['atype']?></td>
                               <td class="text-left"><?=$down['title']?></td>
                               <td><a href="<?=$link?>" target="_blank"><i class="icon ion-document" style="font-size: 1.5rem;"></i></a></td>
                               <td><?php
                               if ($down['body'] > ''){
                                   ?>
                                   <a href="<?=base_url('public/book/'.$down['body']);?>" target="_blank"><i class="icon ion-ios-book" style="font-size: 1.5rem;"></i></a>
                                   <?php
                               }?> 
                               </td>
                             </tr>     
                        <?php
                         }
                    }  
                    ?>    <tr>
  </tbody>
</table>
					  

                  </div>

                  <hr class="mt-0 mb70">
				  
  <?php
  $this->block_service->PJ_ToUrlPageUrl(base_url($Pageurl),$PageSize,$Page,$PageCount,$RecordCount)
  ?>

                  

                </div>


                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				            <div class="mb75">
                    <?=$this->block_service->member_right_menu('love'); ?>   
                      <br><br>
                 <?=$this->block_service->member_right_prdclass(); ?>			
                    </div>
				  
                </aside>
              </div>
            </div>
          </div>

        </div>


      </div>
       <?=$this->block_service->load_html_footer(); ?>  
</div>