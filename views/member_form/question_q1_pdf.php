<?php if (isset($iname) && $iname == 'set'){ ?>
    <h2 class="title"><?=$question_title?>：</h2>
    <div class="box1">
<?php }else{ ?>
<table cellspacing="2" cellpadding="4">
    <tr>
        <td><h2 class="title"><?=$question_title?>：</h2></td>
        <td><h2 class="title"><span>實測日期：<?=$question_date?></span></h2></td>
    </tr>
</table>
<div class="box2">
<?php } ?>

	<table width="100%" cellpadding="4" cellspacing="2">
    <tr>
        <td><strong>體重Kg：</strong><?php if (isset($data) && isset($data['f1'])){ echo show_number($data['f1'],1); } ?></td>
        <td><strong>BMI：</strong><?php if (isset($data) && isset($data['f2']) && $data['f2'] > ''){ echo show_number($data['f2'],1); } ?></td>
        <td><strong>脂肪率%：</strong><?php if (isset($data) && isset($data['f3'])){ echo show_number($data['f3'],1); } ?></td>
    </tr>
    <tr>
        <td><strong>脂肪量Kg：</strong><?php if (isset($data) && isset($data['f4']) && $data['f4'] > ''){ echo show_number($data['f4'],1); } ?></td>
        <td><strong>肌肉%：</strong><?php if (isset($data) && isset($data['f5']) && $data['f5'] > ''){ echo show_number($data['f5'],1); } ?></td>
        <td><strong>肌肉量Kg：</strong><?php if (isset($data) && isset($data['f6']) && $data['f6'] > ''){ echo show_number($data['f6'],1); } ?></td>
    </tr>
	<tr>
        <td><strong>水份比例%：</strong><?php if (isset($data) && isset($data['f7']) && $data['f7'] > ''){ echo show_number($data['f7'],1); } ?></td>
        <td><strong>水含量Kg：</strong><?php if (isset($data) && isset($data['f8']) && $data['f8'] > ''){ echo show_number($data['f8'],1); } ?></td>
        <td><strong>內臟脂肪率%：</strong><?php if (isset($data) && isset($data['f9']) && $data['f9'] > ''){ echo show_number($data['f9'],1); } ?></td>
    </tr>
	<tr>
        <td><strong>骨量Kg：</strong><?php if (isset($data) && isset($data['f10']) && $data['f10'] > ''){ echo show_number($data['f10'],1); } ?></td>
        <td><strong>基礎代謝率(卡)：</strong><?php if (isset($data) && isset($data['f11']) && $data['f11'] > ''){ echo show_number($data['f11'],1); } ?></td>
        <td><strong>蛋白質%：</strong><?php if (isset($data) && isset($data['f12']) && $data['f12'] > ''){ echo show_number($data['f12'],1); } ?></td>
    </tr>
	<tr>
        <td><strong>肥胖度%：</strong><?php if (isset($data) && isset($data['f13']) && $data['f13'] > ''){ echo show_number($data['f13'],1); } ?></td>
        <td><strong>身體年齡：</strong><?php if (isset($data) && isset($data['f14']) && $data['f14'] > ''){ echo show_number($data['f14'],1); } ?></td>
        <td><strong>去脂體重Kg：</strong><?php if (isset($data) && isset($data['f15']) && $data['f15'] > ''){ echo show_number($data['f15'],1); } ?></td>
    </tr>
  </table>
</div>
<br>