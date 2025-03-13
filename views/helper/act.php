<?php            
     $fnum = 0;
     $num = 0;
	   $gid = 0;
	   
     if ($itype == 'cart'){             
	        	foreach ($actdata as $key => $item){ 		             		                 
		                   $num++;
		                   if ($gid <> $item['gid']){
		           	           if ($fnum > 0){
		           	           	   ?>
		           	           	      </tbody>
                                 </table>
	                             </div>
		           	           	   <?php
		           	           }
		           	           $fnum++;
		                       ?>
	                         <div class="col-md-6">
	                         	<p class="text-danger text-center"><?=$item['gtitle']?></p>
	                         	<table class="table table-bordered">
                               <thead>
                                 <tr class="bg-light">         
                                 	 <?php if (!$item['gisgive']){ ?>
                                   <th scope="col">選擇</th>
                                   <?php } ?>
                                   <th scope="col">產品名稱</th>
                                   <th scope="col">數量</th>
                                   <?php if (!$item['gisgive'] && $item['gisbuy']){ ?>
                                   <th scope="col">加購價</th>
                                   <?php } ?>
                                   <?php if (!$item['gisgive'] && $item['gismp']){ ?>
                                   <th scope="col">加贈紅利</th>
                                   <?php } ?>
                                 </tr>
                               </thead>
                               <tbody>
                    <?php } ?>
                       <tr>
                       	 <?php if (!$item['gisgive']){ ?>
                               <td scope="row" style="text-align: center;">
                               <?php if ($item['qty'] > 0){ ?>
                                         <input type="checkbox" name="act_<?=$atype?>_<?=$item['gid']?>[]" id="act_<?=$atype?>_<?=$item['gid']?>[]" 
                         	               <?php 
                         	               if (!empty($this->session->userdata( 'act' )) && in_array(trim($item['p_no']),$this->session->userdata( 'act' ))){
                         	     	             echo " checked";
                         	               }
                         	               ?>
                         	               onclick="change_cart('G',0);" value="<?=trim($item['p_no'])?>" >
                         	     <?php } ?>
                         	     </td>
                         <?php } ?>
                         <td><?=$item['p_name']?></td>
                         <td><?=$item['qty']?></td>
                         <?php if (!$item['gisgive'] && $item['gisbuy']){ ?>
                             <td><?=number_format($item['c_price'])?>元</td>
                         <?php } ?>
                         <?php if (!$item['gisgive'] && $item['gismp']){ ?>
                             <td><?=number_format($item['p_mp'])?></td>
                         <?php } ?>
                       </tr>
      <?php 
                  $gid = $item['gid'];
             } ?>              
                 </tbody>
              </table>
	          </div>
<?php }else{ 
            foreach ($actdata as $key => $item){ 		             		                 	         
	        		   // 贈送的 再加上 選擇的
	        		   if ($item['qty'] > 0 && ($item['gisgive'] || (!empty($this->session->userdata( 'act' )) && in_array(trim($item['p_no']),$this->session->userdata( 'act' ))))){    
		                 if ($gid <> $item['gid']){
		           	           if ($fnum > 0){
		           	           	   echo '</tbody>
                                 </table>
	                             </div>';
		           	           }
		           	           $fnum++;
		                       ?>
	                         <div class="col-md-6">
	                         	<p class="text-danger text-center"><?=$item['gtitle']?></p>
	                         	<table class="table table-bordered">
                               <thead>
                                 <tr class="bg-light">    
                                   <th scope="col">產品名稱</th>
                                   <th scope="col">數量</th>
                                   <?php if (!$item['gisgive']){ ?>
                                         <?php if ($item['gisbuy']){ ?>
                                         <th scope="col">加購價</th>
                                         <?php } ?>
                                         <?php if ($item['gismp']){ ?>
                                         <th scope="col">加贈紅利</th>
                                         <?php } ?>
                                   <?php } ?>
                                 </tr>
                               </thead>
                               <tbody>
                <?php } ?>
                       <tr>
                       	 <td><?=$item['p_name']?></td>
                         <td><?=$item['qty']?></td>
                       	 <?php if (!$item['gisgive']){ ?>
                                <?php if ($item['gisbuy']){ ?>
                                    <td><?=number_format($item['c_price'])?>元</td>
                                <?php } ?>
                                <?php if ($item['gismp']){ ?>
                                    <td><?=number_format($item['p_mp'])?></td>
                                <?php } ?>
                         <?php } ?>
                       </tr>
      <?php        }
                  $gid = $item['gid'];
             } 
             if ($gid <> 0){
                 echo '</tbody>
                      </table>
	                    </div>';
	           } 	      
     } ?>