                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．訂單編號：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p class="text-danger" style="color: red;"><?=$main['web_no']?></p>
                          </div>
                      </div>
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．訂購日期：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
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
                              if (trim($main['pay_type']) == 'F'){ 
                                  $pay_title = '紅利兌換'; 
                              }
                              if ($main['success']){                                                                     
                                  ?>
                                  <div class="form-group row" style="padding: 0 30px;">
                                      <div class="col-sm-3" style="width: 25%;float: left;">
                                       <p>．付款狀態：</p></div>
                                      <div class="col-sm-9" style="width: 65%;float: left;">
                                        <p class="text-danger font-weight-bold" style="color: red;font-weight: bold;"><?=$pay_title?>
                                         <?php if ($main['amt'] == 0){ 
                                                   echo '兌換成功 ';                                                   
                                               }else{
                                                   echo "付款成功 ";
                                               }
                                               if (isset($order) && $order == 'Y'){ 
                                                   echo '<br>(我們已經收到您的訂單與付款，謝謝您的訂購，我們會馬上處理！) ';
                                               } ?>
                                      </p>
                                      </div>
                                  </div>                      
                         <?php }else{                        	  
                                    if (trim($main['pay_type']) == 'A' && !$main['success']){
                            	  	      $showt = "尚未匯款";
                            	  	      $atmdate = date('Y-m-d',strtotime('+1 day',strtotime($main['or_date'])));
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
                            	    <div class="form-group row" style="padding: 0 30px;">
                                      <div class="col-sm-3" style="width: 25%;float: left;">
                                       <p>．付款狀態：</p></div>
                                      <div class="col-sm-9" style="width: 65%;float: left;">
                                        <p class="text-danger font-weight-bold" style="color: red;font-weight: bold;"><?=$pay_title?>&nbsp;<?=$showt?></p>
                                      </div>
                                  </div>    
                        <?php } ?>
                        
                        <?php if (trim($main['pay_type']) == 'A' && !$main['success']){ ?>
					                        <div class="form-group row" style="padding: 0 30px;clear: left;">
                                    <label for="staticEmail" class="col-sm-3 col-form-label" style="width: 16.666667%;float: left;margin: 10px 0;">．虛擬帳號：</label>
                                    <div class="col-sm-9" style="width: 75%;float: left;margin: 10px 0;">
                                      <p class="text-danger font-weight-bold" style="color: red;font-weight: bold;">822 中國信託商業銀行　<?=$main['WebATMAcct']?></p>
                                    </div>                                  
                                  </div>
                        <?php } ?>          
					            <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．訂購會員：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=$main['c_no']?> <?=$main['c_name']?></p>
                          </div>
                      </div>    
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．收件人姓名：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=$main['recv_name']?></p>
                          </div>
                      </div>     
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．收件人地址：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=$main['zip_dl']?> <?=$main['addr_dl']?></p>
                          </div>
                      </div>     
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．收件人聯絡電話：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=$main['cell1']?></p>
                          </div>
                      </div>    
                      <?php if (trim($main['e_mail']) > ''){ ?>
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．電子郵件信箱：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=$main['e_mail']?></p>
                          </div>
                      </div>    
                      <?php } ?>
                      <?php if (1==2){ ?>
                      <div class="form-group row" style="padding: 0 30px;">
                          <div class="col-sm-3" style="width: 25%;float: left;">
                           <p>．付款人身份證字號：</p></div>
                          <div class="col-sm-9" style="width: 65%;float: left;">
                            <p><?=substr($main['idno'], 0,3)?>XXXXX<?=substr($main['idno'], -2)?></p>
                          </div>
                      </div>    
                      <?php } ?>
					
				  </div>
				
                  <div class="mb65" style="margin-top:-50px">
					<table class="table table-striped mb-2 w-100" border="0" style="border: 1px solid #999;width: 100%;">
  <thead class="thead-dark" style="color: #212529;">
    <tr style="box-sizing: border-box;padding: .75rem;height:50px">
      <th style="padding: .75rem;color: #fff;background-color: #343a40;border-color: #454d55;"></th>      
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">產品名稱</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">單價</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">數量</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">小計</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">BP小計</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">兌換紅利</th>
      <th style="color: #fff;background-color: #343a40;border-color: #454d55;">加贈紅利</th>
    </tr>
  </thead>
  <tbody>
    <?php 
          $pn = 0;
          foreach ($prd as $key => $item){ 
              $pn++;
              if ($pn % 2 == 1){ ?> 
              <tr style="padding: .75rem;height:50px;border-top: 1px solid #dee2e6;background-color: rgba(0,0,0,.05);">
              <?php }else{ ?> 
              <tr style="padding: .75rem;height:50px;border-top: 1px solid #dee2e6;">
              <?php } ?>   
                <th scope="row"><?=($key+1)?></th>      
                <td><?=$item['p_name']?></td>
                <td style="text-align:right;"><?php
                if ($item['c_price'] > 0){
                    echo number_format($item['c_price']);
                }?></td>
                <td style="text-align:right;"><?=$item['qty']?></td>
                <td style="text-align:right;"><?php
                if ($item['c_price'] > 0){
                    $total_price = $item['c_price'] * $item['qty'];                    
                    echo number_format($total_price);
                }?></td>
                <td style="text-align:right;"><?php
                if ($item['pv'] > 0){
                    $total_pv = $item['pv'] * $item['qty'];
                    echo number_format($total_pv);
                }?></td>
                <td style="text-align:right;"><?php
                if ($item['m_mp'] > 0){
                    $total_m_mp = $item['m_mp'] * $item['qty'];
                    echo number_format($total_m_mp);
                }?></td>
                <td style="text-align:right;"><?php
                if ($item['p_mp'] > 0){
                    $total_p_mp = $item['p_mp'] * $item['qty'];
                    echo number_format($total_p_mp);
                }?></td>
    </tr>
    <?php } ?>   
  </tbody>
</table>
<div class="row">	
	<div class="col-md-5" style="width: 41.666667%;float: left;">
		<table class="table text-right" style="text-align: right!important;width:100%">
  <thead>
    <tr>
      <th scope="col" style="padding: .75rem;border-top: 1px solid #dee2e6;">&nbsp;</th>
      <th scope="col" style="padding: .75rem;border-top: 1px solid #dee2e6;">BP</th>
      <th scope="col" style="padding: .75rem;border-top: 1px solid #dee2e6;">建議售價</th>
      </tr>
  </thead>
  <tbody>
    <tr style="padding: .75rem;border-top: 1px solid #dee2e6;">
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">A類</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['a_pv'])?></td>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['a_amt'])?></td>
      </tr>
    <tr>
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">B類</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['b_pv'])?></td>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['b_amt'])?></td>
      </tr>
    <tr>
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">合計</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['a_pv']+$main['b_pv'])?></td>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['u_amt'])?></td>
      </tr>
  </tbody>
</table>
	</div>
<div class="col-md-4" style="width: 33.333333%;float: left;">
		<table class="table text-right" style="text-align: right!important;width:100%">
  <thead>
    <tr>
		<th colspan="2" scope="col" style="padding: .75rem;border-top: 1px solid #dee2e6;">紅利點數</th>
      </tr>
  </thead>
  <tbody>   
    <tr>
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">+ 回饋紅利</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['r_mp'])?></td>
      </tr>
    <tr>
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">+ 加贈紅利</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['p_mp'])?></td>
      </tr>
    <tr>
      <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">- 兌換紅利</th>
      <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['m_mp'])?></td>
    </tr>
  </tbody>
</table>
	</div>
  <div class="col-md-3" style="width: 25%;float: left;">
		<table class="table text-right" style="text-align: right!important;width:100%">
  <thead>
    <tr>
      <th colspan="2" scope="col" style="padding: .75rem;border-top: 1px solid #dee2e6;">交易金額</th>
      </tr>
  </thead>
  <tbody>      
      <tr>
         <th scope="row" style="padding: .75rem;border-top: 1px solid #dee2e6;">總金額</th>
         <td style="padding: .75rem;border-top: 1px solid #dee2e6;"><?=number_format($main['amt'])?></td>
      </tr>
  </tbody>
</table>
	</div>
	
</div>		 