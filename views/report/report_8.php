<?php               
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
                            <td align=center class="font13">會員編號</td>
                            <td align=center class="font13">會員姓名</td>                            
                            <td align=center class="font13">推薦人姓名</td>
                            <td align=center class="font13">晉升位階</td>
                           </tr>
	           	        <?php } ?>
	                     <tr>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["u_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["u_name"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	         </tr>	                    
	                    <?php	                   
	                   } 
	                ?>
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=3><b>合計人數</td>	           	        	 
	           	        	 <td align=right class="font13"><?=$nm?></td>
	           	         </tr>	  
	             </table>             
                  
	        <?php  } ?>