<?php               
              $u_price = 0;
	            $qty = 0;         
	            $amt = 0;
	            $year_sale = 0;
	            $bp_tot = 0;
	            $nm = 0;
	           	if ($q_data){
	           	        foreach ($q_data as $key => $rs){	           	        
	           	        $nm++;	           	        
	           	        if ($nm == 1){ 	           	        	  
	           	            ?>
	           	          <table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	           <tr>
	           	        		<td valign=top>
	           	        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	        				 <tr>
                                  <td height="5" colspan="6"></td>
                                </tr>
	           	        				 <tr>
	           	        				 	 <td class="font15"><?=trim($rs["c_name"])?>&nbsp;&nbsp;<?=trim($rs["d_pos"])?></td>
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
                            <td align=center class="font13">產品品名</td>
                            <td align=center class="font13">訂購日期</td>
                            <td align=center class="font13">發票號碼</td>
                            <td align=center class="font13">建議售價</td>
                            <td align=center class="font13">訂購數量</td>
                            <td align=center class="font13">Bp小計</td>
                            <td align=center class="font13">金額合計</td>
                           </tr>
	           	        <?php } ?>
	                     <tr>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["p_name"])?></td>
	           	        	 <td class="font13"><?=$rs["or_date"]?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["vch_no"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["u_price"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["qty"])?></td>
                         <td align=right class="font13"><?=number_format($rs["bp_tot"])?></td>
                         <td align=right class="font13"><?=number_format($rs["amt"])?></td>
	           	         </tr>
	                    <?php
	                    $u_price = $u_price + $rs["u_price"];
	           	        $qty     = $qty  + $rs["qty"];
	           	        $bp_tot  = $bp_tot  + $rs["bp_tot"];
	           	        $amt     = $amt  + $rs["amt"];
	           	        
	           	    } ?>	           
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=3><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($u_price)?></td>
	           	        	 <td align=right class="font13"><?=number_format($qty)?></td>
	           	        	 <td align=right class="font13"><?=number_format($bp_tot)?></td>
                         <td align=right class="font13"><?=number_format($amt)?></td>
	           	         </tr>	  	                     
	             </table>
	        <?php  } ?>