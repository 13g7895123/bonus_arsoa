#!/usr/bin/env php
<?php
/**
 * Comprehensive test script for all eform functionality in CI3
 */

echo "========================================\n";
echo "CI3 EForm Comprehensive Test\n";
echo "========================================\n\n";

// Test if we're in the CI3 directory
if (!file_exists('application/config/config.php')) {
    echo "❌ Error: Must run this script from CI3 root directory\n";
    exit(1);
}

// Configuration
$base_url = 'http://localhost:9126/index.php/';
$admin_base_url = $base_url . 'admin/';
$api_base_url = $base_url . 'api/eeform/';

echo "🔧 Configuration:\n";
echo "   Base URL: $base_url\n";
echo "   Admin URL: $admin_base_url\n";
echo "   API URL: $api_base_url\n\n";

// Test URLs
$test_urls = [
    // Frontend forms
    'EForm1 Frontend' => $base_url . 'eform/eform1',
    'EForm2 Frontend' => $base_url . 'eform/eform2',
    'EForm4 Frontend' => $base_url . 'eform/eform4',
    
    // Admin backends
    'EForm1 Admin' => $admin_base_url . 'form1',
    'EForm2 Admin' => $admin_base_url . 'form2',
    'EForm4 Admin' => $admin_base_url . 'form4',
    
    // API endpoints
    'EForm1 API Test' => $api_base_url . 'eeform1/test',
    'EForm2 API Test' => $api_base_url . 'eeform2/test',
    'EForm4 API Test' => $api_base_url . 'eeform4/test'
];

echo "🌐 Testing URL Access:\n";
foreach ($test_urls as $name => $url) {
    $status = testUrl($url);
    echo sprintf("   %-20s: %s\n", $name, $status);
}

echo "\n📁 File Structure Test:\n";

// Test file structure
$required_files = [
    'Views' => [
        'application/views/eeform/eform01.php',
        'application/views/eeform/eform02.php',
        'application/views/eeform/eform04.php',
        'application/views/layout/main.php',
        'application/views/admin/eeform/form1.php',
        'application/views/admin/eeform/form2.php',
        'application/views/admin/eeform/form4.php'
    ],
    'Controllers' => [
        'application/controllers/Eform.php',
        'application/controllers/admin/Admin_eeform.php',
        'application/controllers/api/eeform/Eeform1.php',
        'application/controllers/api/eeform/Eeform2.php',
        'application/controllers/api/eeform/Eeform4.php'
    ],
    'Models' => [
        'application/models/eeform/Eeform1Model.php',
        'application/models/eeform/Eeform2Model.php',
        'application/models/eeform/Eeform4Model.php'
    ],
    'Services' => [
        'application/service/block_service.php'
    ],
    'Config' => [
        'application/config/routes.php',
        'application/config/config.php'
    ],
    'Assets' => [
        'public/assets/css/bootstrap.min.css',
        'public/assets/css/style.css',
        'public/assets/js/bootstrap.min.js'
    ]
];

foreach ($required_files as $category => $files) {
    echo "\n   $category:\n";
    foreach ($files as $file) {
        $exists = file_exists($file);
        echo sprintf("     %-40s: %s\n", basename($file), $exists ? '✅ EXISTS' : '❌ MISSING');
    }
}

echo "\n🗄️ Database Migration Files:\n";
$migration_files = glob('application/migrations/*.php');
if (empty($migration_files)) {
    echo "   ❌ No migration files found\n";
} else {
    foreach ($migration_files as $migration) {
        echo "   ✅ " . basename($migration) . "\n";
    }
}

echo "\n🧪 Testing Form Functionality:\n";
testFormFunctionality();

echo "\n📊 API Endpoint Tests:\n";
testApiEndpoints();

echo "\n✨ Test Summary Complete!\n";
echo "========================================\n";

function testUrl($url) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);
    
    $result = @file_get_contents($url, false, $context);
    $http_response_header_local = $http_response_header ?? [];
    
    if ($result === false) {
        return '❌ CONNECTION FAILED';
    }
    
    if (empty($http_response_header_local)) {
        return '❌ NO RESPONSE';
    }
    
    $status_line = $http_response_header_local[0];
    if (strpos($status_line, '200') !== false) {
        return '✅ OK (200)';
    } else if (strpos($status_line, '404') !== false) {
        return '❌ NOT FOUND (404)';
    } else if (strpos($status_line, '500') !== false) {
        return '❌ SERVER ERROR (500)';
    } else {
        return '⚠️ ' . trim($status_line);
    }
}

function testFormFunctionality() {
    echo "   Testing form HTML structure...\n";
    
    $forms = [
        'eform01.php' => 'application/views/eeform/eform01.php',
        'eform02.php' => 'application/views/eeform/eform02.php',
        'eform04.php' => 'application/views/eeform/eform04.php'
    ];
    
    foreach ($forms as $name => $path) {
        if (file_exists($path)) {
            $content = file_get_contents($path);
            
            // Check for required form elements
            $has_form = strpos($content, '<form') !== false;
            $has_inputs = strpos($content, '<input') !== false;
            $has_jquery = strpos($content, 'jquery') !== false || strpos($content, '$') !== false;
            
            echo "     $name:\n";
            echo "       Form tag: " . ($has_form ? '✅' : '❌') . "\n";
            echo "       Input fields: " . ($has_inputs ? '✅' : '❌') . "\n";
            echo "       jQuery/JS: " . ($has_jquery ? '✅' : '❌') . "\n";
        } else {
            echo "     $name: ❌ FILE NOT FOUND\n";
        }
    }
}

function testApiEndpoints() {
    global $api_base_url;
    
    $endpoints = [
        'eeform1/test' => 'GET',
        'eeform2/test' => 'GET',
        'eeform4/test' => 'GET'
    ];
    
    foreach ($endpoints as $endpoint => $method) {
        $url = $api_base_url . $endpoint;
        echo "   Testing $endpoint ($method): ";
        
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'timeout' => 3,
                'ignore_errors' => true
            ]
        ]);
        
        $result = @file_get_contents($url, false, $context);
        
        if ($result === false) {
            echo "❌ FAILED\n";
        } else {
            // Check if it's a valid JSON response
            $json = json_decode($result, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                echo "✅ JSON Response\n";
            } else {
                echo "⚠️ Non-JSON Response\n";
            }
        }
    }
}

echo "\n🎯 Next Steps:\n";
echo "1. Start your docker containers: docker-compose up -d\n";
echo "2. Test frontend forms at: http://localhost:9126/index.php/eform/eform1\n";
echo "3. Test admin backend at: http://localhost:9126/index.php/admin/form1\n";
echo "4. Check API endpoints work properly\n";
echo "5. Submit test data through frontend forms\n";
echo "6. Verify data appears in admin backend\n\n";