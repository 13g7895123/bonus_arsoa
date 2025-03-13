				                <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">．訂單編號：</label>
                          <div class="col-sm-3">
                            <p class="text-danger"><?=$main['web_no']?></p>
                          </div>
					              	<label for="staticEmail" class="col-sm-2 col-form-label">．訂購日期：</label>
                          <div class="col-sm-4">
                             <p><?=date('Y-m-d H:i:s',strtotime($main['or_date']))?></p>
                          </div>
                        </div>
                        <?php 
                              if (trim($main['pay_type']) == 'A'){ 
                                  $pay_title = '實體ATM'; 
                              }
                              if (trim($main['pay_type']) == 'W'){ 
                                  $pay_title = '網路ATM'; 
                              }
                              if (trim($main['pay_type']) == 'C'){ 
                                  $pay_title = '信用卡付款'; 
                              }
                              if ($main['success']){                                                                     
                                  ?>
                                  <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">．付款狀態：</label>
                                    <div class="col-sm-9">
                                      <p class="text-danger font-weight-bold"><?=$pay_title?>
                                         <?php if ($main['amt'] == 0){ 
                                                   echo '紅利兌換成功';
                                               }else{
                                                   echo "付款成功";
                                                   if (isset($order) && $order == 'Y'){ ?>
                                                   (我們已經收到您的訂單與付款，謝謝您的訂購，我們會馬上處理！) 
                                         <?php      } 
                                               } ?>
                                      </p>
                                    </div>                                  
                                  </div>
                         <?php }else{                        	  
                                    if (trim($main['pay_type']) == 'A' && !$main['success']){
                            	  	      $showt = "尚未匯款";
                            	  	      $atmdate = date('Y-m-d',strtotime('+3 day',strtotime($main['or_date'])));
                            	  	      $showt .= "&nbsp;&nbsp;&nbsp;";
                            	  	      $showt .= "匯款期限：".$atmdate." 23:59";
                            	  	  }else{          
                            	  	      $errmsg2 = '';                  	  
                            	          if ($main['errmsg2'] > ''){
                            	     	        $errmsg2 = str_replace('<br>','', $main['errmsg2']);
                            	     	        $errmsg2 = "(".$errmsg2.")";
                            	          }
                            	          $showt = $main['ord_statue']."&nbsp;&nbsp;".$errmsg2;
                            	      }
                            	      ?>
                            	    <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">．付款狀態：</label>
                                    <div class="col-sm-9">
                                      <p class="text-danger font-weight-bold"><?=$showt?></p>
                                    </div>                                  
                                  </div>
                        <?php } ?>
                        
                        <?php if (trim($main['pay_type']) == 'A' && !$main['success']){ ?>
					                        <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">．虛擬帳號：</label>
                                    <div class="col-sm-9">
                                      <p class="text-danger font-weight-bold">822 中國信託商業銀行　<?=$main['WebATMAcct']?></p>
                                    </div>                                  
                                  </div>
                        <?php } ?>          
					           
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-3 col-form-label">．訂購會員：</label>
                          <div class="col-sm-9">
                          <?=$main['c_no']?> <?=$main['c_name']?>
                        </div>
                        </div>
                      <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">．收件人姓名：</label>
                          <div class="col-sm-9">
                          <?=$main['recv_name']?>
                        </div>
                        </div>
					  <div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">．收件人地址：</label>
                          <div class="col-sm-9">
                          <?=$main['zip_dl']?> <?=$main['addr_dl']?>
                        </div>
                        </div>
						<div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">．收件人聯絡電話：</label>
                          <div class="col-sm-9">
                          <?=$main['cell1']?>
                        </div>
                        </div>
						<div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">．電子郵件信箱：</label>
                          <div class="col-sm-9">
                          <?=$main['e_mail']?>
                        </div>
                        </div>
						<div class="form-group row">
                          <label for="inputPassword" class="col-sm-3 col-form-label">．付款人身份證字號：</label>
                          <div class="col-sm-9">
                          <?=substr($main['idno'], 0,3)?>XXXXX<?=substr($main['idno'], -2)?>
                        </div>
                        </div>
                    
					
				  </div>
				
                  <div class="mb65" style="margin-top:-50px">
					<table class="table table-striped mb-2 w-100">
  <thead class="thead-dark">
    <tr>
      <th></th>      
      <th>產品名稱</th>
      <th>單價</th>
      <th>數量</th>
      <th>小計</th>
      <th>BP小計</th>
      <th>兌換紅利</th>
      <th>加贈紅利</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($prd as $key => $item){ ?>
              <tr>
                <th scope="row"><?=($key+1)?></th>      
                <td><?=$item['p_name']?></td>
                <td><?php
                if ($item['c_price'] > 0){
                    echo number_format($item['c_price']);
                }?></td>
                <td><?=$item['qty']?></td>
                <td><?php
                if ($item['c_price'] > 0){
                    $total_price = $item['c_price'] * $item['qty'];                    
                    echo number_format($total_price);
                }?></td>
                <td><?php
                if ($item['pv'] > 0){
                    $total_pv = $item['pv'] * $item['qty'];
                    echo number_format($total_pv);
                }?></td>
                <td><?php
                if ($item['m_mp'] > 0){
                    $total_m_mp = $item['m_mp'] * $item['qty'];
                    echo number_format($total_m_mp);
                }?></td>
                <td><?php
                if ($item['p_mp'] > 0){
                    $total_p_mp = $item['p_mp'] * $item['qty'];
                    echo number_format($total_p_mp);
                }?></td>
    </tr>
    <?php } ?>   
  </tbody>
</table>
<div class="row">	
	<div class="col-md-5">
		<table class="table text-right">
  <thead>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">BP</th>
      <th scope="col">建議售價</th>
      </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">A類</th>
      <td><?=number_format($main['a_pv'])?></td>
      <td><?=number_format($main['a_amt'])?></td>
      </tr>
    <tr>
      <th scope="row">B類</th>
      <td><?=number_format($main['b_pv'])?></td>
      <td><?=number_format($main['b_amt'])?></td>
      </tr>
    <tr>
      <th scope="row">合計</th>
      <td><?=number_format($main['a_pv']+$main['b_pv'])?></td>
      <td><?=number_format($main['u_amt'])?></td>
      </tr>
  </tbody>
</table>
	</div>
<div class="col-md-4">
		<table class="table text-right">
  <thead>
    <tr>
		<th colspan="2" scope="col">紅利</th>
      </tr>
  </thead>
  <tbody>   
    <tr>
      <th scope="row">+ 回饋紅利</th>
      <td><?=number_format($main['r_mp'])?></td>
      </tr>
    <tr>
      <th scope="row">+ 加贈紅利</th>
      <td><?=number_format($main['p_mp'])?></td>
      </tr>
    <tr>
      <th scope="row">- 兌換紅利</th>
      <td><?=number_format($main['m_mp'])?></td>
    </tr>
  </tbody>
</table>
	</div>
					  <div class="col-md-3">
		<table class="table text-right">
  <thead>
    <tr>
      <th colspan="2" scope="col">建議售價</th>
      </tr>
  </thead>
  <tbody>      
      <tr>
         <th scope="row">總金額</th>
         <td><?=number_format($main['amt'])?></td>
      </tr>
  </tbody>
</table>
	</div>
	
</div>		         