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
				  
                  <div class="mb65">
					<table class="table table-striped mb-5 text-center">
  <thead>
    <tr>      
      <th class="text-left">日期</th>
      <th class="text-left">標題</th>
    </tr>
  </thead>
  <tbody>
  <?php 
                    if ($list['total'] == 0) {
                        $searchstr = '目前尚無任何資料';
                        echo  "<tr><td colspan=4>".$searchstr."</td></tr>";
                    }else{
		                    $j=0;
		                    foreach ( $list['rows'] as $item ){
			                            $j++;	    
			                            $nn = $j + ($PageSize * ($Page-1))  ;			                            
			                            ?>
			                       <tr>                               
			                      <td class="text-left"><?=$this->block_service->PF_FD($item['begindate'])?></td>  
                               <td class="text-left"><a href="<?=base_url('member/info/news/'.$item['id'])?>" title="<?=$item['title']?>"><?=$item['title']?></a></td>                               
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
                    <?=$this->block_service->member_right_menu('dm_download'); ?>   
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