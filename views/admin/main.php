<div id="page-wrapper">
	<h3 class="blank1">親愛的 <b><?=$this->admin_session['admin_name']?></b> 您好 ！ <br><br>歡迎進入 <b><?=FC_Web?></b> <?=$this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/角色/KIND/傳回值","資料",$this->admin_session['admin_status'])?>管理後台 ！</h3>
</div>
<div style="width:95%;margin:0px auto;">
<div class="alert alert-warning" role="alert">
  <h4 class="alert-heading">注意事項：</h4>  
  <hr>
  <?php if ($this->block_service->PF_SearchXML($this->XmlDoc,"//參數設定檔/角色/KIND/傳回值","類型",$this->admin_session['admin_status']) == 'L'){ ?>
            <p class="mb-0">1. Line 訊息則數，若傳送訊息的則數超過上限，將無法發送訊息，正確訊息則數請於 <a href="https://manager.line.biz/account/@ayz1723n/purchase" target="_blank"><u>Line 官方平台</u></a> 查詢。 </p>
            <p class="mb-0">2.（付費）推廣方案及加購訊息費用的統計與請款作業，將以日本時間（GMT+9）為準。</p>
  <?php }else{ ?>
            <p class="mb-0">1. 商品圖存放位置 <b>public/prdimages</b> </p>
            <p class="mb-0">2. 權益規範存放位置 <b>public/rights</b> </p>
            <p class="mb-0">3. 加入會員的相關表格存放位置 <b>download</b> </p>
  <?php } ?>
</div>
</div>
