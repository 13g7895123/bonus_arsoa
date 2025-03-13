<ul class="nav nav-pills nav-stacked custom-nav">
		  <?php
		  if ($admin_type == 'L'){		  	
		  	  $Menu=$XmlDoc->xpath("/參數設定檔/權限L/選單");
		  }
	elseif ($admin_type == 'C'){		  	
		  	  $Menu=$XmlDoc->xpath("/參數設定檔/權限C/選單");
	}
	else{
          $Menu=$XmlDoc->xpath("/參數設定檔/權限/選單");
      }

      for($x=0;$x< count($Menu);$x++){            	 
      	 $row = simplexml_load_string($Menu[$x]->asXML());
      	 
      	  $MenuContext2 = $row->xpath('SND');
		    
		     $row3 = simplexml_load_string($MenuContext2[0]->asXML());		    
		     $minstatus1  = $MenuContext2[0]->權限;
		     $minstatus2  = $MenuContext2[0]->禁權限;
		     $murl        = $MenuContext2[0]->網址;
		     $classa      = $Menu[$x]['主編號'];
		     
		     if ($murl == ''){ $murl = '#'; }
		     
		     $showok = "Y";
		     if ($minstatus2 != ""){
		     	  if ($_SESSION['admin_session']['admin_status'] == $minstatus2){		    
		     	      $showok = "N";		    
		     	  }
		     }
		     if ($showok == "Y"){
		     	  if ($_SESSION['admin_session']['admin_status'] < $minstatus1){		    
		     	  	   $showok = "N";		    
		     	  }
		     }		    
		
		     if ($showok == "Y"){ 		      
		        $MenuContext=$row->xpath('KIND');		
		        if (count($MenuContext) == 0){    
		          echo "<li";
						  if (isset($kind) && substr($kind,0,1) == $classa){
		              echo " class=\"active\"";
		          }
		          echo "><a href=\"".base_url('wadmin/'.$murl)."\"><i class=\"lnr ".$Menu[$x]['lnr']."";		          		          
		          echo "\"></i> <span>".$Menu[$x]['主選單名稱']."</span></a></li>";
		        }else{		            
		            for ($y=0;$y< count($MenuContext);$y++){		            
		                 if ($y == 0){
		                     ?>
						         <li class="menu-list <?php
						              if (isset($kind) && substr($kind,0,1) == $classa){
		                              echo " nav-active";
		                          }
						              ?>"><a href="#"><i class="lnr <?=$Menu[$x]['lnr']?>"></i> <span><?=$Menu[$x]['主選單名稱']?></span></a>
						             	<ul class="sub-menu-list">
						         <?php	       
		                 } 
		                      $row1       = simplexml_load_string($MenuContext[$y]->asXML());		      	
		              	      $minstatus  = $MenuContext[$y]->權限;
		                      $ablank     = $MenuContext[$y]->傳回值;
		                      $ablank1    = substr($ablank,0,1);
		                      $ordercnt = '';
		                      
		                      if ($_SESSION['admin_session']['admin_status'] >= $minstatus){		   		                      
		                	        $url = base_url('wadmin/'.$MenuContext[$y]->網址);
		              		        $target="";
		              		        if (substr_count($ablank,"blank") > 0){
		              		     	      $target=" target=_blank";
		              		     	      $url = $MenuContext[$y]->網址;
		              		        }
		                          ?>							  
						    		          <li><a href="<?php echo $url?>"<?php echo $target?>><?php echo $MenuContext[$y]->資料?></a> </li>
						    		          <?php
						    		      }
						      }
				          ?>
						    	</ul>
						    </li>      						
						 <?php
						} 
	      }
	   } 
	   if ($admin_type == 'L'){
	       ?>
	       <div align="center" style="margin-top: 10px;">      
	         <img src="<?=base_url('public/images/qr.png')?>" width="95%">
	       </div>  
	       <div align="center" style="font-size:18px;color:#C8C8C8;margin-top: 10px;">
	       專屬ID：<a href="https://line.me/ti/p/<?=$this->config->item('line_bot_basic_id')?>" style="font-size:18px;color:#C8C8C8" target="_blank"><?=$this->config->item('line_bot_basic_id')?></a>
	       </div>
	       
	       <div style="margin-left: 2px;margin-top: 30px;text-align:center;font-size:16px;color:#FFFFFF;">         
	       	<table width=95% style="font-family:serif;">
	       		<tr>
	       			<td>本月的訊息用量</td><td align=right><?=number_format($this->message['quota'])?></td>
	       		</tr>
	       		<tr>
	       			<td>已傳送訊息則數</td><td align=right><?=number_format($this->message['consumption'])?></td>
	       		</tr>
	       		<tr>
	       			<td>可傳送訊息則數</td><td align=right><?=number_format($this->message['canpush'])?></td>
	       		</tr>
           </table>
         </div>
         
	       <?php
	   }
	   ?>
</ul>
<!--sidebar nav end-->