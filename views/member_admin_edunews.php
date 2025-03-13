<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
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
                <h1 class="h2-3d font-libre mb-0"><strong>教育訓練情報</strong></h1>
				        <div class="mb65">
                    <table class="table table-striped mb-5 text-center">
                      <thead>
                        <tr>
                            <th>日期</th>
                            <th>星期</th>
                            <th>時間</th>
                            <th>地點</th>
                            <th>課程名稱</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php        
                      $showid = 0;
                      if (empty($class)){       
                           $searchstr = '目前尚無任何訓練情報';
                           echo  "<tr><td colspan=5>".$searchstr."</td></tr>"; 
                      }else{                          
                          foreach ($class as $key => $item){                 
                              if ($showid == 0){
                                  $showid = $item['id']; 
                              }
                              ?>              
                               <tr>
                                 <td><?=$this->block_service->PF_FD($item['d1'])?></td>
                                 <td><?=$this->block_service->get_chinese_weekday($item['d1'])?></td>
                                 <td><?=$item['field1']?></td>
                                 <td class="text-left"><?=$item['descr']?></td>
                                 <td class="text-left"><a href="javascript:void(0);" onclick="eduinfo(<?=$item['id']?>);" title="<?=$item['title']?>"><?=$item['title']?></a></td>
                               </tr>
                             <?php }
                       }?>                                 
                      </tbody>
                      </table>
                  </div>                 
			            <div id="edunews_info"></div>
                </div>
                <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
                  <div class="mb75">
                    <?=$this->block_service->member_right_menu('admin'); ?>   
                    
				            <?=$this->block_service->admin_right_menu('edunews'); ?>				   
                 
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
<script>
function eduinfo(id){
  	$.ajax({
	     url: base_url + "member_admin/edunews_info/"+id,
		   type: "GET",
		   dataType: "json",	     	      
       success: function(data){	              
		     //  console.log(data.status);		       
		       if (data.status == '1'){
			         $('#edunews_info').html( data.html );
			     }else{
			         $('#edunews_info').html( data.errmsg );
			     }
		   }
	  });
}
<?php if ($showid > 0){ ?>
eduinfo(<?=$showid?>);  
<?php } ?>
</script>