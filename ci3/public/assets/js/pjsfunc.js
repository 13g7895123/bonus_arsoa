var FC_TableCssModule='2';
var extFile = 'php';
var FC_LG = 'zh';
//去除左邊空白
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

//去除右邊空白
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

//去除兩邊空白
function trim(str)
{
	return lTrim(rTrim(str));
}
//列印
function WinPrinter() { window.print(); }
//checkBox 全選
function checkAll(field)
{
field.checked = true ;
for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}
//checkBox 全不選
function uncheckAll(field)
{
field.checked = false ;
for (i = 0; i < field.length; i++)
	field[i].checked = false ;
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
function calendar(t) {
     if(window.showModelessDialog)//IE Use
     {	
				sPath = FC_WebFolder+"include/calendar.htm";
				strFeatures = "dialogWidth=206px;dialogHeight=228px;center=yes;help=no;status: No";
				st = t.value;
				if(st == "")
				  st = new Date();
				else
				  st = TransFromTWDate(st)
			
				sDate = showModalDialog(sPath,st,strFeatures);
				t.value = formatDate(sDate);
     }else{       //FireFox Use         
			var cal19 = new CalendarPopup(); 
			cal19.showYearNavigation(); 
			cal19.showYearNavigationInput();
			cal19.select(t,'x'+t.name,'yyyy/MM/dd'); return false;
     }
}
function OpenDialog(fModal, sURL, lWidth, lHeight, lXPos, lYPos, sArguments) {
  var sFeatures;
  sFeatures = 'dialogHeight:' + lHeight + 'px;'
  sFeatures = sFeatures + 'dialogWidth:' + lWidth + 'px;'
  sFeatures = sFeatures + 'dialogTop:' + lXPos + 'px;'
  sFeatures = sFeatures + 'dialogLeft:' + lYPos + 'px;'
  sFeatures = sFeatures + 'edge: raised; center: yes; help: 0;titlebar:0;toolbar:0;location:0; resizable: 0;directories=0;menubar=0; status: 0;';

  if(fModal) return window.showModalDialog(sURL, sArguments, sFeatures);
  else return window.showModelessDialog(sURL, sArguments, sFeatures);
}
// ------------------------------
// 日期檢核函數
// ------------------------------

function PF_IsDate(datestr) {
    var year, month, day;
    datestr = datestr.replace(/-/g, "/");    
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
}
// ------------------------------
// 數字檢核函數
// ------------------------------

function PF_IsNum(sString)
{

   if (isNaN(sString))
   {
      return false;
   }

   for (var i=0; i<sString.length; i++)
   {
      if (sString.charCodeAt(i) < 48 || sString.charCodeAt(i) > 57)
      {
         return false;
      }
   }
   return true;
}

function PF_IsNumPhoto(sString)
{

   //if (isNaN(sString))
   //{
   //   return false;
   //}

   for (var i=0; i<sString.length; i++)
   {
      
      if ((sString.charCodeAt(i) < 48 || sString.charCodeAt(i) > 57) && sString.charCodeAt(i) != 59)
      {
         return false;
      }
   }
   return true;
}
function PF_IsFloat(sString)
{

   if (isNaN(sString))
   {
      return false;
   }

   for (var i=0; i<sString.length; i++)
   {
      if ((sString.charCodeAt(i) < 48 || sString.charCodeAt(i) > 57) && sString.charCodeAt(i) != 46)
      {
         return false;
      }
   }
   return true;
}	 
// ------------------------------
// 英文字母檢核函數
// ------------------------------

function PF_IsLetter(sString)
{
	sString=sString.toUpperCase();			
   for (var i=0; i<sString.length; i++)
   {
      if (sString.charCodeAt(i) < 65 || sString.charCodeAt(i) > 90)
      {
         return false;
      }
   }
   return true;
}

// ------------------------------
// 數字與英文字母檢核函數
// ------------------------------

function PF_IsChar(sString)
{
   for (var i=0; i<sString.length; i++)
   {

      if ((sString.charCodeAt(i) < 48 || sString.charCodeAt(i) > 57) && ((sString.charCodeAt(i) < 65 || sString.charCodeAt(i) > 90) &&  (sString.charCodeAt(i) < 97 || sString.charCodeAt(i) > 122)))
      {
         return false;
      }
   }
   return true;
}

function PF_ByteLength(sString)
{
var j=0;
   for (var i=0; i<sString.length; i++)
   {

      if (sString.charCodeAt(i) > 31 && sString.charCodeAt(i) <127)
      {

         j=j+1;
      }else{

         j=j+2;         
      }
   }
   return j;
}
function PF_VerifyEMail(strEMail)
{
   var charCanUse = '-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
   var intIndex = strEMail.indexOf('@');
   if (strEMail.length < 5)
   {
      return false;
   }

   if (intIndex < 1)
   {
      return false;
   }

   if (intIndex != strEMail.lastIndexOf('@'))
   {
      return false;
   }

   if (strEMail.charAt(intIndex - 1) == '.')
   {
      return false;
   }

   var strTemp = strEMail.substr(intIndex + 1);
   if (strTemp.indexOf('.') < 1)
   {
      return false;
   }

   if (strTemp.indexOf('..') != -1)
   {
      return false;
   }

   var i;
   for (i = 0; i < strEMail.length; i++)
   {
      if (charCanUse.indexOf(strEMail.charAt(i)) == -1)
      {
         return false;
      }
   }
   return true;
}
function TransFromTWDate(sDate) {
  var iTemp;
  iTemp = sDate.indexOf('/');
  return Number(sDate.substr(0, iTemp)) + sDate.substr(iTemp);
}

function TransToTWDate(sDate) {
	iDay = sDate.getDate();
	iMon = sDate.getMonth() + 1;
	iYea = sDate.getFullYear() ;
  if(iDay < 10) iDay = '0' + iDay;
  if(iMon < 10) iMon = '0' + iMon;

	return iYea + '/' + iMon + '/'  + iDay ;
}



function formatDate(sDate) {
	var sScrap = '';
	var dScrap = new Date(sDate);
	if (dScrap == 'NaN') return sScrap;

  return TransToTWDate(dScrap);
}

function PF_IsNull(Str)
{
 x='' + trim(Str)

 if(x=='')
 { return false; }
 else{return true; }
}

//檢查生日年月日
function IsLeapyear(Year)
{

 if((Year%4==0 ) && (Year%100 != 0)
          || (Year%400==0))
    return true;
 else
   return false;

}

function PF_BirthDay(Year,Month,Day)
{
	if (Month>12)
		 return false;
	 var lDay = 0
	 MonthArray = new Array("31","28","31","30","31","30","31","31","30","31","30","31")
	 lDay =MonthArray[Month-1]
	 if( Month== 2 && IsLeapyear(Year) )
	   lDay = lDay+1
	 if( Day > lDay )
	  {
	   return false;
	  }
	 else
	    return true;
 }

// ------------------------------
// 檢查UID
// 檢查國民身份證編號、營利事業統一編號、護照號碼
// ------------------------------

function PF_IsUid(strUid)
{
   if (strUid.length < 8 || strUid.length == 9)
   {
      return false;
   }

//   if (strUid.length == 8)
//   {
//      if (! PF_CheckBAN(strUid))
//      {
//         return false;
//      }
//   }
//   else
//   {
      if (strUid.length == 10)
      {
         if (! PF_CheckID(strUid))
         {
            return false;
         }
      }
      else
      {
         if (PF_IsLetter(strUid.charAt(0)))
         {
            if (strUid.charAt(10) != '3')
            {
               return false;
            }

            if (! PF_CheckID(strUid.substr(0,10)))
            {
               return false;
            }
         }
         else
         {
            if (! PF_IsNum(strUid.substr(0,8)))
            {
               strReason = '護照號碼第一碼至第八碼必須全部為數字';
               return false;
            }

            if (! PF_IsLetter(strUid.substr(8,2)))
            {
               strReason = '護照號碼第九碼和第十碼必須是英文字母';
               return false;
            }

            if (! PF_IsNum(strUid.charAt(10)))
            {
               strReason = '護照號碼最後一碼必須是數字';
               return false;
            }
         }
      }
 //  }
   return true;
}

// ------------------------------
// 國民身份證編號驗證
// ------------------------------

function PF_CheckID(strUserID){
   var intAreaNo;             //區域碼變數
   var intCheckSum;           //檢核碼變數
   var intCount;              //計數變數
   var strAreaCode;           //區域碼變數
// var blnCheckID = false;    //設定起始值

   strUserID = strUserID.toUpperCase();   //轉換為大寫
   strAreaCode = strUserID.charAt(0);     //取得首碼字母

   //確定身份證有10碼
   if (strUserID.length != 10){
      strReason = '國民身份證號碼必須是十碼';
      return false;
   }

   //確定首碼在A-Z之間
   if (strAreaCode < 'A' || strAreaCode > 'Z'){
      strReason = '國民身份證號碼第一碼必須是英文字母';
      return false;
   }

   //確定2-10碼是數字
   for (intCount = 1; intCount < 10; intCount++){
      if (strUserID.charAt(intCount) < '0' || strUserID.charAt(intCount) > '9'){
         strReason = '國民身份證號碼第二碼至第十碼必須全部為數字';
         return false;
      }
   }

   intAreaNo = 'ABCDEFGHJKLMNPQRSTUVXYWZIO'.indexOf(strAreaCode) + 10;           //取得英文字母對應編號，A->10,B->11等等
   strUserID = intAreaNo + strUserID.substr(1,9);                                //組合字串
   intCheckSum = parseInt(strUserID.charAt(0)) + parseInt(strUserID.charAt(10)); //計算首尾二者之和

   //計算第二碼至第十碼之積
   for (intCount = 1; intCount < 10; intCount++){
      intCheckSum += parseInt(strUserID.charAt(intCount)) * (10 - intCount);
   }

   //檢查是否為10整除
   if ((intCheckSum % 10) == 0){
      return true;
   }
   else{
      strReason = '國民身份證號碼輸入錯誤，請再檢查';
      return false;
   }
}

// ------------------------------
// 營利事業統一編號邏輯檢查
// ------------------------------

function PF_CheckBAN(strBAN){
   var intMod;                            //餘數變數
   var intSum;                            //合計數變數
   var intX = new Array(1,2,1,2,1,2,4,1);
   var intY = new Array(7);
// var blnCheckBAN = false;
   var intCount;                          //計數變數

   if (strBAN.length != 8){
      strReason = '營利事業統一編號必須是八碼';
      return false;
   }

   for (intCount = 0; intCount < 8; intCount++){
      if (strBAN.charAt(intCount) < '0' || strBAN.charAt(intCount) > '9'){
         strReason = '輸入之營利事業統一編號中有非數字';
         return false;
      }
   }

   for (intCount = 0; intCount < 8; intCount++){
      intX[intCount] *= parseInt(strBAN.charAt(intCount));
   }

   intY[0] = parseInt(intX[1] / 10);
   intY[1] = intX[1] % 10;
   intY[2] = parseInt(intX[3] / 10);
   intY[3] = intX[3] % 10;
   intY[4] = parseInt(intX[5] / 10);
   intY[5] = intX[5] % 10;
   intY[6] = parseInt(intX[6] / 10);
   intY[7] = intX[6] % 10;

   intSum = intX[0] + intX[2] + intX[4] + intX[7] + intY[0] + intY[1] + intY[2] + intY[3] + intY[4] + intY[5] + intY[6] + intY[7];

   intMod = intSum % 10;

   if (strBAN.charAt(6) == '7') {
      if (intMod == 0){
         return true;
      }
      else{
         intSum = intSum + 1;
         intMod = intSum % 10;
         if (intMod == 0){
            return true;
         }
         else{
            strReason = '營利事業統一編號輸入錯誤，請再檢查';
            return false;
         }
      }
   }
   else{
      if (intMod == 0){
         return true;
      }
      else{
         strReason = '營利事業統一編號輸入錯誤，請再檢查';
         return false;
      }
   }
}


//查詢郵遞區號
function SelectAddressArea(Field,Field1){	
		var vReturnValue =OpenDialog(true,'SelectAddressArea.php', '250', '250','','','');
		try{
			 if (typeof(vReturnValue) != 'undefined'){
			 		ss = vReturnValue.split(",");
					Field.value= trim(ss[2]);
					Field1.value= trim(ss[0]+ss[1]);
			 }
		}catch(e){
		}
}

//依資料排序
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


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//一筆
function move(fbox,tbox) {
	for(var i=0; i<fbox.options.length; i++) {
	if(fbox.options[i].selected && fbox.options[i].value != "") {
		var no = new Option();
		no.value = fbox.options[i].value;
		no.text = fbox.options[i].text;

		tbox.options[tbox.options.length] = no;
		
		fbox.options[i].value = ""
		fbox.options[i].text = ""
		}
	}
	BumpUp(fbox);
}
//全部
function moveall(fbox,tbox) {
	for(var i=0; i<fbox.options.length; i++) {
	if( fbox.options[i].value != "") {
		var no = new Option();
		no.value = fbox.options[i].value;
		no.text = fbox.options[i].text;

		tbox.options[tbox.options.length] = no;
		
		fbox.options[i].value = ""
		fbox.options[i].text = ""
		}
	}
	BumpUp(fbox);
}
function BumpUp(box) {
	for(var i=0; i<box.options.length; i++) {
		if(box.options[i].value == "") {
			for(var j=i; j<box.options.length-1; j++) {
				box.options[j].value = box.options[j+1].value
				
				box.options[j].text = box.options[j+1].text
			}
		var ln = i
		break
		}
	}
	if(ln < box.options.length) {
		box.options.length -= 1;
		BumpUp(box);
	}
}

function SortD(box) {
var temp_opts = new Array()
var temp = new Object()
for(var i=0; i<box.options.length; i++) {
temp_opts[i] = box.options[i]
}


for(var x=0; x<temp_opts.length-1; x++) {
for(var y=(x+1); y<temp_opts.length; y++) {
if(temp_opts[x].text > temp_opts[y].text) {
temp = temp_opts[x].text
temp_opts[x].text = temp_opts[y].text
temp_opts[y].text = temp
}
}
}

for(var i=0; i<box.options.length; i++) {
box.options[i].value = temp_opts[i].value
box.options[i].text = temp_opts[i].text
}
}

function PF_LoadXML(url){
			var oXmlHttp=null; 
			var objXML=null;
			var tye=2;
			try { 
				 oXmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); 
				 objXML=new ActiveXObject("Microsoft.XMLDOM");
				 tye=1;
			} catch(e) { 
				tye=2;
				try{ 
					oXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");					
				} catch(oc) { 
					 oXmlHttp=null;
				} 
			} 
			
			if ( !oXmlHttp && typeof XMLHttpRequest != "undefined" ){ 
				try{
					oXmlHttp=new XMLHttpRequest(); 
					objXML = document.implementation.createDocument("", "", null);
				}catch(e){
						 alert('msxml3.dll執行錯誤\n請至開始>執行輸入\n regsvr32 C:\WINDOWS\system32\msxml3.dll[enter]');
						 return false;
				}
			} 
			
		
			url=FC_WebFolder+url;
			
			if (tye==1){ 				//ie	
				oXmlHttp.Open("GET", url, false);
				oXmlHttp.setRequestHeader("Content-length",0);	
				
				try{			
					oXmlHttp.send(""); 
				 }catch(e){	
					alert(e.message)
				 }
				 if (objXML.loadXML(oXmlHttp.responseXML.xml)!=0){		
				 	return objXML;
				 }else{
					  var msg="錯誤代碼 : " + objXML.parseError.errorCode+'\n';
					  	   msg+="錯誤原因: " + objXML.parseError.reason+'\n';
						   msg+="錯誤行數 : " + objXML.parseError.line+'\n';
			                msg+="行錯誤字元: " + objXML.parseError.linepos+'\n'; 
				            msg+="來源檔案 : " + objXML.parseError.srcText+'\n'; 	
						   msg+="文件URL : " + url+'\n'; 	
					alert(msg);				
				}
			}else{		//firefox
				
					if((typeof document.implementation != 'undefined')&&(typeof document.implementation.createDocument!='undefined')){   
						
						
						XMLDocument.prototype.selectSingleNode = Element.prototype.selectSingleNode = function (xpath){
					         var  x = this .selectNodes(xpath)
					         if ( ! x || x.length < 1 ) return   null ;
					         return  x[ 0 ];
					    }
						XMLDocument.prototype.selectNodes = Element.prototype.selectNodes = function (xpath){
						
					         var  xpe  =   new  XPathEvaluator();
					   
					         var  nsResolver  =  xpe.createNSResolver( this .ownerDocument  ==   null   ?  this .documentElement :  this .ownerDocument.documentElement);
					         
					         var  result  =  xpe.evaluate(xpath,  this , nsResolver,  0 ,  null );
					         var  found  =  [];
					         var  res;
					         	
					         while  (res  =  result.iterateNext())
					            found.push(res);
					   
					         return  found;
					         
					    }
						
						
				    }  				
					var xmlhttp = new XMLHttpRequest(); 
		              xmlhttp.open("GET", url, false); 
		              xmlhttp.setRequestHeader("Content-Type","text/xml"); 
		              xmlhttp.send(null); 
		              
		              var newDOM = xmlhttp.responseXML; 
		              return newDOM;
			
				
				
			}	
}



