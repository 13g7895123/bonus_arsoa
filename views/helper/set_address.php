<div class="form-group row">
            <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人姓名：</label>
                  <div class="col-sm-12">
                       <input type="text" class="form-control" name="addr_name" id="addr_name" placeholder="收件人姓名">
                  </div>
            </div>
					  <div class="form-group row">
						  <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人地址：</label>
                          <div class="form-group col-md-4">
                          <select id="inputState" class="form-control">
                              <option selected>城市...</option>
                              <option>...</option>
                            </select>
                        </div>
                          <div class="form-group col-md-4">
                          <select id="inputState" class="form-control">
                              <option selected>行政區...</option>
                              <option>...</option>
                            </select>
                        </div>
                          <div class="form-group col-md-4">
                          <input type="text" class="form-control" id="inputZip" placeholder="郵遞區號">
                        </div>
						            <div class="form-group col-sm-12">
                          <input type="text" class="form-control" name="addr_address" id="addr_address"  placeholder="詳細地址">
                        </div>
                        </div>
						            <div class="form-group row">
                          <label for="inputPassword" class="col-sm-12 col-form-label"><span class="text-danger">*</span>收件人聯絡電話：</label>
                          <div class="col-sm-12">
                          <input type="text" class="form-control" name="addr_tel" id="addr_tel"  placeholder="收件人聯絡電話" onKeyUp="value=value.replace(/[^\d\#\-\(\)]/g,'')">
                        </div>
                      </div>
		  				        <div class="form-group row">
                          <p class="form-column">
							               我們重視您的隱私：<a href="<?=base_url('copyright')?>" target="_blank" class="button-terms">會員條款</a>及<a href="<?=base_url('privacy_policy')?>" target="_blank" title="隱私權政策">隱私權政策</a></p>
						          <p class="form-column">
                        <input type="checkbox" name="addr_set" id="addr_set" value="Y">
                        <label for="IAgree">設定該地址為預設地址</label>
                      </p>
</div>