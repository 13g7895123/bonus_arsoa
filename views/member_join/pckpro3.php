<div class="mb-20 mt-5">
  <h5>贈品明細</h5>
</div>
<div class="table-responsive">
      <table class="table table-striped mb-2 text-center">
      	<thead class="thead-dark">
       	  <tr> 
            <th>贈品</th>                                        
            <th style="min-width: 158px;">數量</th>		
          </tr>
        </thead>
        <tbody>
   <?php   	 
   foreach ($pckpro as $key => $item){    	       
            ?>         									   		 
            <tr>
     				  <td nowrap="nowrap" class="text-left"><?=trim($item['p_name']); ?></td>             				  
     				  <td><?=number_format($item['qty'])?></td>
     				</tr>
   <?php
   } ?>   
   </tbody>
 </table>
</div>