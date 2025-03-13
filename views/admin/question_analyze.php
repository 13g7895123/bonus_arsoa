<?php 

$q = json_decode($listdata[0]['q_ans'], true);
$a = json_decode($listdata[0]['reply'], true);

$set_color = array("255, 99, 132","255, 159, 64","255, 205, 86","75, 192, 192","54, 162, 235","153, 102, 255","201, 203, 207","255, 206, 86");
?>
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i> 問卷：<?=$listdata[0]['q_id']?> <?=$listdata[0]['q_title']?>
    </div>
    <script src="<?=base_url().'public/js/chart.js/Chart.bundle.js'?>" type="text/javascript"></script>
   
   <table class="table table-bordered fa-xs" width="100%" cellspacing="0" style="font-size:18px;">
     <?php 
     $n = 0;
     foreach($q as $key1 => $item1) 
     {  
        $n++;
        
        $astr = '';
        $astr_c = '';
        $astr_b = '';
        $astr_n = '';
        foreach($a[$key1] as $key2 => $item2) {  
              if ($astr > ''){ 
                 $astr .= ","; 
                 $astr_c .= ",";
                 $astr_b .= ",";
                 $astr_n .= ",";
              }
              $astr .= '"'.trim($item2).'"';
              
              $astr_c .= '"rgba('.$set_color[$n].', 0.2)"';              
              $astr_b .= '"rgb('.$set_color[$n].')"';     
              
              $num = 0;
              /*foreach($survey_reply as $item3) {  
                      if ($n == $item3['num']){
                          if (($key2+1) == $item3['ans']){
                              $num++;
                          }
                      }
              }*/
              $astr_n .= $num;     
              $ans[$key1][$key2] = $num;
        }
        $item1 = str_replace(array("\n"),'<br>',$item1);
        ?>
     <tr>
       <td><?=$n?></td>
       <td><?=$item1?></td>
       <td><table class="table table-bordered fa-xs" width="100%" cellspacing="0">
          <?php
          //$mnum = count($a[$key1])-1;
          foreach($a[$key1] as $key4 => $item4) {  
                 $anum = 0;
                 foreach($a[$key1] as $key5 => $item5) {  
                         $anum += $ans[$key1][$key5];
                 }                 
                 if ($anum > 0){
                     $p = ($ans[$key1][$key4]/$anum) * 100;
                 }else{
                     $ans[$key1][$key4] = '';
                     $p = '';
                     $anum = '';
                 }
                 echo '<tr><td>';
                 echo $item4;
                 echo '</td>';
                 echo '<td width=50>'.$ans[$key1][$key4].'';
                 echo '</td>';
                 echo '<td width=50>';
                 if ($p <> '0' && $anum > 0 && $p <> 'NAN'){
                     echo round($p,1).'%';
                 }
                 echo '</td>';
                 echo '</tr>';
          }  
          ?></table>
       </td>
       <td><div class="chart-container" style="position: relative; height:300px; width:500px">
           <canvas id="chartjs-<?=$n?>" class="chartjs" width="undefined" height="undefined"></canvas>
           </div>
       </td>               
      </tr> 
    <script>new Chart(document.getElementById("chartjs-<?=$n?>"),{
              "type":"doughnut",
              "data":{
                 "labels":[<?=$astr?>],
                 "datasets":[{
                     "label":"My First Dataset",
                     "data":[<?=$astr_n?>],
                     "backgroundColor":[<?=$astr_b?>]}]
                     }
                  }
            );
    </script>
         
         <?php if (1==2){?>
    <script>
      new Chart(document.getElementById("chartjs-<?=$n?>"),{
           type:"horizontalBar",  
           data:{
             labels:[<?=$astr?>],
             datasets:[{
                  barPercentage: 1,
                  barThickness: 6,
                  maxBarThickness: 8,
                  minBarLength: 3,
                  pointRadius: 0,
                  data:[<?=$astr_n?>],
                  fill:false,
                  backgroundColor:[<?=$astr_c?>],
                  borderColor:[<?=$astr_b?>],
                               "borderWidth":1}]},
                  options:{
                     scales:{                         
                        xAxes:[{
                           ticks:{
                              "beginAtZero":true,
                              min: 0,
                              stepSize: 1
                            }
                        }]
                     },
                     legend: {
                        display: false 
                     }
                  }  
           });
    </script>    
   <?php 
      }
     } ?>
    </table>
    <div class="clearfix"></div>

    <div class="card-footer small text-muted">資料時間: <?=date('Y-m-d H:i:s')?></div>
</div>