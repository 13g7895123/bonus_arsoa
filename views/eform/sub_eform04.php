<div class="mb-2">
    <div class="card bg-light ">
        <div class="card-body">
            <div class="container wow fadeInUp" data-wow-delay=".2s">
                <div class="row product-item">
                    <div class="col-sm-3">
                        <label class="label-custom">貨號：</label>
                        <input type="text" name="p_no_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">品名：</label>
                        <input type="text" name="p_name_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">數量：</label>
                        <input type="number" step="1" min="0" class="quantity" name="purchaser_num_<?=$index;?>" style="width: 100%;">
                    </div>
                    <div class="col-sm-3">
                        <label class="label-custom">售價：</label>
                        <input type="number" step="1" min="0" class="price" name="r_price_<?=$index;?>" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>