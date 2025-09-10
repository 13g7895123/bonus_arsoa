<?php
/**
 * EEForm5 Excel Export Test Script
 * 測試 EEForm5 表單匯出功能
 * 
 * 使用方式:
 * 1. 將此檔案放置於CI3專案根目錄
 * 2. 確保Docker環境已啟動
 * 3. 執行測試: php test_eeform5_export.php
 */

// 設定環境
define('BASEPATH', dirname(__FILE__) . '/system/');
define('APPPATH', dirname(__FILE__) . '/application/');
define('ENVIRONMENT', 'development');

// 測試配置
$base_url = 'http://localhost:8082';  // 根據 .env 設定的 PORT
$test_results = [];

// 顏色輸出函數
function print_colored($message, $color = 'default') {
    $colors = [
        'green' => "\033[32m",
        'red' => "\033[31m",
        'yellow' => "\033[33m",
        'blue' => "\033[34m",
        'default' => "\033[0m"
    ];
    
    echo isset($colors[$color]) ? $colors[$color] : '';
    echo $message;
    echo $colors['default'] . PHP_EOL;
}

// HTTP 請求函數
function make_request($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
    }
    
    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'http_code' => $http_code,
        'headers' => $headers,
        'body' => $body,
        'error' => $error
    ];
}

