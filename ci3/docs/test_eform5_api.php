<?php
/**
 * EForm5 API Quick Test Script - Point 134
 * This script tests the actual API endpoints to verify functionality
 * 
 * Usage: php test_eform5_api.php
 */

// Configuration
$base_url = 'http://localhost'; // Adjust as needed
$api_endpoints = [
    'test' => '/api/eeform/eeform5/test',
    'list' => '/api/eeform/eeform5/list?page=1&limit=5',
    'comprehensive_test' => '/api/eeform/eeform5/comprehensive_test'
];

class EForm5ApiTester {
    private $base_url;
    private $results = [];
    
    public function __construct($base_url) {
        $this->base_url = rtrim($base_url, '/');
    }
    
    public function runTests($endpoints) {
        echo "🧪 EForm5 API Test Script - Point 134\n";
        echo "=====================================\n\n";
        
        foreach ($endpoints as $name => $endpoint) {
            $this->testEndpoint($name, $endpoint);
        }
        
        $this->printSummary();
    }
    
    private function testEndpoint($name, $endpoint) {
        echo "Testing {$name}... ";
        
        $url = $this->base_url . $endpoint;
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]);
        
        $start_time = microtime(true);
        $response = curl_exec($ch);
        $end_time = microtime(true);
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        $duration = round(($end_time - $start_time) * 1000, 2);
        
        // Analyze response
        $result = [
            'name' => $name,
            'url' => $url,
            'http_code' => $http_code,
            'duration' => $duration,
            'success' => false,
            'data' => null,
            'error' => null
        ];
        
        if ($curl_error) {
            $result['error'] = "cURL Error: {$curl_error}";
            echo "❌ CURL_ERROR\n";
        } elseif ($http_code !== 200) {
            $result['error'] = "HTTP {$http_code}";
            echo "❌ HTTP_{$http_code}\n";
        } else {
            $json_data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $result['error'] = "Invalid JSON: " . json_last_error_msg();
                echo "❌ JSON_ERROR\n";
            } elseif (!isset($json_data['success'])) {
                $result['error'] = "Missing 'success' field in response";
                echo "❌ STRUCTURE_ERROR\n";
            } elseif (!$json_data['success']) {
                $result['error'] = $json_data['message'] ?? 'Unknown error';
                echo "❌ API_ERROR\n";
            } else {
                $result['success'] = true;
                $result['data'] = $json_data;
                echo "✅ PASSED ({$duration}ms)\n";
                
                // Additional structure validation for list endpoint
                if ($name === 'list' && isset($json_data['data'])) {
                    $this->validateListStructure($json_data['data']);
                }
            }
        }
        
        $this->results[] = $result;
        
        // Show details for failed tests
        if (!$result['success']) {
            echo "   └─ Error: {$result['error']}\n";
            if ($response && strlen($response) < 500) {
                echo "   └─ Response: " . trim($response) . "\n";
            }
        }
        
        echo "\n";
    }
    
    private function validateListStructure($data) {
        $expected_fields = ['data', 'pagination'];
        $expected_pagination_fields = ['current_page', 'total_pages', 'total', 'per_page'];
        
        $missing_fields = [];
        
        foreach ($expected_fields as $field) {
            if (!isset($data[$field])) {
                $missing_fields[] = "data.{$field}";
            }
        }
        
        if (isset($data['pagination'])) {
            foreach ($expected_pagination_fields as $field) {
                if (!isset($data['pagination'][$field])) {
                    $missing_fields[] = "data.pagination.{$field}";
                }
            }
        }
        
        if (!empty($missing_fields)) {
            echo "   ⚠️ Structure Warning: Missing fields: " . implode(', ', $missing_fields) . "\n";
        } else {
            $record_count = is_array($data['data']) ? count($data['data']) : 0;
            $total_records = $data['pagination']['total'] ?? 0;
            echo "   ✅ Structure OK: {$record_count} records, {$total_records} total\n";
        }
    }
    
    private function printSummary() {
        echo "Summary\n";
        echo "=======\n";
        
        $total = count($this->results);
        $passed = array_filter($this->results, fn($r) => $r['success']);
        $passed_count = count($passed);
        $failed_count = $total - $passed_count;
        
        echo "Total Tests: {$total}\n";
        echo "Passed: {$passed_count}\n";
        echo "Failed: {$failed_count}\n";
        
        if ($failed_count > 0) {
            echo "\nFailed Tests:\n";
            foreach ($this->results as $result) {
                if (!$result['success']) {
                    echo "❌ {$result['name']}: {$result['error']}\n";
                }
            }
        }
        
        if ($passed_count === $total) {
            echo "\n🎉 All tests passed! EForm5 API is working correctly.\n";
            return true;
        } else {
            echo "\n⚠️ Some tests failed. Please check the API configuration.\n";
            return false;
        }
    }
}

// Run the tests
$tester = new EForm5ApiTester($base_url);
$success = $tester->runTests($api_endpoints);

// Exit with appropriate code
exit($success ? 0 : 1);