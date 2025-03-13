var FC_LG = 'zh';

(function() {
    "use strict";

    // custom scrollbar

    $("html").niceScroll({styler:"fb",cursorcolor:"#27cce4", cursorwidth: '5', cursorborderradius: '10px', background: '#424f63', spacebarenabled:false, cursorborder: '0',  zindex: '1000'});

    $(".left-side").niceScroll({styler:"fb",cursorcolor:"#27cce4", cursorwidth: '3', cursorborderradius: '10px', background: '#424f63', spacebarenabled:false, cursorborder: '0'});


    $(".left-side").getNiceScroll();
    if ($('body').hasClass('left-side-collapsed')) {
        $(".left-side").getNiceScroll().hide();
    }
    // Toggle Left Menu
   jQuery('.menu-list > a').click(function() {
      
      var parent = jQuery(this).parent();
      var sub = parent.find('> ul');
      
      if(!jQuery('body').hasClass('left-side-collapsed')) {
         if(sub.is(':visible')) {
            sub.slideUp(200, function(){
               parent.removeClass('nav-active');
               jQuery('.main-content').css({height: ''});
               mainContentHeightAdjust();
            });
         } else {
            visibleSubMenuClose();
            parent.addClass('nav-active');
            sub.slideDown(200, function(){
                mainContentHeightAdjust();
            });
         }
      }
      return false;
   });

   function visibleSubMenuClose() {
      jQuery('.menu-list').each(function() {
         var t = jQuery(this);
         if(t.hasClass('nav-active')) {
            t.find('> ul').slideUp(200, function(){
               t.removeClass('nav-active');
            });
         }
      });
   }

   function mainContentHeightAdjust() {
      // Adjust main content height
      var docHeight = jQuery(document).height();
      if(docHeight > jQuery('.main-content').height()){
         jQuery('.main-content').height(docHeight);
      }
   }

   //  class add mouse hover
   jQuery('.custom-nav > li').hover(function(){
      jQuery(this).addClass('nav-hover');
   }, function(){
      jQuery(this).removeClass('nav-hover');
   });


   // Menu Toggle
   jQuery('.toggle-btn').click(function(){
       $(".left-side").getNiceScroll().hide();
       
       if ($('body').hasClass('left-side-collapsed')) {
           $(".left-side").getNiceScroll().hide();
       }
      var body = jQuery('body');
      var bodyposition = body.css('position');
      
      if(bodyposition != 'relative') {

         if(!body.hasClass('left-side-collapsed')) {
           
            body.addClass('left-side-collapsed');
            jQuery('.custom-nav ul').attr('style','');

            jQuery(this).addClass('menu-collapsed');

         } else {
           
            body.removeClass('left-side-collapsed chat-view');
            jQuery('.custom-nav li.active ul').css({display: 'block'});

            jQuery(this).removeClass('menu-collapsed');

         }
      } else {

         if(body.hasClass('left-side-show'))
            body.removeClass('left-side-show');
         else
            body.addClass('left-side-show');

         mainContentHeightAdjust();
      }

   });
   

   searchform_reposition();

   jQuery(window).resize(function(){

      if(jQuery('body').css('position') == 'relative') {

         jQuery('body').removeClass('left-side-collapsed');

      } else {

         jQuery('body').css({left: '', marginRight: ''});
      }

      searchform_reposition();

   });

   function searchform_reposition() {
      if(jQuery('.searchform').css('position') == 'relative') {
         jQuery('.searchform').insertBefore('.left-side-inner .logged-user');
      } else {
         jQuery('.searchform').insertBefore('.menu-right');
      }
   }
})(jQuery);

                      // Dropdowns Script
						$(document).ready(function() {
						  $(document).on('click', function(ev) {
						    ev.stopImmediatePropagation();
						    $(".dropdown-toggle").dropdown("active");
						  });
						});
						
	
     
  /************** Search ****************/
		$(function() {
	    var button = $('#loginButton');
	    var box = $('#loginBox');
	    var form = $('#loginForm');
	    button.removeAttr('href');
	    button.mouseup(function(login) {
	        box.toggle();
	        button.toggleClass('active');
	    });
	    form.mouseup(function() { 
	        return false;
	    });
	    $(this).mouseup(function(login) {
	        if(!($(login.target).parent('#loginButton').length > 0)) {
	            button.removeClass('active');
	            box.hide();
	        }
	    });
	});
	
	
