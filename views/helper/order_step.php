<?php

$aset1 = '';
$aset2 = '';
$aset3 = '';
$set1 = 'information';
$set2 = 'information';
$set3 = 'information';
if ($step == 2){
   $set2 = 'logins';
   $aset2 = ' active';
}elseif($step == 3){  
   $set3 = 'logins';
   $aset3 = ' active';
}else{
   $set1 = 'logins';  
   $aset1 = ' active';
}
?>
<div class="container">
		<div class="bs-stepper">
         <div class="bs-stepper-header" role="tablist">
           <div class="step<?=$aset1?>" data-target="#<?=$set1?>-part">
             <button type="button" class="step-trigger" role="tab" aria-controls="<?=$set1?>-part" id="<?=$set1?>-part-trigger">
               <span class="bs-stepper-circle">1</span>
               <span class="bs-stepper-label">購物車</span>
             </button>
           </div>
           <div class="line"></div>
           <div class="step<?=$aset2?>" data-target="#<?=$set2?>-part">
             <button type="button" class="step-trigger" role="tab" aria-controls="<?=$set2?>-part" id="<?=$set2?>-part-trigger">
               <span class="bs-stepper-circle">2</span>
               <span class="bs-stepper-label">資料填寫</span>
             </button>
           </div>
	       <div class="line"></div>
           <div class="step<?=$aset3?>" data-target="#<?=$set3?>-part">
             <button type="button" class="step-trigger" role="tab" aria-controls="<?=$set3?>-part" id="<?=$set3?>-part-trigger">
               <span class="bs-stepper-circle">3</span>
               <span class="bs-stepper-label">付款、訂單成立</span>
             </button>
           </div>
         </div>
         <div class="bs-stepper-content">
           <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger"></div>
           <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger"></div>
         </div>
    </div>
</div>