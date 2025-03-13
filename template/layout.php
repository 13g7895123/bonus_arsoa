<?php
  $meta_title1 = FC_Web;
  if (isset($meta['title1']) && $meta['title1'] > ''){
      $meta_title1 = $meta['title1'];
  }  
  $meta_title2 = FC_Web;
  if (isset($meta['title2']) && $meta['title2'] > ''){
      $meta_title2 = $meta['title2'];
  }else{
      if (isset($meta['title1']) && $meta['title1'] > ''){
          $meta_title2 = $meta['title1'];
      }  
  }
  $meta_keywords = FC_Keywords;
  if (isset($meta['keywords']) && $meta['keywords'] > ''){
      $meta_keywords = $meta['keywords'];
  }
  $meta_description = FC_Description;
  if (isset($meta['description']) && $meta['description'] > ''){
      $meta_description = $meta['description'];
  }
  $meta_image = base_url('public/images/logo.png');
  if (isset($meta['image']) && $meta['image'] > ''){
      $meta_image = $meta['image'];
  }else{  // 圖未提供用舊的,所以下面為圖的寬高
    //  $meta['width']  = 200;
   //   $meta['height'] = 68;
  }
  $meta_og_title = FC_Web;
  if (isset($meta['og_title']) && $meta['og_title'] > ''){
      $meta_og_title = $meta['og_title'];
  }
  $meta_url = base_url('');
  if (isset($meta['url']) && $meta['url'] > ''){
      $meta_url = $meta['url'];
  }
  $meta_type = 'website';
  if (isset($meta['type']) && $meta['type'] > ''){
      $meta_type = $meta['type'];
  }
  $meta_og_description = FC_Description;
  if (isset($meta['og_description']) && $meta['og_description'] > ''){
      $meta_og_description = htmlspecialchars($meta['og_description']);
  }elseif (isset($meta['description']) && $meta['description'] > ''){
      $meta_og_description = htmlspecialchars($meta['description']);   
  }
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=$meta_title1?></title>
<meta charset="utf-8"/>    
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, initial-scale=1"/>
<meta name="title" content="<?=$meta_title1?>" />
<?php if ($meta_keywords <> 'Product'){ ?>
<meta name="keywords" content="<?=$meta_keywords?>" />
<?php } ?>
<meta name="description" content="<?=$meta_description?>"/>
<meta property="og:locale" content="zh_TW"/>
<meta property="og:site_name" content="<?=$meta_title1?>"/>
<meta property="og:type" content="<?=$meta_type?>"/>
<meta property="og:title" content="<?=$meta_title1?>"/>
<meta property="og:url" content="<?=$meta_url?>"/>
<meta property="og:image" content="<?=$meta_image?>"/>
<?php if (isset($meta['width']) && $meta['width'] > ''){ ?>
<meta property="og:image:width" content="<?=$meta['width']?>" />
<?php } ?>
<?php if (isset($meta['height']) && $meta['height'] > ''){ ?>
<meta property="og:image:height" content="<?=$meta['height']?>" />
<?php } ?>
<meta property="og:description" content="<?=$meta_og_description?>"/>
<meta property="article:author" content="<?=FC_fburl?>"/>
<meta property="article" content="<?=FC_fburl?>"/>
<meta name="author" content="<?=FC_Company?>"/>
<meta name="copyright" content="<?=FC_Company?>"/>
<meta name="URL" content="<?=$meta_url?>"/>
<meta name="image" content="<?=$meta_image?>"/>
<meta name="robots" content="index,follow" />
<meta name="googlebot" content="index,follow"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=base_url()?>public/js/jquery.min.js"><\/script>')</script>
<script type="text/javascript" src="<?=base_url()?>public/js/jquery-latest.min.js"></script>
<script src="<?php echo base_url( 'public/js/jquery.lazyload.min.js' ); ?>"></script>
<?php if(isset($meta['canonical'])){?>
    <link rel="canonical" href="<?php echo $meta['canonical'];?>"/>
<?php }?>
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
<script type="application/ld+json">[
     {
       "@context": "http://schema.org",
       "@type": "WebSite",
       "name": "<?=$meta_title1?>",
       "alternateName": ["<?=$meta_title1?>"],
       "url": "<?=base_url()?>",
       "image": "<?=base_url()?>public/images/logo.png"
     },
     {
       "@context" : "http://schema.org",
       "@type" : "Organization",
       "name": "<?=$meta_title1?>",
       "url": "<?=base_url()?>",
       "logo": "<?=base_url()?>public/images/logo.png",
       "alternateName": ["<?=$meta_title1?>"], 
       "contactPoint": 
         { 
          "@type": "ContactPoint", 
          "telephone": "<?=FC_service_free_tel?>", 
          "contactType": "customer service", 
          "sameAs": 
           [ <?php
           $sameAs = '';
           if (FC_fburl > ''){
               $sameAs = '"'.FC_fburl.'"'; 
           }
           if (FC_Line > ''){
               if ($sameAs > ''){ $sameAs .= ","; }
               $sameAs .= '"'.FC_Line.'"'; 
           }
           if (FC_Instagram > ''){
               if ($sameAs > ''){ $sameAs .= ","; }
               $sameAs .= '"'.FC_Instagram.'"'; 
           }
           echo $sameAs;
           ?>
           ] 
        }        
     },
     {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
           "@type": "ListItem",
           "position": 1,
           "item": {
               "@id": "<?=base_url()?>",
               "name": "首頁"
                   }
        }
        <?php if (isset($schema_embed['Bread'])){ echo $schema_embed['Bread']; } ?>        
        ]
     }
     <?php if (isset($schema_embed['Bread2'])){ echo $schema_embed['Bread2']; } ?>      
]</script>
<?php if (isset($schema_embed['schema'])){ 
          echo $schema_embed['schema'];
      } ?>

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
<?php    
$css_file = array('var'  => $this->config->item('ver_css'),
                  'file' => array_merge($this->config->item('autoload_css'), $css = (isset($css)) ? $css : array()));