function UpFile(Field,tmpobj){
	  var jurl = FC_WebFolder+'wadmin/upload.php?Folder='+tmpobj.folder+'&sName='+tmpobj.name+'&LimitFile='+tmpobj.limitfile+'&Logo='+tmpobj.logo;
	  //alert(jurl);
	  if (window.showModalDialog) {
          var vReturnValue = OpenDialog(true,jurl, '520', '360','','',tmpobj);
	            	try{
	            		 if (typeof(vReturnValue) != 'undefined'){
	            				Field.value= trim(vReturnValue);					
	            				
	            				if (document.getElementById("showfile_"+Field.name) && Field.value!='' &&PF_CheckFileType('jpg;gif;png;bmp',Field)){
	            					  document.getElementById("showfile_"+Field.name).src=FC_WebFolder+eval('upload_'+Field.name).folder+"/"+Field.value;					
	            				}
	            				
	            		 }
	            	}catch(e){
	            	}
          }
    else {
                var modal = window.open (jurl, null, "width=520,height=360,left=300,top=300,modal=yes,alwaysRaised=yes", null);
                modal.dialogArguments = sharedObject;
    }
}


function PF_CheckFileType(limitFile,filename){
	filename=filename.value;
	if (filename==''){return true;}
    
    vaild_ext = limitFile.split(';');
    var ext = filename.substring(filename.lastIndexOf('.')+1);
   
    ext = ext.toUpperCase();

    for(var i=0; i<vaild_ext.length; i++){
        if(ext == vaild_ext[i].toUpperCase())
        return true;
    }
    return false;
}


/*判斷日期格式是否正確*/
function PF_IsDate(datestr) {
    var year, month, day;
    
    datestr = datestr.replace(/-/g,'/'); 
    
    if (datestr.length == 5) {
        tmpary = datestr.split("/");
        year = '2000';
        month = tmpary[0];
        day = tmpary[1];
    } else {
        if (FC_LG == 'en') {
            var pattern = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
            var tmpary = new Array()
            if (!pattern.test(datestr)) return false;
            tmpary = datestr.split("/");
            year = tmpary[2];
            month = tmpary[0];
            day = tmpary[1];

        } else {
            var pattern = /^\d{4}\/\d{1,2}\/\d{1,2}$/;
            var tmpary = new Array()
            if (!pattern.test(datestr)) return false;
            tmpary = datestr.split("/");
            year = tmpary[0];
            month = tmpary[1];
            day = tmpary[2];
        }
    }

    if (month < 1 || month > 12 || day > 31 || day < 1) return false;

    if (month == 2 && day > 28) {
        if ((year % 4 == 0 && year % 100 != 0) || (year % 400 == 0)) { // 為閏年 
            if (day > 29) return false;
        }
        else {  // 非閏年 
            return false;
        }
    }
    if (day > 30 && ((month % 2) == Math.floor(month / 8))) return false;

    return true;
};

/**
 * 校驗是否爲YYYY-MM-DD HH:mm:ss 日期+時分秒格式
 * @param dateStr 時間字符串
 * @param hourSys 小時制(默認24小時制)
 * @returns
 */
