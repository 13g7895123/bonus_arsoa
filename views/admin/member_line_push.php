<style>
.log_list{
  padding: 2px;
  margin-top: -5px;
  background: #EDF5FA;
  width:100%;
  -webkit-box-shadow:inset 0 0 5px rgba(0,0,0,0.2);
  overflow:auto;
  height:400px;
  scrollbar-width:thin;
  scrollbar-color: blue orange; 
  overflow-y:scroll; 
}  
</style>

<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind); ?>
  </div> 
  <div class="tab-pane active" id="horizontal-form">  
       	    		
		<table class="table table-bordered table-striped table-hover">      
      <tr>
      	  <th width="120" class="info">Line 資訊</th>
                  <td width="38%" style="font-family:serif;">
                  	     
                                <div style="float:left">
                                	   <img src='<?=$rs['picture_url']?>' width='120px' onerror="this.src='<?=base_url('public/images/line_404.png')?>'">                                  
                                </div>
                                <div style="float:left;margin-left: 5px;">
                  	                <!--
                  	                <input type="image" value="推送訊息" width="140" src='<?=base_url('public/images/linebutton_84x20_zh-hant.png')?>' onclick="javascript:action='<?php echo base_url( 'wadmin/member_line/push/'.$kind.'/'.$rs["line_user_user_id"]); ?>';submit();" alt="推送訊息" border="0" >                                                        	  
                  	                <br>
                  	                -->
                  	                <span class="btn btn-sm btn-info text-white">
                                        暱稱
                                        <span style="background-color: #ffffff;color:#222222;margin-left: 5px;border-radius:3px;padding:5px;">
                                           <?=$rs['display_name']?>
                                        </span>                                        
                                    </span> 
                                    <?php
                                    if($rs['follow'] == 'enable') {
                                     //   echo '<span class="btn btn-sm btn-primary text-white">啟用</span>';                                     
                                    }
                                    else {
                                        echo '<span class="btn btn-sm btn-danger text-white" style="height:36px;font-size: 16px;">封鎖</span>';
                                    }    
                                    if ($rs["line_user_cdate"] > ''){
                                    	  echo '<div style="margin-top:5px">';
                      	                echo '建立時間：'.$rs["line_user_cdate"];
                      	                echo '</div>';
                      	            }                                                                       
                                ?>  
                                </div>
           
                  </td>
                  <th width="120" class="info">會員資訊</th> 
                  <td width="38%" style="font-family:serif;">
                  <?php           
                  	if ($rs["member_c_no"] > ''){
                        echo htmlspecialchars($rs["member_c_no"]);
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
                  ?>
                  </td>   
              </tr> 
              <tr>
              	<th width="120" class="info">Line 訊息推送</th> 
              	<td colspan="3">
              	   <div class="form-group">
                     <div class="form-row">        
                         <div class="col-md-12">
                             <div style="margin-bottom: 10px;">
                             <button type="button"  class="btn btn-info btn-sm" onclick="in_code('send_text','name');">會員姓名 or 暱稱</button>
                                   (點選後可直接插入欄位)
                                    <a href="https://tw.piliapp.com/emoji/list/" target=_blank>Emoji 列表</a>                               
                             </div>                  
                             <div class="form-label-group">
                                <textarea cols="20" rows="5" id="send_text" name="send_text" class="form-control">親愛的[name]您好，！</textarea>
                             </div>
                         </div>             
                     </div>
                   </div>
        
                   <div class="form-group" style="margin-top: 6px;">
                       <div class="form-row">                           
                           <div class="col-md-2" style="margin-top: 6px;">
                               <button type="button" class="send_go btn btn-primary" data-dismiss="modal">確認推送</button>
                           </div>
                       </div>
                   </div>
              	</td>
              </tr>		
    </table>
  <form name="SearchoForm" method="post" language="javascript" action="<?=$this->PATH_INFO?>">
  <input type="hidden" name="Page" value="<?=$Page?>">
  <input type="hidden" name="Swp1" value="<?=$Swp1?>">
  <input type="hidden" name="Search" value="<?=$Search?>">  
  
   <div class="form-group float-right" style="margin-top: 6px;">          
		   <input type="button" value="回上一頁" onclick="javascript:action='<?php echo base_url( 'wadmin/member_line/push_list/'.$kind); ?>';submit();" class="btn btn-info">                    				
	 </div>	
	 </form>
	 <div class="clearfix"></div>
	 
   <div class="card-body">            
        <div class="log_list" id="log_list"></div>      
   </div>
<script>
	
$(document).ready(function() {   	 
       $('.send_go').on('click', function(e){
          var htext = $('#send_text').val();
	        if (htext > ''){	 	   
          		alertify.set({ buttonReverse: true }); // true, false
          		alertify.confirm('確定是否推送訊息？<br><br>', function (e) {  
          		     if (e) {  
          		           $.ajax({
   											      url: '<?=base_url("wadmin/member_line/push_send/".$user_id)?>',
   											      type:"post",
   											      data: {
   											             "send_text":htext,   											             
   											            },
														dataType:"json",
														   success: function(data){
   											                console.log(data);
   											                if (data.status){
   											                	   log_show();
   											                }
   											                alertify.alert(data.msg+"<br><br>");
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
       });   
   
});   	      


function in_code(js,str) 
{
            var obj = $("#"+js)[0];
            if (document.selection)  //for ie
            {
                obj.focus();
                var sel = document.selection.createRange();
                sel.text = "["+str+"]";
            }
            else  //for firefox
            {
                var prefix = obj.value.substring(0, obj.selectionStart);
                var suffix = obj.value.substring(obj.selectionEnd);
                obj.value = prefix +"["+str+"]"+ suffix;
            }
} 


function log_show(){
   $.ajax({
         url: "<?=base_url('wadmin/member_line/push_log/'.$user_id)?>",
         type:"get",
			dataType:"json",
			   success: function(data){			                             
                   console.log(data);
                   $( "#log_list" ).html(data.html);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.responseText);
          }

      });
}
log_show();

</SCRIPT>