<div class="card-body">    
        <table class="table table-bordered fa-xs" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="background-color: #364F6A;border-color: #2d4259;color: #ffffff;">
                        <th style="color: #ffffff;">推送記錄
                               &nbsp;
                               <span class="btn btn-sm btn-success text-white" style="margin-bottom: 5px;">
                                   總推送次數：
                                   <span style="background-color: #ffffff;color:#222222;margin-left: 0px;border-radius:3px;padding:2px;">
                                      <?=$log['total']?>
                                   </span>
                               </span>                               
                        </th>                        
                    </tr>
                </thead>   
           <?php if ($log['total'] > 0){ ?>                  
                <tr>                 
                 <td>            
                   <table class="table table-bordered fa-xs" id="dataTable" width="100%" cellspacing="0">
                   <thead>
                    <tr>
                        <th>推送時間</th>
                        <th>推送內容</th>
                        <th>推送狀態</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>推送時間</th>
                        <th>推送內容</th>
                        <th>推送狀態</th>
                    </tr>
                </tfoot>
                <tbody>
                  <?php 
                    $i = 0;
                    foreach ($log['rows'] as $skey => $sitem)
                    {     
                            if ($i % 2 == 0){
                                echo '<tr style="background-color: #f9f9f9;">';
                            }else{
                                echo '<tr>'; 
                            }
                            $i++;  
                            $send_array = json_decode($sitem['push_cont'], true)[0];                                 
                         ?>       
                                <td><?=$sitem['cdate']?></td>                     
                                <td><?=str_replace(array("\r\n", "\r", "\n", "\t"), '<br>', $send_array['text'])?></td>
                                <td><?php
                                	if ($sitem["http_code"]  == 429){
                  	          	      echo 'Line 訊息數不足';
                  	              }elseif ($sitem["http_code"]  == 200){
                  	              	  echo 'Line 訊息成功推送';
                  	              }else{
                  	              	
                  	              }?></td>
                         </tr>
                         <?php
                    } 
                 ?>
                  </tbody>
              <?php }else{
                        echo '<tr><td style="font-size:28px;">尚無任何推送訊息！</td></tr>';
                    } ?>    
            </table>
                
		           </td>
		          </tr>
         </table>     
</div>