function ChangeCity(jc,jp,jz,ja,jv,foption)
{
	      var vfoption = '鄉鎮市區';
	      if (foption > ''){
	      	  vfoption = foption;
	      }
        $('#'+jp).empty().append($('<option></option>').val('').text(vfoption));
        $('#'+jz).val('');
        var cityno = $.trim($('#'+jc+' option:selected').val());        
        if (cityno.length != 0)
        {
            $.getJSON(base_url+"base/town/"+ cityno, function(data)
            {
                $.each(data, function(i, item){
                    $('#'+jp).append($('<option></option>').val(item.postal).text(item.towntitle));
                });
                if (jz > ''){
                    $('#'+jp).val(jv);   
                }                
            });  
            $('#'+ja).val($("#"+jc+" :selected").text());                  
        }
}
function ChangeTown(jc,jp,jz,ja)
{
        var postal = $.trim($('#'+jp+' option:selected').val());   
        $('#'+jz).val(postal);
        $('#'+ja).val($("#"+jc+" :selected").text()+""+$("#"+jp+" :selected").text());      
}

function ChangeProductNum(ntype,num,nm)
{
    if (ntype == 'Minus'){
        pn = parseInt($("#num_"+num).val());
        pn = pn - 1;
        if (pn >= nm){
            $("#num_"+num).val(pn);
        }
    }else{
        pn = parseInt($("#num_"+num).val());
        pn = pn + 1;
        if (pn <= nm){
            $("#num_"+num).val(pn);
        }
    }
}
function incar(ptype,p_no,num){

      $.ajax({
                url: base_url+"order/incart",
                type: "POST",
                dataType: "json",
                data:{"p_no":p_no,
                      "ptype":ptype,  
                      "num" :parseInt($("#num_"+num).val()),
                      "csrf_name": getCookie("csrf_cookie_name"),
                      "csrf_test_name": getCookie("csrf_cookie_name")       
                },
                success: function(data){
                    console.log(data);
                    if (data.status){    
                        $("#num_"+num).val(1); 
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
                        if (data.errcode == 'notlogin'){
                            alert(data.errmsg);
                            top.location.href = base_url+"member/login?rdurl="+location.href;
                        }else{
                            jptype = 'png';
                            png = 'cart_warning';
                            window_alert(data.errmsg,jptype,png);
                        }
                    }         
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}

function getCookie(i) {
    var e = document.cookie.match(new RegExp("(^| )" + i + "=([^;]*)(;|$)"));
    return null != e ? unescape(e[2]) : null
}
function window_alert(msg,ptype,png){
	  if(ptype == 'png'){
         $("#cartGroup").html('<div class="group"><img src="'+base_url+'public/images/'+png+'.png"><br><span style="font-size:42px;"></span>'+msg+'</div>');
    }else if(ptype == 'icon'){
         $("#cartGroup").html('<div class="group"><span style="font-size:42px;color:#FFCC22"><i class="'+icon+'"></i><br></span>'+msg+'</div>'); 
    }else{
         $("#cartGroup").html('<div class="group"><span style="font-size:40px;">'+msg+'</span></div>');
    }
 	 $("#cartnote").show();
 	 $("#cartGroup").show().delay(1500).fadeOut();
}


/* 複製網址  */
function CopyUrl(){    
    var pageUrl = $('#pageUrl').val();       
    var el = $('#pageUrl').val(pageUrl)[0];        
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        var oldContentEditable = el.contentEditable,
        oldReadOnly = el.readOnly,
        range = document.createRange();

        el.contentEditable = true;
        el.readOnly = false;
        range.selectNodeContents(el);

        var s = window.getSelection();
        s.removeAllRanges();
        s.addRange(range);

        el.setSelectionRange(0, 999999); 

        el.contentEditable = oldContentEditable;
        el.readOnly = oldReadOnly;
    } else {
        el.select();
    }
    document.execCommand('copy');
    alert("已複製連結，歡迎分享！");
}

function tracker(i, e) {         
    $.post(base_url+"tracker/banners", {
        type: i,
        id: e,
        csrf_test_name: getCookie("csrf_cookie_name")
    }, function(i) {
        console.log(i)
    }, "json")
}

function chg_token(jid){
  $("#"+jid).val(getCookie("csrf_cookie_name"));
}

function webview(jhref) {
         $.ajax({
                url: base_url+"tracker/webview",
                type: "POST",
                dataType: "json",
                data:{"http_referer":jhref,
                      "csrf_name": getCookie("csrf_cookie_name"),
                      "csrf_test_name": getCookie("csrf_cookie_name")       
                },
                success: function(data){
                 },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.responseText);
                }

            });
}       
$(window).load(function(){
    webview(encodeURIComponent(location.href));       
});   

$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 100) {
        $('#back2Top').fadeIn();
		$('#shoppingcart').fadeIn();
    } else {
        $('#back2Top').fadeOut();
		$('#shoppingcart').fadeOut();
    }
});
$(document).ready(function() {
    $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

});