$(document).ready(function() { 
   $('#addr_cityno').change(function(){                 
       ChangeCity('addr_cityno','addr_postal','addr_zip','addr_address','','');
   });
   $('#addr_postal').change(function(){                 
       ChangeTown('addr_cityno','addr_postal','addr_zip','addr_address');
   });
});

function get_set_address(aid)
{   
        $.ajax({
             url: base_url+"order/set_address/"+aid,                
             type: "GET",
             dataType: "json",
             success: function(data){        
                  /*console.log(data); */
                  $( "#addr_name" ).val(data.params.c_name);
                  $( "#addr_tel" ).val(data.params.tel);                  
                  $( "#addr_cityno").val(data.params.cityno);  
                  $( "#addr_id" ).val(data.params.aid);
                  ChangeCity('addr_cityno','addr_postal','addr_zip','addr_address',data.params.postal,'');
                  $("#addr_zip").val(data.params.postal);  
                  $( "#addr_address" ).val(data.params.address);                  
                  
                  if (data.params.sort == '0'){
                      $("input[name='addr_set']").prop("checked", true);
                  }else{
                      $("input[name='addr_set']").prop("checked", false); 
                  }
             };
        });       
}

function set_address(aid){    
  $( "#addr_name_msg" ).html('');
  $( "#addr_addr_msg" ).html('');
  $( "#addr_tel_msg" ).html('');
  if (aid == 0){
      $( "#addr_name" ).val('');
      $( "#addr_tel" ).val('');
      $( "#addr_id" ).val('0');
      $("input[name='addr_set']").prop("checked", false);       
      $( "#setaddressmodel_title" ).html('增加新地址');
  }else{
      $( "#setaddressmodel_title" ).html('地址修改');
      get_set_address(aid);
  }  
  $("#setaddressmodel").modal('show');    
}

function order_set_address(aid){
         $.getJSON(base_url+"order/set_address_show/"+aid, function(data)
         {
              console.log(data);
              if (data.addr_num >= 6){
	     		        $("#add_addr").css('display','none'); 
	     		    }else{
	     		        $("#add_addr").css('display','block'); 
	     		    }
	     		    $( "#addr_num" ).val(data.addr_num);	     		    
              $( "#set_addr_list" ).html(data.html);
              if ($( "#addr_num" ).val() > 3){
                  $("#addr_more").css('display','block');    
                  if (aid == 0){
                      addrmore('N'); 
                  }                       
              } 
         });  
}
function addrmore(htype){                
         if ($("#addrid_4").is(':hidden') || htype == 'Y'){             
             for (var i = 4; i < 7; i++ ) {
                 if ($("#addrid_"+i).length > 0){
                     $("#addrid_"+i).css('display','block');              
                 }
             }
             $( "#addr_more_chk" ).val('N');
             $( "#addr_more_show" ).html('<i class="icon ion-arrow-up-b"></i>　Close');          		
	       }else{		
	           for (var i = 4; i < 7; i++ ) {
                 if ($("#addrid_"+i).length > 0){
                     $("#addrid_"+i).css('display','none');              
                 }
             }
             $( "#addr_more_chk" ).val('Y');
             $( "#addr_more_show" ).html('<i class="icon ion-arrow-down-b"></i>　More');	           
         }         
};



function check_data(csrf_token_name) {           
        var err=0;
        var errmsg = ''; 
        var focusstr = '';      
        if ($('input[name=addr_name]').val() == ''){            
            $( "#addr_name_msg" ).html('未填寫完成');
            focusstr = 'addr_name';
        }
        if ($('#addr_cityno').val() == '') { 
             $( "#addr_addr_msg" ).html('未填寫完成');
             if (focusstr ==''){ focusstr = 'addr_cityno'; }   
        }
        if ($('#addr_postal').val() == '') { 
             $( "#addr_addr_msg" ).html('未填寫完成');
             if (focusstr ==''){ focusstr = 'addr_postal'; }   
        }
        if ($('input[name=addr_address]').val() == ''){
            $( "#addr_addr_msg" ).html('未填寫完成');    
            if (focusstr ==''){ focusstr = 'addr_address'; }   
        }
        if ($('input[name=addr_tel]').val() == ''){
            $( "#addr_tel_msg" ).html('未填寫完成');
            if (focusstr ==''){ focusstr = 'addr_tel'; }
        }             
        if (focusstr> ''){
             $('#'+focusstr).focus();
        }else{
            chg_token(csrf_token_name);
            $.ajax({
                url: base_url + "order/set_address_save",
                type: "POST",
                dataType: "json",
                data: jQuery('#set_Form').serialize(),
                success: function(data){	   	    
	     		               console.log(data);
	     		               if (data.status){
	     		                   order_set_address(data.addr_id);
	     		                   $('#setaddressmodel').modal('hide');  
	     		               }else{
	     		                   alert(data.errmsg);
	     		               } 
	     	        }
	          });
	      }       
}
function del_address(aid)
{
	    if (confirm('確定是否刪除收件人資訊?')){
	       $.getJSON(base_url+"order/set_address_del/"+aid, function(data)
         {
              order_set_address(0);                 
         });  
      }
}
window.onload = function() {order_set_address(0);};