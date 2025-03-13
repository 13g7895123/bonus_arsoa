<?php 
                 $pv_per  = 0;
                 $pv_sv   = 0;
                 $pv_wv   = 0;
	           	   
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
	           	        				 	 <td class="font15"><?=trim($rs["c_no"])?>&nbsp;&nbsp;<?=trim($rs["c_name"])?></td>
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
                            <td align=center class="font13">獎金年月</td>
                            <td align=center class="font13">位階</td>
                            <td align=center class="font13">個人業績</td>                            
                            <td align=center class="font13">個人組織業績</td>
                            <td align=center class="font13">整體組織業績</td>                            
                           </tr>
	           	        <?php } ?>
	                     <tr>
	           	        	 <td align=center class="font13"><?=trim($rs["bn_mon"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_per"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_sv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_wv"])?></td>	           	        	 
	           	         </tr>	                    
	                    <?php
	                    $pv_per  = $pv_per  + $rs["pv_per"];
	           	        $pv_sv  = $pv_sv  + $rs["pv_sv"];
	           	        $pv_wv  = $pv_wv  + $rs["pv_wv"];
	           	        
	           	   }   ?>
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=2><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($pv_per)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_sv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_wv)?></td>
	           	         </tr>	  
	             </table>                 
	        <?php  } ?>