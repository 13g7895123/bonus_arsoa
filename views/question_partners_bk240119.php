<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
        

        <div class="section-mini">

           <div class="section-item text-left">
			  
            <div class="container">
              <div class="row">               
               <div class="col-md-9 mb130 mt-lg-5" role="main">                  
                  <h1 class="h2-3d font-libre"><strong><?=$set_class['p_name']?></strong></h1>
                  <div class="mb30">
                    <div class="container wow fadeInUp" data-wow-delay=".2s">                    
                       <form name="oForm" id="oForm"  method="post" action="<?=base_url('question/partners/'.$p_id)?>"> 
                        <div class="row">                                	
  												<div class="form-group mx-sm-3 mb-2">
  												  <label for="name" class="sr-only">查詢姓名或編號</label>
  												  <input type="text" class="form-control" id="Search" name="Search" placeholder="查詢姓名或編號" value="<?php if (isset($Search)){ echo $Search;} ?>" maxlength="10" >
  												</div>
  												<input type="submit" class="btn btn-primary mb-2" style="height: 46px;" value="搜尋">    											  
  												<span id="check_mobile_msg" style="color:red;margin-top: 8px;margin-left: 10px;"></span>
                        </div>
                        
                        <div class="row" id="form_personal" style="margin-top: 30px;">                           
                        </div>            
                        <div class="card mb-1">
                  
                    <div class="card-body">					  
                      <table class="table table-striped mb-2 text-center">
                        <thead class="thead-dark">
                          <tr>
							              <th width="25%">會員</th>                            
                            <th width="22%">購買日期</th>		
                            <?php if ($set_class['line_push'] == 'Y'){ ?>
							              <th width="23%">最後填寫日期</th>
                            <th width="15%">寄送 / 填寫</th>
                            <?php }else{ ?>
                            <th width="23%">填寫日期</th>
                            <?php } ?>
                            <th width="15%">查看</th>
                          </tr>
                        </thead>
                        <tbody>
                        	<?php 
                        	     $n = 0;
                        	     if ($list['total'] > 0){ 
                        		        foreach ($list['rows'] as $key => $item){ 

                        		        	       $n++;                        		        	       
		                                         if ($n % 2 == 0){
                                                 echo '<tr style="background-color: #eeeeee;">';
                                             }else{
                                                 echo '<tr style="background-color: #E4FBFC;">'; 
                                             }
                                             
                                             ?>
							                                 <td nowrap="nowrap" class="text-center"><?=$item['c_no']?> <?=$item['c_name']?></td>
                                               <td><?=$item['buy_date']?></td>                                               
                                               <?php if ($set_class['line_push'] == 'Y'){ ?>
                                                   <td><?php
                                                   	$showview = false;
                                                   	if ($item['okdt'] > ''){
                                                   	    echo date('Y-m-d H:i',strtotime($item['okdt']));
                                                   	    $showview = true;
                                                   	}else{
                                                   		  if ($item['last_rid'] == ''){
                                                   		  	  echo '尚未寄送';
                                                   		  }else{
                                                   		  	  echo '尚未填寫';
                                                   		  	  $showview = true;
                                                   		  }
                                                   	}?></td>
                                                    <td><?=$item['send_num']?> / <?=$item['ok_num']?>
                                                   	</td>
                                                <?php }else{ ?>
                                                    <td><?php
                                                   	$showview = false;
                                                   	if ($item['okdt'] > ''){
                                                   	    echo date('Y-m-d H:i',strtotime($item['okdt']));
                                                   	    $showview = true;
                                                   	}else{
                                                   		  if ($item['last_rid'] == ''){           
                                                   		  	  if ($set_class['line_push'] == 'Q'){                                        		  	  
                                                   		  	  	  echo '尚未諮詢';
                                                   		  	  }else{
                                                   		  	      echo '尚未電訪';
                                                   		  	  }
                                                   		  }
                                                   	}?></td>
                                                   	</td>
                                                <?php } ?>
                                               	<td>
                                               		<?php if ($showview){ ?>
                                               	     <a href="javascript:void();" onclick="question_reply_div('<?=$n?>');" title="檢視"><i class="fa fa-angle-down fa-lg menu__icon--open"></i></a>
                                               	  <?php } ?>   
                                               	</td>
                                             </tr>		
                                             <tr style="display:none" id="qdiv_<?=$n?>">
                                              <td colspan=5>
                                              	  <div class="card-body">
                                                     <div class="row mb-3">   
                                                     	 <?php if ($item['okdt'] > ''){ ?>
                                                     	    <?php if ($set_class['line_push'] == 'Y'){ ?>
                                                                 <div class="col-md-auto border-right">已寄送</div>
                                                          <?php }elseif ($set_class['line_push'] == 'Q'){ ?>
                                                                 <div class="col-md-auto border-right">已諮詢</div>       
                                                          <?php }else{ ?>
                                                                 <div class="col-md-auto border-right">已電訪</div>
                                                          <?php } ?>
                                                         <div class="col-md-10">
                                                             <ul class="list-inline text-left" style="margin-top: -10px;">
                                                             	<?php foreach ($item['reply'] as $rkey => $ritem){                                                             		             
                                                             		                 if ($rkey > 0){
                                                             		                  	   echo '<br>';
                                                             		                 }
                                                             		                  ?>
                                                                                  <li class="list-inline-item">
                                                                                  	<?php if ($ritem['status'] == 'Y'){ ?>    
                                                                                  	          <span title="寄送時間：<?=date('Y-m-d H:i',strtotime($ritem['crdt']))?>"><?=date('Y-m-d H:i',strtotime($ritem['okdt']))?></span>
                                                                                  	<?php }else{ ?>    
                                                                                  	          <span title="寄送時間：<?=date('Y-m-d H:i',strtotime($ritem['crdt']))?>"><?=date('Y-m-d H:i',strtotime($ritem['crdt']))?></span>
                                                                                  	<?php } ?>    
                                                                                  	&nbsp;
                                                                                  	<?=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ritem['q_title']);?>&nbsp;&nbsp;
                                                                                  	<?php if ($ritem['status'] == 'Y'){ ?>                                                                                  	
                                                                                  	          <a href="javascript:void();" onclick="question_reply_show('<?=$ritem['checkcode']?>','<?=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ritem['q_title'])?>');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a>
                                                                                  	<?php }else{ ?>
                                                                                  	          <font color=red>尚未填寫</font>
                                                                                  	<?php } ?>
                                                                                  </li><?php                                                                                                                                                               
                                                                    } ?>
                                                                 <br>                                                                 
                                                             </ul>
                                                         </div>
                                                      <?php }else{ ?>   
                                                         <div class="col-md-auto border-right">已寄送</div>
                                                         <div class="col-md-10">
                                                             <ul class="list-inline text-left">
                                                             	  寄送時間：<?=date('Y-m-d H:i',strtotime($item['send_date']))?>
                                                             </ul>
                                                         </div>    	
                                                      <?php } ?>   
                                                   </div>
                                                 </div>  
                                              	</td>
                                             </tr>	                                  
                          <?php            
                                  }             
                                }else{          
                          	        echo '<tr><td colspan=5>尚無會員填答</td></tr>';
                          	    } ?>                   
                        </tbody>
                      </table>
                      </div>
                      </div>
			          	   </form>  
			          	
