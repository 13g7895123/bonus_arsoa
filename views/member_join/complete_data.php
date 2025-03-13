<div class="card-body">
    <div class="form-group mb-30">                            
      <div class="row">
        <div class="form-group col-md-3">
           姓名：<?=htmlspecialchars($data['uname'])?>
        </div>
        <div class="form-group col-md-3">
            <div class="custom_select">
            	性別：
                <?php
                    if ($data['sex'] == 'M'){
                        echo '男';
                    }else{
                    	  echo '女';
                    }
                ?>
            </div>
        </div>
        <div class="form-group col-md-3">
            身份證字號：<?=htmlspecialchars($data['idno'])?>
        </div>
        <div class="form-group col-md-3">
             生日：<?=htmlspecialchars($data['bday'])?>
        </div>
     </div>
     <div class="row">
     	<div class="col-md-6 form-group">
                 聯絡電話：<?=htmlspecialchars($data['tel'])?>
     	</div>
     	<div class="col-md-6 form-group">
                 E-mail：<?=htmlspecialchars($data['email'])?>
     	</div>
     </div>
     <div class="row">
     	<div class="col-md-12 form-group">
                 通訊地址：<?=htmlspecialchars($data['postal'])?>
                       <?=htmlspecialchars($data['address'])?>
     	</div>
     </div>
     <div class="row">
     	<div class="col-md-6 form-group">
                 推薦人姓名：<?=htmlspecialchars($data['referrer_name'])?>
     	</div>
     	<div class="col-md-6 form-group">
                 推薦人會員編號：<?=htmlspecialchars($data['referrer_c_no'])?>
     	</div>
     </div>							           					
 </div>
</div>