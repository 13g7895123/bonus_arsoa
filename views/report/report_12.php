<?php               
              $a_amt = 0;
	            $b_amt = 0;         
	            $u_amt = 0;  
	            	 
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
	           	        				 	 <td class="font15"><?=trim($rs["xc_no"])?>&nbsp;&nbsp;<?=trim($rs["xc_name"])?>&nbsp;&nbsp;<?=trim($rs["orgtype"])?></td>
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
                           	<td align=center class="font13">序</td>    
                            <td align=center class="font13">會員編號</td>
                            <td align=center class="font13">會員姓名</td>
                            <td align=center class="font13">位階</td>
                            <td align=center class="font13">推薦人</td>
                            <td align=center class="font13">A建議售價</td>
                            <td align=center class="font13">B建議售價</td>
                            <td align=center class="font13">A+B建議售價</td>
                            <td align=center class="font13">到期日</td>
                           </tr>
	           	        <?php
	           	          }   ?>
	                     <tr>	        
	                     	 <td align=center class="font13"><?=$nm?></td>    	        	 
	           	        	 <td class="font13"><?=trim($rs["c_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["c_name"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["a_amt"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["b_amt"])?></td>
                         <td align=right class="font13"><?=number_format($rs["u_amt"])?></td>
                         <td align=center class="font13"><?php 
	           	        	  if ($rs["fee_date"] > ''){ 
	           	        	      echo date('Y-m-d',strtotime($rs["fee_date"]));
	           	        	  } ?></td>
	           	         </tr>
	                    <?php
	                    $a_amt = $a_amt + $rs["a_amt"];
	                    $b_amt = $b_amt + $rs["b_amt"];
	                    $u_amt = $u_amt + $rs["u_amt"];
	               } ?>
	                 <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=5><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($a_amt)?></td>
	           	        	 <td align=right class="font13"><?=number_format($b_amt)?></td>
                         <td align=right class="font13"><?=number_format($u_amt)?></td>
                         <td align=right class="font13"></td>
	           	         </tr>	  	                     
	             </table>
	        <?php  } ?>