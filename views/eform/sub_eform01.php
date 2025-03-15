<div class="container mb-2 wow fadeInUp">
    <div class="card bg-light ">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <label class="label-custom">會員編號：</label>
                        <input type="text" name="purchaser_c_no_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">姓名：</label>
                        <input type="text" name="purchaser_c_name_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">數量：</label>
                        <input type="number" step="1" min="0" name="purchaser_num_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">金額：</label>
                        <input type="text" readonly name="purchaser_amount_<?=$index;?>" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>