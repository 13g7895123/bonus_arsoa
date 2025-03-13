<!doctype html>
<html lang="zh-TW" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mdesign">
    <title><?=$data['link_title']?> | <?=FC_Web?></title>    

    <!-- Bootstrap core CSS -->
	<link href="<?=base_url('public/link/css/bootstrap.min.css')?>" rel="stylesheet">
	<!-- Custom styles for this template -->
    <link href="<?=base_url('public/link/css/custom.css')?>" rel="stylesheet">
	<!-- icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
	
  </head>
  
  <body class="d-flex flex-column h-100">
    
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="my-3 text-center"><img src="<?=base_url('public/link/images/logo.png')?>" class="img-fluid"></h1>
    <p class="text-center"><img src="<?=base_url('public/link/images/202005182034410FnJ.jpg')?>" class="img-fluid"></p>
	
	<h2 class="text-center"><?=$data['link_title']?></h2>
	
	<div class="row mt-3 row-flex g-2">
      <?php 
      if ($data['link_data']){
          foreach ($data['link_data'] as $key => $item){  ?>      
                 <div class="col-4"><a href="<?=$item['link']?>" title="<?=$item['title']?>">
                   <img src="<?=base_url('public/func/'.$item['image'])?>" class="img-fluid" style="padding: 6.5px 0;border-radius: 30px;" alt="<?=$item['title']?>">                   
                    </a>
                 </div>
                 <?php
          }
      } ?>
    </div>
	
  </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
  <div class="container text-center">
    <span class="text-muted">© <?=date('Y')?> Arsoa. All Rights Reserved.</span>
  </div>
</footer>
    
  </body>
</html>