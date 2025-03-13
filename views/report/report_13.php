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
                           	<td align=center class="font13" rowspan=2>會員編號</td>
                            <td align=center class="font13" rowspan=2>會員姓名</td>
                            <td align=center class="font13" rowspan=2>位階</td>
                            <td align=center class="font13" rowspan=2>推薦人</td>
                            <td align=center class="font13" rowspan=2>培育圓夢支部</td>
                            <td align=center class="font13" rowspan=2>挑戰申請日</td>
                            <td align=center class="font13" rowspan=2>LINE綁定日</td>
                            <td align=center class="font13" colspan=7><?=$datatitle?>顆星數（當月參考）</td>
                            <td align=center class="font13">第一階段</td>
                            <td align=center class="font13">第二階段</td>
                            <td align=center class="font13">總計</td>
                           </tr>  
                           <tr bgcolor="#bfbfbf">                                                   	
                            <td align=center class="font13">新增員</td>
                            <td align=center class="font13">新圓夢入會</td>
                            <td align=center class="font13">舊圓夢入會</td>
                            <td align=center class="font13">培育支部長</td>
                            <td align=center class="font13">晉升優支</td>
                            <td align=center class="font13">本月加碼</td>
                            <td align=center class="font13">本月調整</td>
                            <td align=center class="font13">總顆星數</td>
                            <td align=center class="font13">總顆星數</td>                            
                            <td align=center class="font13">總顆星數</td>
                           </tr>
	           	        <?php } ?>
	                     <tr>	        
	                     	 <td class="font13"><?=trim($rs["c_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["c_name"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["dreamer"])?></td>
	           	        	 <td class="font13"><?=trim($rs["jdate"])?></td>
	           	        	 <td class="font13"><?=trim($rs["bdate"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["nv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["dv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["ov"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["tv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["uv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["pv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["jv"])?></td>
                         <td align=right class="font13"><?=number_format($rs["stara"])?></td>
                         <td align=right class="font13"><?=number_format($rs["starb"])?></td>
                         <td align=right class="font13"><?=number_format($rs["star"])?></td>                         
	           	         </tr>
	                    <?php
	                    
	                    $dreamer   += $rs["dreamer"];     
                      $nv        += $rs["nv"];       
                      $dv        += $rs["dv"];       
                      $ov        += $rs["ov"];       
                      $tv        += $rs["tv"];       
                      $uv        += $rs["uv"];       
                      $pv        += $rs["pv"];       
                      $jv        += $rs["jv"];                             
                      $stara     += $rs["stara"];       
                      $starb     += $rs["starb"];       
                      $star      += $rs["star"];     
                      
	                 } ?>	 
	                 <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=4><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($dreamer)?></td>
	           	        	 <td align=right class="font13"></td>
	           	        	 <td align=right class="font13"></td>
                         <td align=right class="font13"><?=number_format($nv)?></td>
                         <td align=right class="font13"><?=number_format($dv)?></td>
                         <td align=right class="font13"><?=number_format($ov)?></td>
                         <td align=right class="font13"><?=number_format($tv)?></td>
                         <td align=right class="font13"><?=number_format($uv)?></td>
                         <td align=right class="font13"><?=number_format($pv)?></td>
                         <td align=right class="font13"><?=number_format($jv)?></td>
                         <td align=right class="font13"><?=number_format($stara)?></td>
                         <td align=right class="font13"><?=number_format($starb)?></td>
                         <td align=right class="font13"><?=number_format($star)?></td>
	           	         </tr>	  	                                     
	             </table>
	             <font color=red>*所有正確顆星數以活動辦法為主，本報表僅限參考用，如有疑問請洽各負責之營業輔導							</font>
	        <?php  } ?>