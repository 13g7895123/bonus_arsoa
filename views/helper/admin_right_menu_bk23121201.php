				<div class="pt-2" style="border: 1px solid #888;">
          <?php if ($active == 'admin'){ ?>
              <div class="adminmenutitle">
                   <i class="icon ion-earth mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">獎金資料查詢</span>
							</div>
							<ul class="adminmenu" >
								<li><a href="javascript:report_A(1);">月份獎金明細查詢 </a></li>
								<li><a href="javascript:report_A(2);">歷史獎金明細查詢 </a></li>
							</ul>
                        
						  <div class="adminmenutitle">
                   <i class="icon ion-ios-book mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">組織業績查詢</span>
						  </div>
							<ul class="adminmenu">
								<li><a href="javascript:report_A(3);">月份組織業績查詢 </a></li>
								<li><a href="javascript:report_A(4);">個人歷史業績查詢 </a></li>
								<li><a href="javascript:report_A(11);">會員訂購品項查詢</a></li>
								<li><a href="javascript:report_A(12);">建議售價查詢 </a></li>
								<li><a href="javascript:report_A(13);">赴日研修顆星 </a></li>
								<?php if ($this->session->userdata('member_session')['c_no'] == '000000'){ ?>
								          <li><a href="javascript:report_A(14);">組織宅配訂單查詢 </a></li>
								<?php } ?>
							</ul>
                        
						  <div class="adminmenutitle">
                          <i class="icon ion-ios-contact mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">組織基本資料</span>
						  </div>
							<ul class="adminmenu">
								<li><a href="javascript:report_A(5);">直接推薦資料查詢 </a></li>
								<li><a href="javascript:report_A(6);">組織人數統計查詢 </a></li>
								<li><a href="javascript:report_A(7);">歷史組織人數查詢</a></li>
								<li><a href="javascript:report_A(8);">月份晉升名單查詢  </a></li>
							</ul>
                        
				  		<div class="adminmenutitle">
                          <i class="icon ion-filing mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;">產品銷售分析</span>
						  </div>
							<ul class="adminmenu" >
								<li><a href="javascript:report_A(9);">期間產品統計查詢 </a></li>
								<li><a href="javascript:report_A(10);">年度進貨資枓查詢 </a></li>
							</ul>
          <?php } ?>              
						<div class="adminmenutitle">
                          <i class="icon ion-cube mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;"><a href="<?=base_url('member_admin/edunews')?>"<?php if ($active == 'edunews'){ ?> class="active"<?php }?>>教育訓練情報</a></span>
                        </div>
						<div class="adminmenutitle">
                          <i class="icon ion-ios-paper mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;"><a href="<?=base_url('member_admin/news')?>"<?php if ($active == 'news'){ ?> class="active"<?php }?>>ARSOA NEWS 月刊</a></span>
                        </div>
						<div class="adminmenutitle">
                          <i class="icon ion-archive mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;"><a href="<?=base_url('member_admin/download')?>"<?php if ($active == 'download'){ ?> class="active"<?php }?>>表格下載列印</a></span>
                        </div>
						<div class="adminmenutitle">
                          <i class="icon ion-ios-body mr-3" style="font-size: 1.5rem;"></i><span style="font-size: 1.25rem; font-weight: bold;"><a href="<?=base_url('member_admin/law')?>"<?php if ($active == 'law'){ ?> class="active"<?php }?>>商德規範</a></span>
                        </div>
						  
                    </div>
              <br>