<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper parallax-start">
        <?=$this->block_service->load_html_header(); ?>     
        <div class="section-mini">

          <div class="section-item text-left">
       
			  <div class="container">
			  
			  </div>
			  
          </div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
                <div class="col-md-9 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>訂單列表</strong></h1>
                  <div class="news-info mb30">
                    
                  </div>

                  <div class="mb65">
      <?php if (count($orderlist) == 0){
                 echo '<h4>尚無訂單</h4>';
       }else{ ?>
        <form name="form1" method="post" action="<?=base_url('order/orderlist')?>" onSubmit="return Form_check(this);">					  
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>_cancel" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<table class="table table-striped table-responsive mb-2 text-center">
  <thead class="thead-dark">
    <tr>
      <th>訂購日期</th>
      <th>獎金日期</th>
      <th>訂單編號</th>
      <th>BP</th>
      <th>本單金額/點數</th>
      <th>付款狀態</th>
      <th>查看明細</th>
      <th>取消訂單</th>
    </tr>
  </thead>
  <tbody>
    <?php   
    $cancel_num = 0;
    foreach ($orderlist as $key => $item){ ?>
    <tr>
      <td><?=date('Y-m-d H:i',strtotime($item['or_date']))?></th>
      <td><?=date('Y-m-d',strtotime($item['bv_date']))?></td>
      <td><?=$item['web_no']?></td>
      <td><?=number_format($item['a_pv']+$item['b_pv'])?></td>
      <td>
      <?php
          if ($item['amt'] == 0 && $item['success'] == '1'){
              echo number_format($item['m_mp'])." 點數</td>";
              echo '<td>';
              echo '紅利兌換成功 ';
          }else{
              echo number_format($item['amt'])." 元";
              if ($item['m_mp'] > 0){
              	  echo "<br>";
              	  echo number_format($item['m_mp'])." 點數";
              }
              echo "</td>";
              echo '<td>';
              echo $item['ord_statue'] ;
          }
          ?></td>
          <td><a href="<?=base_url('order/orderview/'.$item['web_no'])?>"><i class="icon ion-clipboard" style="font-size: 1.5rem;"></i></a></td>
          <td>
          <?php if (trim($item['ord_statue']) == '等待付款' || trim($item['ord_statue']) == '付款未完成'){ 
              $cancel_num++;
              ?>
              <input type="checkbox" name="cancel_no[]" value="<?=$item['web_no']?>">  
        <?php } ?>   
      </td>
    </tr>
    <?php } ?>  
  </tbody>
</table>
					  
          <?php if ($cancel_num > 0){ ?>
					<div class="text-right">
						<a href="javascript:void(0);" onclick="chg_token('<?php echo $this->security->get_csrf_token_name(); ?>_cancel');document.form1.submit();" class="btn btn-outline-secondary">取消訂單</a>
					</div>
   <?php        }
        } ?>  
                  </div>

                  <hr class="mt-0 mb70">
				  
                </div>
                <aside id="leftmenu" role="complementary" class="aside col-xl-3 col-md-3 mb130">
					
				        <div class="mb75">
                  <?=$this->block_service->member_right_menu('orderlist'); ?>  
                  <br><br>
                  <?=$this->block_service->member_right_prdclass(); ?>				 
                </div>
				  
                </aside>
              
              </div>
            </div>
          </div>
        </div>
      </div>

      <?=$this->block_service->load_html_footer(); ?>  
                    
</div>
<script>
function Form_check(obj){         
         return true;
}
</script>