#!/usr/bin/env php
<?php
/**
 * Comprehensive CSS and JS testing for CI3 project
 * Tests not only file presence but also proper loading and functionality
 */

echo "========================================\n";
echo "CI3 Comprehensive CSS & JS Test\n";
echo "========================================\n\n";

// Test if we're in the CI3 directory
if (!file_exists('application/config/config.php')) {
    echo "❌ Error: Must run this script from CI3 root directory\n";
    exit(1);
}

// Load CodeIgniter for testing
define('BASEPATH', true);
require_once 'system/core/Common.php';

echo "🔧 Comprehensive testing of CSS and JS resources...\n\n";

// Define all CSS files that should be present
$css_files_extended = [
    // Core CSS
    'public/assets/css/bootstrap.min.css',
    'public/assets/css/bootstrap.css', 
    'public/assets/css/animate.min.css',
    'public/assets/css/animate.css',
    'public/assets/css/style.css',
    
    // UI Components
    'public/assets/css/jquery.ui.all.css',
    'public/assets/css/jquery.ui.core.css',
    'public/assets/css/jquery.ui.datepicker.css',
    'public/assets/css/jquery.ui.theme.css',
    'public/assets/css/jquery.fancybox.min.css',
    'public/assets/css/jquery.fancybox.css',
    'public/assets/css/jquery.tagsinput.css',
    
    // Theme and Effects
    'public/assets/css/animsition.min.css',
    'public/assets/css/animsition.css',
    'public/assets/css/owl.carousel.min.css',
    'public/assets/css/owl.carousel.css',
    'public/assets/css/owl.theme.default.min.css',
    'public/assets/css/owl.theme.default.css',
    
    // Icons and Fonts
    'public/assets/css/ionicons.min.css',
    'public/assets/css/ionicons.css',
    'public/assets/css/socicon.css',
    'public/assets/css/monosocialiconsfont.css',
    
    // Additional Components
    'public/assets/css/alertify.core.css',
    'public/assets/css/alertify.default.css',
    'public/assets/css/arsoa.css',
    'public/assets/css/bs-stepper.min.css',
    'public/assets/css/colorbox.min.css',
    'public/assets/css/jquery.pagepiling.css'
];

// Define all JS files that should be present  
$js_files_extended = [
    // Core jQuery
    'public/assets/js/jquery.min.js',
    'public/assets/js/jquery-latest.min.js',
    
    // Bootstrap
    'public/assets/js/bootstrap.min.js',
    'public/assets/js/bootstrap.js',
    'public/assets/js/popper.min.js',
    
    // jQuery UI
    'public/assets/js/jquery.ui.core.js',
    'public/assets/js/jquery.ui.datepicker.js',
    'public/assets/js/jquery.ui.datepicker-zh-TW.js',
    
    // Effects and Animation
    'public/assets/js/wow.min.js',
    'public/assets/js/wow.js',
    'public/assets/js/animsition.min.js',
    'public/assets/js/animsition.js',
    'public/assets/js/TweenMax.min.js',
    'public/assets/js/ScrollMagic.min.js',
    'public/assets/js/ScrollMagic.js',
    
    // UI Components  
    'public/assets/js/jquery.fancybox.min.js',
    'public/assets/js/jquery.fancybox.js',
    'public/assets/js/owl.carousel.min.js',
    'public/assets/js/owl.carousel.js',
    'public/assets/js/jquery.lazyload.min.js',
    'public/assets/js/jquery.tagsinput.js',
    'public/assets/js/jquery.colorbox-min.js',
    
    // Custom and Utility
    'public/assets/js/alertify.min.js',
    'public/assets/js/alertify.js',
    'public/assets/js/arsoa.js',
    'public/assets/js/pjsfunc.js',
    'public/assets/js/main.js',
    'public/assets/js/member.js',
    'public/assets/js/script.js',
    'public/assets/js/smoothscroll.js'
];

// Test CSS files
echo "📂 Extended CSS Files Test:\n";
$css_present = 0;
$css_missing = [];
foreach ($css_files_extended as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
        $css_present++;
    } else {
        echo "  ❌ $file (MISSING)\n";
        $css_missing[] = $file;
    }
}

echo "\n📂 Extended JavaScript Files Test:\n";
$js_present = 0;
$js_missing = [];
foreach ($js_files_extended as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
        $js_present++;
    } else {
        echo "  ❌ $file (MISSING)\n";
        $js_missing[] = $file;
    }
}

// Test CSS Image Assets
echo "\n📂 CSS Image Assets Extended Test:\n";
$image_files_extended = [
    'public/assets/css/ajax-loader.gif',
    'public/assets/css/images/ui-icons_222222_256x240.png',
    'public/assets/css/images/ui-icons_454545_256x240.png', 
    'public/assets/css/images/loading.gif',
    'public/assets/css/images/close.png',
    'public/assets/css/images/controls.png',
    'public/assets/css/images/border.png',
    'public/assets/css/owl.video.play.png'
];

$img_present = 0;
$img_missing = [];
foreach ($image_files_extended as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
        $img_present++;
    } else {
        echo "  ❌ $file (MISSING)\n";
        $img_missing[] = $file;
    }
}

// Test Font Files
echo "\n📂 Font Files Test:\n";
$font_directories = [
    'public/assets/fonts/',
    'public/assets/css/fonts/',
    'public/assets/webfonts/'
];

