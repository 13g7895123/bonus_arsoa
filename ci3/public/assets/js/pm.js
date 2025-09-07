

function PF_Lg(str){
	return str;
}

function PF_SortoFormClassName(form){
		if ( typeof(form.getElementsByTagName("td")) != "undefined" ){ 
		
		var Ptr=form.getElementsByTagName("td");
	
	    for (var i=0;i<Ptr.length+1;i++) { 
	    		
	    		if ( typeof(Ptr[i]) != "undefined" && Ptr[i].id!=''){
		    		Ptr[i].className ="TitleBgcolorSort"; 	    		
		    		Ptr[i].onclick=SortoForm_onsubmit;
		    		
		    	}	
	    }
		if (form.Sort_Name.value!='' && form.Sort_Type.value=='desc'){
		/*	eval('document.all.'+form.Sort_Name.value).className='TitleBgcolorSort2';*/
		}else if (form.Sort_Name.value!='' ){	
		/*	eval('document.all.'+form.Sort_Name.value).className='TitleBgcolorSort1';*/
		}	
	}	
}

/*依資料排序*/
function SortoForm_onsubmit(e){
  	   if(e==null){
       		e=window.event;         
			Sort_Name=e.srcElement.id;
	   }else{
	   	Sort_Name=e
	   }	
	
	SortoForm.Sort_Name.value=Sort_Name;
	if (SortoForm.Sort_Type.value=="desc"){
		SortoForm.Sort_Type.value='';
	}else{
		SortoForm.Sort_Type.value='desc';
	}
	SortoForm.submit();
}

function upchange_file(Filed){
    if(confirm("確定重傳?")){
		
       document.getElementById("uploaddiv"+Filed).style.display='';  
       document.getElementById("filediv"+Filed).style.display='none';  
	}
}

function PF_upload(editid,Filed,FileLimit,Text){
    var SS='';
    var Pform;
    if ( typeof(Filed)== "undefined" ){return true;}
    
    if (editid == "N"){        
        if (PF_IsNull(Filed.value)==false){
            alert(Text +' '+ PF_Lg('未上傳'));try{Filed.focus();}catch(e){};
            return false;
        }
    }
    
    if (PF_IsNull(Filed.value)){
            if (PF_CheckFileType(FileLimit,Filed)==false){
                alert(Text +' '+ PF_Lg('上傳格式錯誤'));try{Filed.focus();}catch(e){};
                return false;
            }
    }       
}

