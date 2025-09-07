#!/usr/bin/env php
<?php
/**
 * Test script to verify CSS and JS files are accessible in CI3 project
 */

echo "========================================\n";
echo "CI3 CSS & JS Loading Test\n";
echo "========================================\n\n";

// Test if we're in the CI3 directory
if (!file_exists('application/config/config.php')) {
    echo "❌ Error: Must run this script from CI3 root directory\n";
    exit(1);
}

echo "🔧 Testing CSS and JS file accessibility...\n\n";

// List of critical CSS files
$css_files = [
    'public/assets/css/bootstrap.min.css',
    'public/assets/css/animate.min.css', 
    'public/assets/css/style.css',
    'public/assets/css/jquery.ui.datepicker.css',
    'public/assets/css/arsoa.css',
    'public/assets/css/alertify.core.css',
    'public/assets/css/alertify.default.css'
];

// List of critical JS files
$js_files = [
    'public/assets/js/jquery.min.js',
    'public/assets/js/bootstrap.min.js',
    'public/assets/js/jquery.ui.core.js',
    'public/assets/js/jquery.ui.datepicker.js',
    'public/assets/js/jquery.ui.datepicker-zh-TW.js',
    'public/assets/js/jquery.lazyload.min.js',
    'public/assets/js/alertify.min.js',
    'public/assets/js/arsoa.js',
    'public/assets/js/pjsfunc.js'
];

// Test CSS files
echo "📂 CSS Files:\n";
$css_missing = 0;
foreach ($css_files as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
    } else {
        echo "  ❌ $file (MISSING)\n";
        $css_missing++;
    }
}

echo "\n📂 JavaScript Files:\n";
$js_missing = 0;
foreach ($js_files as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
    } else {
        echo "  ❌ $file (MISSING)\n";
        $js_missing++;
    }
}

// Test view files
echo "\n📂 View Files:\n";
$view_files = [
    'application/views/eeform/eform01.php',
    'application/views/eeform/eform02.php', 
    'application/views/eeform/eform04.php',
    'application/views/layout/main.php'
];

$view_missing = 0;
foreach ($view_files as $file) {
    if (file_exists($file)) {
        $lines = count(file($file));
        echo "  ✅ $file ($lines lines)\n";
        
        // Check if it has HTML structure (which would be wrong)
        $content = file_get_contents($file);
        if (strpos($content, '<!DOCTYPE') !== false || strpos($content, '<html') !== false) {
            echo "    ⚠️  WARNING: Contains HTML structure (should use layout)\n";
        }
    } else {
        echo "  ❌ $file (MISSING)\n";
        $view_missing++;
    }
}

// Test CSS images
echo "\n📂 CSS Image Assets:\n";
$image_files = [
    'public/assets/css/images/ui-icons_222222_256x240.png',
    'public/assets/css/images/loading.gif',
    'public/assets/css/ajax-loader.gif'
];

$img_missing = 0;
foreach ($image_files as $file) {
    if (file_exists($file)) {
        $size = number_format(filesize($file) / 1024, 1);
        echo "  ✅ $file ({$size} KB)\n";
    } else {
        echo "  ❌ $file (MISSING)\n";
        $img_missing++;
    }
}

echo "\n========================================\n";
echo "📊 Summary:\n";
echo "  CSS Files: " . (count($css_files) - $css_missing) . "/" . count($css_files) . " ✅\n";
echo "  JS Files: " . (count($js_files) - $js_missing) . "/" . count($js_files) . " ✅\n";
echo "  View Files: " . (count($view_files) - $view_missing) . "/" . count($view_files) . " ✅\n";
echo "  Image Files: " . (count($image_files) - $img_missing) . "/" . count($image_files) . " ✅\n";

$total_missing = $css_missing + $js_missing + $view_missing + $img_missing;

if ($total_missing == 0) {
    echo "\n🎉 All files are present and accessible!\n";
    echo "✅ CSS and JS loading issues should be resolved.\n";
} else {
    echo "\n⚠️  Found $total_missing missing files.\n";
    echo "❌ Please copy the missing files to resolve CSS/JS issues.\n";
}

echo "\n📌 Next steps:\n";
echo "  1. Start the Docker container: docker-compose up -d\n";
echo "  2. Test the forms in browser:\n";
echo "     - http://localhost:9119/index.php/eform/eform1\n";
echo "     - http://localhost:9119/index.php/eform/eform2\n";
echo "     - http://localhost:9119/index.php/eform/eform4\n";
echo "  3. Verify CSS styles are properly loaded\n";
echo "  4. Check JavaScript functionality\n";

echo "========================================\n";