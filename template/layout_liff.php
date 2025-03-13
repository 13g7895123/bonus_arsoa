<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=3.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<title><?=FC_Web?></title>

<meta property="og:locale" content="zh_TW"/>
<meta property="og:site_name" content="<?=FC_Web?>"/>
<meta property="og:type" content="article"/>
<meta property="og:title" content="<?=FC_Web?>"/>
<meta property="og:url" content="<?=$this->config->item('web_url')?>"/>
<meta property="og:image" content="<?=base_url('public/images/logo.png')?>"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=base_url()?>public/js/jquery.min.js"><\/script>')</script>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery-latest.min.js"></script>
<link href="<?=base_url()?>public/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=base_url()?>public/css/animsition.min.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/owl.carousel.min.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/owl.theme.default.min.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/socicon.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/ionicons.min.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/animate.min.css" rel="stylesheet">
<link href="<?=base_url()?>public/css/jquery.fancybox.min.css" rel="stylesheet">    
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<?php if(FC_googlekey > ''){?>
<script async='async' src='https://securepubads.g.doubleclick.net/tag/js/gpt.js'></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', '<?=FC_googlekey?>', 'auto');       
    <?php if (isset($ga_embed)){ echo $ga_embed; } ?>    
    ga('send', 'pageview');
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CR9Q9FF07K"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CR9Q9FF07K');
</script>
<?php }?>

<?php
    $css_file = array('var'  => $this->config->item('ver_css'),
                      'file' => array_merge($this->config->item('autoload_css'), $css = (isset($css)) ? $css : array()));
    $css_name = urlencode(base64_encode(json_encode($css_file)));
    ?>
    <link href="<?= base_url() . 'mini/css/' . $css_name ?>" rel="stylesheet" media="screen">
    
    <!-- Main CSS -->
    <link href="<?=base_url()?>public/css/style.css" rel="stylesheet">
    
    
</head>
<script>
var base_url = "<?=base_url()?>";          
var platform = "<?=$this->data['platform']?>";     
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrf_cookie_name = '<?php echo $this->config->item("csrf_cookie_name"); ?>';
</script>
<script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>   
    <?=$content_for_layout;?>
</body>
<?php
$js_file = array('var'  => $this->config->item('ver_js'),
                  'file' => array_merge($this->config->item('autoload_js'), $js = (isset($js)) ? $js : array()));
$js_name = urlencode(base64_encode(json_encode($js_file)));
?>
<script src="<?= base_url() . 'mini/js/' . $js_name ?>" async="true"></script>
<script src="<?=base_url()?>public/js/smoothscroll.js"></script>
<script src="<?=base_url()?>public/js/popper.min.js"></script>
<script src="<?=base_url()?>public/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>public/js/animsition.min.js"></script>
<script src="<?=base_url()?>public/js/owl.carousel.min.js"></script>
<script src="<?=base_url()?>public/js/wow.min.js"></script>
<script src="<?=base_url()?>public/js/jquery.pagepiling.min.js"></script>
<script src="<?=base_url()?>public/js/isotope.pkgd.min.js"></script>
<script src="<?=base_url()?>public/js/jquery.fancybox.min.js"></script>
<script src="<?=base_url()?>public/js/TweenMax.min.js"></script>
<script src="<?=base_url()?>public/js/ScrollMagic.min.js"></script>
<script src="<?=base_url()?>public/js/animation.gsap.min.js"></script>
<script src="<?=base_url()?>public/js/script.js"></script>
</html>
<?php
_timer('*** HTML END ***');
$client_ip = $this->input->ip_address();
if (preg_match("/^192\.168\./",$client_ip) || $client_ip == '203.69.196.229') {
    echo '<script>';
    echo 'console.group("System Info");console.log("執行時間：'.$this->benchmark->elapsed_time().'\n記憶體消耗量：'.$this->benchmark->memory_usage().'");console.groupEnd();';
    echo 'console.group("Timer Result");console.log("分段時間：'.str_replace("\n", '\n', _timer_text()).'");console.groupEnd();';
    echo '</script>';
    echo '<script>console.log("css：'.implode(',', $css_file['file']).'");</script>';
    echo '<script>console.log("js：'.implode(',', $js_file['file']).'");</script>';
}
?>