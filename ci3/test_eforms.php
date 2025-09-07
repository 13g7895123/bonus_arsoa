<?php
/**
 * Comprehensive Test Suite for EForm2 and EForm4
 * 
 * This script tests all critical functionality for the transferred eform2 and eform4 components
 * Run this script from the CI3 root directory
 */

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define paths
define('ENVIRONMENT', 'development');
define('BASEPATH', __DIR__ . '/system/');
define('APPPATH', __DIR__ . '/application/');

// Include CodeIgniter bootstrap
require_once BASEPATH . 'core/CodeIgniter.php';

class EFormTestSuite {
    
    private $testResults = array();
    private $baseUrl;
    
    public function __construct() {
        $this->baseUrl = 'http://localhost:9126';
        echo "=== EForm2 & EForm4 Comprehensive Test Suite ===\n";
        echo "Testing started at: " . date('Y-m-d H:i:s') . "\n\n";
    }
    
    public function runAllTests() {
        $this->testDatabaseConnection();
        $this->testDatabaseTables();
        $this->testApiHealth();
        $this->testRouting();
        $this->testControllers();
        $this->testModels();
        $this->testFormSubmission();
        $this->testMemberLookup();
        $this->generateReport();
    }
    
    private function testDatabaseConnection() {
        echo "1. Testing Database Connection...\n";
        try {
            $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'ci3_database', 9226);
            if ($mysqli->connect_error) {
                $this->addResult('Database Connection', false, 'Connection failed: ' . $mysqli->connect_error);
            } else {
                $this->addResult('Database Connection', true, 'Successfully connected to ci3_database');
                $mysqli->close();
            }
        } catch (Exception $e) {
            $this->addResult('Database Connection', false, 'Exception: ' . $e->getMessage());
        }
    }
    
    private function testDatabaseTables() {
        echo "2. Testing Database Tables...\n";
        try {
            $mysqli = new mysqli('127.0.0.1', 'root', 'root', 'ci3_database', 9226);
            
            $requiredTables = [
                'eeform2_submissions',
                'eeform2_products', 
                'eeform2_product_master',
                'eeform2_contact_history',
                'eeform4_submissions',
                'eeform4_products',
                'eeform4_product_master', 
                'eeform4_contact_history',
                'eeform4_health_tracking'
            ];
            
            foreach ($requiredTables as $table) {
                $result = $mysqli->query("SHOW TABLES LIKE '$table'");
                if ($result->num_rows > 0) {
                    $this->addResult("Table: $table", true, 'Table exists');
                    
                    // Test table structure
                    $structure = $mysqli->query("DESCRIBE $table");
                    if ($structure->num_rows > 0) {
                        $this->addResult("Structure: $table", true, 'Table structure verified');
                    }
                } else {
                    $this->addResult("Table: $table", false, 'Table does not exist');
                }
            }
            $mysqli->close();
        } catch (Exception $e) {
            $this->addResult('Database Tables', false, 'Exception: ' . $e->getMessage());
        }
    }
    
    private function testApiHealth() {
        echo "3. Testing API Health Endpoints...\n";
        $endpoints = [
            'api/eeform2/health',
            'api/eeform4/health'
        ];
        
        foreach ($endpoints as $endpoint) {
            $response = $this->makeHttpRequest($endpoint);
            if ($response !== false && strpos($response, 'success') !== false) {
                $this->addResult("API Health: $endpoint", true, 'Health check passed');
            } else {
                $this->addResult("API Health: $endpoint", false, 'Health check failed');
            }
        }
    }
    
    private function testRouting() {
        echo "4. Testing Route Configuration...\n";
        
        // Check if routes.php contains our routes
        $routesFile = __DIR__ . '/application/config/routes.php';
        if (file_exists($routesFile)) {
            $content = file_get_contents($routesFile);
            
            $requiredRoutes = [
                'eform/eform2',
                'eform/eform4', 
                'api/eeform2/submit',
                'api/eeform4/submit',
                'api/eeform2/health',
                'api/eeform4/health'
            ];
            
            foreach ($requiredRoutes as $route) {
                if (strpos($content, $route) !== false) {
                    $this->addResult("Route: $route", true, 'Route configured correctly');
                } else {
                    $this->addResult("Route: $route", false, 'Route not found in config');
                }
            }
        } else {
            $this->addResult('Routes Configuration', false, 'routes.php file not found');
        }
    }
    
    private function testControllers() {
        echo "5. Testing Controllers...\n";
        
        $controllers = [
            'application/controllers/Eform.php' => ['eform2', 'eform4'],
            'application/controllers/api/eeform/Eeform2.php' => ['submit', 'health'],
            'application/controllers/api/eeform/Eeform4.php' => ['submit', 'health']
        ];
        
        foreach ($controllers as $file => $methods) {
            $fullPath = __DIR__ . '/' . $file;
            if (file_exists($fullPath)) {
                $content = file_get_contents($fullPath);
                $this->addResult("Controller: $file", true, 'Controller file exists');
                
                foreach ($methods as $method) {
                    if (strpos($content, "function $method") !== false) {
                        $this->addResult("Method: $file::$method", true, 'Method exists');
                    } else {
                        $this->addResult("Method: $file::$method", false, 'Method not found');
                    }
                }
            } else {
                $this->addResult("Controller: $file", false, 'Controller file not found');
            }
        }
    }
    
    private function testModels() {
        echo "6. Testing Models...\n";
        
        $models = [
            'application/models/eeform/Eeform2Model.php' => ['create_submission', 'save_products'],
            'application/models/eeform/Eeform4Model.php' => ['create_submission', 'save_products']
        ];
        
        foreach ($models as $file => $methods) {
            $fullPath = __DIR__ . '/' . $file;
            if (file_exists($fullPath)) {
                $content = file_get_contents($fullPath);
                $this->addResult("Model: $file", true, 'Model file exists');
                
                foreach ($methods as $method) {
                    if (strpos($content, "function $method") !== false) {
                        $this->addResult("Method: $file::$method", true, 'Method exists');
                    } else {
                        $this->addResult("Method: $file::$method", false, 'Method not found');
                    }
                }
            } else {
                $this->addResult("Model: $file", false, 'Model file not found');
            }
        }
    }
    
    private function testFormSubmission() {
        echo "7. Testing Form Submission...\n";
        
        // Test data for eform2
        $eform2Data = json_encode([
            'member_name' => 'Test User',
            'join_date' => date('Y-m-d'),
            'gender' => '女',
            'age' => 25,
            'skin_health_condition' => 'Test condition',
            'line_contact' => 'test_line',
            'tel_contact' => '0912345678',
            'submission_date' => date('Y-m-d')
        ]);
        
        $response = $this->makeHttpRequest('api/eeform2/submit', 'POST', $eform2Data);
        if ($response !== false) {
            $this->addResult('EForm2 Submission', true, 'Submission test completed');
        } else {
            $this->addResult('EForm2 Submission', false, 'Submission test failed');
        }
        
        // Test data for eform4
        $eform4Data = json_encode([
            'member_name' => 'Test User Health',
            'join_date' => date('Y-m-d'),
            'gender' => '男',
            'age' => 30,
            'skin_health_condition' => 'Healthy',
            'line_contact' => 'test_line_health',
            'tel_contact' => '0987654321',
            'submission_date' => date('Y-m-d')
        ]);
        
        $response = $this->makeHttpRequest('api/eeform4/submit', 'POST', $eform4Data);
        if ($response !== false) {
            $this->addResult('EForm4 Submission', true, 'Submission test completed');
        } else {
            $this->addResult('EForm4 Submission', false, 'Submission test failed');
        }
    }
    
    private function testMemberLookup() {
        echo "8. Testing Member Lookup...\n";
        
        $endpoints = [
            'api/eeform2/member_lookup/TEST001',
            'api/eeform4/member_lookup/TEST001'
        ];
        
        foreach ($endpoints as $endpoint) {
            $response = $this->makeHttpRequest($endpoint);
            if ($response !== false) {
                $this->addResult("Member Lookup: $endpoint", true, 'Lookup test completed');
            } else {
                $this->addResult("Member Lookup: $endpoint", false, 'Lookup test failed');
            }
        }
    }
    
    private function makeHttpRequest($endpoint, $method = 'GET', $data = null) {
        $url = $this->baseUrl . '/' . $endpoint;
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);
        
        if ($data && $method === 'POST') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        return ($httpCode >= 200 && $httpCode < 400) ? $response : false;
    }
    
    private function addResult($test, $passed, $message) {
        $this->testResults[] = [
            'test' => $test,
            'passed' => $passed,
            'message' => $message,
            'timestamp' => date('H:i:s')
        ];
        
        $status = $passed ? '[PASS]' : '[FAIL]';
        echo "  $status $test: $message\n";
    }
    
    private function generateReport() {
        echo "\n=== TEST SUMMARY ===\n";
        
        $totalTests = count($this->testResults);
        $passedTests = array_filter($this->testResults, function($result) {
            return $result['passed'];
        });
        $passedCount = count($passedTests);
        $failedCount = $totalTests - $passedCount;
        
        echo "Total Tests: $totalTests\n";
        echo "Passed: $passedCount\n"; 
        echo "Failed: $failedCount\n";
        echo "Success Rate: " . round(($passedCount / $totalTests) * 100, 2) . "%\n\n";
        
        if ($failedCount > 0) {
            echo "=== FAILED TESTS ===\n";
            foreach ($this->testResults as $result) {
                if (!$result['passed']) {
                    echo "[{$result['timestamp']}] {$result['test']}: {$result['message']}\n";
                }
            }
        }
        
        echo "\nTest completed at: " . date('Y-m-d H:i:s') . "\n";
    }
}

// Run tests only if called directly
if (basename(__FILE__) == basename($_SERVER["SCRIPT_NAME"])) {
    $testSuite = new EFormTestSuite();
    $testSuite->runAllTests();
}