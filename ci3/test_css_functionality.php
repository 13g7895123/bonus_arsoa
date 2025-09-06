<?php
// CSS Functionality Test for CI3 Project

echo "=== CI3 CSS Loading Functionality Test ===\n";
echo "Testing CSS loading and form1 functionality\n\n";

$base_url = 'http://localhost:9126';
$test_results = [];

// Test 1: Check if CSS files are accessible
echo "1. Testing CSS file accessibility...\n";
$css_files = [
    'bootstrap.min.css' => $base_url . '/views/eeform/css/bootstrap.min.css',
    'style.css' => $base_url . '/views/eeform/css/style.css',
    'animate.css' => $base_url . '/views/eeform/css/animate.css'
];

foreach ($css_files as $name => $url) {
    $headers = get_headers($url, 1);
    if (strpos($headers[0], '200') !== false) {
        echo "  ✓ $name is accessible\n";
        $test_results['css_' . $name] = true;
    } else {
        echo "  ✗ $name is not accessible\n";
        $test_results['css_' . $name] = false;
    }
}

// Test 2: Check controller functionality
echo "\n2. Testing controller functionality...\n";
$controller_url = $base_url . '/eform/test';
$response = file_get_contents($controller_url);
if (strpos($response, 'Eform controller is working!') !== false) {
    echo "  ✓ Eform controller is working\n";
    $test_results['controller'] = true;
} else {
    echo "  ✗ Eform controller has issues\n";
    $test_results['controller'] = false;
}

// Test 3: Check if eform1 page loads
echo "\n3. Testing eform1 page loading...\n";
$eform1_url = $base_url . '/eform/eform1';
$eform1_content = file_get_contents($eform1_url);

if (strpos($eform1_content, 'bootstrap.min.css') !== false) {
    echo "  ✓ EForm1 page loads with CSS links\n";
    $test_results['eform1_css_links'] = true;
} else {
    echo "  ✗ EForm1 page missing CSS links\n";
    $test_results['eform1_css_links'] = false;
}

if (strpos($eform1_content, '肌膚諮詢記錄表') !== false) {
    echo "  ✓ EForm1 page contains form title\n";
    $test_results['eform1_content'] = true;
} else {
    echo "  ✗ EForm1 page missing expected content\n";
    $test_results['eform1_content'] = false;
}

// Test 4: Check base URL configuration
echo "\n4. Testing base URL configuration...\n";
if (strpos($eform1_content, 'http://localhost:9126/') !== false) {
    echo "  ✓ Base URL is correctly configured\n";
    $test_results['base_url'] = true;
} else {
    echo "  ✗ Base URL configuration issue\n";
    $test_results['base_url'] = false;
}

// Test 5: Database connection (from previous test)
echo "\n5. Testing database functionality...\n";
try {
    $db = new mysqli('db', 'ci3_user', 'ci3_password', 'ci3_database');
    if (!$db->connect_error) {
        echo "  ✓ Database connection working\n";
        $test_results['database'] = true;
        
        // Check if eeform1_submissions table exists
        $result = $db->query("SHOW TABLES LIKE 'eeform1_submissions'");
        if ($result && $result->num_rows > 0) {
            echo "  ✓ EEForm1 table exists\n";
            $test_results['table'] = true;
        } else {
            echo "  ✗ EEForm1 table missing\n";
            $test_results['table'] = false;
        }
        $db->close();
    } else {
        echo "  ✗ Database connection failed\n";
        $test_results['database'] = false;
    }
} catch (Exception $e) {
    echo "  ✗ Database test failed: " . $e->getMessage() . "\n";
    $test_results['database'] = false;
}

// Summary
echo "\n=== Test Summary ===\n";
$passed = 0;
$total = count($test_results);

foreach ($test_results as $test => $result) {
    if ($result) {
        echo "✓ $test: PASSED\n";
        $passed++;
    } else {
        echo "✗ $test: FAILED\n";
    }
}

echo "\nResults: $passed/$total tests passed\n";

if ($passed === $total) {
    echo "\n🎉 All tests passed! CSS loading is working correctly.\n";
    echo "\nYou can now access:\n";
    echo "- EForm1: http://localhost:9126/eform/eform1\n";
    echo "- CSS Test: http://localhost:9126/css_test.html\n";
    echo "- Controller Test: http://localhost:9126/eform/test\n";
} else {
    echo "\n⚠️  Some tests failed. Please review the issues above.\n";
}

echo "\n=== Test completed ===\n";
?>