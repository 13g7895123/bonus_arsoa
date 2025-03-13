<body class="theme-orange fixed-footer fixed-footer-lg" id="main">
    <div class="animsition">      
      <div class="wrapper">
                           
           <?=$this->block_service->load_html_header(); ?>

            <div class="section-mini pt-2">

          <div class="section-item text-left">
        
			  
          </div>

          <div class="section-item text-left mt-5">
            <div class="container">
				
              <div class="row">
                <div class="col-md-9 mb130" role="main">
					        <div class="row">
                    <div class="col-6">
                        <h1 class="h2-3d font-libre mb-0"><strong>組織專區</strong></h1>
                      </div>
                    
                    <!-- Example split danger button -->
                    <div class="col-auto mb-2 d-sm-none text-right">
                        <div class="btn-group">
                        <button type="button" class="btn btn-primary">請選擇…</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="sr-only">Toggle Dropdown</span> </button>
                        <div class="dropdown-menu">
							            <a class="dropdown-item" href="#"><i class="icon ion-earth mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">獎金資料查詢</span></a>
							               <a class="dropdown-item" href="javascript:report_A(1);" style="padding-left: 3.6rem;">月份獎金明細查詢</a>
							               <a class="dropdown-item" href="javascript:report_A(2);" style="padding-left: 3.6rem;">歷史獎金明細查詢</a>
							
                          <div class="dropdown-divider"></div>
							
                          <a class="dropdown-item" href="#"><i class="icon ion-ios-book mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">組織業績查詢</span></a> 
                      		<a class="dropdown-item" href="javascript:report_A(3);" style="padding-left: 3.6rem;">月份組織業績查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(4);" style="padding-left: 3.6rem;">個人歷史業績查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(11);" style="padding-left: 3.6rem;">會員訂購品項查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(12);" style="padding-left: 3.6rem;">建議售價查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(13);" style="padding-left: 3.6rem;">赴日研修顆星</a>
                      		<?php if ($this->session->userdata('member_session')['c_no'] == '000000'){ ?>								                    
								                    <a class="dropdown-item" href="javascript:report_A(14);" style="padding-left: 3.6rem;">組織宅配訂單查詢</a>
								          <?php } ?>
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="#"><i class="icon ion-ios-contact mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">組織基本資料</span></a> 
                      		<a class="dropdown-item" href="javascript:report_A(5);" style="padding-left: 3.6rem;">直接推薦資料查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(6);" style="padding-left: 3.6rem;">組織人數統計查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(7);" style="padding-left: 3.6rem;">歷史組織人數查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(8);" style="padding-left: 3.6rem;">月份晉升名單查詢</a>
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="#"><i class="icon ion-filing mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">產品銷售分析</span></a> 
                      		<a class="dropdown-item" href="javascript:report_A(9);" style="padding-left: 3.6rem;">期間產品統計查詢</a>
                      		<a class="dropdown-item" href="javascript:report_A(10);" style="padding-left: 3.6rem;">年度進貨資料查詢</a>
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="<?=base_url('member_admin/edunews')?>"><i class="icon ion-cube mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">教育訓練情報</span></a> 
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="<?=base_url('member_admin/news')?>"><i class="icon ion-ios-paper mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">ARSOA NEWS 月刊</span></a> 
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="<?=base_url('member_admin/download')?>"><i class="icon ion-archive mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">表格下載列印</span></a> 
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		<a class="dropdown-item" href="<?=base_url('member_admin/law')?>"><i class="icon ion-ios-body mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">商德規範</span></a> 
                      		
                      		<div class="dropdown-divider"></div>
                      		
                      		
                      	</div>
                      </div>
                    </div>
                    
                  </div>
				  
                  <div class="news-info mb30"></div>
					
					<form name="admin_Form" id="admin_Form" method="post" language="javascript">
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">							
					
					<!--月份獎金明細查詢 start-->
				  <div class="mb65" id="admin_1" style="display: none;">
                    <h4>月份獎金明細查詢</h4>
                    
                      <h5>獎金年月</h5>
                      <div class="form-row">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y1'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m1'); ?>                          
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('1','會員佣金明細表')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--月份獎金明細查詢 end-->
					
					<!--歷史獎金明細查詢 start-->
				  <div class="mb65" id="admin_2" style="display: none;">
                    <h4>歷史獎金明細查詢</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y2'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m2'); ?>                  
                        </div>
							  <div class="col-4">至</div>
							  </div>
						  <div class="form-row">
						<div class="col">
                          <?=$this->block_service->admin_select_year('y21'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m21'); ?>                  
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('2','歷史獎金明細查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--歷史獎金明細查詢 end-->
					
					<!-- 月份組織業績查詢  start-->
				  <div class="mb65" id="admin_3" style="display: none;">
                    <h4>月份組織業績查詢</h4>
                    
                      <h5>業績年月</h5>
                      <div class="form-row mb-5">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y3'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m3'); ?>          
                        </div>
						</div>
						<h5>組織類型</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <div class="row align-items-center form-inline">
							  <div class="col-auto"><input type="radio" value="0" name="r3" checked> 第 </div>
							  <div class="col-auto px-0">
							    <?=$this->block_service->admin_select_num('type3',1,99); ?>
							  </div>
							  <div class="col-6">代組織 (第一代直屬組織)</div>
								  </div>
							  <input type="radio" value="1" name="r3" > 個人組織(不含同位階下線)<br>
							  <input type="radio" value="2" name="r3" > 整體組織(含同位階下線)
						  </div>						  
						  <div class="col-lg-4 col-sm-12 align-self-end">
                           <button type="button" onclick="show_report('3','月份組織業績查詢')" class="btn btn-outline-secondary">開始查詢</button>
              </div>
						</div>                    
                  </div>
					<!-- 月份組織業績查詢  end-->
					
					<!--個人歷史業績查詢 start-->
				  <div class="mb65" id="admin_4" style="display: none;">
                    <h4>個人歷史業績查詢</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y4'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m4'); ?>
                        </div>
							  <div class="col-4">至</div>
							  </div>
						  <div class="form-row">
						<div class="col">
                          <?=$this->block_service->admin_select_year('y41'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m41'); ?>
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('4','個人歷史業績查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--個人歷史業績查詢 end-->
					
					<!--會員訂購品項 start-->
				  <div class="mb65" id="admin_11" style="display: none;">
                    <h4>會員訂購品項</h4>                    
					            <h5>會員編號</h5>
					            <div class="form-row mb-3">
						            <div class="col-lg-4 col-sm-12">
						            <input type="text" class="form-control" name="dno" id="dno" maxlength=6>
						            </div>
						          </div>						
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y11'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m11'); ?>
                        </div>
							  <div class="col-4">至</div>
							  </div>
						  <div class="form-row">
						<div class="col">
                          <?=$this->block_service->admin_select_year('y111'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m111'); ?>
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('11','會員訂購品項')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>
                    
                  </div>
					<!--會員訂購品項 end-->
					
					<!--建議售價查詢 start-->
				  <div class="mb65" id="admin_12" style="display: none;">
                    <h4>建議售價查詢</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y12'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m12'); ?>
                        </div>
							  <div class="col-4">至</div>
							  </div>
						  <div class="form-row mb-3">
						<div class="col-4">
                          <?=$this->block_service->admin_select_year('y121'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m121'); ?>
                        </div>
                      </div>
						
					            <h5>組織類型</h5>
					            <div class="form-row">
						            <div class="col-lg-8 col-sm-12 mb-3">
						          	  <div class="row align-items-center form-inline">
						          	  <div class="col-auto"><input type="radio" value="0" name="r12"> 第 </div>
						          	  <div class="col-auto px-0">
						          	    <?=$this->block_service->admin_select_num('type12',1,99); ?>
						          	  </div>
						          	  <div class="col-6">代組織 (第一代直屬組織)</div>
						          		  </div>
						          	  <input type="radio" value="1" name="r12" checked> 個人組織(不含同位階下線)<br>
						          	  <input type="radio" value="2" name="r12"> 整體組織(含同位階下線)
						            </div>						  
						          </div>
						          
						          <h5>排序方式</h5>
					            <div class="form-row">
						            <div class="col-lg-8 col-sm-12 mb-3">
						          	  <input type="radio" value="1" name="o12" checked> 組織<br>
						          	  <input type="radio" value="2" name="o12"> 位階<br>
						          	  <input type="radio" value="3" name="o12"> 有效日期 + 推薦人
						            </div>						  
						            <div class="col-lg-4 col-sm-12 align-self-end">
                             <button type="button" onclick="show_report('12','建議售價查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
						          </div>
						
                    
                  </div>
					<!--建議售價查詢 end-->
					
					<!--赴日研修顆星 start-->
				  <div class="mb65" id="admin_13" style="display: none;">
                    <h4>赴日研修顆星</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y13'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m13'); ?>                          
                        </div>                        
							  </div>
						
					  <h5>排序方式</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <input type="radio" value="1" name="o13" checked> 組織 (個人組織)<br>
							  <input type="radio" value="2" name="o13" > 位階<br>
							  <input type="radio" value="3" name="o13" > 顆星數(大至小)<br>
						  </div>						  
						</div>
						
						<h5>顯示方式</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <input type="radio" value="1" name="type13" checked> 只顯示有顆星會員<br>
							  <input type="radio" value="2" name="type13"> 全部<br>							  
						  </div>		
						  <div class="col-lg-4 col-sm-12 align-self-end">
                      <button type="button" onclick="show_report('13','赴日研修顆星')" class="btn btn-outline-secondary">開始查詢</button>
              </div>				  
						</div>
						
                    
                  </div>
					<!--赴日研修顆星 end-->
					
					<!--直接推薦資料查詢 start-->
				  <div class="mb65" id="admin_5" style="display: none;">
                    <h4>直接推薦資料查詢</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y5'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m5'); ?>
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('5','直接推薦資料查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>
                    
                  </div>
					<!--直接推薦資料查詢 end-->
					
					<!-- 組織人數統計查詢  start-->
				  <div class="mb65" id="admin_6" style="display: none;">
                    <h4>組織人數統計查詢</h4>
                    
                      <h5>業績年月</h5>
                      <div class="form-row mb-5">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y6'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m6'); ?>
                        </div>
						</div>
						<h5>組織類型</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <div class="row align-items-center form-inline">
							  <div class="col-auto"><input type="radio" value="0" name="r6" checked> 第 </div>
							  <div class="col-auto px-0">
								  <?=$this->block_service->admin_select_num('type6',1,99); ?>
							  </div>
							  <div class="col-6">代組織 (第一代直屬組織)</div>
								  </div>
							  <input type="radio" value="1" name="r6"> 個人組織(不含同位階下線)<br>
							  <input type="radio" value="2" name="r6"> 整體組織(含同位階下線)
						  </div>						  
						  <div class="col-lg-4 col-sm-12 align-self-end">
                      <button type="button" onclick="show_report('6','組織人數統計查詢')" class="btn btn-outline-secondary">開始查詢</button>
              </div>
						</div>
                    
                  </div>
					<!-- 組織人數統計查詢  end-->
					
					<!-- 歷史組織人數查詢  start-->
				  <div class="mb65" id="admin_7" style="display: none;">
                    <h4>歷史組織人數查詢</h4>
                    
						<h5>組織類型</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <div class="row align-items-center form-inline">
							  <div class="col-auto"><input type="radio" value="0" name="r7" checked> 第 </div>
							  <div class="col-auto px-0">
								  <?=$this->block_service->admin_select_num('type7',1,99); ?>
							  </div>
							  <div class="col-6">代組織 (第一代直屬組織)</div>
								  </div>
							  <input type="radio" value="1" name="r7" > 個人組織(不含同位階下線)<br>
							  <input type="radio" value="2" name="r7" > 整體組織(含同位階下線)
						  </div>					
						  <div class="col-lg-4 col-sm-12 align-self-end">
                      <button type="button" onclick="show_report('7','歷史組織人數查詢')" class="btn btn-outline-secondary">開始查詢</button>
              </div>	  
						</div>
                    
                  </div>
					<!-- 歷史組織人數查詢  end-->
					
					<!-- 月份晉升名單查詢  start-->
				  <div class="mb65" id="admin_8" style="display: none;">
                    <h4>月份晉升名單查詢</h4>                    
                      <h5>業績年月</h5>
                      <div class="form-row mb-5">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y8'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m8'); ?>
                        </div>
						</div>
						<h5>組織類型</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <div class="row align-items-center form-inline">
							  <div class="col-auto"><input type="radio" value="0" name="r8" checked> 第 </div>
							  <div class="col-auto px-0">
								  <?=$this->block_service->admin_select_num('type8',1,99); ?>
							  </div>
							  <div class="col-6">代組織 (第一代直屬組織)</div>
								  </div>
							  <input type="radio" value="1" name="r8" > 個人組織(不含同位階下線)<br>
							  <input type="radio" value="2" name="r8" > 整體組織(含同位階下線)
						  </div>						  
						  <div class="col-lg-4 col-sm-12 align-self-end">
                      <button type="button" onclick="show_report('8','月份晉升名單查詢')" class="btn btn-outline-secondary">開始查詢</button>
              </div>	
						</div>
                    
                  </div>
					<!-- 月份晉升名單查詢  end-->
					
					<!--期間產品統計查詢 start-->
				  <div class="mb65" id="admin_9" style="display: none;">
                    <h4>期間產品統計查詢</h4>
                    
                      <h5>資料年月</h5>
                      <div class="form-row mb-3">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y9'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m9'); ?>
                        </div>
							  <div class="col-4">至</div>
							  </div>
						  <div class="form-row mb-3">
						<div class="col-4">
                          <?=$this->block_service->admin_select_year('y91'); ?>
                        </div>
                        <div class="col-4">
                          <?=$this->block_service->admin_select_month('m91'); ?>
                        </div>
                      </div>
						
					  <h5>組織類型</h5>
					  <div class="form-row">
						  <div class="col-lg-8 col-sm-12 mb-3">
							  <div class="row align-items-center form-inline">
							  <div class="col-auto"><input type="radio" value="0" name="r9" checked> 第 </div>
							  <div class="col-auto px-0">
								  <?=$this->block_service->admin_select_num('type9',1,99); ?>
							  </div>
							  <div class="col-6">代組織 (第一代直屬組織)</div>
								  </div>
							  <input type="radio" value="1" name="r9"> 個人組織(不含同位階下線)<br>
							  <input type="radio" value="2" name="r9"> 整體組織(含同位階下線)<br>
							  <input type="radio" value="3" name="r9"> 個人
						  </div>
						  <div class="col-lg-4 col-sm-12 align-self-end">
                      <button type="button" onclick="show_report('9','期間產品統計查詢')" class="btn btn-outline-secondary">開始查詢</button>
              </div>	
						</div>
						
                    
                  </div>
					<!--期間產品統計查詢 end-->
					
					<!--年度進貨資枓查詢 start-->
				  <div class="mb65" id="admin_10" style="display: none;">
                    <h4>年度進貨資枓查詢</h4>
                    
                      <h5>進貨年度</h5>
                      <div class="form-row">
                        <div class="col-4">
                          <?=$this->block_service->admin_select_year('y10'); ?>
                        </div>
                        <div class="col-4">
                           <button type="button" onclick="show_report('10','年度進貨資枓查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--年度進貨資枓查詢 end-->
					
					<!--組織宅配訂單查詢 start-->
				  <div class="mb65" id="admin_14" style="display: none;">
                    <h4>組織宅配訂單查詢</h4>
                    
                      <h5>請選擇宅配單產品</h5>
                      <div class="form-row">
                        <div class="col-4">
                          <select name="type14" class="form-control">
                          	  <?php if (isset($ww_q_helpro)){ 
                          	  	        foreach ($ww_q_helpro as $item){
                          	  	        	       echo '<option value="'.trim($item['helno']).'">'.trim($item['helna']).'</option>';
                          	  	        }
                          	        }	
                          	  ?>
                          </select>                        
                        </div>                        
                        <div class="col-4">
                           <button type="button" onclick="show_report('14','組織宅配訂單查詢')" class="btn btn-outline-secondary">開始查詢</button>
                        </div>
                      </div>                    
                  </div>
					<!--組織宅配訂單查詢 end-->
					
					</form>
					<hr class="mt-0 mb70" id="admin_hr" style="display: none;">
					<?php if ($position['title1'] > ''){ ?>					          
					          <div class="mb15" style="margin-top: -20px;">
					             <p class="text-info">
                              <?=$position['title1']?>
                       </p>
                    </div>   
               <?php } ?>   
               <div class="mb65" style="margin-top: -20px;" id="admin_desc"><?=$admin_remark?></div>   
               <?php if (isset($ww_q_monpv)){ ?>               
                  <div class="mb65" style="margin-top: -30px;"> 
					            <p class="text-info">這是您 <?=date('Y-m-d H:i',strtotime($this->session->userdata('bp_date')))?> 為止本月份 業績現況 統計</p>
					            <h5>組織業績(BP)</h5>
                      <div class="news-info mb30"></div>
				              	<table class="table table-bordered mb-5 text-center">
                         <thead class="table-secondary">
                           <tr>
                             <th>類別</th>
                             <th>領取獎金</th>
                             <th>領取推廣獎金</th>
                             <th>本月份建議售價</th>
                             <th>個人業績</th>
                             <th>個人組織業績</th>
                             <th>整體組織業績</th>
                           </tr>
                         </thead>
                         <tbody>
                           <tr>
                             <td>A</th>
                             <td><?=$ww_q_monpv['is_bonu']?></td>
                             <td><?=$ww_q_monpv['is_a_dev']?></td>
                             <td><?=number_format($ww_q_monpv['a_amt'])?></td>                             
                             <td><?=number_format($ww_q_monpv['pv_per'])?></td>
                             <td><?=number_format($ww_q_monpv['pv_sv'])?></td>
                             <td><?=number_format($ww_q_monpv['pv_wv'])?></td>
                           </tr>
                           <tr>
                             <td>B</th>
                             <td><?=$ww_q_monpv['is_h_bonu']?></td>
                             <td><?=$ww_q_monpv['is_b_dev']?></td>
                             <td><?=number_format($ww_q_monpv['b_amt'])?></td>                             
                             <td><?=number_format($ww_q_monpv['pv_h_per'])?></td>
                             <td><?=number_format($ww_q_monpv['pv_h_sv'])?></td>
                             <td><?=number_format($ww_q_monpv['pv_h_wv'])?></td>
                           </tr>
                           </tbody>
                       </table>
                  </div>
               
			            <div class="mb65">
					             <h5>代數業績(BP)</h5>
                       <div class="news-info mb30"></div>
					               <table class="table table-bordered mb-5 text-center">
                          <thead class="table-secondary">
                            <tr>
                              <th>類別</th>
                              <th>第一代業績</th>
                              <th>第二代業績</th>
                              <th>第三代業績</th>
                              <th>第四代業績</th>
                              <th>第五代業績</th>
                              <th>第六代業績</th>
                              <th>第七代業績</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>A</th>
                              <td><?=number_format($ww_q_monpv['pv_1'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_2'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_3'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_4'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_5'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_6'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_7'])?></td>
                            </tr>
                            <tr>
                              <td>B</th>
                              <td><?=number_format($ww_q_monpv['pv_h_1'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_2'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_3'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_4'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_5'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_6'])?></td>
                              <td><?=number_format($ww_q_monpv['pv_h_7'])?></td>
                            </tr>
                            </tbody>
                        </table>
                 </div>
               <?php } ?>
                <hr class="mt-0 mb70">
              </div>                 
              <aside role="complementary" class="aside col-xl-3 col-md-3 mb130">                  
				      <div class="mb75">
				         <?=$this->block_service->member_right_menu('admin'); ?>				   
				         
				         <?=$this->block_service->admin_right_menu('admin'); ?>				   
                 
                 <?=$this->block_service->member_right_prdclass(); ?>				  
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>       
      <?=$this->block_service->load_html_footer(); ?>  
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="newsmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: 0px solid #ffffff;">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="newsmodal_body" id="newsmodal_body" style="margin-top:-36px;">
      </div>    
      <div class="modal-footer mt-3" style="border-top: 0px solid #ffffff;margin-top:-30px;">  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>


<script language="JavaScript" type="text/JavaScript">

function show_report(report_id,report_title)
{   
    var reportgo = true;
    chg_token('<?php echo $this->security->get_csrf_token_name(); ?>');
    if (report_id == 11){        
        if ($( "#dno" ).val().length == 0){   
            $( "#dno" ).focus();
            reportgo = false;
            alert('會員編號未輸入'); 
        }
    }
    if (reportgo){
        var params=$('#admin_Form').serialize();     
        console.log(params);        
        //$( "#newsmodal_title" ).html(report_title);        
        $("#newsmodal").modal('show');    
        $( "#newsmodal_body" ).html('<p><center style="font-size:20px"><img src="'+base_url+'public/images/loading.gif"> 資料讀取中，請稍後。</center></p>');
        
        $.ajax({
             url: base_url+"report/"+report_id,                
             type: "POST",
             dataType: "json",
             data:params,
             success: function(data){                       
                  $( "#newsmodal_body" ).html(data.bodyhtml);           
             }
        });   
    }
}

function report_A(jnum){
  
  for(i=1 ; i < 15;i++){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
      $( "#admin_"+i ).hide();
  }
  $( "#admin_"+jnum ).show();     
  $( "#admin_hr" ).show();  
  $( "#admin_desc" ).hide();  
  
  if (platform == "DESKTOP"){ 
      $('html,body').animate({scrollTop:$('#admin_Form').offset().top}, 1000);              
  }
}

</script>  