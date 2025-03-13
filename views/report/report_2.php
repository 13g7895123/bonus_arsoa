<?php 
                 $nbn_per  = 0;
	            	 $nbn_dev  = 0;
	            	 $nbn_dai  = 0;
	            	 $nbn_sam  = 0;
	            	 $nbn_sha  = 0;
	            	 $nbn_else = 0;
	            	 $nbn_adj  = 0;
	            	 $nbn_tot  = 0;
	            	 $nbn_tax  = 0;
	            	 $nbn_amt  = 0;
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
                            <td align=center class="font13">增員特別</td>
                            <td align=center class="font13">增員輔導</td>
                            <td align=center class="font13">組織發展</td>
                            <td align=center class="font13">培育發展</td>
                            <td align=center class="font13">全國分紅</td>
                            <td align=center class="font13">販促佣金</td>
                            <td align=center class="font13">佣金調整</td>
                            <td align=center class="font13">合計</td>
                            <td align=center class="font13">稅額</td>
                            <td align=center class="font13">實發佣金</td>
                           </tr>
	           	        <?php 
	           	          }
	           	        ?>
	                     <tr>
	           	        	 <td align=center class="font13"><?=trim($rs["bn_mon"])?></td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_per"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_dev"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_dai"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_sam"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_sha"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_else"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_adj"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_tot"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_tax"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["bn_amt"])?></td>
	           	         </tr>	                    
	                    <?php
	                    $nbn_per  = $nbn_per  + $rs["bn_per"];
	           	        $nbn_dev  = $nbn_dev  + $rs["bn_dev"];
	           	        $nbn_dai  = $nbn_dai  + $rs["bn_dai"];
	           	        $nbn_sam  = $nbn_sam  + $rs["bn_sam"];
	           	        $nbn_sha  = $nbn_sha  + $rs["bn_sha"];
	           	        $nbn_else = $nbn_else + $rs["bn_else"];
	           	        $nbn_adj  = $nbn_adj  + $rs["bn_adj"];
	           	        $nbn_tot  = $nbn_tot  + $rs["bn_tot"];
	           	        $nbn_tax  = $nbn_tax  + $rs["bn_tax"];
	           	        $nbn_amt  = $nbn_amt  + $rs["bn_amt"];	   	   
	           	        
	                }  ?>
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=1><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($nbn_per)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_dev)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_dai)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_sam)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_sha)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_else)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_adj)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_tot)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_tax)?></td>
	           	        	 <td align=right class="font13"><?=number_format($nbn_amt)?></td>
	           	         </tr>	  
	             </table>	             
            
	        <?php  } ?>