<form name="PageForm" method="post" action="<?=base_url('question/partners/'.$p_id)?>" style="margin-top: -60px;">
  <?php
  echo '<input type="hidden" name="Search" value="'.$Search.'">'; 
  $this->block_service->PJ_ToPageNew("document.PageForm",$PageSize,$Page,$PageCount,$RecordCount)
  ?>  
</form>
               <?php if (isset($member)){ 
               	         $item = $member[0];
               	         $n++;  
               	         ?>
                  <div class="card">
                    <div class="card-body">			
                    	產品購買訪談紀錄		  
                     
                                              	  <div class="card-body">
                                                     <div class="row mb-3">   
                                                     	 <?php if ($item['okdt'] > ''){ ?>
                                                     	    <?php if ($set_class['line_push'] == 'Y'){ ?>
                                                                 <div class="col-md-auto border-right">已寄送</div>
                                                          <?php }elseif ($set_class['line_push'] == 'Q'){ ?>
                                                                 <div class="col-md-auto border-right">已諮詢</div>       
                                                          <?php }else{ ?>
                                                                 <div class="col-md-auto border-right">已電訪</div>
                                                          <?php } ?>
                                                         <div class="col-md-10">
                                                             <ul class="list-inline text-left" style="margin-top: -10px;">
                                                             	<?php foreach ($member as $rkey => $ritem){                                                             		             
                                                             		                 if ($rkey > 0){
                                                             		                  	   echo '<br>';
                                                             		                 }
                                                             		                  ?>
                                                                                  <li class="list-inline-item">
                                                                                  	<?php if ($ritem['status'] == 'Y'){ ?>    
                                                                                  	          <span title="寄送時間：<?=date('Y-m-d H:i',strtotime($ritem['crdt']))?>"><?=date('Y-m-d H:i',strtotime($ritem['okdt']))?></span>
                                                                                  	<?php }else{ ?>    
                                                                                  	          <span title="寄送時間：<?=date('Y-m-d H:i',strtotime($ritem['crdt']))?>"><?=date('Y-m-d H:i',strtotime($ritem['crdt']))?></span>
                                                                                  	<?php } ?>    
                                                                                  	&nbsp;
                                                                                  	<?=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ritem['q_title']);?>&nbsp;&nbsp;
                                                                                  	<?php if ($ritem['status'] == 'Y'){ ?>                                                                                  	
                                                                                  	          <a href="javascript:void();" onclick="question_reply_show('<?=$ritem['checkcode']?>','<?=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $ritem['q_title'])?>');" data-toggle="modal" data-target="#exampleModal"><i class="icon ion-clipboard" style="font-size: 1.1rem;"></i></a>
                                                                                  	<?php }else{ ?>
                                                                                  	          <font color=red>尚未填寫</font>
                                                                                  	<?php } ?>
                                                                                  </li><?php                                                                                                                                                               
                                                                    } ?>
                                                                 <br>                                                                 
                                                             </ul>
                                                         </div>
                                                      <?php }else{ ?>   
                                                         <div class="col-md-auto border-right">已寄送</div>
                                                         <div class="col-md-10">
                                                             <ul class="list-inline text-left">
                                                             	  寄送時間：<?=date('Y-m-d H:i',strtotime($item['send_date']))?>
                                                             </ul>
                                                         </div>    	
                                                      <?php } ?>   
                                                   </div>
                                                 </div>  
                                             
                     </div> 	
                    </div>
               <?php } ?>     
                    
                  </div>	       
                  </div>	        					        
			         </div>			          
               
               <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">					
         				  <?=$this->block_service->member_question_menu($set_class,$qtype,$p_id); ?>  
               </aside>
			        </div>
			      </div>
			    </div>  
			  </div>      	
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
       </div>
     </div>
</div>       
<script>

function question_reply_div(n){    			
    if ($('#qdiv_'+n).is(":hidden")){
        $('#qdiv_'+n).show();    //如果元素為隱藏,則將它顯現
    }else{
        $('#qdiv_'+n).hide();     //如果元素為顯現,則將其隱藏
    }
}	

function question_reply_show(rid,htitle){
    $( ".modal-title" ).html(htitle);
    
    $.ajax({
        url: "<?=base_url('question')?>/question_reply_show/"+rid,                
              type: "GET",
                dataType: "json",                
                success: function(data){
                    $( "#newsmodal_body" ).html(data.html);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}

</script>	


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="font-size:20px;"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size:38px;">&times;</span>
        </button>
		  
      </div>
      <div class="modal-body">
        <div class="newsmodal_body" id="newsmodal_body">
						
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>

<style>
li.list-inline-item > br {
	display: none;
}

</style>