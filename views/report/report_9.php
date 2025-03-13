<?php               
                 $brand_tc = "";
	           	   $n = 0;
	           	   $qty = 0;
                 $pv  = 0;
                 $amt = 0;                      
                 $tqty =0;
                 $tpv  =0;
                 $tamt =0;
                 
	            $nm = 0;
	           	if ($q_data){
	           	        foreach ($q_data as $key => $rs){
	           	        $nm++;
	           	        $n++;
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
                            <td align=center class="font13">品牌類型</td>
                            <td align=center class="font13">產品編號</td>                            
                            <td align=center class="font13">產品名稱</td>
                            <td align=center class="font13">銷售數量</td>
                            <td align=center class="font13">銷售BP</td>
                            <td align=center class="font13">銷售金額</td>
                           </tr>
	           	        <?php }	           	           
	           	        if ($brand_tc <> trim($rs["brand_tc"]) && $brand_tc <> ""){ ?>
	           	            <tr bgcolor="#EBF5FF">
	           	              <td align=right class="font13" colspan=3><b>小計</td>
	           	              <td align=right class="font13"><?=number_format($qty)?></td>
	           	              <td align=right class="font13"><?=number_format($pv)?></td>
	           	              <td align=right class="font13"><?=number_format($amt)?></td>
	           	            </tr>	  <?php
	           	            $qty = 0;
	           	            $pv  = 0;
	           	            $amt = 0;
	           	            $n = 1;
	           	        }
	           	        ?>
	                     <tr>	           	        	 
	           	        	 <td class="font13">
	           	        	 	<?php if ($n == 1){
	           	        	 	         echo trim($rs["brand_tc"]);
	           	        	 	      }else{
	           	        	 	   	     echo "&nbsp;";
	           	        	 	      } ?></td>
	           	        	 <td class="font13"><?=trim($rs["p_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["p_name"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["qty"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["amt"])?></td>
	           	         </tr>	                    
	                    <?php
	                    
	                 $brand_tc = trim($rs["brand_tc"]);
	                 $qty = $qty + $rs["qty"];
	                 $pv  = $pv  + $rs["pv"];
	                 $amt = $amt + $rs["amt"];
	                 
	                 $tqty = $tqty + $rs["qty"];
	                 $tpv  = $tpv  + $rs["pv"];
	                 $tamt = $tamt + $rs["amt"];
	                 
	              }  ?>
	                     <tr bgcolor="#EBF5FF">
	           	        	 <td align=right class="font13" colspan=3><b>小計</td>
	           	        	 <td align=right class="font13"><?=number_format($qty)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($amt)?></td>
	           	         </tr>	  	                     
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=3><b>總計</td>
	           	        	 <td align=right class="font13"><?=number_format($tqty)?></td>
	           	        	 <td align=right class="font13"><?=number_format($tpv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($tamt)?></td>
	           	         </tr>	  
	             </table>       
                  
	        <?php  } ?>