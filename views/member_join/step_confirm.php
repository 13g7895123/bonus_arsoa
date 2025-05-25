<style>
#signaturePad {
	width: 100%;
	height: 150px;
    border: 2px solid #000;
    cursor: crosshair;
	display: block;
}
</style>

<script src="<?=base_url()?>public/js/member_join.js?20211227"></script>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main" >
    <div class="animsition">      
      	<div class="wrapper">
                           
			<?=$this->block_service->load_html_header(); ?>
			<form name="oForm" id="oForm" method="post">	
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							 
				<input type="hidden" name="signature_id" id="signature_id" value="">
         
         <div class="section-mini">

          <div class="section-item text-left">		  
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-12 mb130" role="main">
                  <h1 class="h2-3d font-libre"><strong>以<?=$join_name[$arsoa_join_data['jointype']]?>方式登錄</strong></h1>
					
					       <div class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#logins-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="logins-part" id="logins-part-trigger"> <span class="bs-stepper-circle">1</span> <span class="bs-stepper-label">選購商品</span> </button>
                      </div>
                        <div class="line"></div>
                        <div class="step" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">2</span> <span class="bs-stepper-label">紅利兌換</span> </button>
                      </div>
                        <div class="line"></div>
                        <div class="step active" data-target="#information-part">
                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger"> <span class="bs-stepper-circle">3</span> <span class="bs-stepper-label">確認資料、付款</span> </button>
                      </div>
                      </div>
                    <div class="bs-stepper-content">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger"></div>
                        <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger"></div>
                      </div>
                  </div>
                  
				  <div class="row">
					  <div class="col-md-12">
						  <div class="card mb-3">
                    <div class="card-header"><h4 class="mb-0">訂購資料</h4></div>
                    <div class="card-body">
					          <?php if ($pckpro1){  
					          	        echo $this->block_service->member_join_pckpro(1,$arsoa_join_data['jointype'],$pckpro1);					                  
						              } 
						              if ($pckpro2){  
					          	        echo $this->block_service->member_join_pckpro(2,$arsoa_join_data['jointype'],$pckpro2);					                  
						              }
						              if ($pckpro3){  
					          	        echo $this->block_service->member_join_pckpro(3,$arsoa_join_data['jointype'],$pckpro3);					                  
						              } 
						              if ($pckpro4){  
					          	        echo $this->block_service->member_join_pckpro(4,$arsoa_join_data['jointype'],$pckpro4);					                  
						              } 
						          ?>        					                 
                      </div>
                  </div>
					  </div>
					  
					</div>
																	
					<?php if ($sumdetail['chkdays'] > ''){ ?>					          
				            <div class="row">
						           <div class="col-md-6">			
													<div class="form-group">
          					         <div class="custom_select">
          					                <select class="form-control select-active" name="out_day" id="out_day">
          					                   <option value="0">請選每期出貨日...</option>
          					                   <?php	
          					                 	$a_out_day  = explode(',', $sumdetail['chkdays']);
	                                     foreach ($a_out_day as $days) {
	                                     	  echo '<option value="'.$days.'">每期 '.$days.' 日（遇假日提前）</option>';
	                                     }
	                                     ?>
          					                 </select>
          					             </div>
          					         </div>
													</div>
													<div class="col-md-6">
														<div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">備註</span>
                              </div>
                              <input type="text" class="form-control" name="remark" id="remark" value="<?=$arsoa_join_data['remark']?>" maxlength="30" placeholder="備註">
                            </div>	
                          </div>
				               </div>				 																	          
					<?php }else{ ?>				
					             <div class="row">
						              <div class="col-md-6">				          
														<div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">備註</span>
                              </div>
                              <input type="text" class="form-control" name="remark" id="remark" value="<?=$arsoa_join_data['remark']?>" maxlength="30" placeholder="備註">
                            </div>														
													</div>
													<div class="col-md-6 d-flex align-items-center">				
												  </div>
				               </div>				
					<?php } ?>	
					<?php //20230701 MARK 國瑜
					      if (1==2 && $arsoa_join_data['jointype'] == '3' && (date('Y-m-d H:i:s') > '2022-10-31 16:00:00' || ($arsoa_join_data['referrer_c_no'] == '000000' && $arsoa_join_data['uname'] == 'TEST'))){ ?>
				               <div class="row">
						              <div class="col-md-6">				          
														<select class="form-control select-active" name="is_sample" id="is_sample">
          					                   <option value="">是否要綁定LINE並以此2000紅利兌換3組試用組?</option>
          					                   <option value="1">我要兑換</option>
          					                   <option value="0">不要兑換</option>
          					                 </select>													
													</div>
													<div class="col-md-6 d-flex align-items-center">				
												  </div>
				               </div>		
				  <?php } ?>
				  <?php if ($arsoa_join_chkpromo){ ?>
				  						  <div class="row">
						           <div class="col-md-6">			
													<div class="form-group">
          					         <div class="custom_select">
          					                <select class="form-control select-active" name="promo_sel" id="promo_sel">
          					                   <option value=""><?=$arsoa_join_chkpromo[0]['promomsg']?></option>
          					                   <?php	          					                 	  
	                                     foreach ($arsoa_join_chkpromo as $item) {
	                                     	  echo '<option value="'.trim($item['p_no']).'">'.$item['p_name'].'</option>';
	                                     }
	                                     ?>
          					                 </select>
          					             </div>
          					         </div>
													</div>
													<div class="col-md-6">														
                          </div>
				               </div>
				  <?php } ?>
					<hr>
					  
					  <?php if ($sumdetail){  
					          	echo $this->block_service->member_join_sumdetail($sumdetail);					                  
						      }
						?>    
						<div class="row">
						   <div class="col-md-12">
                        <div class="card mb-3">
                          <div class="card-header">
                            <h4 class="mb-0">登錄資料確認</h4>
                          </div>
                          <?=$this->block_service->member_join_complete_data($arsoa_join_data);?>                          
                        </div>
               </div>  
            </div>
					     
			<div class="row">
				<div class="col-md-12">
					<div class="card mb-3">
						<div class="card-header">
							<h4 class="mb-0">登錄權益及規範</h4>
						</div>
						<div class="card-body">
							<div class="form-group mb-30">
							<textarea rows="8" class="form-control" placeholder="登錄條款"><?=$policy?></textarea>
							</div>
							<hr>
							<input type="checkbox" name="iagree" id="iagree" value="Y">
							我已閱讀並同意(請於下方簽名確認)。 
							<br>
							<div style="display: flex; flex-direction: column;">
								<canvas id="signaturePad" height="150"></canvas>
								<button id="clearSignature" type="button">清除簽名</button>
							</div>
						</div>
					</div>
				</div>
			</div>
					
			<div class="form-group col-md-12" id="error_msg"></div> 
					
			<div class="row">
				<div class="col-md-12 text-right">
					<div class="btn-group" role="group" aria-label="">
						<a href="<?=base_url('member_join/product')?>" class="btn btn-outline-secondary"><i class="icon ion-ios-cart"></i>　回上頁</a> 
						<a href="javascript:void(0);" id="submitbutton" class="btn btn-outline-secondary">我要結帳、登錄　<i class="icon ion-ios-calculator"></i></a> 							  
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
</form>
      <?=$this->block_service->load_html_footer(); ?>  