$css_name = urlencode(base64_encode(json_encode($css_file)));
?>
<link href="<?= base_url() . 'mini/css/' . $css_name ?>.css" rel="stylesheet" media="screen">

    <!-- Main CSS -->
    <link href="<?=base_url()?>public/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>public/favicon/favicon-16x16.png">
    
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
<script>
var base_url = "<?=base_url()?>";          
var platform = "<?=$this->data['platform']?>";
var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
var csrf_cookie_name = '<?php echo $this->config->item("csrf_cookie_name"); ?>';
</script>
</head> 
<div class="cartnote" id="cartnote"><div class="content" id="cartGroup"></div></div>
<?=$content_for_layout;?>    
<a id="back2Top" title="Back to top" href="#"><i class="ico ion-arrow-right-b"></i></a>
	
<?php if (isset($this->session->userdata('member_session')['c_no']) && $this->session->userdata('member_session')['c_no'] > '') {    ?>
    <a id="shoppingcart" class="pt-2" title="檢視購物車" href="<?=base_url('order/cart')?>">
	  <i class="ico ion-ios-cart" style="font-size:32px"></i>
    <span class='badge badge-warning' id="lblCartCount"> <?=$this->front_order_model->check_cart_num()?> </span></a>
<?php } ?>


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
<script src="<?=base_url()?>public/js/jquery.viewport.js"></script>
<script src="<?=base_url()?>public/js/jquery.countdown.min.js"></script>
<script src="<?=base_url()?>public/js/script.js"></script>
<script>lazyload_set('main');</script>
<?php
    $js_file = array('var'  => $this->config->item('ver_js'),
                      'file' => array_merge($this->config->item('autoload_js'), $js = (isset($js)) ? $js : array()));                      
    $js_name = urlencode(base64_encode(json_encode($js_file))); 
?>    
<script src="<?= base_url() . 'mini/js/' . $js_name ?>.js" async="true"></script>
<?php if (isset($GLOBALS['injava'])){ echo $GLOBALS['injava']; } ?>
</body>
</html>
<?php
_timer('*** HTML END ***');

$client_ip = $this->block_service->client_ip();

if (preg_match("/^192\.168\./",$client_ip) || $client_ip == '::1' || in_array($client_ip, config_item('company_ip'))) {   // 不是內部 IP 直接預覽     
    load_website($this->data['platform']);
    
    echo '<script>';
    echo 'console.group("System Info");console.log("執行時間：'.$this->benchmark->elapsed_time().'\n記憶體消耗量：'.$this->benchmark->memory_usage().'");console.groupEnd();';
    echo 'console.group("Timer Result");console.log("分段時間：'.str_replace("\n", '\n', _timer_text()).'");console.groupEnd();';
    echo '</script>';
    if (isset($css_file['file'])){
        echo '<script>console.log("css：'.implode(',', $css_file['file']).'");</script>';
    }
    if (isset($js_file['file'])){
    echo '<script>console.log("js：'.implode(',', $js_file['file']).'");</script>';
    }
}

?>