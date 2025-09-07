<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'EForm System'; ?></title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/animsition.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/ionicons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/jquery.fancybox.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/socicon.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/monosocialiconsfont.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css'); ?>">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- JavaScript Files -->
    <script src="<?php echo base_url('public/assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/animsition.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/wow.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/jquery.fancybox.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/assets/js/owl.carousel.min.js'); ?>"></script>
    
    <!-- Custom Styles -->
    <style>
        .label-custom {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .form-control-custom {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .mb30 {
            margin-bottom: 30px;
        }
        .mb130 {
            margin-bottom: 130px;
        }
        .mt-lg-5 {
            margin-top: 3rem;
        }
        .h2-3d {
            font-size: 2rem;
            font-weight: bold;
        }
        .font-libre {
            font-family: 'Libre Baskerville', serif;
        }
        .theme-orange {
            background-color: #fff;
        }
        .fixed-footer {
            min-height: 100vh;
            position: relative;
        }
        .section-mini {
            padding: 40px 0;
        }
        .section-item {
            padding: 20px 0;
        }
        .animsition {
            position: relative;
        }
        .wrapper {
            min-height: 100vh;
        }
        
        /* Form styles */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 8px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        /* Grid system */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .col-sm-1 { flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-sm-2 { flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-sm-3 { flex: 0 0 25%; max-width: 25%; }
        .col-sm-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-sm-5 { flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-sm-6 { flex: 0 0 50%; max-width: 50%; }
        .col-sm-7 { flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-sm-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-sm-9 { flex: 0 0 75%; max-width: 75%; }
        .col-sm-10 { flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-sm-11 { flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-sm-12 { flex: 0 0 100%; max-width: 100%; }
        
        .col-md-1 { flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-md-2 { flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-md-3 { flex: 0 0 25%; max-width: 25%; }
        .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-md-5 { flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; }
        .col-md-7 { flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-md-8 { flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-md-9 { flex: 0 0 75%; max-width: 75%; }
        .col-md-10 { flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-md-11 { flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-md-12 { flex: 0 0 100%; max-width: 100%; }
        
        [class*="col-"] {
            padding: 0 15px;
        }
        
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        /* Header styles */
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        /* Footer styles */
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            border-top: 1px solid #dee2e6;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<?php echo $content; ?>
</html>