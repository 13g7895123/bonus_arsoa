<?php               
              $percnt   = 0;
              $S03      = 0;
              $S04      = 0;
              $S05      = 0;
              $S06      = 0;
              $S07      = 0;
              $S08      = 0;
              $S114     = 0;
              $S115     = 0;
              $S116     = 0;
              $S117     = 0;
              $S118     = 0;
              $SA       = 0;
              $SB       = 0;
              $SC       = 0;
              $S121     = 0;
              $S122     = 0;
              $S12      = 0;
              $SADJ     = 0;
              $S21      = 0;
              $S22      = 0;
              $STAR     = 0;
              $SAVESTAR = 0;          
	            	 
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
	           	        				 	 <td class="font15"><?=$this->session->userdata('member_session')['c_no']?>&nbsp;&nbsp;<?=$this->session->userdata('member_session')['c_name']?>&nbsp;&nbsp;個人組織</td>
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
                           	<td align=center class="font13" rowspan=2>會員編號</td>
                            <td align=center class="font13" rowspan=2>姓名</td>
                            <td align=center class="font13" rowspan=2>位階</td>
                            <td align=center class="font13" rowspan=2>推薦人</td>
                            <td align=center class="font13" rowspan=2>增員</td>
                            <td align=center class="font13" colspan=6>各月份加碼活動</td>
                            <td align=center class="font13" colspan=5>各月份業績顆星</td>
                            <td align=center class="font13" colspan=3>4 ~ 8 月份</td>
                            <td align=center class="font13" rowspan=2>培育幹部30</td>
                            <td align=center class="font13" rowspan=2>培育幹部60</td>
                            <td align=center class="font13" rowspan=2>本人晉升優支</td>
                            <td align=center class="font13" rowspan=2>調整</td>
                            <td align=center class="font13" colspan=2>優地挑戰</td>
                            <td align=center class="font13" rowspan=2>顆星總計</td>                            
                            <td align=center class="font13" rowspan=2>儲備顆星</td>
                           </tr>
                           <tr bgcolor="#bfbfbf">                        
                           	<td align=center class="font13">三月</td>
                           	<td align=center class="font13">四月</td>
                           	<td align=center class="font13">五月</td>
                           	<td align=center class="font13">六月</td>
                           	<td align=center class="font13">七月</td>
                           	<td align=center class="font13">八月</td>
                           	<td align=center class="font13">四月</td>
                           	<td align=center class="font13">五月</td>
                           	<td align=center class="font13">六月</td>
                           	<td align=center class="font13">七月</td>
                           	<td align=center class="font13">八月</td>
                           	<td align=center class="font13">圓夢組合</td>
                           	<td align=center class="font13">宅配單</td>
                           	<td align=center class="font13">淨水器</td>
                           	<td align=center class="font13">組織人數成長</td>
                           	<td align=center class="font13">60顆加碼</td>                           	
                           </tr>
	           	        <?php } ?>
	                     <tr>	        
	                     	 <td class="font13"><?=trim($rs["c_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["c_name"])?></td>	           	        	 
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["percnt"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["S03"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["S04"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["S05"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S06"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S07"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S08"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S114"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S115"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S116"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S117"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S118"])?></td>
                         <td align=right class="font13"><?=number_format($rs["SA"])?></td>
                         <td align=right class="font13"><?=number_format($rs["SB"])?></td>
                         <td align=right class="font13"><?=number_format($rs["SC"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S121"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S122"])?></td>
                         <td align=right class="font13"><?=number_format($rs["S12"])?></td>                         
                         <td align=right class="font13"><?=number_format($rs["SADJ"])?></td>                         
                         <td align=right class="font13"><?=number_format($rs["S21"])?></td>                         
                         <td align=right class="font13"><?=number_format($rs["S22"])?></td>                         
                         <td align=right class="font13"><?=number_format($rs["STAR"])?></td>                         
                         <td align=right class="font13"><?=number_format($rs["SAVESTAR"])?></td>                         
	           	         </tr>
	                    <?php
	                    $percnt   += $rs["percnt"];
	                    $S03      += $rs["S03"];   
                      $S04      += $rs["S04"];   
                      $S05      += $rs["S05"];   
                      $S06      += $rs["S06"];
                      $S07      += $rs["S07"];
                      $S08      += $rs["S08"];
                      $S114     += $rs["S114"];
                      $S115     += $rs["S115"];
                      $S116     += $rs["S116"];
                      $S117     += $rs["S117"];
                      $S118     += $rs["S118"];
                      $SA       += $rs["SA"];
                      $SB       += $rs["SB"];
                      $SC       += $rs["SC"];
                      $S121     += $rs["S121"];
                      $S122     += $rs["S122"];
                      $S12      += $rs["S12"];
                      $SADJ     += $rs["SADJ"];
                      $S21      += $rs["S21"];
                      $S22      += $rs["S22"];
                      $STAR     += $rs["STAR"];
                      $SAVESTAR += $rs["SAVESTAR"];
	                     //  ob_flush();
	                    //   flush();             
	                 } ?>	 
	                 <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=4><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($percnt)?></td>
                         <td align=right class="font13"><?=number_format($S03)?></td>
                         <td align=right class="font13"><?=number_format($S04)?></td>
                         <td align=right class="font13"><?=number_format($S05)?></td>
                         <td align=right class="font13"><?=number_format($S06)?></td>
                         <td align=right class="font13"><?=number_format($S07)?></td>
                         <td align=right class="font13"><?=number_format($S08)?></td>
                         <td align=right class="font13"><?=number_format($S114)?></td>
                         <td align=right class="font13"><?=number_format($S115)?></td>
                         <td align=right class="font13"><?=number_format($S116)?></td>
                         <td align=right class="font13"><?=number_format($S117)?></td>
                         <td align=right class="font13"><?=number_format($S118)?></td>
                         <td align=right class="font13"><?=number_format($SA)?></td>
                         <td align=right class="font13"><?=number_format($SB)?></td>
                         <td align=right class="font13"><?=number_format($SC)?></td>
                         <td align=right class="font13"><?=number_format($S121)?></td>
                         <td align=right class="font13"><?=number_format($S122)?></td>
                         <td align=right class="font13"><?=number_format($S12)?></td>
                         <td align=right class="font13"><?=number_format($SADJ)?></td>
                         <td align=right class="font13"><?=number_format($S21)?></td>
                         <td align=right class="font13"><?=number_format($S22)?></td>
                         <td align=right class="font13"><?=number_format($STAR)?></td>
                         <td align=right class="font13"><?=number_format($SAVESTAR)?></td>   
	           	         </tr>	  	                                     
	             </table>
	        <?php  } ?>