<div class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mb30">
                <label class="label-custom">講師產品使用建議方式說明：<input type="hidden" name="qnum" id="qnum" value="<?=$qnum?>"></label>
                <textarea rows="9" cols="30" class="form-control form-control-custom" name="t1" id="t1" required onkeyup="check(300);" placeholder="請輸入內容，限300字內"><?php if(isset($t1) && $t1 > ''){ echo $t1; } ?></textarea>
            </div>
        </div>        
        
    </div>
</div>
<script>
function check(num) {
   var regC = /[^ -~]+/g;
   var regE = /\D+/g;
   var str = t1.value;
   
   if (regC.test(str)){
       t1.value = t1.value.substr(0,num);
   }
   
   if(regE.test(str)){
       t1.value = t1.value.substr(0,num);
   }
}
</script>