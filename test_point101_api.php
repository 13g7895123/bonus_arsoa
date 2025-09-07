<?php
/**
 * Point 101 API 測試腳本
 * 測試 eeform1 資料庫寫入功能的 API
 * 
 * 使用方式：
 * 1. 瀏覽器訪問：http://yourdomain.com/test_point101_api.php
 * 2. 或透過 cURL 測試：curl -X POST http://yourdomain.com/ci3/api/eeform1/test_write
 */

echo "<h1>Point 101: eeform1 資料庫寫入測試 API</h1>";
echo "<hr>";

// API 端點設定
$api_url = '/ci3/api/eeform1/test_write';
$full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . 
           "://" . $_SERVER['HTTP_HOST'] . $api_url;

echo "<h2>🎯 測試目標</h2>";
echo "<p>測試 Point 100 建立的 eeform1 資料表是否可以正常寫入資料</p>";

echo "<h2>📍 API 端點</h2>";
echo "<p><strong>URL:</strong> <code>$full_url</code></p>";
echo "<p><strong>方法:</strong> POST</p>";
echo "<p><strong>說明:</strong> 這個 API 會測試所有 8 個 eeform1 相關資料表的寫入功能</p>";

echo "<h2>🧪 執行測試</h2>";

// 使用 cURL 測試 API
function test_api($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['test' => 'point101']));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $http_code,
        'error' => $error
    ];
}

// 執行測試
echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
echo "<p><strong>正在測試 API...</strong></p>";

$result = test_api($full_url);

if ($result['error']) {
    echo "<div style='color: red; background: #ffe6e6; padding: 10px; border-radius: 3px;'>";
    echo "<h3>❌ cURL 錯誤</h3>";
    echo "<p>錯誤訊息: " . htmlspecialchars($result['error']) . "</p>";
    echo "<p>可能原因：伺服器未啟動、網路連線問題、或 cURL 未啟用</p>";
    echo "</div>";
} else {
    echo "<div style='background: white; padding: 10px; border-radius: 3px; margin: 10px 0;'>";
    echo "<h3>📡 HTTP 狀態碼: " . $result['http_code'] . "</h3>";
    
    if ($result['http_code'] == 200) {
        echo "<p style='color: green;'>✅ API 回應正常</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ 非預期的 HTTP 狀態碼</p>";
    }
    
    echo "<h3>📋 API 回應內容：</h3>";
    
    // 嘗試解析 JSON 回應
    $json_response = json_decode($result['response'], true);
    
    if ($json_response) {
        echo "<div style='background: #f8f8f8; padding: 10px; border-left: 4px solid #2196F3;'>";
        
        if (isset($json_response['success']) && $json_response['success']) {
            echo "<h4 style='color: green;'>🎉 測試成功！</h4>";
            echo "<p><strong>訊息:</strong> " . htmlspecialchars($json_response['message']) . "</p>";
            
            if (isset($json_response['data'])) {
                $data = $json_response['data'];
                echo "<p><strong>測試時間:</strong> " . htmlspecialchars($data['測試時間'] ?? 'N/A') . "</p>";
                echo "<p><strong>測試狀態:</strong> " . htmlspecialchars($data['測試狀態'] ?? 'N/A') . "</p>";
                
                if (isset($data['資料表測試結果'])) {
                    echo "<h5>📊 各資料表測試結果：</h5>";
                    echo "<ul>";
                    foreach ($data['資料表測試結果'] as $table => $status) {
                        echo "<li><strong>" . htmlspecialchars($table) . ":</strong> " . htmlspecialchars($status) . "</li>";
                    }
                    echo "</ul>";
                }
                
                if (isset($data['總結'])) {
                    echo "<h5>📈 測試總結：</h5>";
                    echo "<ul>";
                    foreach ($data['總結'] as $key => $value) {
                        echo "<li><strong>" . htmlspecialchars($key) . ":</strong> " . htmlspecialchars($value) . "</li>";
                    }
                    echo "</ul>";
                }
                
                if (isset($data['說明'])) {
                    echo "<div style='background: #e8f5e8; padding: 10px; margin: 10px 0; border-radius: 3px;'>";
                    echo "<p><strong>說明:</strong> " . htmlspecialchars($data['說明']) . "</p>";
                    echo "</div>";
                }
            }
        } else {
            echo "<h4 style='color: red;'>❌ 測試失敗</h4>";
            echo "<p><strong>錯誤訊息:</strong> " . htmlspecialchars($json_response['message'] ?? '未知錯誤') . "</p>";
            
            if (isset($json_response['errors'])) {
                echo "<h5>錯誤詳情：</h5>";
                echo "<pre style='background: #ffe6e6; padding: 10px; border-radius: 3px; overflow-x: auto;'>";
                echo htmlspecialchars(print_r($json_response['errors'], true));
                echo "</pre>";
            }
        }
        
        echo "</div>";
    } else {
        // 非 JSON 回應
        echo "<div style='background: #fff3cd; padding: 10px; border-radius: 3px;'>";
        echo "<p style='color: #856404;'>⚠️ API 回應不是有效的 JSON 格式</p>";
        echo "<h5>原始回應內容：</h5>";
        echo "<pre style='background: #f8f8f8; padding: 10px; border-radius: 3px; overflow-x: auto; max-height: 300px; overflow-y: auto;'>";
        echo htmlspecialchars($result['response']);
        echo "</pre>";
        echo "</div>";
    }
    
    echo "</div>";
}

echo "</div>";

echo "<h2>🔍 手動測試指令</h2>";
echo "<p>如果上述自動測試無法運作，您可以使用以下指令手動測試：</p>";
echo "<div style='background: #2d3748; color: #e2e8f0; padding: 15px; border-radius: 5px; font-family: monospace;'>";
echo "# 使用 cURL 測試<br>";
echo "curl -X POST " . htmlspecialchars($full_url) . " \\<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;-H \"Content-Type: application/json\" \\<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;-H \"Accept: application/json\" \\<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;-d '{\"test\":\"point101\"}'";
echo "</div>";

echo "<h2>✅ 預期結果</h2>";
echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px;'>";
echo "<p><strong>成功測試應該包含以下資料表的寫入測試：</strong></p>";
echo "<ul>";
echo "<li>eeform1_submissions (主表)</li>";
echo "<li>eeform1_occupations (職業資料)</li>";
echo "<li>eeform1_lifestyle (生活習慣)</li>";
echo "<li>eeform1_products (使用產品)</li>";
echo "<li>eeform1_skin_issues (肌膚問題)</li>";
echo "<li>eeform1_allergies (過敏資料)</li>";
echo "<li>eeform1_skin_scores (肌膚評分)</li>";
echo "<li>eeform1_suggestions (建議內容)</li>";
echo "</ul>";
echo "<p><strong>所有測試完成後，測試資料會自動清理，不會留在資料庫中。</strong></p>";
echo "</div>";

echo "<hr>";
echo "<p><small>Point 101 測試腳本 - " . date('Y-m-d H:i:s') . "</small></p>";
?>