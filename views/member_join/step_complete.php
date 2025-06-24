<body class="theme-orange fixed-footer fixed-footer-lg" id="main" >
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
         
         <div class="section-mini">

          <div class="section-item text-left">
            <div class="container">
              <div class="row justify-content-center" id="printArea">
                <div class="col-md-12 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>以<?=$join_name[$arsoa_join_data['jointype']]?>方式登錄</strong></h1>
					
					<div class="alert alert-success" role="alert">
						<div class="row">
						   <div class="col-md-9">
                    <h4 class="alert-heading">付款完成！</h4>
                    <h5>您的會員編號為：<?=$arsoa_join_data['c_no']?></h5>
                    <?php if ($arsoa_join_data['out_day'] > 0){ ?>
					                    <h5>每期宅配日為：<?=$arsoa_join_data['out_day']?> 號（遇假日提前）</h5>
					          <?php } ?>          
                    <hr>						
								<h5 class="mb-2 text-danger">提醒您：</h5>
								<ul class="text-danger fs20">
									<li>登錄資料正本須於 "<b>隔月底前</b>"寄(繳)至安露莎公司，方可完成正式入會。<br>（<font color=red>若未繳回,即喪失會員資格</font>）。</li>
									<li>宅配單登錄者，正本務必在第二期出貨前寄(繳)至安露莎公司，方可出貨。</li>
									<li>以圓夢方式登錄者，務必需於登錄後，將身份證影本傳至<a href="https://line.me/ti/p/<?=$this->config->item('line_bot_basic_id')?>" target="_blank">官方Line</a>，方可出貨。</li>									
								</ul>
							
							</div>
							<div class="col-md-3 text-center">
								<a href="<?=$line_url?>" target="_blank">請點選綁定安露莎官方Line</a><br><a href="<?=$line_url?>" target="_blank"><img src="<?=base_url('reg?c='.$line_url)?>" class="img-fluid"></a>
								<div class="row mt-3">
						       <div class="col-12" style="margin-top: -25px;padding-right: 0px;padding-left: 0px;">
							       <?php
							       $share_text = '請點選下方網址綁定安露莎官方Line';
							       ?>
							       <br>綁定連結&nbsp;
							       <a type="button" class="btn btn-outline-secondary btn-sm text-secondary" title="分享Line綁定連結" 
							       <?php if ($platform == 'MOBILE'){ ?> 
							                 href="http://line.naver.jp/R/msg/text/?<?= urldecode($share_text) ?>%0D%0A<?php echo $line_url; ?>" target="_blank">
                     <?php }else{ ?>
                               href="javascript:void(0);" onclick="window.open('https://lineit.line.me/share/ui?url=' .concat(encodeURIComponent('<?php echo $line_url; ?>')) , 'Line', config='height=500,width=600');return false;">
                     <?php } ?>
                           <i class="fas fa-share-alt"></i> 分享</a> <a class="btn btn-outline-secondary btn-sm text-secondary" title="複製Line綁定連結" href="javascript:void(0)" onClick="copyidtxt('<?php echo $line_url; ?>');"><i class="fa fa-link" aria-hidden="true"></i> 複製</a>

						       </div>
					      </div>
							</div>
						</div>
          </div>
					
          	<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-header">
							<h4 class="mb-0">登錄資料</h4>
						</div>
						<?=$this->block_service->member_join_complete_data($arsoa_join_data);?>                          
					</div>
               </div>  
          	</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-header">
							<h4 class="mb-0">會員簽名</h4>
						</div>
						<img src="https://www.arsoa.tw/<?=$signature;?>"/>
					</div>
               </div>  
          	</div>
            
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-header"><h4 class="mb-0">訂購資料</h4></div>
						<div class="card-body">
							<?php
								if (isset($pckpro1) && $pckpro1){  
									echo $this->block_service->member_join_pckpro(1,$arsoa_join_data['jointype'],$pckpro1,'C');					                  
								}
							?>
							<?php
								if (isset($pckpro2) && $pckpro2){  
									echo $this->block_service->member_join_pckpro(2,$arsoa_join_data['jointype'],$pckpro2,'C');					                  
								}
							?>
							<?php
								if (isset($pckpro3) && $pckpro3){  
									echo $this->block_service->member_join_pckpro(3,$arsoa_join_data['jointype'],$pckpro3,'C');					                  
								}
							?>
							<?php
								if (isset($pckpro4) && $pckpro4){  
									echo $this->block_service->member_join_pckpro(4,$arsoa_join_data['jointype'],$pckpro4,'C');					                  
								}
							?>
						</div>
					</div>
				</div>					  
			</div>
					           
					<?php if ($arsoa_join_data['remark'] > ''){ ?>
					          <div class="row">
					             <div class="col-md-6">				          
					          		<div class="input-group mb-3">
                           <div class="input-group-prepend">
                             <span class="input-group-text" id="basic-addon1">備註</span>
                           </div>
                           <?=$arsoa_join_data['remark']?>
                         </div>														
					          	</div>
					          	<div class="col-md-6 d-flex align-items-center">				
					            </div>
				            </div>				
					<?php } ?>
					<hr>					  					  
					  
					  <?php if ($sumdetail){  
					          	echo $this->block_service->member_join_sumdetail($sumdetail);					                  
						      }
						?>    
				
					<div class="row">
					  <div class="col-md-12 text-right">
						  <div class="btn-group" role="group" aria-label="">
						  	<a href="javascript:void(0);" id="btnPrint" onclick="onprint()" value="print" class="btn btn-outline-secondary"><i class="icon ion-printer"></i>　訂單列印</a>
							  <a href="<?=base_url()?>" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　回首頁</a> 
						  </div>
					  </div>
					</div>
                </div>
                             
				  
				  <div class="col-md-12 mb130">
					  <hr class="mt-0 mb70">
		<p></p><p>備註：</p>

