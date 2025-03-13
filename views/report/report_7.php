<?php 
              
              $m10   = 0;
              $pv10  = 0;
              $m20   = 0;
              $pv20  = 0;
              $m30   = 0;
              $pv30  = 0;
              $m40   = 0;
              $pv40  = 0;
              $m50   = 0;
              $pv50  = 0;
              $m60   = 0;
              $pv60  = 0;
              $mnew  = 0;
              $mtot  = 0;
              
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
	           	        				 	 <td class="font15"><?=trim($rs["c_no"])?>&nbsp;&nbsp;<?=trim($rs["c_name"])?>&nbsp;&nbsp;<?=trim($rs["orgtype"])?>&nbsp;&nbsp;
	           	        				 	 	<font color=blue>(每筆年月組織人數均包含本人)</font>
	           	        				 	 	</td>
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
                            <td align=center width="7%" class="font13" rowspan=2>年月</td>
                            <td align=center class="font13" colspan=2>優秀地區本部</td>
                            <td align=center class="font13" colspan=2>地區本部</td>
                            <td align=center class="font13" colspan=2>優秀支部長</td>
                            <td align=center class="font13" colspan=2>支部長</td>
                            <td align=center class="font13" colspan=2>支部</td>
                            <td align=center class="font13" colspan=2>合歡會員</td>
                            <td align=center width="6.8%"class="font13" rowspan=2>加入</td>
                            <td align=center width="6.8%" class="font13" rowspan=2>總人數</td>
                           </tr>
                           <tr bgcolor="#bfbfbf">
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                            <td align=center width="6.8%" class="font13">組織</td>	
                            <td align=center width="6.8%" class="font13">業績</td>	
                           </tr>
	           	        <?php } ?>
	                     <tr>	           	        	
	           	        	 <td class="font13" align=center><?=$rs["mon"]?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m10"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv10"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m20"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv20"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m30"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv30"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m40"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv40"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m50"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv50"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["m60"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv60"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["mnew"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["mtot"])?></td>
	           	         </tr>	                    
	                    <?php
	               }  ?>
	             </table>	             
                  
	        <?php  } ?>