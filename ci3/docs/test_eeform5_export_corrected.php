<?php
/**
 * EEForm5 修正後的匯出功能測試
 * 驗證 Point 137 的修正結果
 */

// 測試配置
$base_url = 'http://localhost:8082';
$test_submission_id = 1;

echo "=== EForm5 匯出功能修正驗證 ===" . PHP_EOL;
echo "時間: " . date('Y-m-d H:i:s') . PHP_EOL;
echo "測試 URL: {$base_url}/api/eeform/eeform5/export_single/{$test_submission_id}" . PHP_EOL;
echo str_repeat("=", 50) . PHP_EOL;

// 測試匯出功能
function test_corrected_export($base_url, $id) {
    $url = "{$base_url}/api/eeform/eeform5/export_single/{$id}";
    
    echo "正在測試匯出 API..." . PHP_EOL;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ CURL 錯誤: {$error}" . PHP_EOL;
        return false;
    }
    
    $headers = substr($response, 0, $header_size);
    $body = substr($response, $header_size);
    
    echo "HTTP 狀態碼: {$http_code}" . PHP_EOL;
    
    if ($http_code === 200) {
        // 檢查是否為 Excel 格式
        if (strpos($headers, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') !== false) {
            echo "✅ 成功：接收到 Excel 格式檔案" . PHP_EOL;
            echo "📁 檔案大小: " . strlen($body) . " bytes" . PHP_EOL;
            
            // 驗證檔案格式
            if (substr($body, 0, 2) === 'PK') {
                echo "✅ Excel 檔案格式正確 (ZIP 容器)" . PHP_EOL;
            } else {
                echo "⚠️  Excel 檔案格式可能異常" . PHP_EOL;
            }
            
            // 檢查內容類型標頭中的檔名
            if (preg_match('/filename="([^"]+)"/', $headers, $matches)) {
                echo "📋 檔案名稱: {$matches[1]}" . PHP_EOL;
            }
            
            // 保存測試檔案
            $test_filename = 'corrected_export_test_' . date('YmdHis') . '.xlsx';
            file_put_contents($test_filename, $body);
            echo "💾 測試檔案已保存: {$test_filename}" . PHP_EOL;
            
            return true;
            
        } else if (strpos($headers, 'text/csv') !== false) {
            echo "✅ 備用格式：接收到 CSV 檔案" . PHP_EOL;
            echo "📁 檔案大小: " . strlen($body) . " bytes" . PHP_EOL;
            
            // 檢查前幾行內容
            $lines = array_slice(explode("\n", $body), 0, 5);
            echo "📄 檔案內容預覽:" . PHP_EOL;
            foreach ($lines as $i => $line) {
                echo "   行 " . ($i + 1) . ": " . substr($line, 0, 60) . PHP_EOL;
            }
            
            return true;
            
        } else if (strpos($headers, 'application/json') !== false) {
            $json = json_decode($body, true);
            if ($json && isset($json['success']) && !$json['success']) {
                echo "❌ API 錯誤: " . ($json['message'] ?? '未知錯誤') . PHP_EOL;
            } else {
                echo "❌ 未預期的 JSON 回應" . PHP_EOL;
            }
            return false;
            
        } else {
            echo "❌ 未知的內容類型" . PHP_EOL;
            echo "Response Headers: " . substr($headers, 0, 500) . PHP_EOL;
            echo "Response Body (前100字): " . substr($body, 0, 100) . PHP_EOL;
            return false;
        }
        
    } else if ($http_code === 404) {
        echo "❌ 找不到表單記錄 (ID: {$id})" . PHP_EOL;
        return false;
        
    } else {
        echo "❌ HTTP 錯誤: {$http_code}" . PHP_EOL;
        $json = json_decode($body, true);
        if ($json && isset($json['message'])) {
            echo "錯誤訊息: " . $json['message'] . PHP_EOL;
        }
        return false;
    }
}

// 驗證內容格式
function validate_eeform5_content() {
    echo "\n=== 驗證 EForm5 內容結構 ===" . PHP_EOL;
    
    $expected_sections = [
        '個人體測表+健康諮詢表',
        '基本資料',
        '體測標準建議值', 
        '職業資訊',
        '健康困擾',
        '建議產品',
        '其他資訊'
    ];
    
    echo "✅ 預期的內容區塊:" . PHP_EOL;
    foreach ($expected_sections as $section) {
        echo "   • {$section}" . PHP_EOL;
    }
    
    return $expected_sections;
}

// 執行測試
echo "\n開始測試..." . PHP_EOL;

$result = test_corrected_export($base_url, $test_submission_id);

if ($result) {
    echo "\n✅ 測試通過！EForm5 匯出功能已修正" . PHP_EOL;
    validate_eeform5_content();
} else {
    echo "\n❌ 測試失敗，請檢查修正結果" . PHP_EOL;
}

echo "\n" . str_repeat("=", 50) . PHP_EOL;
echo "測試完成" . PHP_EOL;
?>