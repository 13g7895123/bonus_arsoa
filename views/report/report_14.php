<?php               
              $nm = 0;
	           	if ($q_data){
	           	        foreach ($q_data as $key => $rs){
	           	        $nm++;
	           	        $font_color = '';
	           	        if ($rs['isShip'] == '1'){
	           	            $font_color = 'style="color:red;"';	
	           	        }elseif ($rs['isShip'] == '3'){
	           	        	  $font_color = 'style="color:blue;"';	
	           	        }
	           	        if ($nm == 1){  ?>	           	        	  
	           	
	           	          <table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	           <tr>
	           	        		<td valign=top>
	           	        			<table width="100%" border="0" cellspacing="0" cellpadding="2">
	           	        				 <tr>
                                  <td height="5" colspan="6"></td>
                                </tr>
	           	        				 <tr>
	           	        				 	 <td class="font15"><?=$this->session->userdata('member_session')['c_no']?>&nbsp;&nbsp;<?=$this->session->userdata('member_session')['c_name']?>&nbsp;&nbsp;組織宅配訂單查詢</td>
	           	        				 </tr>
	           	        				  <tr>
                                  <td height="5" colspan="6">查詢宅配產品：<?=$typetitle?></td>
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
                            <td align=center class="font13">會員位階</td>
                            <td align=center class="font13">推薦人編號</td>
                            <td align=center class="font13">推薦人姓名</td>
                            <td align=center class="font13">出貨期數</td>
                            <td align=center class="font13">出貨日期</td>
                            <td align=center class="font13">配送日</td>
                           </tr>  
	           	        <?php } ?>
	                     <tr>	        
	                     	 <td class="font13"><span <?=$font_color?>><?=trim($rs["c_no"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["c_name"])?></span></td>	           	        	 
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["d_pos"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["d_spno"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["d_spname"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["parts"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["c_date"])?></span></td>
	           	        	 <td class="font13"><span <?=$font_color?>><?=trim($rs["days"])?></span></td>
	           	         </tr>
	                    <?php
	                 } ?>	 	                   	                                     
	             </table>
	             <font color=red>共 <?=$nm?> 張宅配單<br>
	             	備註：紅字部份表示為當月未出貨之宅配訂單	             	
	             	</font>
	             
	        <?php  } ?>