</div>
<script>
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var check_step = 'confirm';

class Signature {
	constructor(canvasId) {
		this.canvasId = canvasId;
		this.canvas = document.getElementById(canvasId);
		this.canvas.width = this.canvas.offsetWidth;
		this.ctx = this.canvas.getContext('2d');
		this.drawing = false;
		this.signatured = false; // 是否有簽名

		// 設定筆刷樣式
		this.ctx.lineWidth = 2;
		this.ctx.lineCap = "round";
		this.ctx.strokeStyle = "#000";

		// 綁定事件
		this.init();
	}

	// 取得相對座標 (適用於滑鼠 & 觸控)
	getPosition(event) {
		const rect = this.canvas.getBoundingClientRect();
		if (event.touches) {
			return {
				x: event.touches[0].clientX - rect.left,
				y: event.touches[0].clientY - rect.top
			};
		} else {
			return {
				x: event.offsetX,
				y: event.offsetY
			};
		}
	}

	// 監聽滑鼠 & 觸控事件
	init() {
		// 滑鼠事件
		this.canvas.addEventListener('mousedown', (e) => this.startDraw(e));
		this.canvas.addEventListener('mousemove', (e) => this.draw(e));
		this.canvas.addEventListener('mouseup', () => this.stopDraw());
		this.canvas.addEventListener('mouseleave', () => this.stopDraw());

		// 觸控事件
		this.canvas.addEventListener('touchstart', (e) => this.startDraw(e), { passive: false });
		this.canvas.addEventListener('touchmove', (e) => this.draw(e), { passive: false });
		this.canvas.addEventListener('touchend', () => this.stopDraw());
		this.canvas.addEventListener('touchcancel', () => this.stopDraw());
	}

	// 開始繪圖
	startDraw(event) {
		event.preventDefault(); // 防止手機滾動畫面
		this.signatured = true;
		this.drawing = true;
		const pos = this.getPosition(event);
		this.ctx.beginPath();
		this.ctx.moveTo(pos.x, pos.y);
	}

	// 繪製過程
	draw(event) {
		if (!this.drawing) return;
		event.preventDefault();
		const pos = this.getPosition(event);
		this.ctx.lineTo(pos.x, pos.y);
		this.ctx.stroke();
	}

	// 停止繪圖
	stopDraw() {
		this.drawing = false;
	}

	// 取得簽名 Blob（圖片格式）
	getSignatureBlob() {
		return new Promise((resolve, reject) => {
			if (!this.signatured) {
				reject("請先簽名！");
				return;
			}
			this.canvas.toBlob((blob) => {
				if (blob) {
					resolve(blob);
				} else {
					reject("轉換失敗");
				}
			}, "image/png");
		});
	}

	// 清除簽名
	clearSignature() {
		this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
		this.signatured = false;
	}
}

// 上傳簽名圖片
const uploadSignature = (formData) => {
	$.ajax({
        url: `${base_url}eform/Api/upload`,
        method: 'POST',
        dataType: 'json',
		data: formData,
		processData: false,
		contentType: false,  // 不設置內容類型
		async: false,
		success: (response) => {
			$('#signature_id').val(response.fileId);
		},
		error: (error) => {
			console.log(error);
		}
    });
}

$(document).ready(function() {
	const signaturePad = new Signature('signaturePad');
	signaturePad.init();

	// 清除簽名按鈕
	$('#clearSignature').click(function() {
		signaturePad.clearSignature();
	});

	// 送出按鈕
	$('#submitbutton').click(function() {
		submit();
	});

	async function submit() {
		const formData = new FormData();

		if ($('#iagree').is(':checked') === false) {
			$( "#error_msg" ).html('會員條款並未閱讀同意！');
			return;
		}

		if (!signaturePad.signatured) {
			$( "#error_msg" ).html('請先簽名！');
			return;
		}

		// 上傳簽名圖片
		const signatureBlob = await signaturePad.getSignatureBlob();
		formData.append('signature', signatureBlob);
		await uploadSignature(formData);

		// 原本的送出功能
		check_data();
	}
});


</script>