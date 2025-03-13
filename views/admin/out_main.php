<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=FC_Web?> - 後端管理系統</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME="rating" CONTENT="General">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="private">
<?php    
$css_file = array('var'  => $this->config->item('ver_css'),
                  'file' => array_merge($this->config->item('admin_autoload_css'), $css = (isset($css)) ? $css : array()));

$css_name = urlencode(base64_encode(json_encode($css_file)));
?>
<link href="<?= base_url() . 'mini/admin_css/' . $css_name ?>.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<body>

<form class="needs-validation" novalidate>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationTooltip01">First name</label>
      <input type="text" class="form-control" id="validationTooltip01" placeholder="First name" value="Mark" required>
      <div class="valid-tooltip">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationTooltip02">Last name</label>
      <input type="text" class="form-control" id="validationTooltip02" placeholder="Last name" value="Otto" required>
      <div class="valid-tooltip">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationTooltipUsername">Username</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
        </div>
        <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Username" aria-describedby="validationTooltipUsernamePrepend" required>
        <div class="invalid-tooltip">
          Please choose a unique and valid username.
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationTooltip03">City</label>
      <input type="text" class="form-control" id="validationTooltip03" placeholder="City" required>
      <div class="invalid-tooltip">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationTooltip04">State</label>
      <input type="text" class="form-control" id="validationTooltip04" placeholder="State" required>
      <div class="invalid-tooltip">
        Please provide a valid state.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationTooltip05">Zip</label>
      <input type="text" class="form-control" id="validationTooltip05" placeholder="Zip" required>
      <div class="invalid-tooltip">
        Please provide a valid zip.
      </div>
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit form</button>
</form>

<?php

$js_file = array('var'  => $this->config->item('ver_js'),
                 'file' => array_merge($this->config->item('admin_autoload_js'), $js = (isset($js)) ? $js : array()));                      
$js_name = urlencode(base64_encode(json_encode($js_file)));
    
?>
<script src="<?= base_url() . 'mini/admin_js/' . $js_name ?>.js" async="true"></script>