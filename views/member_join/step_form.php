<script src="<?=base_url()?>public/js/member_join.js?20211227"></script>
<body class="theme-orange fixed-footer fixed-footer-lg" id="main" key="<?=$arsoa_join_key?>">
    <div class="animsition">      
      <div class="wrapper">
                           
        <?=$this->block_service->load_html_header(); ?>
          <div class="section-mini">

          <div class="section-item text-left">
           
          </div>

          <div class="section-item text-left">
            <div class="container">
              <div class="row">
              	<form name="oForm" id="oForm" method="post">	
              	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
              	<input type="hidden" name="jointype" id="jointype" value="">
                <div class="col-lg-12 mb130" role="main">
                  <h1 class="h3-3d font-libre"><strong>登錄會員方式</strong></h1>
                  
                  <hr class="mt-0 mb40">
					
				<div class="progress-item wow fadeInRight" data-wow-delay=".2s" style="border-top: 0px; visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">
                  <div class="row">
                    <div class="col-sm-2">
                      <div class="progress-item-num font-libre">1.</div>
                    </div>
                    <div class="col-sm-10">
                      <div class="progress-item-title" id="datafirst">填寫基本資料</div>
                      <!--<div class="fs18 text-grey mb-5">文字文字文字文字文字文字文字文字說明文字。</div>-->
                      <div class="form-group col-md-12" id="error_msg1" class="errors"></div>
						
					
							<div class="row">
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" required="" name="uname" id="uname" value="<?=$params['uname']?>" maxlength="25" placeholder="姓名 *">
                            </div>
							<div class="form-group col-md-3">
                                <div class="custom_select">
                                    <select class="form-control select-active" name="sex" id="sex">
                                        <option value="">請選擇性別 *</option>
                                        <option value="F" <?php if ($params['sex'] == 'F'){ echo ' selected'; }?>>女</option>
                                        <option value="M" <?php if ($params['sex'] == 'M'){ echo ' selected'; }?>>男</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <input required="" class="form-control" type="text" name="idno" id="idno" value="<?=$params['idno']?>" maxlength="10" placeholder="身份證字號">
                            </div>
							<div class="form-group col-md-3">
                   <?php
								   $dparams = array(
			  	                        'TheDateField' => 'bday', 
			  	                        'TheDateValue' => $params['bday'],
			  	                        'placeholder'  => '生日 *',
			  	                        'class'        => 'form-control',
			  	                        'Required'     => 'Y',
			  	                        'width'        => 0,
			  	                        'readonly'     => 'Y'
			  	                        );			  	                
                            $this->ui->PJ_JInputDate('date',$dparams);          
								   ?>
                            </div>
							</div>
						    <div class="row">
								<div class="col-md-6 form-group">
                                <input required="" class="form-control" type="text" name="tel" id="tel" value="<?=$params['tel']?>" placeholder="聯絡電話(行動電話優先，公司電話請寫分機) *">
								</div>
								<div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="email" id="email" value="<?=$params['email']?>" maxlength="100" placeholder="E-mail">
								</div>
							</div>
							<?php 
							if (1==2){ ?>
							<div class="row">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" required="" name="spouse_name" id="spouse_name" value="<?=$params['spouse_name']?>" maxlength="20" placeholder="配偶姓名">
                            </div>
                            <div class="form-group col-md-4">
                                <input required="" class="form-control" type="text" name="spouse_idno" id="spouse_idno" value="<?=$params['spouse_idno']?>" maxlength="10" placeholder="配偶身份證字號">
                            </div>
							<div class="form-group col-md-4">                                
                   <?php
								   $dparams = array(
			  	                        'TheDateField' => 'spouse_bday', 
			  	                        'TheDateValue' => $params['spouse_bday'],
			  	                        'placeholder'  => '配偶生日',
			  	                        'class'        => 'form-control',
			  	                        'width'        => 0,
			  	                        'readonly'     => 'Y'
			  	                        );			  	                
                            $this->ui->PJ_JInputDate('date',$dparams);          
								   ?>
                            </div>
							</div>
						  <?php } ?>
							<div class="mb-20">
                                <h5>通訊地址</h5>
                            </div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
                                <div class="custom_select">
                                    <select id="cityno" name="cityno" class="form-control select-active" required="required">
                                      <option value="">請選擇縣市 *</option>
                                      <?php foreach ($city as $citydata){ ?>
                                           <option value="<?=$citydata['cityno']?>" <?=($params['cityno']==$citydata['cityno'])?'selected':''?>><?=$citydata['citytitle']?></option>
                                      <?php } ?>                                 
                                    </select>
                                </div>
                            </div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
                                <div class="custom_select">
                                    <select class="form-control select-active" name="postal" id="postal">
                                        <option value="">請選擇行政區 *</option>                                                     
                            <?php if (!empty($town) && count($town) > 0){
                                      foreach ($town as $towndata){ ?>
                                           <option value="<?=$towndata['postal']?>" <?=($params['postal']==$towndata['postal'])?'selected':''?>><?=$towndata['towntitle']?></option>
                            <?php     }
                                  }
                                  ?>
                                    </select>
                                    <input type="hidden" name="zip" id="zip" value="<?=$params['postal']?>">
                                </div>
                            </div>
								</div>
							</div>
                            
							
                            <div class="form-group">
                                <input type="text" class="form-control" name="address" id="address" value="<?=$params['address']?>" maxlength="60" required="" placeholder="詳細地址 *">
                            </div>
                            
							              <div class="mb-20">
                                <h5>推薦人</h5>
                            </div>							
                            <div class="row">
                              <div class="form-group col-md-6">
                                <input type="text" class="form-control" required="" name="referrer_name" id="referrer_name" value="<?=$params['referrer_name']?>" maxlength="10" placeholder="推薦人姓名 *">
                              </div>                            
							                <div class="form-group col-md-6">
                                <input required="" class="form-control" type="text" name="referrer_c_no" id="referrer_c_no" value="<?=$params['referrer_c_no']?>" maxlength="10" placeholder="推薦人會員編號 *">
                              </div>
							              </div>                           
							           					
							            
                        
							             <div class="form-group col-md-12" id="error_msg2" class="errors"></div> 
                        </form>
                    </div>
                  </div>
                </div>
					
					
			<hr class="mt-0 mb40">
					
					<div class="progress-item wow fadeInRight" data-wow-delay=".2s" style="border-top: 0px; visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;">
						
						<div class="row">
                    <div class="col-sm-2">
                      <div class="progress-item-num font-libre">2.</div>
                    </div>
                    <div class="col-sm-10">
                      <div class="progress-item-title">選擇登錄方式</div>
                      <!--<div class="fs18 text-grey mb-5">文字文字文字文字文字文字文字文字說明文字。</div>-->
					
            <div class="slide-container pt-3">
              <div class="container">
                <div class="slide-body">
                  <div class="row no-gutters partner-bordered">
                    <div class="col partner-item"><span class="inside"><img src="<?=base_url()?>public/images/m01.png" alt="會費750元" /><br><h4 class="my-2">750元</h4>
                    	<p>會費750元<br>（單一筆產品必選$750）</p><a href="javascript:void(0);" onclick="check_join_data(1);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
                    <div class="col partner-item"><span class="inside"><img src="<?=base_url()?>public/images/m02.png" alt="購買3500元產品" /><br><h4 class="my-2">購買3500元產品</h4>
                    	<p>購買多筆，<br>需整張單達$3500才可以登錄</p><a href="javascript:void(0);" onclick="check_join_data(2);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
                    <div class="col partner-item d-none"><span class="inside"><img src="<?=base_url()?>public/images/m03.png" alt="圓夢事業組合" /><br><h4 class="my-2">圓夢事業組合</h4>
                    	<p>購買圓夢產品，<br>整張單達$10500才可以登錄</p><a href="javascript:void(0);" onclick="check_join_data(3);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
					          <div class="col partner-item"><span class="inside"><img src="<?=base_url()?>public/images/m04.png" alt="健康宅配專案" /><br><h4 class="my-2">健康宅配專案</h4>
					          	<p>購買B類宅配單產品，<br>即可登錄</p><a href="javascript:void(0);" onclick="check_join_data(4);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
                    <div class="col partner-item"><span class="inside"><img src="<?=base_url()?>public/images/m05.png" alt="肌能調理宅配專案" /><br><h4 class="my-2">肌能調理宅配專案</h4>
                    	<p>購買A類宅配單產品、<br>即可登錄</p><a href="javascript:void(0);" onclick="check_join_data(5);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
					  			  <div class="col partner-item d-none"><span class="inside"><img src="<?=base_url()?>public/images/m06.png" alt="可佳媽媽淨活水器專案" /><br><h4 class="my-2">可佳媽媽淨活水器專案</h4>
					  			  	<p>購買淨水器宅配產品，<br>即可登錄</p><a href="javascript:void(0);" onclick="check_join_data(6);" type="button" class="btn btn-outline-secondary btn-sm text-secondary">以此方式登錄</a></span></div>
                  </div>
                </div>
              </div>
            </div>
							</div></div>
						
						
					</div>
                </div>
              </div>
            </div>
          </div>

        </div>


      </div>
      <?=$this->block_service->load_html_footer(); ?>  
</div>
<script>
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var check_step = 'form';
</script>