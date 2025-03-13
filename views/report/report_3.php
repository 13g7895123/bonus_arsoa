<?php 
$pv_per  = 0;
$pv_sv  = 0;
$pv_wv  = 0;
$pv_mp  = 0;               
$a_amt  = 0;
$pv_h_per = 0;
$pv_h_sv  = 0;
$pv_h_wv  = 0;
$b_amt  = 0;
$pv_nstar = 0;
$mp = 0;
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
                                     <td height="5" colspan="2"></td>
                                   </tr>
	           	        		   <tr>
	           	        			  <td class="font15"><?=trim($rs["c_no"])?>&nbsp;&nbsp;<?=trim($rs["c_name"])?>&nbsp;&nbsp;<?=trim($rs["orgtype"])?>
	           	        				<br><span class="font13"><font color=red> (獎金欄位打勾,表示本月份符合領取獎金資格) </font>
	           	        			  </td>
	           	        			  <td align=right class="font13" valign="bottom">更新日期:<?=date('Y-m-d H:i',strtotime($this->session->userdata('bp_date')))?></td>
	           	        		   </tr>
	           	        		   <tr>
                                     <td height="5" colspan="2"></td>
                                   </tr>
	           	         		  </table>
	           	        	   </td>
	           	            </tr>
	           	           </table>
	           	           <table style="BORDER-RIGHT: medium none; BORDER-TOP: medium none; BORDER-LEFT: medium none; BORDER-BOTTOM: medium none; BORDER-COLLAPSE: collapse; mso-border-alt: solid windowtext .5pt; mso-padding-alt: 0cm 1.4pt 0cm 1.4pt"
                            bordercolor=#000000 cellspacing=0 cellpadding=2
                            border=1 align="center" width="100%" class="shi12_20">
                           <tr bgcolor="#bfbfbf">
                            <td align=center class="font13" rowspan=2>獎金<br>(A)</td>
                            <td align=center class="font13" rowspan=2>獎金<br>(B)</td>
                            <td align=center class="font13" rowspan=2>推廣<br>(A)</td>
                            <td align=center class="font13" rowspan=2>推廣<br>(B)</td>
                            <td align=center class="font13" rowspan=2>會員<BR>編號</td>
                            <td align=center class="font13" rowspan=2>姓名</td>
                            <td align=center class="font13" rowspan=2>生日<BR>月份</td>
                            <td align=center class="font13" rowspan=2>位階</td>
                            <td align=center class="font13" rowspan=2>上線<BR>姓名</td>
                            <td align=center class="font13" colspan=4>A 類</td>
                            <td align=center class="font13" colspan=4>B 類</td>                                                         
                            <td align=center class="font13" rowspan=2>到期日</td>
                            <td align=center class="font13" rowspan=2>顆星數</td>
                            <td align=center class="font13" rowspan=2>紅利點數</td>
                           </tr>
                           <tr bgcolor="#bfbfbf"> 
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">個人<br>訂購<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">個人<br>組織<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">整體<br>組織<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">本月<BR>建議售價</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">個人<br>訂購<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">個人<br>組織<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">整體<br>組織<BR>BP</td>
                            <td align=center class="font13" style="WHITE-SPACE: nowrap;">本月<BR>建議售價</td>                               
                           </tr>
	           	        <?php  } ?>
	                     <tr>
	           	        	 <td align=center class="font13"><?php
	           	        	  if (trim($rs["is_bonu"]) == "Y"){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>
	           	        	 <td align=center class="font13"><?php
	           	        	  if (trim($rs["is_h_bonu"]) == "Y"){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>
	           	        	 <td align=center class="font13"><?php
	           	        	  if (trim($rs["is_a_dev"]) == "Y"){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>
	           	        	 <td align=center class="font13"><?php
	           	        	  if (trim($rs["is_b_dev"]) == "Y"){
	           	        	     echo "√";
	           	        	  } ?>
	           	        	 </td>
	           	        	 <td class="font13"><?=trim($rs["o_no"])?></td>
	           	        	 <td class="font13"><?=trim($rs["o_name"])?></td>
	           	        	 <td align=center class="font13"><?=trim($rs["b_mon"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_pos"])?></td>
	           	        	 <td class="font13"><?=trim($rs["d_spname"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_per"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_sv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_wv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["a_amt"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_h_per"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_h_sv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["pv_h_wv"])?></td>
	           	        	 <td align=right class="font13"><?=number_format($rs["b_amt"])?></td>
	           	        	 <td class="font13"><?=trim($rs["fee_date"])?></td>
	           	        	 <td align=right class="font13"><?php
	           	        	    $nstar = $rs["star"];
	           	        	    if ($nstar == ""){
	           	        	        $nstar = 0;
	           	        	    }
	           	        	    echo number_format($nstar);
	           	        	    ?></td>                         
	           	        	 <td align=right class="font13"><?php
	           	        	    $nmp = $rs["mp"];
	           	        	    if ($nmp == ""){
	           	        	        $nmp = 0;
	           	        	    }
	           	        	    echo number_format($nmp);
	           	        	    ?></td>                            
	           	         </tr>	                    
	                    <?php
	                    $pv_per  = $pv_per  + $rs["pv_per"];
	           	        $pv_sv  = $pv_sv  + $rs["pv_sv"];
	           	        $pv_wv  = $pv_wv  + $rs["pv_wv"];
	           	        $a_amt  = $a_amt  + $rs["a_amt"];
	           	        $pv_h_per  = $pv_h_per  + $rs["pv_h_per"];
	           	        $pv_h_sv  = $pv_h_sv  + $rs["pv_h_sv"];
	           	        $pv_h_wv  = $pv_h_wv  + $rs["pv_h_wv"];
	           	        $b_amt  = $b_amt  + $rs["b_amt"];	           	        
	           	        $pv_nstar  = $pv_nstar  + $nstar;	           	        
	           	        $mp  +=  $nmp;	       
	           	     } ?>
	                     <tr bgcolor="#DDDDDD">
	           	        	 <td align=right class="font13" colspan=9><b>合計</td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($pv_per)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_sv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_wv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($a_amt)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_h_per)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_h_sv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($pv_h_wv)?></td>
	           	        	 <td align=right class="font13"><?=number_format($b_amt)?></td>	           	        	 
	           	        	 <td align=right class="font13"></td>	           	        	 
	           	        	 <td align=right class="font13"><?=number_format($pv_nstar)?></td>
	           	        	 <td align=right class="font13"><?=number_format($mp)?></td>
	           	         </tr>	  
	             </table>                      
	        <?php  } ?>