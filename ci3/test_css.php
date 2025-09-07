#!/usr/bin/env php
<?php
/**
 * Test script to verify CSS is properly loading for eform2 and eform4
 */

echo "Testing CSS loading for eform2 and eform4...\n\n";

// Test if CSS files exist in public directory
$css_files = [
    'public/assets/css/bootstrap.min.css',
    'public/assets/css/animate.min.css',
    'public/assets/css/animsition.min.css',
    'public/assets/css/ionicons.min.css',
    'public/assets/css/jquery.fancybox.min.css',
    'public/assets/css/owl.carousel.min.css',
    'public/assets/css/owl.theme.default.min.css',
    'public/assets/css/socicon.css',
    'public/assets/css/monosocialiconsfont.css',
    'public/assets/css/style.css'
];

echo "Checking CSS files in public directory:\n";
foreach ($css_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "✓ $file (Size: " . number_format($size) . " bytes)\n";
    } else {
        echo "✗ $file - NOT FOUND\n";
    }
}

echo "\n";

// Test if JS files exist in public directory
$js_files = [
    'public/assets/js/bootstrap.min.js',
    'public/assets/js/animsition.min.js',
    'public/assets/js/jquery.fancybox.min.js',
    'public/assets/js/owl.carousel.min.js'
];

echo "Checking JavaScript files in public directory:\n";
foreach ($js_files as $file) {
    if (file_exists($file)) {
        $size = filesize($file);
        echo "✓ $file (Size: " . number_format($size) . " bytes)\n";
    } else {
        echo "✗ $file - NOT FOUND\n";
    }
}

echo "\n";

// Check if layout file exists
if (file_exists('application/views/layout/main.php')) {
    echo "✓ Layout file exists: application/views/layout/main.php\n";
    
    // Check if layout contains CSS references
    $layout_content = file_get_contents('application/views/layout/main.php');
    if (strpos($layout_content, 'public/assets/css/') !== false) {
        echo "✓ Layout contains CSS references to public/assets/css/\n";
    } else {
        echo "✗ Layout does not contain CSS references to public/assets/css/\n";
    }
} else {
    echo "✗ Layout file not found\n";
}

echo "\n";

// Check if controllers are properly configured
if (file_exists('application/controllers/Eform.php')) {
    echo "✓ Eform controller exists\n";
    
    $controller_content = file_get_contents('application/controllers/Eform.php');
    
    // Check if eform2 method uses layout
    if (strpos($controller_content, 'layout/main') !== false) {
        echo "✓ Controller uses layout system\n";
    } else {
        echo "✗ Controller does not use layout system\n";
    }
} else {
    echo "✗ Eform controller not found\n";
}

echo "\n";

// Check if views exist
$views = ['application/views/eeform/eform02.php', 'application/views/eeform/eform04.php'];
foreach ($views as $view) {
    if (file_exists($view)) {
        echo "✓ View exists: $view\n";
    } else {
        echo "✗ View not found: $view\n";
    }
}

echo "\n✅ CSS configuration test completed.\n";
echo "Please test the forms in the browser:\n";
echo "- http://localhost:9126/index.php/eform/eform2\n";
echo "- http://localhost:9126/index.php/eform/eform4\n";