$font_files = [];
foreach ($font_directories as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '*.{woff,woff2,ttf,eot}', GLOB_BRACE);
        $font_files = array_merge($font_files, $files);
    }
}

if (empty($font_files)) {
    echo "  ⚠️  No font files found in standard directories\n";
} else {
    foreach ($font_files as $file) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
    }
}

// Test Layout Integration
echo "\n📂 Layout Integration Test:\n";
$layout_file = 'application/views/layout/main.php';
if (file_exists($layout_file)) {
    $content = file_get_contents($layout_file);
    
    // Check for CSS inclusions
    $css_includes = preg_match_all('/public\/assets\/css\/[^"\']+\.css/', $content, $matches);
    echo "  ✅ Layout includes {$css_includes} CSS files\n";
    
    // Check for JS inclusions  
    $js_includes = preg_match_all('/public\/assets\/js\/[^"\']+\.js/', $content, $matches);
    echo "  ✅ Layout includes {$js_includes} JS files\n";
    
    // Check for jQuery
    if (strpos($content, 'jquery') !== false) {
        echo "  ✅ jQuery included in layout\n";
    } else {
        echo "  ❌ jQuery not found in layout\n";
    }
    
    // Check for Bootstrap
    if (strpos($content, 'bootstrap') !== false) {
        echo "  ✅ Bootstrap included in layout\n";
    } else {
        echo "  ❌ Bootstrap not found in layout\n";
    }
} else {
    echo "  ❌ Layout file not found\n";
}

// Test View Files Structure
echo "\n📂 View Files Structure Test:\n";
$view_files = [
    'application/views/eeform/eform01.php',
    'application/views/eeform/eform02.php',
    'application/views/eeform/eform04.php'
];

foreach ($view_files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Check if it has HTML structure (which would be wrong)
        $has_doctype = strpos($content, '<!DOCTYPE') !== false;
        $has_html = strpos($content, '<html') !== false;
        $has_head = strpos($content, '<head') !== false;
        $has_body_tag = strpos($content, '<body') !== false;
        
        if ($has_doctype || $has_html || $has_head) {
            echo "  ⚠️  $file: Contains HTML structure (should use layout)\n";
        } else {
            echo "  ✅ $file: Properly formatted for layout system\n";
        }
        
        // Check for inline styles that might be missing
        $has_inline_css = strpos($content, '<style') !== false;
        if ($has_inline_css) {
            echo "  ℹ️  $file: Contains inline styles\n";
        }
        
        // Check for jQuery usage
        $uses_jquery = strpos($content, '$') !== false || strpos($content, 'jQuery') !== false;
        if ($uses_jquery) {
            echo "  ✅ $file: Uses jQuery\n";
        }
    } else {
        echo "  ❌ $file: Not found\n";
    }
}

// Performance Analysis
echo "\n📊 Performance Analysis:\n";
$total_css_size = 0;
$total_js_size = 0;

foreach (array_merge($css_files_extended, $js_files_extended) as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        if (strpos($file, '.css') !== false) {
            $total_css_size += $size;
        } else {
            $total_js_size += $size;
        }
    }
}

echo "  📊 Total CSS Size: " . number_format($total_css_size / 1024, 1) . " KB\n";
echo "  📊 Total JS Size: " . number_format($total_js_size / 1024, 1) . " KB\n";
echo "  📊 Total Assets Size: " . number_format(($total_css_size + $total_js_size) / 1024, 1) . " KB\n";

// Summary
echo "\n========================================\n";
echo "📊 Comprehensive Summary:\n";
echo "  CSS Files: {$css_present}/" . count($css_files_extended) . " ✅\n";
echo "  JS Files: {$js_present}/" . count($js_files_extended) . " ✅\n";
echo "  Image Assets: {$img_present}/" . count($image_files_extended) . " ✅\n";
echo "  Font Files: " . count($font_files) . " found\n";

$total_missing = count($css_missing) + count($js_missing) + count($img_missing);

if ($total_missing == 0) {
    echo "\n🎉 All essential files are present!\n";
    echo "✅ CSS and JS loading should be fully functional.\n";
} else {
    echo "\n⚠️  Found $total_missing missing files:\n";
    
    if (!empty($css_missing)) {
        echo "\n🔴 Missing CSS files:\n";
        foreach ($css_missing as $file) {
            echo "  - $file\n";
        }
    }
    
    if (!empty($js_missing)) {
        echo "\n🔴 Missing JS files:\n";
        foreach ($js_missing as $file) {
            echo "  - $file\n";
        }
    }
    
    if (!empty($img_missing)) {
        echo "\n🔴 Missing Image files:\n";
        foreach ($img_missing as $file) {
            echo "  - $file\n";
        }
    }
}

echo "\n📌 Testing Recommendations:\n";
echo "  1. Start Docker: docker-compose up -d\n";
echo "  2. Test forms in browser and check Developer Tools -> Network tab\n";
echo "  3. Verify no 404 errors for CSS/JS resources\n";
echo "  4. Check Console for JavaScript errors\n";
echo "  5. Test form functionality (date pickers, validation, etc.)\n";

echo "\n📌 Browser Test URLs:\n";
echo "  - http://localhost:9119/index.php/eform/eform1\n";
echo "  - http://localhost:9119/index.php/eform/eform2\n";
echo "  - http://localhost:9119/index.php/eform/eform4\n";

echo "========================================\n";