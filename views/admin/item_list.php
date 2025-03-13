<div id="page-wrapper">
	<div class="graphs">
    <?=$this->block_service->PJ_PageTitle($this->XmlDoc,$kind);?>
  </div> 

<?php if (isset($errmsg) && $errmsg > ""){ ?>   
   <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>錯誤！</strong>&nbsp;<?php echo $errmsg?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>
<?php if (isset($ok_message) && $ok_message > ""){ ?>   
   <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>成功！</strong>&nbsp;<?php echo $ok_message?> （<?php echo date("H:i:s")?>）
   </div>
<?php } ?>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>  
<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em;  height: 36px;font-size:18px;  }
	#sortable li a { color:#237BD7; text-decoration:underline;  }
	#sortable li span { position: absolute; margin-left: -1.3em; }
	
</style>
<script>
function delchk(delid,deltitle,jcnt){
   var jtitle1 = deltitle.replace(/&&&/g,"\'");
    
   if (jcnt > 0){
       alertify.error('沒有第 <?=($wstype+1)?> 層分類，才可以刪除哦！');  
   }else{
       alertify.set({ buttonReverse: true }); // true, false
       alertify.confirm('確認要刪除？<br><br>第 <?=$wstype?> 層分類:'+jtitle1+'<br><br>', function (e) {  
         if (e) {               
             $('input[name="_submit"]').attr("value", "D");
             $('input[name="sortid"]').attr("value",delid);
             $( "#oForm" ).submit();             
         } else {  
            //alertify.log('你按下了放 cancel');  
         }  
       });      
   }
}  
$(function() {
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
});
function checkup(){
    var vsortid = ""; 
    $("#sortable li").each(function(){
        if (vsortid > ""){
            vsortid = vsortid +',';
        }
        vsortid = vsortid + $(this).find('#classidstr').attr('value');
    });
    
    $('input[name="_submit"]').attr("value", "Y");
    $('input[name="sortid"]').attr("value",vsortid);
    $( "#oForm" ).submit();
    
    // document.oForm._submit.value = 'Y';
    // document.oForm.sortid.value = vsortid;
    // alert(vsortid);
    // document.oForm.submit();
}
function editchk(jid,jtitle){
    var s=document.getElementById('editdiv_'+jid);      
    var jtitle1=jtitle.replace(/&&&/g,"\'");
    s.innerHTML='<input type="text" style="width:350px" maxlength="25" name="classtitle'+jid+'" value="'+jtitle1+'" >&nbsp;<a href=\"javascript:void(0);\" title="放棄修改" onclick="rchk(\''+jid+'\',\''+jtitle+'\')"><i class="fa fa-reply" aria-hidden="true"></i></a>';
}
function rchk(jid,jtitle){
    var s=document.getElementById('editdiv_'+jid);
    var jtitle1=jtitle.replace(/&&&/g,"\'");
    <?php if ($wetstype > $wstype){ ?>
           s.innerHTML=''+jtitle1+'&nbsp;<a href=\"javascript:void(0);\" onclick="editchk(\''+jid+'\',\''+jtitle+'\')" title=\"修改第 <?=$wstype?> 層分類名稱\"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href=\"?pager=classlist.php&classtype='+jid+'&kind=<?=$kind?>&wstype=<?=($wstype+1)?>\" title=\"設定第 <?=($wstype+1)?> 層分類\"><i class=\"glyphicon glyphicon-th-list\" style=\"color:#3399ff\" aria-hidden=\"true\"></i></a>';
    <?php }else{ ?>
           s.innerHTML=''+jtitle1+'&nbsp;<a href=\"javascript:void(0);\" onclick="editchk(\''+jid+'\',\''+jtitle+'\')" title=\"修改第 <?=$wstype?> 層分類名稱\"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
    <?php } ?>
}

function add(n)  
 {  
  var jhnum = parseInt($("#hnum").val());
   //parseInt(document.oForm.hnum.value);
  jhnum = jhnum + 1;
  //document.oForm.hnum.value = jhnum;  
  $("#hnum").attr("value",jhnum);
  
  var s=document.getElementById('sortable');  
  var t=s.childNodes.length;  
  var li= document.createElement("li");  
  li.innerHTML='<i class="fa fa-arrows" aria-hidden="true"></i>&nbsp;'+
                '<input type="text" style="width:350px" maxlength="25" name="classtitle'+jhnum+'" placeholder="新增第 <?=$wstype?> 層分類">'+
			          '<input type="hidden" name="classidstr" id="classidstr" value="'+jhnum+'" />';  
  li.className = 'alert alert-warning';
  li.style = 'height:45px';
  for (var i=0;i<t;i++)  
  {  
   if (n==-1)  
   {  
    s.appendChild(li);  
   }  
   else if (i==n-1)  
   {  
    s.insertBefore(li,s.childNodes[i]);  
   }  
  }  
 }  
</script>
<form name="oForm" id="oForm"  method="post" language="javascript" action="<?=$this->PATH_INFO?>" >
<?php HIDDEN($this->PATH_INFO,"oForm")?>
<div class="tab-pane active" id="horizontal-form">
<input type="hidden" name="wstype" value="<?php echo $wstype?>">
<input type="hidden" name="classtype" value="<?php echo $classtype?>">
<input type="hidden" name="_submit" value="Y" />


