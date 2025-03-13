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
                            <td align=center class="font13">代數</td>
                            <td class="font13">會員姓名<br>會員編號</td>                            
                            <td class="font13">位階<br>通訊地址</td>
                            <td class="font13"><br>推薦人</td>
                            <td class="font13"><br>公司電話</td>
                            <td class="font13"><br>住宅電話</td>
                            <td class="font13">行動電話<br>最後銷貨日</td>
                            <td class="font13">加入LINE</td>
                            <td class="font13">綁定LINE</td>                            
                           </tr>
	           	        <?php }    ?>
	                     <tr>	           	        	 
	           	        	 <td class="font13" align=center><?=trim($rs["dai"])?></td>
	           	        	 <td class="font13"><?=trim($rs["o_name"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td class="font13"><?=trim($rs["tel_o"])?></td>
	           	        	 <td class="font13"><?=trim($rs["tel_h"])?></td>
	           	        	 <td class="font13"><?=trim($rs["cell1"])?></td>
	           	        	 <td align=center class="font13" rowspan=2><?php
	           	        	  if ($rs["isline"]){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>	  
	           	        	 <td align=center class="font13" rowspan=2><?php
	           	        	  if ($rs["linebind"]){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>	         	        	 
	           	         </tr>
	           	         <tr>
	           	         	 <td></td>
	           	        	 <td class="font13"><?=trim($rs["o_no"])?></td>	           	        	 
	           	        	 <td class="font13" colspan=4><?=trim($rs["addr_cm"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["last_sale"])?></td>	           	        	 
	           	         </tr>	                    
	                    <?php
	                }  ?>	                   
	             </table>           
	        <?php  } ?>