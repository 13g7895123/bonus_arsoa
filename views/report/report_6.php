<?php 
               
              $all_org  =0;
	            $pv_org   =0;
	            $new_org  =0;
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
	           	        				 	 <td class="font15"><?=trim($rs["c_no"])?>&nbsp;&nbsp;<?=trim($rs["c_name"])?>&nbsp;&nbsp;<?=trim($rs["orgtype"])?></td>
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
                            <td align=center class="font13">位階</td>
                            <td align=center class="font13">組織人數</td>
                            <td align=center class="font13">有業績人數</td>
                            <td align=center class="font13">本月加入人數</td>
                           </tr>
	           	        <?php } ?>
	                     <tr>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13" align=right><?=number_format($rs["all_org"])?></td>
	           	        	 <td class="font13" align=right><?=number_format($rs["pv_org"])?></td>
	           	        	 <td class="font13" align=right><?=number_format($rs["new_org"])?></td>	           	        	 
	           	         </tr>
	                    <?php
	                    $all_org  = $all_org  + $rs["all_org"];
	           	        $pv_org   = $pv_org  + $rs["pv_org"];
	           	        $new_org  = $new_org  + $rs["new_org"];	           	        
	           	    } ?>
	                 <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13"><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($all_org)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_org)?></td>
	           	        	 <td align=right class="font13"><?=number_format($new_org)?></td>
	           	         </tr>	  	                     
	             </table>
	             
                  
	        <?php  } ?>