//多層式下拉式(一對一)
function PJ_SelectThird(AxajUrl, KeyValue1, str, Field1, Field2, KeyValue2) {

    if (KeyValue1 == '') { return false; }
    var FieldTitle;
    if (AxajUrl == '') { AxajUrl = 'PJ_SelectThird.' + extFile; }
    var url = FC_WebFolder + AxajUrl;
    if (url.indexOf('?') > 0) {
        url += "&str=" + str + "&Key=" + PF_escape(KeyValue1);
    } else {
        url += "?str=" + str + "&Key=" + PF_escape(KeyValue1);
    }


    if (Field1.options.length > 0) {
        FieldTitle = Field1.options[0].text;
    } else {
        FieldTitle = Field1.options.text;
    }

    jQuery.ajax({
        type: "POST",
        url: url,
        dataType: "xml",
        error: function (e) {
            alert('Error: url : ' + url + '\n' + e);
        },
        beforeSend: function () {
            while (Field1.hasChildNodes()) {
                anode = Field1.firstChild;
                Field1.removeChild(anode);
            }
            Field1.options[0] = new Option("Loading", '');

        },
        success: function (xml) {

            property = $(xml).find("Data > Record");

            while (Field1.hasChildNodes()) {
                anode = Field1.firstChild;
                Field1.removeChild(anode);
            }
            Field1.options[0] = new Option(FieldTitle, '');

            if (property.length > 0) {
                for (var i = 0, x = 1; i < property.length; i++, x++) {

                    aname = $("資料", property[i]).text();
                    avalue = $("傳回值", property[i]).text();

                    Field1.options[x] = new Option();
                    Field1.options[x].value = avalue;
                    Field1.options[x].text = aname;
                    if (trim(avalue) == trim(KeyValue2)) {
                        Field1.options.selectedIndex = i + 1;
                    }
                }
            }

            if (typeof (Field2) != "undefined" && Field2 != '') {
                Field2.options.length = 0;
                Field2.options[0] = new Option('請選擇', '');
            }
        }
    });

}