<ol>
	<li>請您於交易完成時，記下網購單號，以便追蹤查詢進度。</li>
	<li>本公司保留出貨與否權利。</li>
	<li>購滿建議售價2000元，或兌換紅利點數達4000點，即可免付運費100元(點)。</li>
	<li>為保障會員用卡安全，本公司僅接受訂貨人本人持有之信用卡。</li>
	<li>一但確定您要的贈品數量後，請按更改數量確認；否則將會造成資料的遺失。</li>
</ol>
<p></p>
	</div>
				  
              </div>
            </div>
          </div>
        </div>
      </div>
      <?=$this->block_service->member_join_modal()?>	

      <?=$this->block_service->load_html_footer(); ?>  
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if ($homeDelivery): ?>
	Swal.fire({
      title: '系統提示', 
      text: '請選擇是否需要填寫信用卡授權書',
      icon: 'info',
      showCancelButton: false,
      confirmButtonText: '開啟表單',
    //   cancelButtonText: '我之前填過了',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // 點擊開啟表單 - 在新分頁開啟宅配表單
        window.open('<?=$homeDelivery_url?>', '_blank');
      }
      // 點擊我之前填過了或關閉 - 關閉 alert
    });
<?php endif; ?>

//列印功能
function printHtml(html) {
	var bodyHtml = document.body.innerHTML;
	document.body.innerHTML = html;
	window.print();
	document.body.innerHTML = bodyHtml;
	window.location.reload(); //列印輸出後更新頁面
}
function onprint() {
//去除超連結設置
$('a').each(function(index) {
$(this).replaceWith($(this).html());
});
$( "#leftmenu" ).hide();
$( "#printbutton" ).hide();

var html = $("#printArea").html();
printHtml(html);

}

function copyidtxt(str) 
{   
   var input = '<input type="text" id="temp_link" value="'+str+'">';
   $("body").append(input);
   $("#temp_link").select();
   document.execCommand("Copy");
   $("#temp_link").remove();
   let div = '<div id="tip" style="position: absolute; top: 50%;left: 50%;transform: translate(-50%, -50%);padding: 12px 25px;background: rgba(0, 0, 0, 0.6); color: #fff;font-size: 14px;">複製成功</div>'; 
   $("body").append(div);
        setTimeout(() => {
            $("#tip").remove();
        }, 3000);
}


</script>