/*是否檢查,屬性,form.Kind,'文字'*/
function PF_FormMulti(S1,S2,Filed,Text){

    var SS='';
    var Pform;

		if ( typeof(Filed)== "undefined" ){return true;}

    if (S1=='1'){      
             switch (Filed.type){  
                  case 'text':     
                  case 'password':  
                  case 'textarea':  
                  case 'file': 	
                        if (PF_IsNull(Filed.value)==false){alert(Text +' '+ PF_Lg('未填'));try{Filed.focus();}catch(e){};return false;}
                        break;    
                  case 'select-one':
                  case 'select-multiple':
                        if (PF_IsNull(Filed.value)==false){alert(PF_Lg('請選擇其一') +' ' + Text);Filed.focus();return false;}
                        break;
                  default: 
                       if (typeof(Filed.name)== "undefined"){
                           if (checkbox(Filed)==false){alert(PF_Lg('請勾取其一') +' ' + Text);Filed[0].focus();return false;}	                     
             		           SS="1";
              		         break;                         
                       }else{
	                         Pform=Filed.form.attributes["name"].value;
	                         if (typeof(eval(Pform+'.'+Filed.name+'_year'))!= "undefined" ){
			                         if (eval(Pform+'.'+Filed.name+'_year').value==''){alert('請選擇'+Text +'日期');eval(Pform+'.'+Filed.name+'_year').focus();return false;}
			                         if (eval(Pform+'.'+Filed.name+'_month').value==''){alert('請選擇'+Text+'日期');eval(Pform+'.'+Filed.name+'_month').focus();return false;}
			                         if (eval(Pform+'.'+Filed.name+'_day').value==''){alert('請選擇'+Text +'日期');eval(Pform+'.'+Filed.name+'_day').focus();return false;}
		             			         if (PF_IsDate(eval(Pform+'.'+Filed.name+'_year').value+'/'+eval(Pform+'.'+Filed.name+'_month').value+'/'+eval(Pform+'.'+Filed.name+'_day').value)==false){
								                   eval(Pform+'.'+Filed.name+'_day').focus();
							                     alert(Text+'  日期輸入錯誤!');
								                   return false;
							                 }  		                     
	                     	   }else{
	                     		     if (Filed.type=='hidden'){break;}
			                   	     if (checkbox(Filed)==false){
			                   		       alert(PF_Lg('請勾取其一') +' ' + Text);
								                   for(i=0;i<Filed.length;i++){
										               if(Filed[i].disabled==false){				
											                Filed[i].focus();break; 
									   	             }
									             }   			                       		
			                   		   return false;
			                   	 }   
	                   		   SS="1";
	                    	   break;  
	                     }	  
                  }
             }   

          }  

          if (SS==''){          
               switch (S2){  
               case 'INT':                /*數字 */
                    if (PF_IsNum(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.focus();return false;}
                    break; 
               case 'FLOAT':              /*數字 */
                    if (PF_IsFloat(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.focus();return false;}
                    break;                    
               case 'DATE':               /*日期*/            
               	    if (Filed.type=="text"){
               	 		    if (PF_IsNull(Filed.value)==true) {if ( PF_IsDate(Filed.value) == false ){alert(Text+' ' +PF_Lg('格式錯誤1'));Filed.focus();return false;}}
               	    }else{ 
               	  	  	Pform=Filed.form.attributes["name"].value;
               	  		  if (eval(Pform+'.'+Filed.name+'_year').value!='' || eval(Pform+'.'+Filed.name+'_month').value!='' || eval(Pform+'.'+Filed.name+'_day').value!=''){
	             			        if (PF_IsDate(eval(Pform+'.'+Filed.name+'_year').value+'/'+eval(Pform+'.'+Filed.name+'_month').value+'/'+eval(Pform+'.'+Filed.name+'_day').value)==false){
							                  alert(Text+' ' +PF_Lg('格式錯誤2'));
							                  return false;
						                }          
					              }
                    }
                    break;               
               case 'DATETIME':               /*日期*/
               	    if (Filed.type=="text"){
               	 		    if (PF_IsNull(Filed.value)==true) {if ( PF_IsDatetime(Filed.value ) == false ){alert(Text+' ' +PF_Lg('格式錯誤1'));Filed.focus();return false;}}
               	    }else{ 
               	  	  	  Pform=Filed.form.attributes["name"].value;
               	  		  if (eval(Pform+'.'+Filed.name+'_year').value!='' || eval(Pform+'.'+Filed.name+'_month').value!='' || eval(Pform+'.'+Filed.name+'_day').value!=''){
	             			        if (validateYYYYMMDDHHmmss(eval(Pform+'.'+Filed.name+'_year').value+'/'+eval(Pform+'.'+Filed.name+'_month').value+'/'+eval(Pform+'.'+Filed.name+'_day').value)==false){
							                  alert(Text+' ' +PF_Lg('格式錯誤2'));
							                  return false;
						                }          
					              }
                    }
                    break;               
               case 'EMAIL':         /*EMAIL*/
                    if (PF_IsNull(Filed.value)==true) {
                        if (PF_VerifyEMail(Filed.value)==false){alert(Text+' ' +PF_Lg('格式錯誤'));Filed.focus();return false;}
                    } 
                    break;                
               case 'PASSWORD':  /*密碼*/
               case 'ACCOUNT': /*帳號*/
                    if (Filed.value.length< 4 ){alert(Text+' '+PF_Lg('請用4~20碼之英文字母或數字，英文有大小寫之分，切勿用全形和其它特殊符號，如.,!@#$%^&*()等'));Filed.focus();return false;}   
                    if (PF_IsChar((Filed.value).toUpperCase()) == false) {alert(Text+' 格式錯誤');Filed.focus();return false;}
                    break;               
               case 'MOBILE':  /*手機*/
               	if (PF_IsNull(Filed.value)==true) {
                    if (PF_IsNum(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.select();return false;}
                    if (Filed.value.length!=10){alert('對不起!' +Text +'長度必須等於十位.');Filed.focus();return false;}
                    if ((Filed.value).substring(0,2)!='09'){alert(Text+' ' +PF_Lg('格式錯誤'));Filed.focus();return false;}
                 }   
                    break;                                                     
               case 'UID':              /*身份証*/
               		if (PF_IsNull(Filed.value)==true){ 
	                            strReason = '';
	                        	if (! PF_IsUid(Filed.value)){
	                        		if (strReason == ''){
	                        			 alert('請輸入正確的身分證或統編!');
	                        			 Filed.focus();
	                        		}else{
	                        			 alert(strReason);
	                        			 Filed.focus();
	                        		}
	                        		 return false;
	                        	 }             
                        	 }            
                break;                 
               }   
          }  
}

function checkbox(TxnID)
{
      if (typeof(TxnID.checked)== "undefined"){

             	var count=0;
         	for(i=0;i<TxnID.length;i++)
         	{
         		if(TxnID[i].checked == true && TxnID[i].disabled==false)
         		{
         			count++;
         		}
         
         	}
         
         	if (count<=0 )
         	{
         
         		return false;
         	}
         	else
         	{
         		return true;
         	}
      }else{
            if (!TxnID.checked){
               return false;
            }else{
              return true;
            }
      }

}

/*將全部button Disabled*/
function PF_FieldDisabled(form){
	for (var i=0;i<form.getElementsByTagName("input").length;i++){		
		    if (form.getElementsByTagName("input")[i].type=="button" || form.getElementsByTagName("input")[i].type=="submit" || form.getElementsByTagName("input")[i].type=="reset"){
				form.getElementsByTagName("input")[i].disabled=true;
			}		
	}
}


/*產生資料庫語法*/
function SearchoForm_onsubmit(form)
{

	if (PF_FormMulti('0','DATE',form.StartDate,'起始日期')==false){return false;}
       if (PF_FormMulti('0','DATE',form.EndDate,'結束日期')==false){return false;}
       
	var Search_Name='';
	var Search_Name_length=0;
	
    if ( typeof(form.Search_Name)!= "undefined" ){
		Search_Name=form.Search_Name.value;
		Search_Name_length=form.Search_Name.length;
	}
   
	if (PF_IsNull(Search_Name)){	    
		Search_Name=(form.Search_Name.value).toUpperCase();

		if (Search_Name.slice(-4)=="|INT" && Search_Name.indexOf("+")==-1 ){
			if (PF_IsNum(form.search.value)==false){alert('搜尋字串請勿輸入非數字');form.search.focus();return false;}
		}
		
		if ( typeof(form.EndDate)!= "undefined" ){
			if (PF_IsNull(form.EndDate.value) && PF_IsNull(form.EndDate.value)){
				if (form.StartDate.value>form.EndDate.value){alert('起始日不得大於終止日');form.EndDate.focus();return false;}
			}	
		}
	}else{
		
		var Search_NameT='';
		var cc='';

		for(var i=0; i<Search_Name_length; i++) {
			if (PF_IsNull(form.Search_Name[i].value)){	
			
			 Search_NameT=Search_NameT+cc+form.Search_Name[i].value;
			 cc="^";
			}
			
			form.Search_Name[0].value=Search_NameT;
		}

	}

   return true;
}


function PF_IsNull(Str)
{
 x='' + trim(Str)

 if(x=='')
 { return false; }
 else{return true; }
}


/*去除左邊空白*/
function lTrim(str)
{
	if (typeof(str) != 'undefined'){
		if (str.charAt(0) == " ")
		{
			str = str.slice(1);
			str = lTrim(str);
		}
		return str;
	}
}

/*去除右邊空白*/
function rTrim(str)
{
var iLength;
	if (typeof(str) != 'undefined'){
		iLength = str.length;

			if (str.charAt(iLength - 1) == " ")
			{
				str = str.slice(0, iLength - 1);
				str = rTrim(str);
			}
			return str;
	}

}

/*去除兩邊空白*/
function trim(str)
{
	return lTrim(rTrim(str));
}