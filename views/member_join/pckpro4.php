<div class="mb-20 mt-5">
  <h5>紅利兌換</h5>
</div>
<div class="table-responsive">
      <table class="table table-striped mb-2 text-center">
      	<thead class="thead-dark">
       	  <tr> 
            <th>兌換商品</th>                            
            <th>點數</th>
            <th style="min-width: 158px;">數量</th>				    
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
   <?php   
	 $total_price = 0;
   foreach ($pckpro as $key => $item){ 
   	        $prdtotal = $item['m_mp']*$item['qty'];
   	        $total_price += $prdtotal;
            ?>         									   		 
            <tr>
     				  <td nowrap="nowrap" class="text-left"><?=$this->block_service->load_join_product(trim($item['p_no']),trim($item['p_name']),$item['m_mp'],'點數'); ?></td>        
     				  <td><?=number_format($item['m_mp'])?></td>
     				  <td><?=number_format($item['qty'])?></td>
     				  <td><?=number_format($prdtotal)?></td>     				  
     				</tr>
   <?php
   } ?>   
		<tr>
		  <td nowrap="nowrap" class="text-left">&nbsp;</td>
		  <td>&nbsp;</td>
		  <th>合計：</th>
		  <th><?=number_format($total_price)?></th>
		  </tr>
   </tbody>
 </table>
</div>