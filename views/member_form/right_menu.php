<div class="mb75">
 <h4><strong>問卷調查</strong></h4>
 <?php if ($this->session->userdata('member_session')['c_no'] == '000000'){  ?>
 <a href="<?php echo base_url( 'question/partners' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($qtype=='P'){ echo " active"; }?>">會員產品體驗回覆　<i class="icon ion-ios-contact mr-3"></i></a>
 <?php }  ?>
 <a href="<?php echo base_url( 'member_form/data' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($qtype=='data'){ echo " active"; }?>">表單個人資料維護　<i class="icon ion-ios-contact mr-3"></i></a>
 <a href="<?php echo base_url( 'member_form/question/q1' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($qtype=='q1'){ echo " active"; }?>">個人體測檢量記錄表　<i class="icon ion-document-text"></i></a>
 <a href="<?php echo base_url( 'member_form/question/q2' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($qtype=='q2'){ echo " active"; }?>">鶴力晶 體驗服務表　<i class="icon ion-help-circled"></i></a>
 <a href="<?php echo base_url( 'member_form/question/q3' ); ?>" class="btn btn-outline-secondary btn-block<?php if ($qtype=='q3'){ echo " active"; }?>">肌膚諮詢記錄表　<i class="icon ion-ios-paper"></i></a>
</div>