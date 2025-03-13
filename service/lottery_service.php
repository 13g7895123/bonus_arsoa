<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lottery_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }
 
    public function draw() {
        // 獲取獎項數據
        $prizes = $this->getPrizes();
        
        // 進行抽獎
        $winner = $this->doDraw($prizes);
        
        // 返回抽獎結果
        echo "Congratulations! You won: " . $winner;
    }      
    
    private function getPrizes() {
        // TODO: 從數據庫或其他來源獲取獎項數據，並返回一個包含數量和機率的陣列
        return [
            ['name' => 'Prize 1', 'quantity' => 10, 'probability' => 0.2],
            ['name' => 'Prize 2', 'quantity' => 5, 'probability' => 0.1],
            ['name' => 'Prize 3', 'quantity' => 2, 'probability' => 0.05],
            // ...
        ];
    }
    
    private function doDraw($prizes) {
        // 計算總機率
        $totalProbability = 0;
        foreach ($prizes as $prize) {
            $totalProbability += $prize['probability'];
        }
        
        // 生成一個隨機數
        $random = mt_rand(1, 100) / 100;
        
        // 遍歷獎項，根據機率進行抽獎
        $currentProbability = 0;
        foreach ($prizes as $prize) {
            $currentProbability += $prize['probability'] / $totalProbability;
            
            if ($random <= $currentProbability) {
                // 檢查獎項數量是否足夠
                if ($prize['quantity'] > 0) {
                    // 減少獎項數量
                    $prize['quantity']--;
                    
                    // TODO: 更新獎項數量到數據庫或其他來源
                    
                    // 返回獎項名稱
                    return $prize['name'];
                } else {
                    // 獎項數量不足，繼續抽獎
                    continue;
                }
            }
        }
        
        // 如果沒有中獎獎項，返回空值或其他提示
        return "Sorry, you didn't win any prize.";
    }
}