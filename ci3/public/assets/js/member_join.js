function getCookie_join(i) {
    var e = document.cookie.match(new RegExp("(^| )" + i + "=([^;]*)(;|$)"));
    return null != e ? unescape(e[2]) : null
}

/* 放入車 */
function join_incar(itype,p_no,pid,num){
      $.ajax({
                url: base_url+"member_join/join_incart/"+itype,
                type: "POST",
                dataType: "json",
                data:{"p_no":p_no,
	                    "pid":pid,
                      "num" :parseInt($("#num_"+num).val()),
                      "csrf_name": getCookie_join("csrf_cookie_name"),
                      "csrf_test_name": getCookie_join("csrf_cookie_name")       
                },
                success: function(data){                    
                    if (data.status){                            
                        jptype = 'png';
      	              	png = 'cart_already';       	             
      	                if ($('#show_prd_num1').length > 0) {
                            $( "#show_prd_num1").text(data.prd_num);
                        }
                        if ($('#show_prd_num2').length > 0) {
                            $( "#show_prd_num2").text(data.prd_num);
                        }          
                        if ($('#lblCartCount').length > 0) {
                            $( "#lblCartCount").text(data.prd_num);
                        }                
                        window_alert(data.errmsg,jptype,png);
                    }else{
                        jptype = 'png';
                        png = 'cart_warning';
                        window_alert(data.errmsg,jptype,png);
                    }    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}

/* 放入車 */
function join_incart(itype,prd,num){
      $.ajax({
                url: base_url+"member_join/join_incart/"+itype,
                type: "POST",
                dataType: "json",
                data:{"prd":prd,
                      "num" :parseInt($("#num_"+num).val()),
                      "csrf_name": getCookie_join("csrf_cookie_name"),
                      "csrf_test_name": getCookie_join("csrf_cookie_name")       
                },
                success: function(data){                    
                    if (data.status){                            
                        jptype = 'png';
      	              	png = 'cart_already';       	             
      	                if ($('#show_prd_num1').length > 0) {
                            $( "#show_prd_num1").text(data.prd_num);
                        }
                        if ($('#show_prd_num2').length > 0) {
                            $( "#show_prd_num2").text(data.prd_num);
                        }          
                        if ($('#lblCartCount').length > 0) {
                            $( "#lblCartCount").text(data.prd_num);
                        }                
                        window_alert(data.errmsg,jptype,png);
                    }else{
                        jptype = 'png';
                        png = 'cart_warning';
                        window_alert(data.errmsg,jptype,png);
                    }    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}


/* 購物車 內容變更 顯示提示 */
function change_cart(ctype){
	  if (ctype == 'C'){
    		$('#submitbutton').attr('disabled', true);
    		$("#submitbutton").attr("onclick","");
    		$("#submitbutton").css("color","red");
    		$("#submitbutton").html('↑變動需按更改才可下一步');	     
    }else{
    	  $('#submitbutton').attr('disabled', false);
    		$("#submitbutton").attr("onclick","check_data();");
    		$("#submitbutton").css("color","#6c757d");
    		$("#submitbutton").html('下一步');	 
    }
}

/* 購物車 顯示 */
function join_cart_change(jtype) {          
        $( "#error_msg" ).html( '' );
        $.ajax({            
            url: base_url + "member_join/step_cart_change/"+jtype,      
            type: 'POST',
            data: jQuery('#oForm').serialize(),
        dataType: 'json',
         success: function(data){	   	    	     	             
	     	             if (data.status){
	     	                 pckpro_protype_change(jtype,'cart');
	     	                 change_cart('U');
	     	                 pckpro_num(jtype);
	     	             }
	     	         }
	       });
}

/* 產品 顯示 */
function product_show(p_no,p_name,p_price,unit){
						$( "#p_name" ).html(p_name);
						$( "#p_price" ).html(p_price);
						$( "#p_imgsrc" ).attr("src", '');						
						$( "#p_desc" ).html('');						
          	$.ajax({
                url: base_url+"member_join/product_show",
                type: "POST",
                dataType: "json",
                data:{"p_no":p_no,
                      "csrf_name": getCookie_join("csrf_cookie_name"),
                      "csrf_test_name": getCookie_join("csrf_cookie_name")       
                },
                success: function(data){                    
                    if (data.status){   	                      
	                      $("#p_imgsrc").attr("src",data.imgsrc);
	                      $("#p_desc").html(data.desc);                      
	                      $("#p_unit").html(unit);
                    }    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });

}	

/* 分類 改變 */
function pckpro_protype_change(itype,protype){	     
	      $.ajax({            
                  url: base_url + "member_join/pckpro_protype/"+itype,      
                  type: "POST",
     					    data: { 
     					              'protype'  : protype
     					           },
     					    dataType: "json",
     					    success: function(data){     					             					       
     					        $( '#pckpro_list' ).html(data.html); 
     					        if (protype == 'cart'){
     					        	  $("#pckpro_protype option[value='cart']").attr("selected", true); 
     					        	  console.log('cart');
     					        }    					        
     					    },
     					    error: function (xhr, ajaxOptions, thrownError) {
     					        console.log(xhr.responseText);
     					    }
     					});     
}

/* 計算產品數 */
function pckpro_num(itype){	
	      $.ajax({            
                 url: base_url + "member_join/pckpro_num/"+itype,      
                  type: "POST",     					    
     					    dataType: "json",
     					    success: function(data){   
     					        if (data.status){    
                          if ($('#show_prd_num1').length > 0) {
                              $( "#show_prd_num1").text(data.prd_num);
                          }
                          if ($('#show_prd_num2').length > 0) {
                              $( "#show_prd_num2").text(data.prd_num);
                          }          
                          if ($('#lblCartCount').length > 0) {
                              $( "#lblCartCount").text(data.prd_num);
                          }                                        
                      }			        
     					    },
     					    error: function (xhr, ajaxOptions, thrownError) {
     					        console.log(xhr.responseText);
     					    }
     					});     
}

/* 下頁 */
function check_data() {          
    $( "#error_msg" ).html( '' );   
    
    $.ajax({            
        url: base_url + "member_join/step_check/"+check_step,      
        type: 'POST',
        data: jQuery('#oForm').serialize(),
        dataType: 'json',
            success: function(data){	   	    
            console.log(data);
            if (data.status){
                location.href = data.next_url;
            }else{	     		                   
                $( "#error_msg" ).html( data.errmsg );
                if (check_step == 'reward'){
                    pckpro_protype_change(4,'cart');
                    $('html,body').animate({scrollTop:$('#datafirst').offset().top}, 500);
                }
                $('input[name='+csrf_token_name+']').val(getCookie_join("csrf_cookie_name"));
                
            }
        }
    });
}

$(document).ready(function() { 
   $('#cityno').change(function(){                 
       ChangeCity('cityno','postal','zip','address','','請選擇行政區 *');
   });
   $('#postal').change(function(){                 
       ChangeTown('cityno','postal','zip','address');
       $('#address').focus();
   });   
});

function check_join_data(jointype) {
    $( "#error_msg1" ).html( '' );        
    $( "#error_msg2" ).html( '' );     
    $( "#jointype" ).val( jointype );     
    var errmsg = ''; 
    var focusstr = '';      

    if ($('input[name=uname]').val() == ''){
        errmsg = '姓名';                
        focusstr = 'uname';
    }

    // 姓名檢查只能輸入中文全形2~4個字
    const name = $('input[name=uname]').val();
    if (name != '' && !/^[\u4e00-\u9fa5]{2,4}$/.test(name)) {
        errmsg = '請輸入2~4個全形中文名字';
        focusstr = 'uname';
    }

    if ($('#sex').val() == '') { 
            if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '性別';                
        if (focusstr ==''){ focusstr = 'sex'; }
    }
    if (jointype == 3){
        if ($('input[name=idno]').val() == ''){
                if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '圓夢事業組合—身份證字號必填';                
            if (focusstr ==''){ focusstr = 'idno'; }
        } 	  
    }        
    if ($('input[name=bday]').val() == ''){
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '生日';                
        if (focusstr ==''){ focusstr = 'bday'; }
    }

    // 日期
    const birthday = $('input[name=bday]').val();
    const regex = /^(\d{4})-(\d{2})-(\d{2})$/;    

    if (birthday != '') {
        const match = birthday.match(regex);

        if (match) {
            // 提取年月日
            const [, year, month, day] = match;

            // 檢查格式
            if (!regex.test(birthday)) {
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '生日日期有誤';                
                if (focusstr ==''){ focusstr = 'bday'; }
            }

            // 檢查日期是否有效
            if (!isValidDate(year, month, day)) {
                if (errmsg > ''){ errmsg = errmsg + '\n' }
                errmsg = errmsg + '生日日期有誤';                
                if (focusstr ==''){ focusstr = 'bday'; }
            }
        }
    }

    if ($('input[name=tel]').val() == ''){
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '聯絡電話';                
        if (focusstr ==''){ focusstr = 'tel'; }
    }     

    const phone = $('input[name=tel]').val();
    if (phone != ''){
        if (!isValidMobile(phone) && !isValidLandline(phone)) {
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '聯絡電話格式錯誤';
            if (focusstr ==''){ focusstr = 'tel'; }
        }
    }

    if ($('input[name=email]').val() > ''){            
        if(!/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( $('input[name=email]').val() )){
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + 'E-mail格式有誤';      
            if (focusstr ==''){ focusstr = 'email'; }             
        }
    } 
    if ($('#cityno').val() == '') { 
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '縣巿';                
            if (focusstr ==''){ focusstr = 'cityno'; }   
    }
    if ($('#postal').val() == '') { 
            if (errmsg > ''){ errmsg = errmsg + '\n' }
            errmsg = errmsg + '行政區';                
            if (focusstr ==''){ focusstr = 'postal'; }   
    }
    if ($('input[name=address]').val() == ''){
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '地址';                
        if (focusstr ==''){ focusstr = 'address'; }   
    }

    // 地址
    const address = $('input[name=address]').val();
    if (!address.includes('號')) {
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '輸入地址有誤';
        if (focusstr ==''){ focusstr = 'address'; } 
    }

    if ($('input[name=referrer_name]').val() == ''){
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '推薦人姓名';                
        if (focusstr ==''){ focusstr = 'referrer_name'; }   
    }
    if ($('input[name=referrer_c_no]').val() == ''){
        if (errmsg > ''){ errmsg = errmsg + '\n' }
        errmsg = errmsg + '會員編號';                
        if (focusstr ==''){ focusstr = 'referrer_c_no'; }   
    }                  
    if (errmsg> ''){
            $('#'+focusstr).focus();
        alert("請確認以下欄位資訊是否有誤\n\n" + errmsg);            
    }else{            
        $.ajax({            
            url: base_url + "member_join/step_check/form",      
            type: 'POST',
            data: jQuery('#oForm').serialize(),
            dataType: 'json',
            success: function(data){	   	    	     		              
                            if (data.status){
                                location.href = data.next_url;
                            }else{	     		                   
                                $( "#error_msg1" ).html( data.errmsg );
                                $( "#error_msg2" ).html( data.errmsg );
                                $('html,body').animate({scrollTop:$('#datafirst').offset().top}, 1000);
                                if (data.focuskey > ''){
                                    $('#'+data.focuskey).focus();
                                }
                                $('input[name='+csrf_token_name+']').val(getCookie_join("csrf_cookie_name"));
                                
                            }
                        }
        });
    }  
}

// 檢查日期是否有效
function isValidDate(year, month, day) {
    const date = new Date(year, month - 1, day); // JS 月份從 0 開始
    return date.getFullYear() === parseInt(year) &&
           date.getMonth() + 1 === parseInt(month) &&
           date.getDate() === parseInt(day);
}

const areaCodeMap = {
    '02': [8],
    '03': [6, 7, 8],
    '037': [6],
    '04': [8],
    '049': [6, 7],
    '05': [6, 7],
    '06': [7, 8],
    '07': [7, 8],
    '08': [6, 7],
    '082': [6],
    '0836': [6],
    '089': [6],
    '0826': [6]
};

// 驗證手機
function isValidMobile(phone) {
    const clean = phone.replace(/[-\s]/g, '');
    return /^09\d{8}$/.test(clean);
}

// 驗證市話
function isValidLandline(phone) {
    const [mainPart, extPart] = phone.split('#');

    // 分機驗證（最多6碼數字）
    if (extPart !== undefined && !/^\d{1,6}$/.test(extPart)) {
        return false;
    }

    const clean = mainPart.replace(/[-\s]/g, '');

    for (let areaCode in areaCodeMap) {
        if (clean.startsWith(areaCode)) {
            const numberPart = clean.slice(areaCode.length);
            const validLengths = areaCodeMap[areaCode];
            if (validLengths.includes(numberPart.length)) {
                return true;
            }
        }
    }
    return false;
}