function PF_IsDatetime(dateStr,hourSys){
	/*如果日期字符串爲空*/
	if(strIsNull(dateStr)){
		return false;
	}
	
	/*如果小時製爲空,則設置爲24小時制*/
	if(strIsNull(hourSys)){
		hourSys = hour24System;
	}
	
	var regResult = dateStr.replace(YYYYMMDDHHmmssReg,'');
	/*符合格式*/
	if(regResult==''){
		var line_one = dateStr.indexOf('-');       /*獲取第一個橫-*/
		var line_two = dateStr.lastIndexOf('-');   /*獲取第二個橫-*/
		var space = dateStr.indexOf(' ');          /*獲取空格*/
		var colon_one = dateStr.indexOf(':');      /*獲取第一個冒號*/
		var colon_two = dateStr.lastIndexOf(':');  /*獲取第二個冒號*/
		
		var year_str = dateStr.substring(0,line_one);   /*獲取年*/
		var month_str = dateStr.substring(line_one+1,line_two); /*獲取月*/
		var day_str = dateStr.substring(line_two+1,space);  /*獲取日*/
		
		var hour_str = dateStr.substring(space+1,colon_one); /*獲取小時*/
		var minute_str = dateStr.substring(colon_one+1,colon_two);  /*獲取分鐘*/
		var second_st = dateStr.substring(colon_two+1);  /*獲取分鐘*/
		
		/*轉換成數字格式 */
		var year_num = getIntValue(year_str);
		var month_num = getIntValue(month_str);
		var day_num = getIntValue(day_str);
		
		var hour_num = getIntValue(hour_str);
		var minute_num = getIntValue(minute_str);
		var second_num = getIntValue(second_st);
		
		/*校驗月份*/
		var monthResult = validateMonth(month_num);
		if(monthResult!=success){
			return false;
		}
		
		/*如果日期小於1*/
		if(day_num<1){
			return false;
		}
		/*校驗日期*/
		var dayResult = validateDay(year_num,month_num,day_num);
		if(dayResult!=success){
			return false;
		}
		
		/*校驗小時*/
		var hourResult = validateHour(hour_num,hourSys);
		if(hourResult!=success){
			return false;
		}
		
		/*校驗分鐘*/
		var minuteResult = validateMinute(minute_num);
		if(minuteResult!=success){
			return false;
		}
		
		/*校驗秒*/
		return validateSecond(second_num);
	}else{
		return false;
	}
	return false;
}

/**
 * 根據字符串獲取整數值
 * @param str
 * @returns
 */
function getIntValue(str){
	if(strIsNull(str)){
		return 0;
	}
	
	return str.replace(/^0+/g,'');
}


/**
 * 校驗日期是否合法
 * @param year_num  年份
 * @param month_num 月份
 * @param day_num 日期
 * @returns
 */
function validateDay(year_num,month_num,day_num){
	if(day_num<1){
		return false;
		
	/*如果月份是1,3,5,7,8,10,12*/
	}else if((month_num==1||month_num==3||month_num==5||month_num==7
			||month_num==8||month_num==10||month_num==12)&&day_num>31){
		return false;
		
	/*如果月份是4,6,9,11*/
	}else if((month_num==4||month_num==6||month_num==9||month_num==11)
			&&day_num>30){
		return false;
		
	/*如果月份是2*/
	}else if(month_num==2){
		/*如果爲閏年*/
		if(isLeapYear(year_num)&&day_num>29){
			return false;
		}else if(day_num>28){
			return false;
		}
	}
	return true;
}

function validateSecond(second_num){
	/*如果小時大於24*/
	if(second_num>59){
		return false;
	}
	return true;
}

/**
 * 校驗小時
 * @param hourSys 小時制
 * @param hour_num
 * @returns
 */
function validateHour(hour_num,hourSys){
	/*24小時制*/
	if(hourSys == hour24System&&hour_num > 23){
		return false;
	
	/*12小時制*/
	}else if(hourSys == hour12System&&hour_num > 11){
		return false;
	}
	return true;
}

/**
 * 校驗分鐘
 * @param minute_num
 * @returns
 */
function validateMinute(minute_num){
	//如果小時大於24
	if(minute_num>59){
		return false;
	}
	return true;
}


$(document).ready(function(){	
	$(".group1").colorbox({rel:'group1'});
	$(".group2").colorbox({rel:'group2', transition:"fade"});
	$(".group3").colorbox({rel:'group3', transition:"fade", width:"75%", height:"75%"});
	$(".group3w").colorbox({rel:'group3', transition:"fade", width:"75%"});
	$(".group4").colorbox({rel:'group4', slideshow:true});
	$(".ajax").colorbox();
	$(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
	$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
	$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	$(".inline").colorbox({inline:true, width:"50%"});
	$(".callbacks").colorbox({
		onOpen:function(){ alert('onOpen: colorbox is about to open'); },
		onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
		onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
		onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
		onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
	});
	$('.non-retina').colorbox({rel:'group5', transition:'none'})
	$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
	$("#click").click(function(){ 
		$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
		return false;
	});
});