// 測試函數
function test_export_single($base_url, $submission_id) {
    print_colored("\n=== 測試 Export Single API ===", 'blue');
    
    $url = $base_url . '/api/eeform/eeform5/export_single/' . $submission_id;
    print_colored("測試 URL: $url", 'yellow');
    
    $response = make_request($url);
    
    if ($response['error']) {
        print_colored("❌ CURL 錯誤: " . $response['error'], 'red');
        return false;
    }
    
    print_colored("HTTP 狀態碼: " . $response['http_code'], 'yellow');
    
    // 檢查回應
    if ($response['http_code'] === 200) {
        // 檢查是否為 Excel 格式 (PHPExcel)
        if (strpos($response['headers'], 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') !== false) {
            print_colored("✓ 成功接收到 Excel 檔案", 'green');
            
            // 檢查檔案內容
            if (!empty($response['body'])) {
                print_colored("✓ Excel 檔案大小: " . strlen($response['body']) . " bytes", 'green');
                
                // 儲存測試檔案
                $filename = 'test_eeform5_export_' . date('YmdHis') . '.xlsx';
                file_put_contents($filename, $response['body']);
                print_colored("✓ 匯出檔案已儲存為: $filename", 'green');
                
                // 驗證 Excel 檔案格式
                if (substr($response['body'], 0, 2) === 'PK') {
                    print_colored("✓ Excel 檔案格式正確 (ZIP 格式)", 'green');
                } else {
                    print_colored("⚠ Excel 檔案格式可能不正確", 'yellow');
                }
                
                return true;
            } else {
                print_colored("❌ Excel 檔案內容為空", 'red');
                return false;
            }
        } else if (strpos($response['headers'], 'Content-Type: text/csv') !== false) {
            print_colored("✓ 成功接收到 CSV 檔案 (備用格式)", 'green');
            
            // 檢查檔案內容
            if (!empty($response['body'])) {
                // 檢查 BOM
                if (substr($response['body'], 0, 3) === "\xEF\xBB\xBF") {
                    print_colored("✓ CSV 包含 UTF-8 BOM", 'green');
                }
                
                // 解析 CSV 內容
                $lines = explode("\n", $response['body']);
                print_colored("✓ CSV 包含 " . count($lines) . " 行資料", 'green');
                
                // 顯示前幾行
                print_colored("\n前 5 行內容:", 'yellow');
                for ($i = 0; $i < min(5, count($lines)); $i++) {
                    echo "  行 " . ($i + 1) . ": " . substr($lines[$i], 0, 100) . PHP_EOL;
                }
                
                // 儲存測試檔案
                $filename = 'test_export_' . date('YmdHis') . '.csv';
                file_put_contents($filename, $response['body']);
                print_colored("✓ 匯出檔案已儲存為: $filename", 'green');
                
                return true;
            } else {
                print_colored("❌ CSV 檔案內容為空", 'red');
                return false;
            }
        } else {
            // 可能是錯誤回應
            $json = json_decode($response['body'], true);
            if ($json) {
                print_colored("❌ API 錯誤: " . ($json['message'] ?? '未知錯誤'), 'red');
            } else {
                print_colored("❌ 未預期的回應格式", 'red');
                echo "回應內容: " . substr($response['body'], 0, 500) . PHP_EOL;
            }
            return false;
        }
    } else if ($response['http_code'] === 404) {
        print_colored("❌ 找不到指定的表單記錄 (ID: $submission_id)", 'red');
        return false;
    } else if ($response['http_code'] === 405) {
        print_colored("❌ 方法不允許 (應使用 GET 請求)", 'red');
        return false;
    } else {
        print_colored("❌ 未預期的 HTTP 狀態碼: " . $response['http_code'], 'red');
        $json = json_decode($response['body'], true);
        if ($json) {
            print_colored("錯誤訊息: " . ($json['message'] ?? '未知'), 'red');
        }
        return false;
    }
}

// 建立測試資料
function create_test_submission($base_url) {
    print_colored("\n=== 建立測試資料 ===", 'blue');
    
    $test_data = [
        'member_name' => '測試公司',
        'member_id' => 'TEST' . date('His'),
        'phone' => '0912' . rand(100000, 999999),
        'name' => '測試使用者',
        'gender' => '男',
        'age' => rand(20, 60),
        'height' => rand(150, 190) + (rand(0, 9) / 10),
        'exercise_habit' => '是',
        
        // 體測數據
        'weight' => rand(50, 90) + (rand(0, 9) / 10),
        'bmi' => rand(18, 30) + (rand(0, 9) / 10),
        'fat_percentage' => rand(10, 30) + (rand(0, 9) / 10),
        'fat_mass' => rand(5, 20) + (rand(0, 9) / 10),
        'muscle_percentage' => rand(30, 50) + (rand(0, 9) / 10),
        'muscle_mass' => rand(20, 40) + (rand(0, 9) / 10),
        'water_percentage' => rand(50, 70) + (rand(0, 9) / 10),
        'water_content' => rand(30, 50) + (rand(0, 9) / 10),
        'visceral_fat_percentage' => rand(5, 15) + (rand(0, 9) / 10),
        'bone_mass' => rand(2, 4) + (rand(0, 9) / 10),
        'bmr' => rand(1200, 2000),
        'protein_percentage' => rand(15, 25) + (rand(0, 9) / 10),
        'obesity_percentage' => rand(5, 25) + (rand(0, 9) / 10),
        'body_age' => rand(20, 60),
        'lean_body_mass' => rand(40, 70) + (rand(0, 9) / 10),
        
        // 其他資料
        'occupation' => ['上班族', '自由業'],
        'health_concerns' => ['睡眠不佳', '免疫力'],
        'health_concerns_other' => '偶爾頭痛',
        'recommended_products' => ['活力精萃', '白鶴靈芝EX'],
        'product_dosages' => [
            'energy_essence_dosage' => '每日1包',
            'reishi_ex_dosage' => '每日2粒'
        ],
        'has_medication_habit' => rand(0, 1),
        'medication_name' => '維他命C',
        'has_family_disease_history' => rand(0, 1),
        'disease_name' => '高血壓',
        'microcirculation_test' => '血液循環良好',
        'dietary_advice' => '建議多攝取蔬果'
    ];
    
    $url = $base_url . '/api/eeform/eeform5/submit';
    print_colored("提交測試資料到: $url", 'yellow');
    
    $response = make_request($url, 'POST', $test_data);
    
    if ($response['http_code'] === 200) {
        $json = json_decode($response['body'], true);
        if ($json && isset($json['success']) && $json['success']) {
            print_colored("✓ 成功建立測試資料, ID: " . ($json['submission_id'] ?? 'N/A'), 'green');
            return $json['submission_id'] ?? null;
        } else {
            print_colored("❌ 建立測試資料失敗: " . ($json['message'] ?? '未知錯誤'), 'red');
            return null;
        }
    } else {
        print_colored("❌ HTTP 錯誤: " . $response['http_code'], 'red');
        return null;
    }
}

// 主測試流程
function run_tests($base_url) {
    print_colored("\n" . str_repeat("=", 50), 'blue');
    print_colored("  EEForm5 Excel Export 功能測試", 'blue');
    print_colored(str_repeat("=", 50), 'blue');
    print_colored("測試時間: " . date('Y-m-d H:i:s'), 'yellow');
    print_colored("測試環境: $base_url", 'yellow');
    
    $all_passed = true;
    
    // 測試 1: 建立測試資料
    $submission_id = create_test_submission($base_url);
    if (!$submission_id) {
        $submission_id = 1;  // 使用預設 ID
        print_colored("⚠ 使用預設 ID: $submission_id", 'yellow');
    }
    
    // 測試 2: 匯出單一表單
    if (!test_export_single($base_url, $submission_id)) {
        $all_passed = false;
    }
    
    // 測試 3: 測試無效 ID
    print_colored("\n=== 測試無效 ID ===", 'blue');
    if (test_export_single($base_url, 999999)) {
        print_colored("⚠ 無效 ID 測試應該失敗", 'yellow');
        $all_passed = false;
    } else {
        print_colored("✓ 無效 ID 正確處理", 'green');
    }
    
    // 總結
    print_colored("\n" . str_repeat("=", 50), 'blue');
    if ($all_passed) {
        print_colored("✅ 所有測試通過！", 'green');
    } else {
        print_colored("❌ 部分測試失敗，請檢查錯誤訊息", 'red');
    }
    print_colored(str_repeat("=", 50), 'blue');
}

// 檢查 Docker 環境
function check_docker() {
    print_colored("\n檢查 Docker 環境...", 'yellow');
    
    $output = [];
    $return_var = 0;
    exec('docker-compose ps 2>&1', $output, $return_var);
    
    if ($return_var !== 0) {
        print_colored("❌ Docker 環境未啟動", 'red');
        print_colored("請執行: docker-compose up -d", 'yellow');
        return false;
    }
    
    $running = false;
    foreach ($output as $line) {
        if (strpos($line, 'Up') !== false) {
            $running = true;
            break;
        }
    }
    
    if ($running) {
        print_colored("✓ Docker 環境運行中", 'green');
        return true;
    } else {
        print_colored("❌ Docker 容器未運行", 'red');
        print_colored("請執行: docker-compose up -d", 'yellow');
        return false;
    }
}

// 執行測試
if (php_sapi_name() === 'cli') {
    // 檢查參數
    $port = isset($argv[1]) ? $argv[1] : '8082';
    $base_url = "http://localhost:$port";
    
    if (check_docker()) {
        run_tests($base_url);
    } else {
        print_colored("\n請先啟動 Docker 環境後再執行測試", 'red');
        exit(1);
    }
} else {
    echo "此腳本必須從命令列執行\n";
    exit(1);
}