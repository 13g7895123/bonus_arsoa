<a href="javascript:;" class="btn btn-outline-secondary btn-block">問卷專區　　<i class="icon ion-ios-list"></i></a>
<div class="card">
  <div class="card-body">
  <a href="<?php echo base_url( 'question/partners/Y' ); ?>" class="btn btn-outline-secondary btn-block text-left<?php if ($line_push == 'Y'){ echo ' active'; } ?>">產品體驗</a>
  
      <a href="<?php echo base_url( 'question/partners/N' ); ?>" class="btn btn-outline-secondary btn-block text-left <?php if ($line_push == 'N'){ echo ' active'; } ?>">電訪紀錄</a>
      <a href="<?php echo base_url( 'question/partners/Q' ); ?>" class="btn btn-outline-secondary btn-block text-left <?php if ($line_push == 'Q'){ echo ' active'; } ?>">諮詢紀錄</a>
  
  <a href="<?php echo base_url( 'sample/partners/S' ); ?>" class="btn btn-outline-secondary btn-block text-left <?php if ($line_push == 'S'){ echo ' active'; } ?>">試用品</a>

  </div>
</div>
