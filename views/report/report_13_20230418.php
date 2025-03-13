<?php               
              $dreamer = 0;   
              $dv      = 0;   
              $uv      = 0;   
              $hv      = 0;   
              $bv      = 0;   
              $mv      = 0;   
              $tv      = 0;   
              $jv      = 0;   
              $wt      = 0;   
              $pv      = 0;   
              $sv      = 0;   
              $savea   = 0;   
              $stara   = 0;   
              $saveb   = 0;   
              $starb   = 0;   
              $savec   = 0;   
              $star    = 0;        
	            	 
	            $nm = 0;
	           	if ($q_data){
	           	        foreach ($q_data as $key => $rs){
	           	        $nm++;
	           	        if ($nm == 1){  ?>	           	        	  
	           	
	           	          <table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	           <tr>
	           	        		<td valign=top>
	           	        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	        				 <tr>
                                  <td height="5" colspan="6"></td>
                                </tr>
	           	        				 <tr>
	           	        				 	 <td class="font15"><?=$this->session->userdata('member_session')['c_no']?>&nbsp;&nbsp;<?=$this->session->userdata('member_session')['c_name']?>&nbsp;&nbsp;個人組織</td>
	           	        				 </tr>
	           	        				  <tr>
                                  <td height="5" colspan="6"></td>
                                </tr>
	           	         			</table>
	           	        	   </td>
	           	            </tr>
	           	           </table>
	           	           <table style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; BORDER-COLLAPSE: collapse; mso-border-alt: solid windowtext .5pt; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt"
                            bordercolor=#ADB5C9 cellspacing=0 cellpadding=2
                            border=1 align="center" width="100%" class="shi12_20">
                           <tr bgcolor="#bfbfbf">                        
                           	<td align=center class="font13" colspan=15><?=$datatitle?></td>
                            <td align=center class="font13" colspan=2>第一期</td>
                            <td align=center class="font13" colspan=2>第二期</td>
                            <td align=center class="font13" colspan=2>總計</td>
                           </tr>  
                           <tr bgcolor="#bfbfbf">                        
                           	<td align=center class="font13">會員編號</td>
                            <td align=center class="font13">會員姓名</td>
                            <td align=center class="font13">位階</td>
                            <td align=center class="font13">推薦人</td>
                            <td align=center class="font13">培育圓夢支部</td>
                            <td align=center class="font13">直接組織</td>
                            <td align=center class="font13">晉升加碼</td>
                            <td align=center class="font13">宅配加碼</td>
                            <td align=center class="font13">販促加碼</td>
                            <td align=center class="font13">業績合計</td>
                            <td align=center class="font13">業績顆星</td>
                            <td align=center class="font13">顆星調整</td>
                            <td align=center class="font13">每月儲備</td>
                            <td align=center class="font13">顆星加碼</td>                            
                            <td align=center class="font13">實際顆星</td>
                            <td align=center class="font13">儲備顆星</td>
                            <td align=center class="font13">總顆星數</td>
                            <td align=center class="font13">儲備顆星</td>
                            <td align=center class="font13">總顆星數</td>
                            <td align=center class="font13">儲備顆星</td>
                            <td align=center class="font13">總顆星數</td>
                           </tr>
	           	        <?php } ?>
	                     <tr>	        
	                     	 <td class="font13"><?=trim($rs["c_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["c_name"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["dreamer"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["dv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["uv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["hv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["mv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["tv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["jv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["w"])?></td>
                         <td align=right class="font13"><?=number_format($rs["pv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["sv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["savea"])?></td>
                         <td align=right class="font13"><?=number_format($rs["stara"])?></td>
                         <td align=right class="font13"><?=number_format($rs["saveb"])?></td>
                         <td align=right class="font13"><?=number_format($rs["starb"])?></td>
                         <td align=right class="font13"><?=number_format($rs["savec"])?></td>
                         <td align=right class="font13"><?=number_format($rs["star"])?></td>               
	           	         </tr>
	                    <?php
	                    
	                    $dreamer   += $rs["dreamer"];     
                      $dv        += $rs["dv"];       
                      $uv        += $rs["uv"];       
                      $hv        += $rs["hv"];       
                      $bv        += $rs["bv"];       
                      $mv        += $rs["mv"];       
                      $tv        += $rs["tv"];       
                      $jv        += $rs["jv"];       
                      $wt        += $rs["wt"];       
                      $pv        += $rs["pv"];       
                      $sv        += $rs["sv"];       
                      $savea     += $rs["savea"];       
                      $stara     += $rs["stara"];       
                      $saveb     += $rs["saveb"];       
                      $starb     += $rs["starb"];       
                      $savec     += $rs["savec"];       
                      $star      += $rs["star"];     
                      
	                 } ?>	 
	                 <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=4><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($dreamer)?></td>
                         <td align=right class="font13"><?=number_format($dv)?></td>
                         <td align=right class="font13"><?=number_format($uv)?></td>
                         <td align=right class="font13"><?=number_format($hv)?></td>
                         <td align=right class="font13"><?=number_format($bv)?></td>
                         <td align=right class="font13"><?=number_format($mv)?></td>
                         <td align=right class="font13"><?=number_format($tv)?></td>
                         <td align=right class="font13"><?=number_format($jv)?></td>
                         <td align=right class="font13"><?=number_format($wt)?></td>
                         <td align=right class="font13"><?=number_format($pv)?></td>
                         <td align=right class="font13"><?=number_format($sv)?></td>
                         <td align=right class="font13"><?=number_format($savea)?></td>
                         <td align=right class="font13"><?=number_format($stara)?></td>
                         <td align=right class="font13"><?=number_format($saveb)?></td>
                         <td align=right class="font13"><?=number_format($starb)?></td>
                         <td align=right class="font13"><?=number_format($savec)?></td>
                         <td align=right class="font13"><?=number_format($star)?></td>
	           	         </tr>	  	                                     
	             </table>
	        <?php  } ?>