function PF_Lg(str){
	return str;
}

//是否檢查,屬性,form.Kind,'文字'
function PF_FormMulti(S1,S2,Filed,Text){

var SS='';
var Pform;

		if ( typeof(Filed)== "undefined" ){return true;}

         if (S1=='1' ){
       

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
	                     	 if ( typeof(eval(Pform+'.'+Filed.name+'_year'))!= "undefined" ){
			                     if (eval(Pform+'.'+Filed.name+'_year').value==''){alert('請選擇'+Text +'日期');eval(Pform+'.'+Filed.name+'_year').focus();return false;}
			                     if (eval(Pform+'.'+Filed.name+'_month').value==''){alert('請選擇'+Text+'日期');eval(Pform+'.'+Filed.name+'_month').focus();return false;}
			                     if (eval(Pform+'.'+Filed.name+'_day').value==''){alert('請選擇'+Text +'日期');eval(Pform+'.'+Filed.name+'_day').focus();return false;}
		             			if (PF_IsDate(eval(Pform+'.'+Filed.name+'_year').value+'/'+eval(Pform+'.'+Filed.name+'_month').value+'/'+eval(Pform+'.'+Filed.name+'_day').value)==false){
								eval(Pform+'.'+Filed.name+'_day').focus();
								alert(Text+'  日期輸入錯誤');
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
               case 'INT':                 //數字 
                   if (PF_IsNum(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.focus();return false;}
                   break; 
               case 'FLOAT':                 //數字 
                   if (PF_IsFloat(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.focus();return false;}
                   break;                    
               case 'DATE':                 //日期
               
               	  if (Filed.type=="text"){
               	 		 if (PF_IsNull(Filed.value)==true) {if ( PF_IsDate(Filed.value ) == false ){alert(Text+' ' +PF_Lg('格式錯誤'));Filed.focus();return false;}}
               	  }else{ 
               	  		Pform=Filed.form.attributes["name"].value;
               	  		if (eval(Pform+'.'+Filed.name+'_year').value!='' || eval(Pform+'.'+Filed.name+'_month').value!='' || eval(Pform+'.'+Filed.name+'_day').value!=''){
	             			if (PF_IsDate(eval(Pform+'.'+Filed.name+'_year').value+'/'+eval(Pform+'.'+Filed.name+'_month').value+'/'+eval(Pform+'.'+Filed.name+'_day').value)==false){
							alert(Text+' ' +PF_Lg('格式錯誤'));
							return false;
						}          
					}
                    }
                   break;               
               case 'EMAIL':         //EMAIL
                     if (PF_IsNull(Filed.value)==true) {
                           if (PF_VerifyEMail(Filed.value)==false){alert(Text+' ' +PF_Lg('格式錯誤'));Filed.focus();return false;}
                    } 
                    break;                
               case 'PASSWORD':  //密碼
               case 'ACCOUNT': //帳號
                    if (Filed.value.length< 4 ){alert(Text+' '+PF_Lg('請用4~20碼之英文字母或數字，英文有大小寫之分，切勿用全形和其它特殊符號，如.,!@#$%^&*()等'));Filed.focus();return false;}   
                    if (PF_IsChar((Filed.value).toUpperCase()) == false) {alert(Text+' 格式錯誤');Filed.focus();return false;}
                    break;               
               case 'MOBILE':  //手機    
               	if (PF_IsNull(Filed.value)==true) {
                    if (PF_IsNum(Filed.value)==false){alert(PF_Lg('請輸入數字') +' ' +Text);Filed.select();return false;}
                    if (Filed.value.length!=10){alert('對不起!' +Text +'長度必須等於十位.');Filed.focus();return false;}
                    if ((Filed.value).substring(0,2)!='09'){alert(Text+' ' +PF_Lg('格式錯誤'));Filed.focus();return false;}
                 }   
                    break;                                                     
               case 'UID':              //身份証
               		if (PF_IsNull(Filed.value)==true){ 
	                            strReason = '';
	                        	if (! PF_IsUid(Filed.value)){
	                        		if (strReason == ''){
	                        			 alert('請輸入正確的身分證或統編');
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
//if (PF_FormQual(form,'xx',form.xx,'xx')==false){return false;}
function PF_FormQual(form,DbTable,Field,Text){

	if (typeof(Field) != "undefined"){		

		if (typeof(eval('form.'+Field.name+'1'))!=="undefined"){
				if (eval('form.'+Field.name+'1').value!=Field.value){

					var str="PF_FormQual.php?DbTable="+DbTable+"&Field="+Field.name+"&Fieldvalue="+PF_escape(Field.value);
          
					var xmlDoc=PF_LoadXML(str);
					
					if (xmlDoc.selectSingleNode("Data/item/text()").nodeValue=='Y'){
						alert('此筆'+Text+'已經存在');Field.focus();return false;
					}
				}
		}
	}
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
			eval('document.all.'+form.Sort_Name.value).className='TitleBgcolorSort2';
		}else if (form.Sort_Name.value!='' ){	
			eval('document.all.'+form.Sort_Name.value).className='TitleBgcolorSort1';
		}	
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


function setCookie(name, value)		//cookies設置
{
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	if(expires!=null)
	{
		var LargeExpDate = new Date ();
		LargeExpDate.setTime(LargeExpDate.getTime() + (expires*1000*3600*24));
	}
	document.cookie = name + "=" + escape (value)+((expires == null) ? "" : ("; expires=" +LargeExpDate.toGMTString()));
}

function getCookie(Name)			//cookies讀取
{
	var search = Name + "="
	if(document.cookie.length > 0) 
	{
		offset = document.cookie.indexOf(search)
		if(offset != -1) 
		{
			offset += search.length
			end = document.cookie.indexOf(";", offset)
			if(end == -1) end = document.cookie.length
			return unescape(document.cookie.substring(offset, end))
		 }
	else return ""
	  }
}

//將全部button Disabled
function PF_FieldDisabled(form){
    
	jQuery("input:button,input:image,input:submit,input:reset").attr("disabled", true); 
	$.blockUI({ 
		message: "資料傳輸中，請稍候...",  
		css: {         	
		    border: 'none', 
		    padding: '15px', 
		    backgroundColor: '#000', 
		    '-webkit-border-radius': '10px', 
		    '-moz-border-radius': '10px', 
		    opacity: .5, 
		    fadeIn: 0 ,
		    color: '#FFFFFF' 
			} 
	}); 
}

function PF_Mbgclass(A,ss){
	
	
	if (ss==1){//左右				
		
			for (var i=0;i<=A.getElementsByTagName("tr").length-1;i++){								
				if (A.getElementsByTagName("tr")[i].getElementsByTagName("td").length==2){					
					A.getElementsByTagName("tr")[i].getElementsByTagName("td")[0].className='MDataBgcolor1';						
					A.getElementsByTagName("tr")[i].getElementsByTagName("td")[1].className='MDataBgcolor2';	
				}	
			}								
	
	}else{//上下

			for (var i=0;i<=A.getElementsByTagName("tr").length-2;i++){							

				if (i%2==0){					
					A.getElementsByTagName("tr")[i].className='DataBgcolor1';											
				}else{
					A.getElementsByTagName("tr")[i].className='DataBgcolor2';						
				}
			}						
			
	}		
}


function PF_InputCss(){	
	
	if (document.getElementById("oFormTable2")!=null){			
	
			PF_Mbgclass(document.getElementById("oFormTable2"),2);
	}
	
	if (document.getElementById("oFormTable1")!=null){			
			PF_Mbgclass(document.getElementById("oFormTable1"),1);
	}
	for (var i=0;i<document.getElementsByTagName("input").length;i++){		
		var filed=document.getElementsByTagName("input")[i];		
		    if (filed.type=="text" || filed.type=="textarea" || filed.type=="password"){
				filed.onfocus=function(){this.className='txtFocus';}
				filed.onblur=function(){this.className='txtBlur';}
			}		
	}
	
	for (var i=0;i<document.getElementsByTagName("textarea").length;i++){		
		
				var filed=document.getElementsByTagName("textarea")[i];		
				filed.onfocus=function(){this.className='txtFocus';}
				filed.onblur=function(){this.className='txtBlur';}
		
	}
}

//---------------------------------------------------------------------------------------------------------
//輸入檢核: 只可輸入數字0-9,-,. (負號,小數點)
//	  傳出: 否則return .F.
//---------------------------------------------------------------------------------------------------------
function Fun_InputNum(){
	if (!(event.keyCode >= 45 && event.keyCode <= 57 && event.keyCode != 47)) event.returnValue = false;
}

//---------------------------------------------------------------------------------------------------------
//輸入檢核: 數字, 以文字框的title內容為錯誤提示 (欄位物件名稱)
//	  傳入: obj		: 欄位物件名稱, 
//			show	: 0或''-傳回訊息, 否則直接alert訊息, 
//			wChk	: ''-只check是數字即可; 與0 check = >= <= < > <> 條件
//			wValue	: 限制最大值
//			wMinValue:限制最小值
//			wValue2	: 限制小數位數
//	  傳出: 錯誤訊息或彈出訊息框
//---------------------------------------------------------------------------------------------------------
function Fun_CheckInt(obj, show, wChk, wValue, wMinValue, wValue2)
{
    var errmsg='';    
 
    if (isNaN(obj.value))
        errmsg  =   '. 必須數字';
    else
    {	
		if (typeof(wChk) == 'undefined' || wChk == '')
		{ 
		}
		else
		{
			if (wChk.substr(0,1) != '.' && obj.value.indexOf('.') != -1)	//第1碼若不為小數點, 則必須為整數
				errmsg	= '. 必須為整數'  ;	
		
			if (wChk.substr(0,1) == '.')
				wChk = wChk.substr(1,2)
		
			if (wChk != '')
			{
				switch (wChk){
					case '=':	if  (!(obj.value == 0))	errmsg	= '. 必須＝0' ;	break;
					case '>=':	if  (!(obj.value >= 0))	errmsg	= '. 必須≧0' ;	break;
					case '<=':	if  (!(obj.value <= 0))	errmsg	= '. 必須≦0' ;	break;
					case '!=':	if  (  obj.value == 0)	errmsg	= '. 必須≠0' ;	break;
					case '>':	if  (!(obj.value >  0))	errmsg	= '. 必須＞0' ;	break;
					case '<':	if  (!(obj.value <  0))	errmsg	= '. 必須＜0' ;	break;
				}
			}			  
		}	
		
		if (typeof(wValue) == 'undefined'){
		}
		else{
		    if (wValue > '' && parseInt(obj.value,10) > parseInt(wValue,10) )	{	//限制最大值			 
			    errmsg	= '. 必須 ＜= ' + wValue ;  	
		    }	
		}
		
		if (typeof(wMinValue) == 'undefined'){
	    }
	    else{
	        if (wMinValue != ''){
    	        if (parseInt(obj.value,10) < parseInt(wMinValue,10) ){		//限制最小值			 
    			    errmsg	= '. 必須 ＞= ' + wMinValue ;  			    
    			}
			}
	    }	
	  
	  	
	    if (typeof(wValue2) == 'undefined')
	    {
	    }
	    else
	    {
	        if (wValue2 != '' && obj.value.indexOf('.') != -1)
	        {
    	        	if(parseInt(obj.value.substr(obj.value.indexOf('.')+1).length,10) > parseInt(wValue2,10))
    	        	{
    				    errmsg	= 	errmsg	+	'. 小數位數最多 ' + wValue2 + '位' ;  			        			    
    			}
		}
	    }	
    }
   
    if (errmsg != '')
    {
		errmsg  =   obj.title   +   errmsg	+	'\n';    
		
		if (show == '' || show == '0' || typeof(show) == 'undefined') 
		{}
		else
		{	if (errmsg != "" )
				alert(errmsg+'?');
				errmsg = '';
		}
	}
		
	return errmsg;
}
//---------------------------------------------------------------------------------------------------------
//存檔檢核: 資料實際長度(byte)及必須輸入否, 以物件的MaxLength檢查欄位可輸入長度,並以title內容為錯誤提示
//	  傳入: 欄位物件名稱, chkmode= 0(必須輸入並檢核長度) 1(必須輸入) 2(可為空白只檢核長度),多行資料的最大長度值  9(必須輸入& 必須輸滿位數 maxLen)
//	  傳出: 錯誤訊息字串
//---------------------------------------------------------------------------------------------------------
function Fun_CheckLens(obj,chkmode,wmaxlen)
{
	var tmplen = 0;
	var tmpmax = 0;
	var i;
	var errmsg='';	
	var tStr = '';
	
	if (typeof (wmaxlen) == "undefined")	
		tmpmax = obj.maxLength;
	else
		tmpmax = wmaxlen;
		
	if	(chkmode != 2 && obj.value.trim() == '')                       //chkmode=0,1必須輸入
	{	errmsg = obj.title	+	" 必須輸入 \n";}	
	
	if	(chkmode != 1)								//chkmode=0,2檢查長度 中文=2Byte
	{	for (i=0; i<obj.value.length ; i++){		
		if	(obj.value.charCodeAt(i) <=	255)
			tmplen	=	tmplen	+	1;
		else
			tmplen	=	tmplen	+	2;
		}
		
		if	(tmplen > tmpmax ||	(chkmode == 9 && tmplen != tmpmax))
			errmsg	=	obj.title + "目前：" + tmplen + "碼 \n";        //顯示實際輸入長度				
	}
	
	return	errmsg;
}
//---------------------------------------------------------------------------------------------------------
//檢核: 資料必須為英數字 , 主要用在key, trim後, 中間也不可有空白
//---------------------------------------------------------------------------------------------------------
function Fun_CheckCode(obj)
{
	var tmpchar ;
	var i;
	var errmsg='';
		
	
	for (i=0; i< obj.value.trim().length ; i++)		
	{
		tmpchar = obj.value.substr(i, 1);
		if	(! ( (tmpchar >= '0' && tmpchar <= '9') || (tmpchar >= 'a' && tmpchar <= 'z') || (tmpchar >= 'A' && tmpchar <= 'Z') ) )
		{	errmsg = '請輸入英數字\n';
			break;
		}
	}	
	if	(errmsg > '')
		errmsg	=	obj.title + errmsg ;  	
	
	return	errmsg; 
}

// 郵件帳號檢查副程式
function FunEmailCheck(vEmail)
{
	var fResult	=	false;
	var sEmail	=	vEmail;

	if(sEmail.length > 5)
	{
		if (sEmail.indexOf("!")>=0)  { return fResult; }
		if (sEmail.indexOf("|")>=0)  { return fResult; }
		if (sEmail.indexOf(":")>=0)  { return fResult; }
		if (sEmail.indexOf(",")>=0)  { return fResult; }
		if (sEmail.indexOf(";")>=0)  { return fResult; }
		if (sEmail.indexOf("(")>=0)  { return fResult; }
		if (sEmail.indexOf(")")>=0)  { return fResult; }
		if (sEmail.indexOf("<")>=0)  { return fResult; }
		if (sEmail.indexOf(">")>=0)  { return fResult; }
		if (sEmail.indexOf("[")>=0)  { return fResult; }
		if (sEmail.indexOf("]")>=0)  { return fResult; }
		if (sEmail.indexOf("@")<1)   { return fResult; }
		if (sEmail.indexOf(".")==-1) { return fResult; }
		if (sEmail.substr(sEmail.length-1 , 1)=="@") { return fResult; }
		if (sEmail.substr(sEmail.length-1 , 1)==".") { return fResult; }
		if (sEmail.substr(sEmail.indexOf("@")+1,sEmail.length-sEmail.indexOf("@")-1).indexOf("@")>=0) { return fResult; }
		if (sEmail.substr(sEmail.indexOf("@")+1,sEmail.length-sEmail.indexOf("@")-1).indexOf(".")==-1) { return fResult; }
		fResult = true ;
	}
    return fResult ;
}

//---------------------------------------------------------------------------------------------------------
//輸入轉換: 英文小寫轉大寫 (欄位物件名稱)
//	  傳入: 欄位物件名稱
//	  傳出: 自動將物件轉成大寫英文字母
//---------------------------------------------------------------------------------------------------------
function Fun_UpperCase(obj,wIndex)
{
	if (wIndex >= 0) 
	{  
	   if (obj[wIndex].value != null)
	   {
		obj[wIndex].value = obj[wIndex].value.toUpperCase();
	   }
	}
	else 
	{
	    if (obj.value != null)
	    {
		obj.value = obj.value.toUpperCase();
	    }
	}
}

//---------------------------------------------------------------------------------------------------------
//輸入轉換: 英文大寫轉小寫 (欄位物件名稱)
//	  傳入: 欄位物件名稱
//	  傳出: 自動將物件轉成小寫英文字母
//---------------------------------------------------------------------------------------------------------
function Fun_LowerCase(obj,wIndex)
{
	if (wIndex >= 0) 
	{  
	   if (obj[wIndex].value != null)
	   {
		obj[wIndex].value = obj[wIndex].value.toLowerCase();
	   }
	}
	else 
	{
	    if (obj.value != null)
	    {
		obj.value = obj.value.toLowerCase();
	    }
	}
}

function getRadiovalue(formObj) {  
 var value  = null;
 for (var i=0;i<formObj.length;i++){
      if (formObj[i].checked){
       value=formObj[i].value
             break
      }
 }
 return value
}

var iCount = 0;
function changeText(jname,objElement) {       
    iCount = objElement.value.length;
    document.getElementById(jname+"_txt").innerHTML = "" + iCount;       
    eval("document.oForm."+jname+"_count").value = parseInt(iCount);
}   

function PF_escape(S){
	return escape(S)
}


$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
               console.log(log);
              //if( log ) alert(log);
          }

      });
  });
  
});


function wcolorbox(murl,stype){
	var w_w = $(window).width();
	var w_h = $(window).height();
	m_w = typeof m_w !== 'undefined' ? m_w : 961;

	function overflowBody(status){
		if(status){
			$('body').css({
				'height':w_h,
				'width':w_w,
				'overflow':'hidden'
			});
		} else {
			$('body').css({
				'height':'auto',
				'width':'100%',
				'overflow':'auto'
			});
		}
	}

	if(w_w >= m_w){	   	   
	   if (stype == 'S'){
		    $.colorbox({
		    	href:  murl,
		    	iframe:true, 
		    	width:"50%", 
		    	height:"70%",
		    	maxWidth:"1000px",
		    	onComplete:function(){
		    		overflowBody(true);
		    	},
		    	onClosed:function(){
		    		overflowBody(false);
		    	}
		    });
		}else{		  
		    $.colorbox({
		    	href:  murl,
		    	iframe:true, 
		    	width:"80%", 
		    	height:"90%",
		    	maxWidth:"1000px",
		    	onComplete:function(){
		    		overflowBody(true);
		    	},
		    	onClosed:function(){
		    		overflowBody(false);
		    	}
		    });
		}
	} else {	  
		$.colorbox({
			href: murl,
			iframe:true, 
			width:"95%", 
			height:"95%",
			onComplete:function(){
				overflowBody(true);
			},
			onClosed:function(){
				overflowBody(false);
			}
		});
	}
}

$(document).ready(function(){           
            // resize colorbox on screen rotate in mobile devices and set to cover 90% of screen
            jQuery(window).resize(function() {
                jQuery.colorbox.resize({width:"95%"});
            });
        
				//Examples of how to assign the Colorbox event to elements
				$(".group1").colorbox({rel:'group1', maxWidth: "95%",
                onComplete : function() {
                    jQuery(this).colorbox.resize();
                }});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
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
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
});


function isMobile() {
    var userAgentInfo = navigator.userAgent;

    var mobileAgents = [ "Android", "iPhone", "SymbianOS", "Windows Phone", "iPad","iPod"];

    var mobile_flag = false;

    //根据userAgent判断是否是手机
    for (var v = 0; v < mobileAgents.length; v++) {
        if (userAgentInfo.indexOf(mobileAgents[v]) > 0) {
            mobile_flag = true;
            break;
        }
    }

     var screen_width = window.screen.width;
     var screen_height = window.screen.height;    

     //根据屏幕分辨率判断是否是手机
     if(screen_width < 500 && screen_height < 800){
         mobile_flag = true;
     }

     return mobile_flag;
}

function myModel(jtype) {
    var x = document.getElementById("loginbox_"+jtype);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

// tracker log
function tracker(track_id) {
    var sPath = FC_WebFolder+"ad_click.php";
    $.post(sPath, {        
        id: track_id
    }, function (res) {
        console.log(res);
    }, 'json');
}