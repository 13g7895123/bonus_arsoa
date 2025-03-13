   <section>
			<div id="page-wrapper" class="sign-in-wrapper">
				<div class="graphs">
					<div class="sign-in-form">
						
						<div class="signin">	
						  <div class="sign-in-form-top">
							   <p style="margin-top: -20px;"><?=FC_Web?> <br>後端管理系統</p><br>
						  </div>	  					
							<form name="oForm" method="post" language="javascript" action="<?php echo base_url( 'wadmin/login' ); ?>">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<br>
							<div class="log-input">
								<div class="log-input-left">
								   <input type="text" class="user" name="account" value="" onfocus="this.value = '';" placeholder="帳號" required />
								</div>								
								<div class="clearfix"> </div>
							</div>
							<div class="log-input">
								<div class="log-input-left">
								   <input type="password" class="lock" name="password" value="" placeholder="密碼" onfocus="this.value = '';" required />
								</div>								
								<div class="clearfix"> </div>
							</div>
							<div class="log-input">						  	
						  		<div class="col-md-4 grid_box1" style="border: 1px solid #D3D3D3;">						  			
						  			<img id="siimage" style="width:100%;height:40px" src="<?php echo base_url( 'captcha' ); ?>" alt="看不清楚時,可點選可更換圖示" onclick="$(this).attr('src','<?php echo base_url( 'captcha' ); ?>');" style="cursor: pointer;" class="fixed-size">
						  		</div>
						  		<div class="col-md-8">
						  			<input type="text" class="lock" class="form-control1" onkeyup="this.value=this.value.toUpperCase()" name="captcha" placeholder="認證碼" AutoComplete="Off" required>
						  		</div>
						  		<div class="clearfix"> </div>						  	
						  </div>
						  <?php if ( !empty( $error_message ) ): ?>
						          <div class="log-input">
								          <div class="log-input-center" >
                                <div class="alert alert-danger" role="alert"><?php echo $error_message; ?></div>
                          </div>
						          </div>
              <?php endif; ?>
							<input type="submit" name="loginchk" value="登入">
						</form>	 
						</div>
					</div>
				</div>
			</div>		
</section>	