<style>
	.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 0.25rem;
}
.border-right {
    border-right: 1px solid #dee2e6!important;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.text-danger {
    color: #dc3545!important;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}

@media (min-width: 768px){
.col-md-auto {
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    width: auto;
    max-width: 100%;
}
}
.col-md-auto{
    position: relative;    
    padding-right: 15px;
    padding-left: 15px;
}

.modal-title {
    margin-bottom: 0;
    line-height: 1.5;
}
.border-right {
    border-right: 1px solid #dee2e6!important;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}
.modal-content {
    padding: 1rem;
}
.modal-header {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem 1rem;
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}
</style>
<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<div style="width:100%">
  <div style="float:right;">
     
  </div>
  <div><!-- 搜尋機制 S -->    
    <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
     <div style="float:left;">       
       <select class="form-control" name="P_id" id="P_id" style="border-color: #8a6d3b;">
           <option value="" <?php if ($P_id == '' || $P_id == ''){ echo 'selected'; } ?>>全部產品體驗</option>
           <?php foreach ($class as $key => $item){  ?>
                       <option value="<?=$item['p_id']?>" <?php if ($P_id == $item['p_id']){ echo 'selected'; } ?>>(<?=$item['p_id']?>) <?=$item['p_name']?></option>
           <?php } ?>                  
       </select>              
     </div>
     <div style="float:left;margin-left: 5px;">    
       <select class="form-control" name="Follow" id="Follow" style="border-color: #8a6d3b;">
                <option value="" <?php if (!isset($Follow) || $Follow == ''){ echo 'selected'; } ?>>Line 狀態(全部)</option>
                <option value="enable" <?php if (isset($Follow) && $Follow == 'enable'){ echo 'selected'; } ?>>未封鎖</option>
                <option value="disable" <?php if (isset($Follow) && $Follow == 'disable'){ echo 'selected'; } ?>>封鎖</option>           
       </select>              
     </div>  
     <div class="form-group has-warning" style="float:left;margin-left: 5px;">
       <input type="text" name="Search" value="<?php 
           if (isset($Search)){ 
               echo htmlspecialchars($Search);
           } ?>" class="form-control" style="width:200px" placeholder="關鍵字搜尋" />
     </div>     
     <div style="float:left"> &nbsp;     
      <input type="submit" value="查詢" class="btn btn-sm btn-info" style="height:34px"/>	      	
    </div>      
      <?php HIDDEN($this->PATH_INFO,"SearchoForm")?>
    
    </form>
    <!-- 搜尋機制 E -->   
  </div>
</div>

<?php if (isset($errmsg) && $errmsg > ""){ ?>   
   <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>錯誤！</strong>&nbsp;<?php echo $errmsg?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>
<?php if (isset($ok_message) && $ok_message > ""){ ?>   
   <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>成功！</strong>&nbsp;<?php echo $ok_message?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>

<form name="oForm"  method="post" language="javascript" action="<?=$this->PATH_INFO?>" >
<input type="hidden" name="break_bid" id="break_bid" value="0">
<?php HIDDEN($this->PATH_INFO,"oForm",$Search,$Follow,$Page)?>

<div style="width:100%">
<table class="table table-bordered table-striped table-hover">
  <tr class="info">
      <th>序號</th>                  
      <th>會員、Line 資訊和購買資訊</th>   
      <th>推薦人</th>   
      <th>寄送問卷</th>
  </tr>
<!--傳給下一頁的參數-->

<?php

if ($list['total'] == 0) {
    if (isset($Search) && $Search > ''){
        $searchstr = "關鍵字：<font color=red>".htmlspecialchars($Search)."</font>，查詢不到任何資料"; 
    }else{
        $searchstr = '目前尚無任何資料';
    }
    echo  "<tr><td colspan=8>".$searchstr."</td></tr>";
}else{
		$j=0;
		foreach ( $list['rows'] as $rs ){
			          $j++;	
		            $bgclass= ($j % 2 == 0 ? "active" : "warning");  		    
		            
		            ?>
                <tr class="<?php echo $bgclass?>">                               
                <td><?=$rs["hid"]?></td>                 
                <td style="font-family:serif;">      
                      <?php if ($rs["user_id"] > ''){ ?>                      
                      <div style="float:left">
                      	 <span class="btn btn-sm btn-info text-white">
                          暱稱
                          <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                             <?=$rs['display_name']?>
                          </span>                                        
                         </span> 
                      </div>   
                      <div style="float:left;margin-left: 5px;">
                          <a href="<?php echo base_url( 'wadmin/member_line/push/U901/'.$rs['user_id']); ?>" target=_push_line><img width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' alt="推送訊息" border="0" ></a>
                      </div>   
                      <div style="float:left">
                          <?php
                          if($rs['follow'] == 'enable') {
                           //   echo '<span class="btn btn-sm btn-primary text-white">啟用</span>';                                     
                          }
                          else {
                             // echo '<span class="btn btn-sm btn-danger text-white" style="height:36px;font-size: 16px;margin-left: 5px;">封鎖</span>';
                          }                                       
                          ?>                             
                      </div>
                      <div class="clearfix"></div>              
                      <?php } ?>                      
                      <?php           
                      if ($rs["d_pos"] > ''){
                      	    echo '會員編號：'.$rs['c_no'];
                      	    echo '<br>';
                            echo htmlspecialchars($rs["member_c_name"]);
                            echo "（";
                            echo htmlspecialchars($rs["mb_status"]);
                            echo "）";
                            echo '<br>';
                            echo htmlspecialchars($rs["d_pos"])."（".$rs["d_posn"]."）";
                            if ($rs["is_org"] == 0){
                                echo "組織鎖死";
                            }
                            echo '<br>';
                            echo htmlspecialchars($rs["cell1"]);
                            echo '<br>';
                            echo htmlspecialchars($rs["cell2"]);                            
                        }
                        echo '<br>';
                        echo "(".$rs["p_id"]." ".$rs["p_no"].")".$rs["p_name"];
                        echo '<br>';
                        echo '購買日期：';
                        echo $rs["buy_date"];
                      ?>
                  </td>
                  <td style="font-family:serif;">   
                  	    會員編號：<?=$rs['p_c_no']?><br>
                  	    姓名：<?=$rs['p_u_name']?><br>
                  	    位階：<?=$rs['p_d_pos']?><br>
                  </td>	
                  <td style="font-family:serif;">                  	  
                  <?php                          
                      if ($rs['reply']){    	
                           ?>
                           <table class="table table-bordered table-striped table-hover" width=100%>
                           	  <tr class="info" style="background-color: #9999;">
                           	  	<?php if ($rs["line_push"] == 'Y'){ ?>
                                  <th style="background-color: #9999;width:55px;">次數</th>
                                  <th style="background-color: #9999;">問卷</th>
                                  <th style="background-color: #9999;width:140px;">寄送時間</th>
                                  <th style="background-color: #9999;width:140px;">開啟時間</th>
                                  <th style="background-color: #9999;width:140px;">點擊時間</th>
                                  <th style="background-color: #9999;width:140px;">完成時間</th>
                                  <th style="background-color: #9999;text-align:center;width:55px;">檢視</th>
                                <?php }else{ ?>    
                                  <th style="background-color: #9999;">問卷</th>
                                  <th style="background-color: #9999;width:140px;">完成時間</th>
                                  <th style="background-color: #9999;text-align:center;width:55px;">檢視</th>
                                <?php } ?>    
                              </tr>
                           <?php
                           foreach ($rs['reply'] as $qkey => $item){
                           	  ?>
                           	  <tr>
                           	  	<?php if ($rs["line_push"] == 'Y'){ ?>
                           	  	<td align=center>
                           	  		<?=$item['p_num']?>
                           	  	</td>	
                           	  	<?php } ?>
                           	  	<td>
                           	  		(<?=$item['q_id']?>) <?=$item['q_title']?>
                           	  		<?php if ($item['show_web'] == 'N'){ 
                           	  		          echo '&nbsp;&nbsp;<font color=red> 不顯示</font>';
                           	  		      } ?>
                           	  	</td>	
                           	  	<?php if ($rs["line_push"] == 'Y'){ ?>
                           	  	<td align=center><?=$item["crdt"]?></td>
                           	  	<td align=center><?=$item["opdt"]?></td>
                           	  	<td align=center><?=$item["ckdt"]?></td>
                           	  	<?php } ?>
                           	  	<?php 
                           	  		if ($item["okdt"] > ''){
                           	  			  echo '<td align=center>';
                           	  			  echo $item["okdt"];                           	  			  
                           	  			  ?></td>
                           	  		    <td style="font-size:18px;text-align:center;">
                           	  		    	<?php if ($item["okdt"] > ''){  ?>
                           	  		         <a href="javascript:void();" onclick="question_reply_show('<?=$item['rid']?>','(<?=$item['q_id']?>) <?=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $item['q_title'])?>');" data-toggle="modal" data-target="#exampleModal">
                           	  		            <span class="lnr lnr-chart-bars"></span>
                           	  		         </a> 
                           	  		      <?php } 
                           	  		}else{
                           	  			  echo '<td colspan=2 align=center>';
                           	  			  if ($item['msg'] > ''){                           	  			  	
                           	  			      echo '<font color=red>';
                           	  			      echo $item['msg'];
                           	  			      echo '</font>';
                           	  			      echo '&nbsp;&nbsp;';
                           	  			  }
                           	  			 // if ($rs['follow'] == 'enable') {
                           	  		        echo '<span class="btn btn-sm btn-danger text-white" onclick="send_again('.$item['rid'].');" >重新寄送</span>';
                           	  		   // }else{
                           	  		   // 	  echo '<font color=red>會員封鎖無法寄送</font>';
                           	  		   // }
                           	  		}
                           	  		?>       
                           	  		</td>               	  		
                           	  </tr>	
                           	  <?php                     	
                           }
                           echo '</table>';
                      }else{
                      	if ($rs["line_push"] == 'Y'){
                      	   echo '<font color=red>尚未寄送</font>';
                      	}else{
                      		 echo '<font color=red>尚未填寫</font>';
                      	}
                      }
                  ?>      
                </tr>
                <?php }  ?>
</table>
</div>
</form>

<form name="PageForm" method="post" action="<?=$this->PATH_INFO?>">
  <?php
  $this->block_service->PJ_ToUrlPageNew("document.PageForm",$PageSize,$Page,$PageCount,$RecordCount)
  ?>
  <?php HIDDEN($this->PATH_INFO,"PageForm",$Search,$Follow)?>
</form>
<?php } ?>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod,$Search='',$Follow='',$Page=1){
          if ($Mothod != 'PageForm' && $Mothod!='SearchoForm'){  // 不等於分頁和搜尋
              echo '<input type="hidden" name="Page" value="'.$Page.'">';   
          }
          if ($Mothod!='SearchoForm' && $Mothod!='AddoForm'){ // 不等於搜尋和新增
              echo '<input type="hidden" name="Search" value="'.$Search.'">'; 
              echo '<input type="hidden" name="Follow" value="'.$Follow.'">'; 
          }
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>
<script>
function question_reply_show(rid,htitle){
    $( ".modal-title" ).html(htitle);
    
    $.ajax({
        url: "<?=base_url('wadmin/question')?>/question_reply_show/"+rid,                
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
function send_again(id){        
        alertify.set({ buttonReverse: true }); // true, false
        alertify.confirm('確認要重新寄送（寄送時間、開啟時間、點擊時間將清空）？<br><br>', function (e) {  
          if (e) {  
              $.ajax({
                 url: "<?=base_url('wadmin/question/send_again')?>",
                 type:"post",
                 data: {
                      "id":id
                 },
			        dataType:"json",
			           success: function(data){			          
                           alert(data.msg);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.responseText);
                  }
              
              });
          } else {  
           // alertify.log('你按下了 cancel');  
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