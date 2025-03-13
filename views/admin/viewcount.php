<div id="page-wrapper">
	<div class="graphs">
      <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<table border="0" cellpadding="0" cellspacing="0" align=center>
<tr>
	<td height="50px"  valign="middle" style="font-size:15px">
		<font size=+2>瀏覽數查詢 | 總瀏覽數： 
<?php
		echo '<span class="badge-success">';
		echo number_format($total);
		echo '</span>';	
?>  
</font>&nbsp;&nbsp;
</td><td><font size=+2>
	  <a href="<?php echo base_url( 'wadmin/func/viewcount/'.$kind ); ?>">依日期</a>&nbsp;/&nbsp;<a href="<?php echo base_url( 'wadmin/func/viewcount/'.$kind.'/1'); ?>">依月份</a></td>
	  </tr><tr height="40px"><td align=center colspan=2>
<?php if ($Mon==""){?>
     
        <form name="SearchoForm" method="post" language="javascript" action="<?php echo $this->PATH_INFO?>" onSubmit="return SearchoForm_onsubmit(this);">
        <table><tr>
               <td valign="middle"><font size=+2>範圍：</font></td>
                <td width=160>
                  <div class="col-md-12"><?php 
                      $params = array(
			  	                        'TheDateField' => 'StartDate', 
			  	                        'TheDateValue' => $StartDate
			  	                        );			  	                
                      $this->ui->PJ_JInputDate('date',$params);
                      ?></div>
                </td>                
                <td valign="middle"><font size=+2>~</font></td>
                
                <td width=160>
                <div class="col-md-12"><?php 
                      $params = array(
			  	                        'TheDateField' => 'EndDate', 
			  	                        'TheDateValue' => $EndDate
			  	                        );			  	                
                      $this->ui->PJ_JInputDate('date',$params);
                      ?></div>
                </td>                
                <td>
                <div class="col-md-2">
                <input type="submit" name="Submit" value="查詢" class="btn btn-success">             
                
                 </div>
              </td>
        </table>
        </form>
<?php }?>        
	</td>
</tr>
</table>   
<center>
<SCRIPT src="<?php echo base_url('public/js/Chart.bundle.js')?>" type=text/javascript></SCRIPT>
  <div style="width:90%;">
        <canvas id="hr_line_A_172"></canvas>
  </div>
  <script>               
        var config_hr_line_A_172 = {
            type: 'line',
            data: {
                labels: [<?=$xstr?>],
                datasets: [{
                    label: "",
                    data: [<?=$ystr?>],
                    fill: true,
                    borderDashOffset: 0.0,
                    backgroundColor: "rgba(75,192,192,0.7)",
                    borderColor: "rgba(75,192,192,1)",
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointHoverBackgroundColor: "rgba(75,192,192,1)",
                    pointHoverBorderColor: "rgba(220,220,220,1)",                    
                    borderCapStyle: 'butt',
                    borderJoinStyle: 'miter',
                    pointBorderWidth: 1,
                    pointHoverRadius: 1,
                    lineTension: 0.1,
                    borderDash: [1,1],
                }]
            },
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:''
                },
               
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                        <?php if ($Mon==""){ ?>
                            display: true, // 下面是否要顯示名稱
                            labelString: '合計:<?=$sum?>'
                        <?php }else{ ?>
                            display: false, // 下面是否要顯示名稱
                            labelString: 'Value'
                        <?php } ?>
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: false, // 左邊是否要顯示名稱
                            labelString: 'Value'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 10,
                        }
                    }]
                }
            }
        };        
    </script>
</center>
<br><br>
<script>    
window.onload = function() {
        var ctx = document.getElementById("hr_line_A_172").getContext("2d");
        window.myLine = new Chart(ctx, config_hr_line_A_172);
        
          };  
</script>  
</div>
