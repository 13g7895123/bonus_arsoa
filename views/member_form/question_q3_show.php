<div class="mb-4">
    <div class="container">       
        <div class="row">
            <div class="col-sm-12 mb30">
                <label class="label-custom">講師產品使用建議方式說明：<input type="hidden" name="qnum" id="qnum" value="<?=$qnum?>"></label>
                <?=str_replace("\n", "<br>",$t1);?>
                <textarea style="display:none" rows="9" cols="30" class="form-control form-control-custom" name="t1" id="t1" required readonly onkeyup="check(300);" placeholder="請輸入內容，限300字內"><?=$t1?></textarea>
            </div>
        </div>        
        
    </div>
</div>