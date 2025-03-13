<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">
      <div class="wrapper">
        <?=$this->block_service->load_html_header(); ?>

            <div class="section-mini pt-0">

			

          <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130 mt-lg-0" role="main">
                  <h1 class="h2-3d font-libre"><strong>當月販促活動</strong></h1>
				  
				  <?php if (!($list)){  ?>
                  <div class="news-info mb30">                        
                  </div>
                  <div class="mb65">                       
                        <div class="pt-1 pb-1 text-grey fs18"><strong>目前無販促活動！</strong></div>
                  </div>
          <?php }else{ 
          	     // if (1==1 || $this->session->userdata('member_session')['c_no'] == '000000'){
          	           $n = 0;
          	           /*
                       foreach ($list as $key => $item){                                                                             
                                ?>                                      	
		           		             <div class="row border py-3 my-5 mx-0">
		           		           	  <div class="col-md-7 col-sm-12">
		           		           		  <a href="javascript:void(0);" title="<?=$item['title']?>" onclick="show_sale('<?=trim($item["id"])?>','<?=trim($item["title"])?>',<?=$n?>,1,'<?=trim($item['qtext'])?>')"><img src="<?=base_url('public/func/'.$item['field1'])?>" class="img-fluid" alt="<?=$item['title']?>"></a>
		           		           	  </div>
		           		           	  <hr class="d-sm-none w-100">
                                            <div class="col-md-5 col-sm-12">
                                              <h4 class="article-author-name"><?=$item['title']?></h4>
		           		           		  <div class="border-top mt-3 py-2">活動期間：<?=$item['title2']?><br>
		           		           		  <?php
		           		           		    echo date('Y-m-d H:i',strtotime($item['show_stdt']));
		           		           		  	if ($item['show_eddt'] > ''){
		           		           		  		  echo ' ~ ';
		           		           		  		  if (date('Y',strtotime($item['show_eddt'])) == date('Y',strtotime($item['show_stdt']))){
		           		           		  		      echo date('m-d H:i',strtotime($item['show_eddt']));
		           		           		  		  }else{
		           		           		  		  	  echo date('Y-m-d H:i',strtotime($item['show_eddt']));
		           		           		  		  }
		           		           		  	}else{
		           		           		  		  echo ' 起';
		           		           		  	}
		           		           		  	?></div>
		           		           		  <?php if ($item['descr'] > ''){ ?>
		           		           		        <div class="border-top border-bottom mb-3 py-2"><?=str_replace(array("\n"),'<br>',$item['descr'])?></div>
		           		           		  <?php }else{ ?>
		           		           		        <hr class="d-sm w-100">
		           		           		  <?php } ?>
		           		           		  <div class="row">
		           		           		  <div class="col-md-5 col-sm-12 mb-3">	  
		           		           		  <a href="javascript:void(0);" onclick="show_sale('<?=trim($item["id"])?>','<?=trim($item["title"])?>',<?=$n?>,1,'<?=trim($item['qtext'])?>')" class="btn btn-outline-info btn-sm w-100">活動詳情</a>
		           		           		  </div>
		           		           		  <div class="col-md-7 col-sm-12 mb-3">
		           		           		  	  <?php 
		           		           		  	  if (strtotime($item['show_stdt']) <= strtotime(date('Y-m-d H:i:s')) && ($item['show_eddt'] == '' || strtotime($item['show_eddt']) >= strtotime(date('Y-m-d H:i:s')))){ ?>
		           		           		          <a href="javascript:void(0);" onclick="incar('S','<?=trim($item["id"])?>',<?=$n?>);" class="btn btn-outline-danger btn-sm w-100"><i class="icon ion-ios-cart"></i>　放入購物車</a>
		           		           		      <?php
		           		           		      }else{
		           		           		      	  echo "<a href=\"javascript:void(0);\" alt=\"活動尚未開始\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-alert\"></i> 活動尚未開始</a>";
		           		           		      }    ?>
		           		           		  </div>			           		           		  
		           		           		  </div>		           		           		  
                                 </div>
                               </div>
                               <input name="num_<?=$n?>" id="num_<?=$n?>" type="hidden" value="1" maxlength="2">
                       <?php
                                $n++;
                       }  
                       
                       if ($this->session->userdata('member_session')['c_no'] == '000000' || $this->session->userdata('member_session')['c_no'] == '200764'){                       	
                       */
                       	   foreach ($list as $key => $item){  
                       	        ?>                                      	
		           		             <div class="row border py-3 my-5 mx-0">
		           		           	  <div class="col-md-7 col-sm-12">
		           		           		  <a href="javascript:void(0);" title="<?=$item['title']?>" onclick="show_sale('<?=trim($item["id"])?>','<?=trim($item["title"])?>',<?=$n?>,<?=$item['qty']?>,'<?=trim($item['qtext'])?>')"><img src="<?=base_url('public/func/'.$item['field1'])?>" class="img-fluid" alt="<?=$item['title']?>"></a>
		           		           	  </div>
		           		           	  <hr class="d-sm-none w-100">
                                            <div class="col-md-5 col-sm-12">
                                              <h4 class="article-author-name"><?=$item['title']?></h4>
		           		           		  <div class="border-top mt-3 py-2">活動期間：<?=$item['title2']?><br>
		           		           		  <?php
		           		           		    echo date('Y-m-d H:i',strtotime($item['show_stdt']));
		           		           		  	if ($item['show_eddt'] > ''){
		           		           		  		  echo ' ~ ';
		           		           		  		  if (date('Y',strtotime($item['show_eddt'])) == date('Y',strtotime($item['show_stdt']))){
		           		           		  		      echo date('m-d H:i',strtotime($item['show_eddt']));
		           		           		  		  }else{
		           		           		  		  	  echo date('Y-m-d H:i',strtotime($item['show_eddt']));
		           		           		  		  }
		           		           		  	}else{
		           		           		  		  echo ' 起';
		           		           		  	}
		           		           		  	?></div>
		           		           		  <?php if ($item['descr'] > ''){ ?>
		           		           		        <div class="border-top border-bottom mb-3 py-2"><?=str_replace(array("\n"),'<br>',$item['descr'])?></div>
		           		           		  <?php }else{ ?>
		           		           		        <hr class="d-sm w-100">
		           		           		  <?php } ?>
		           		           		  <div class="row">
		           		           		  <div class="col-md-5 col-sm-12 mb-3">	  
		           		           		  <a href="javascript:void(0);" onclick="show_sale('<?=trim($item["id"])?>','<?=trim($item["title"])?>',<?=$n?>,<?=$item['qty']?>,'<?=trim($item['qtext'])?>')" class="btn btn-outline-info btn-sm w-100">活動詳情</a>
		           		           		  </div>
		           		           		  <div class="col-md-7 col-sm-12 mb-3">
		           		           		  	  <?php 
		           		           		  	  if (strtotime($item['show_stdt']) <= strtotime(date('Y-m-d H:i:s')) && ($item['show_eddt'] == '' || strtotime($item['show_eddt']) >= strtotime(date('Y-m-d H:i:s')))){ 
		           		           		  	  	  if ($item['qty'] == 0){
		           		           		  	  	      echo "<a href=\"javascript:void(0);\" class=\"btn btn-outline-secondary btn-sm disabled\">".trim($item['qtext'])."</a>";	
		           		           		  	  	  }else{		           		           		  	  	
		           		           		  	  	      echo "<a href=\"javascript:void(0);\" onclick=\"incar('S','".trim($item["id"])."',".$n.");\" class=\"btn btn-outline-danger btn-sm w-100\"><i class=\"icon ion-ios-cart\"></i>　放入購物車</a>";
		           		           		          }
		           		           		      }else{
		           		           		      	  if ($item['show_eddt'] > '' && strtotime($item['show_eddt']) < strtotime(date('Y-m-d H:i:s'))){
		           		           		      	      echo "<a href=\"javascript:void(0);\" alt=\"活動已結束\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-ios-cart\"></i>　活動已結束</a>";
		           		           		      	  }else{
		           		           		      	      echo "<a href=\"javascript:void(0);\" alt=\"活動尚未開始\" class=\"btn btn-outline-secondary btn-sm disabled\"><i class=\"icon ion-ios-cart\"></i>　活動尚未開始</a>";
		           		           		      	  }    
		           		           		      }    ?>
		           		           		  </div>			           		           		  
		           		           		  </div>
		           		           		  <?php if ($item['qty'] > 0 && ($item['qlvl']	== 1 || $this->session->userdata('member_session')['d_posn'] == 55)){  ?>
		           		           		  	        <div class="mb-3 py-2"><?=trim($item['qtext'])?> <?=$item['qty']?></div>
		           		           		  <?php }?>		           		           		   
                                 </div>
                               </div>
                               <input name="num_<?=$n?>" id="num_<?=$n?>" type="hidden" value="1" maxlength="2">
                            <?php
                                $n++;
                            }  
                      // }
                       /*        	
          	      }else{
          	      ?>
                  <div class="mb65">
					             <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                          <ol class="carousel-indicators" style="margin-bottom: -1rem;">
                             <?php 
                             $n = 0;
                             foreach ($list as $key => $item){                                       
                                      $classstr = '';
                                      if ($n == 0){
                                          $classstr = ' class="active"';
                                      }
                                      ?>
                                      <li data-target="#carouselExampleIndicators" data-slide-to="<?=$n?>"<?=$classstr?>></li>
                             <?php
                                      $n++;
                             } ?>
                          </ol>
                          <div class="carousel-inner">
                          <?php 
                          $n = 0;
                          foreach ($list as $key => $item){                                       
                                   $classstr = '';
                                   if ($n == 0){
                                       $classstr = ' active';
                                   }
                                   ?>
                                   <div class="carousel-item text-center<?=$classstr?>">
							                       <img src="<?=base_url('public/func/'.$item['field1'])?>" class="d-block w-100 mb-2" alt="<?=$item['title']?>">
							                       <a href="javascript:void(0);" onclick="incar('S','<?=trim($item["id"])?>',<?=$n?>);" class="btn btn-outline-danger">放入購物車</a>
                                   </div>
                                   <input name="num_<?=$n?>" id="num_<?=$n?>" type="hidden" value="1" maxlength="2">
                          <?php
                                   $n++;
                          } ?>           
                       </div>
                       <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>                        
                      </div> 
                  </div>
				  <?php   } 
				         */
				       } ?>                
                </div>

                 <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				            <div class="mb75">
                      <?=$this->block_service->member_right_menu('sale'); ?>   
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

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="newsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body" ></div>
      <div class="modal-footer" id="modal_footer">
      </div>
    </div>
  </div>
</div>


<script>
	
function show_sale(sid,stitle,sn,qty,qtext)
{   
    chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');
    
    var params=$('#admin_Form').serialize();     
    console.log(params);        
    $("#modal_title" ).html(stitle);        
    $("#newsmodal").modal('show');    
    $("#modal_body").html('<p><center style="font-size:20px"><img src="'+base_url+'public/images/loading.gif"> 資料讀取中，請稍後。</center></p>');
    if (qty == 0){
        $("#modal_footer").html('<button type="button" class="btn btn-primary disabled">'+qtext+'</button><button type="button" class="btn btn-primary" data-dismiss="modal">關閉</button>');
    }else{
    	  $("#modal_footer").html('<button type="button" class="btn btn-primary" onclick="show_sale_buy(\''+sid+'\','+sn+');">放入購物車</button><button type="button" class="btn btn-primary" data-dismiss="modal">關閉</button>');
    }
    
    $.getJSON(base_url+"sale/detail/"+sid, function(data)
    {
          $( "#modal_body" ).html(data.bodyhtml);           
    
    });   
    
}
function show_sale_buy(sid,sn)
{
    $("#newsmodal").modal('hide');    
    incar('S',sid,sn);
}
</script>