<input type="hidden" name="sortid"  />   
<?php
$n=0;
$uclasstype = '';
if ($wstype != '1'){
    echo '<h3 id="h3">&nbsp;&nbsp;分類：';
    
    $wn = 0;
    $whilechk = true;
    $whilet = $classtype;
    do{       
       $where  = array ('classid' => $whilet);                 
       $class_data = $this->front_admin_model->list_data('ap_itemclass',$where);                        
       if ($class_data){
           foreach ($class_data as $rs1)
           {
                  $wn++;                  
                  $whilet  = $rs1["classtype"];
                  $wi[$wn] = $rs1["classtype"];
                  $wt[$wn] = trim($rs1["classtitle"]);
           }
       }else{
           $whilechk = false;
       }
    } while ( $whilechk );
    $k = 0;
    for ($i = $wn;$i>0;$i--){
         $k++;
         if ($i < $wn) echo "&nbsp;>&nbsp;";
         $uclasstype  = $wi[$i];
         echo "<a href=\"".base_url('wadmin/func/item_list/'.$kind.'?classtype='.$wi[$i].'&wstype='.$k)."\">".$wt[$i]."</a>";
    }
    echo '</h3>';
}
if (count($list)== 0) {
      ?>      
      <div class="alert alert-danger alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        目前尚無資料！
      </div>
      <ul id="sortable" style="width:100%">
      <?php 
}else{
			?>
			<ul id="sortable" style="width:100%">
			<?php
			//列出欄位名稱		
			$n = 0;	
		  foreach ($list as $rs) {
			     $n++;	
		       $bgclass= ($n % 2 == 0 ? "active" : "warning"); 
		       	         
	         echo "<li class=\"alert alert-warning\" style=\"height:45px\">";
	         echo "<div style=\"float:left;\"><i class=\"fa fa-arrows\" aria-hidden=\"true\"></i>&nbsp;</div>";
	         echo "<div style=\"float:left;\" id=\"editdiv_".$rs["classid"]."\">";
	         
	         echo "".$rs["classtitle"]."";
	         
				   echo "&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"editchk('".$rs["classid"]."','".str_replace("'","&&&",$rs["classtitle"])."');\" title=\"修改第 ".$wstype." 層分類名稱\"><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>";
				   
				   if ($wetstype > $wstype){
				       echo "&nbsp;&nbsp;<a href=\"".base_url('wadmin/func/item_list/'.$kind.'?classtype='.$rs["classid"].'')."&wstype=".($wstype+1)."\" title=\"設定第 ".($wstype+1)." 層分類\"><i class=\"glyphicon glyphicon-th-list\" style=\"color:#3399ff\" aria-hidden=\"true\"></i></a>";
				   }
				   echo "</div>";				   
				   echo "<input type=\"hidden\" name=\"classidstr\" id=\"classidstr\" value=\"".$rs["classid"]."\" />";				   
				   echo "<div style=\"float:right;\">";
				   $cnt = 0;
				   if ($wetstype > $wstype){				       
				       $cnt = $this->front_base_model->count_total('ap_itemclass',array('classtype' => $rs["classid"]));
	             
				       echo "第 ".($wstype+1)." 層分類數：".$cnt;
				       echo "&nbsp;";
				       echo "&nbsp;";
				   }
				   echo "";				   
				   echo "<a href=\"javascript:void(0);\" onclick=\"delchk('".$rs["classid"]."','".str_replace("'","&&&",$rs["classtitle"])."',".$cnt.");\" ><i class=\"fa fa-trash-o\" style=\"color:red\" aria-hidden=\"true\"></i></a>";          
           echo "</div></li>";
	    }
    } 
   
    ?>
	    </ul>
	    </div>
	    <input type="hidden" name="hnum" id="hnum" value="<?php echo $n?>" />
	    
	        <div class="panel-footer">
			      <div class="row"  style="float:left;">		
			        <input type="button" value="新增第 <?=$wstype?> 層分類" onclick="add(-1);" class="btn btn-info">  
			      </div>
			      <div class="row" align="right">					    
	            <font color=red>(您可移動項目進行排序)</font>
	            &nbsp;&nbsp;&nbsp;	            	            
	            <input name="button1" onclick="javascript:checkup();" type="button"  value="儲存" class="btn btn_5 btn-lg btn-primary">
	            <?php if ($wetstype >= $wstype && $wstype > 1){ ?>
	                      <input type="button" value="回上一頁" onclick="location.href='<?=base_url('wadmin/func/item_list/'.$kind.'?classtype='.$uclasstype)?>&wstype=<?php echo ($wstype-1)?>';" class="btn btn-info">  
	            <?php } ?>
	          </div> 
	        </div> 
	    <?php
    
?>	    
<br><br>
</form>
</div>

<?php 
/* 共用的參數 */
function HIDDEN($PATH_INFO,$Mothod){               
          echo '<input type="hidden" name="GoBackUrl" value="'.$PATH_INFO.'">';
}?>
</div>