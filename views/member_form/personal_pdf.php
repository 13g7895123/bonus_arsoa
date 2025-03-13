<?php if (isset($personal_data['birth_year'])){
   	        $s_y = $personal_data['birth_year'] - 1911;
   	        $s_age = date('Y') - $personal_data['birth_year'];
   	        
   	        $birth_year = $s_age." 歲";
   	  }
?>
   	        
<table cellspacing="2" cellpadding="4">
    <tr>
        <td><strong>手機號碼：</strong><?=$mobile?></td>
        <td><strong>姓名：</strong><?=$name?></td>
        <td><strong>性別：</strong><?=$sex?></td>
    </tr>
    <tr>    
        <td><strong>年齡：</strong><?=$birth_year?></td>             
		    <td><strong>身高：</strong><?=$q2?></td>
		    <td><strong>運動習慣：</strong><?=$q1?></td>
    </tr>
</table>

<br /><br />

<?php if ($qtype == 'q3'){ ?>
<table cellspacing="0" cellpadding="4">
    <tr>
        <td><b>肌膚困擾：</b><?=$q3?>
		    </td>
    </tr>	
</table>    
<table cellspacing="0" cellpadding="4" class="tableb">
    <tr>
        <td width="20%">
        	<b></b>
        </td>	
        <td width="40%" align="center">
        	肌膚特徵
		    </td>
		    <td width="40%" align="center">
        	建議產品
		    </td>
    </tr>
    <tr>
        <td>
        	<b><?=$q4?></b>
        </td>	
        <td><?=$form_q4_set[$q4.'_time']?></td>
		    <td><?=$form_q4_set[$q4.'_hz']?></td>
    </tr>	
</table> 
<br>
<?php } ?>