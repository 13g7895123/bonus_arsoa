<?php 
             $Totalprice = 0;
	           $Totalbp    = 0;
             $nb_typena = "";
	           if ($q_data){
	               $nm = 0;
	           	   foreach ($q_data as $key => $rs){
	           	        $nm++;
	           	        if ($nm == 1){ 
	           	          ?>
	           	        	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	        	<tr>
	           	        		<td colspan=7 valign=top>
	           	        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	        				 <tr>
                                  <td height="5" colspan="6"></td>
                                </tr>
	           	        				 <tr>
	           	        				 	 <td class="font13" align=right>會員：</td>
	           	        				 	 <td class="font13"><?=trim($rs["c_no"])?>&nbsp;&nbsp;<?=trim($rs["c_name"])?></td>
	           	        				 	 <td class="font13" align=right>推薦人姓名：</td>
	           	        				 	 <td class="font13"><?=trim($rs["upper_na"])?></td>
	           	        				 	 <td class="font13" align=right>階級：</td>
	           	        				 	 <td class="font13"><?=trim($rs["sp_pos"])?></td>
	           	        				  </tr>
	           	        				</table>
	           	        				
	           	        				   <table style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; BORDER-COLLAPSE: collapse; mso-border-alt: solid windowtext .5pt; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt"
                            bordercolor=#ADB5C9 cellspacing=0 cellpadding=2
                            border=1 align="center" width="100%" class="shi12_20">
                                  <tr>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">業績類別</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">建議售價</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">領取</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">領推廣</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">個人業績</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">個人組織</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第一代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第二代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第三代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第四代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第五代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第六代</td>
                                    <td align="center" bgcolor="#DDDDDD" class="font12">第七代</td>
                                  </tr>
                                  <tr>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12">A</td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["a_amt"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=$rs["is_bonu"]?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=$rs["is_a_dev"]?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_per"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_sv"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_1"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_2"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_3"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_4"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_5"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_6"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_7"])?></td>
                                  </tr>
                                  <tr>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12">B</td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["b_amt"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=$rs["is_h_bonu"]?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=$rs["is_b_dev"]?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_per"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_sv"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_1"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_2"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_3"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_4"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_5"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_6"])?></td>
                                  	<td align="center" bgcolor="#FFFFFF" class="font12"><?=number_format($rs["pv_h_7"])?></td>
                                  </tr>
                                  </table>
	           	        				  
	           	         <table style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; BORDER-COLLAPSE: collapse; mso-border-alt: solid windowtext .5pt; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt"
                            bordercolor=#ADB5C9 cellspacing=0 cellpadding=2
                            border=1 align="center" width="100%" class="shi12_20">
	           	        <?php
	           	        }
	           	        if ($nb_typena <> trim($rs["b_typena"])){
	           	        	 if ($nm > 1){ ?>
	           	        	 	  <tr>
	           	        	    	<td bgcolor="#DDDDDD" align=right colspan=5 class="font13"><b>小計</b></td>
	           	        	    	<td align=right class="font13"><?=number_format($Totalbp)?></td>
	           	        	    	<td align=center class="font13"></td>
	           	        	    	<td align=right class="font13"><?=number_format($Totalprice)?></td>	   	        	    	
	           	               </tr>	   	        	 	
	           	        	 <?php
	           	        	 }
	           	        	 $Totalprice = 0;
	           	        	 $Totalbp    = 0;
	           	        	 ?>	   	       	 
	           	        	 <tr>
	           	        		<td style='border-top:none' style='border-left:none' style='border-bottom:none' style='border-right:none' colspan=7 valign=top><b><?=trim($rs["b_typena"])?></td>
	           	           </tr>	   	           	   	           
	           	           <tr bgcolor="#bfbfbf">
	           	           	<td align=center class="font13">類別</td>
	           	        		<td align=center class="font13">會員姓名</td>
	           	        		<td align=center class="font13">推薦人姓名</td>
	           	        		<td align=center class="font13">階級</td>
	           	        		<td align=center class="font13">代數</td>
	           	        		<td align=center class="font13">業績(BP)</td>
	           	        		<td align=center class="font13">百分比</td>
	           	        		<td align=center class="font13">佣金</td>
	           	           </tr>
	           	        <?php	
	           	        }	   	        
	           	        $Totalbp += $rs["pv"];
	           	        $Totalprice += $rs["bonus"];
	           	        ?>
	           	         <tr>
	           	         	 <td class="font13" align=center><?=trim($rs["ab_type"])?></td>
	           	        	 <td class="font13"><?=trim($rs["dn_name"])?></td>
	           	        	 <td class="font13"><?=trim($rs["up_name"])?></td>
	           	        	 <td class="font13"><?=trim($rs["dn_pos"])?></td>
	           	        	 <td class="font13" align=center><?=trim($rs["lvl"])?></td>
	           	        	 <td class="font13" align=right><?=number_format($rs["pv"])?></td>
	           	        	 <td class="font13" align=right><?=trim($rs["perc"])?></td>
	           	        	 <td class="font13" align=right><?=number_format($rs["bonus"])?></td>
	           	         </tr>
	           	        <?php
	           	        $nb_typena = trim($rs["b_typena"]);
	           	        $nbn_per = $rs["bn_per"];
	           	        $nbn_dev = $rs["bn_dev"];
	           	        $nbn_dai = $rs["bn_dai"];
	           	        $nbn_sam = $rs["bn_sam"];
	           	        $nbn_sha = $rs["bn_sha"];
	           	        $nbn_else = $rs["bn_else"];
	           	        $nbn_adj = $rs["bn_adj"];
	           	        $nbn_tot = $rs["bn_tot"];
	           	        $nbn_tax = $rs["bn_tax"];
	           	        $nbn_amt = $rs["bn_amt"];	           	        
	              } ?>
	                           <tr>
	           	        	    	<td bgcolor="#DDDDDD" align=right colspan=5 class="font13"><b>小計</b></td>
	           	        	    	<td align=right class="font13"><?=number_format($Totalbp)?></td>
	           	        	    	<td align=center class="font13"></td>
	           	        	    	<td align=right class="font13"><?=number_format($Totalprice)?></td>	   	        	    	
	           	               </tr>	   
	           	               <tr>
                               <td height="15" colspan="7" style='border-top:none' style='border-left:none' style='border-bottom:none' style='border-right:none'></td>
                             </tr>
	           	               <tr>
                               <td colspan="8">
                               	<table width="100%" border="0" cellspacing="0" cellpadding="2">
                               	 <tr>
                               	  <td align=right class="font13">增員特別</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">增員輔導</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">組織發展</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">培育發展</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">全國分紅</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">其它佣金</td>
                               	  <td align=center class="font13"></td>
                               	  <td align=right class="font13">佣金調整</td>                       	  
                               	 </tr>
                               	 <tr>
                               	  <td align=right class="font13"><?=number_format($nbn_per)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_dev)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_dai)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_sam)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_sha)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_else)?></td>
                               	  <td align=center class="font13">+</td>
                               	  <td align=right class="font13"><?=number_format($nbn_adj)?></td>                       	  
                               	 </tr>
                               	 <tr><td align=center colspan=13>
                               	 	   <table border="0" cellspacing="0" cellpadding="2">
                               	      <tr>
                               	       <td align=center class="font13"></td>
                               	       <td align=right class="font13">本月份總佣金</td>
                               	       <td align=center class="font13"></td>
                               	       <td align=right class="font13">代扣所得稅</td>
                               	       <td align=center class="font13"></td>
                               	       <td align=right class="font13">本月份實發佣金</td>                       	       
                               	      </tr>
                               	      <tr>
                               	       <td align=center class="font13">=</td>
                               	       <td align=right class="font13"><?=number_format($nbn_tot)?></td>
                               	       <td align=center class="font13">-</td>
                               	       <td align=right class="font13"><?=number_format($nbn_tax)?></td>
                               	       <td align=center class="font13">=</td>
                               	       <td align=right class="font13"><?=number_format($nbn_amt)?></td>                       	       
                               	      </tr>
                               	    </table>
                               	 </td></tr>
                               	</table>
                               </td>
                             </tr>
	           	             </table>
	        <?php  } ?>