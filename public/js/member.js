// 加入購物車
const joinToCart = () => {
    const formData = new FormData(document.querySelector('#oForm'));
    const data = Object.fromEntries(formData);
    data.days = 0;

    // 檢查是否選擇專案
    if (data['sel_prd[]'] == undefined) {
        Swal.fire({
            title: '提醒',
            text: '請選擇一個專案',
            icon: 'info',
            timer: 1500,
            showConfirmButton: false
        });

        return;
    }

    // Check if URL ends with /4
    const currentUrl = window.location.pathname;
    if(currentUrl.endsWith('/4')) {
        Swal.fire({
            title: '系統提示',
            text: '請選擇您希望的出貨日期',
            icon: 'question',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonText: '5號出貨',
            denyButtonText: '20號出貨',
            cancelButtonText: '取消'
        }).then((result) => {
            if (result.isConfirmed) {
                data.days = 5;
                callApi();
                return;
            } else if (result.isDenied) {
                data.days = 20;
                callApi();
                return;
            }
            // 取消
            return;
        });
    }else if(currentUrl.endsWith('/5')){
        // 肌能調理宅配專案
        data.days = 10;
        callApi();
        return;
    }

    function callApi(){
        data.csrf_name = getCookie("csrf_cookie_name");
        data.csrf_test_name = getCookie("csrf_cookie_name");
        
        $.ajax({
            url: base_url + "order/inCartNew",
            type: "POST", 
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // 加入購物車成功
                    Swal.fire({
                        icon: "success",
                        title: "系統訊息",
                        text: response.msg,
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        location.href = base_url + 'order/cart';
                    })
                } else {
                    // 加入購物車失敗
                    Swal.fire({
                        icon: "error",
                        title: "系統訊息",
                        text: response.msg,
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}

// 商品選取限制
// 使用方式:
// 在商品的checkbox元素上加上onclick事件
// 例如: <input type="checkbox" name="sel_prd[]" onclick="checkProductSelection(this)">
const checkProductSelection = (checkbox) => {
    const checkboxes = document.querySelectorAll('input[name="sel_prd[]"]');
    let checkedCount = 0;
    
    checkboxes.forEach(box => {
        if(box.checked) checkedCount++;
    });

    if(checkedCount > 1) {
        // 取消勾選當前checkbox
        checkbox.checked = false;
        
        // 顯示錯誤訊息
        Swal.fire({
            icon: 'warning',
            title: '系統訊息',
            text: '一次只能選擇一項商品',
            showConfirmButton: false,
            timer: 2000
        });
    }
}
