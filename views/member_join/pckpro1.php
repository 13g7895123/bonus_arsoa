<div class="mb-20">
  <h5>基本組合</h5>
</div>
<div class="table-responsive">
 <table class="table table-striped mb-2 text-center">
   <?php
   $colspan_num = 1;
   switch ($jointype) {
	     case 4:
	         $colspan_num = 2;
	         if ($pagetype == 'M'){
	         		 ?>
	         		 <thead class="thead-dark">
           		   <tr>
           		     <th colspan=2>專案</th>                          
           		     <th>首簽當期贈品</th>  
           		     <th>首簽後<br>每滿 6 個月循環總贈品</th>																																
           		     <th>每月宅配<br>金額</th>
           		   </tr>
           		 </thead>
           		 <tbody> 
	         		 <?php
	         }else{
	         		 $colspan_num = 4;
	         		 ?>
	         		 <thead class="thead-dark">
           		   <tr>
           		     <th colspan=4>專案</th>                          
           		     <th>每月宅配<br>金額</th>
           		   </tr>
           		 </thead>
           		 <tbody> 
	         		 <?php
	         }
	         break;
	     case 5:
	         $colspan_num = 3;
	         if ($pagetype == 'M'){
	         		 ?>
	         		 <thead class="thead-dark">
           		   <tr>
           		     <th colspan="<?=$colspan_num?>">專案 ( 一次 3 期 / 6 個月為一完整循環 )</th>                          
           		     <th>每期贈品</th>              									                
           		     <th>每期宅配金額</th>
           		   </tr>
           		 </thead>
           		 <tbody> 
	         		 <?php	
	         }else{
	         	   $colspan_num = 4;
	         	   ?>
	         		 <thead class="thead-dark">
           		   <tr>
           		     <th colspan="<?=$colspan_num?>">專案 ( 一次 3 期 / 6 個月為一完整循環 )</th>                                     		                 									                
           		     <th>每期宅配金額</th>
           		   </tr>
           		 </thead>
           		 <tbody> 
	         		 <?php	
	         }
	         break;	
	     case 6:
	         $colspan_num = 2;
	         ?>
	         <thead class="thead-dark">
             <tr>
               <th colspan=2>專案</th>                          
               <th>建議售價</th>  
               <th style="min-width: 158px;">數量</th>																																
               <th>金額</th>
             </tr>
           </thead>
           <tbody> 
	         <?php	
	         break;	    															        
	     default:
	         $colspan_num = 2;
	         ?>
	         <thead class="thead-dark">
             <tr>
               <th colspan="<?=$colspan_num?>">品名</th>                          
               <th>建議售價</th>  
               <th style="min-width: 158px;">數量</th>																																
               <th>金額</th>
             </tr>
           </thead>
           <tbody>   																	        
	         <?php																	        
	 }   
	 $total_price = 0;
	 $total_qty = 0;
   foreach ($pckpro as $key => $item){ 
   	        $prdtotal = $item['price']*$item['qty'];
   	        $total_price += $prdtotal;
   	        $total_qty += $item['qty'];
            ?>         									   		 
            <tr>
     				  <td nowrap="nowrap" class="text-left" colspan="<?=$colspan_num?>"><?=$this->block_service->load_join_product(trim($item['p_no']),trim($item['p_name']),$item['price']); ?></td>        
     				  <?php
     				  		switch ($jointype) {
									    case 4:
									        if ($pagetype == 'M'){
									        	  echo "<td>".$item['firstgive']."</td>";
            							    echo "<td>".$item['aftergive']."</td>";
            							}else{
            								
            							}
            							echo "<td>".number_format($prdtotal)." 元</td>";									        
									        break;
									    case 5:									        
									        if ($pagetype == 'M'){
									        	  echo "<td>".$item['everygive']."</td>";
									        	  echo "<td>".number_format($prdtotal)." 元/".$item['everybp']."</td>";
									        }else{
									        	  echo "<td>".number_format($prdtotal)." 元</td>";									        
									        }									        
									        break;																        
									    default:
									        ?>
									        <td><?=number_format($item['price'])?></td>
            							<td><?=$item['qty']?></td>
            							<td><?=number_format($prdtotal)?> 元</td>
									        <?php																	        
									}    			
            	?>
     				</tr>
   <?php
   } ?>   
		<tr>
		  <td nowrap="nowrap" class="text-right" colspan=4>合計：</td>				  
		  <th><?=number_format($total_price)?> 元</th>
		  </tr>
   </tbody>
 </table>
</div>