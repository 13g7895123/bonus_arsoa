# 專案側邊欄配置系統詳細說明

## 系統概覽

本專案採用**雙重側邊欄配置系統**，根據不同的功能區域使用不同的配置方式：

1. **XML配置系統** - 用於管理後台的動態選單系統
2. **硬編碼配置系統** - 用於前台用戶區域的固定選單

## 1. XML配置系統 (setup.xml)

### 檔案位置
```
config/setup.xml
```

### 系統架構

XML配置系統主要用於**管理後台選單**，具備以下特色：
- 動態權限控制
- 階層式選單結構
- 角色基礎的選單顯示
- 集中化配置管理

### 載入機制

XML配置在 `core/MY_Controller.php` 中載入：
```php
$this->XmlDoc = $this->block_service->PF_LoadXmlDoc('setup.xml');
```

### 選單結構定義

XML中選單結構位於 `<權限>` 節點下：

```xml
<選單 主選單名稱="會員專區" 主編號="U" lnr="lnr-user">
    <SND 權限檢查="1">
        <權限>2</權限>
    </SND>
    <KIND 權限檢查="1">
        <資料>會員列表</資料>
        <傳回值>U002</傳回值>
        <網址>member/list/U002</網址>
        <層級>2</層級>
        <權限>2</權限>
    </KIND>
</選單>
```

### 權限等級說明

| 權限等級 | 說明 | 對應角色 |
|---------|------|----------|
| 0 | 停用 | 無權限 |
| 2 | 網站管理 | 一般管理員 |
| 50 | LINE管理 | LINE管理員 |
| 999 | 超級管理者 | 系統管理員 |

### 主要選單分類

#### 後台管理選單包含：

1. **首頁BANNER** (主編號: B)
   - 首頁BANNER管理

2. **情報分享** (主編號: 1)
   - 最新消息
   - 媒體介紹
   - 美麗情報
   - 其他分享

3. **美麗分享** (主編號: S)
   - 廣告輪播
   - 品牌與產品
   - 美麗分享
   - 分享說明

4. **肌膚檢測** (主編號: A)
   - 題目維護
   - 分類結果維護

5. **產品資訊** (主編號: 2)
   - 產品資訊
   - 紅利產品
   - 販促活動

6. **會員專區** (主編號: U)
   - 會員列表
   - LINE選單管理
   - 綁定LINE會員列表
   - LINE訊息傳送
   - 入會申請
   - 最新情報
   - 型錄下載
   - ARSOA AI

7. **組織專區** (主編號: G)
   - 組織專區訊息
   - 教育訓練情報
   - ARSOA NEWS 月刊
   - 商德規範文件
   - 商德規範內容

8. **問卷管理** (主編號: Q)
   - 題庫類型
   - 題庫
   - 問卷管理

9. **電子表單** (主編號: E)
   - 題庫類型
   - 題庫
   - 問卷管理

10. **產品體驗管理** (主編號: N)
    - 產品體驗管理
    - 產品體驗回覆

11. **索取試用組管理** (主編號: F)
    - 試用組設定
    - 索取試用組列表
    - 試用組心得回覆

12. **抽獎管理** (主編號: L)
    - 抽獎設定
    - 抽獎人列表

13. **活動課程管理** (主編號: C)
    - 活動課程管理
    - 參加人員列表

14. **同意書管理** (主編號: T)
    - 同意書設定
    - 同意人列表

15. **表格下載** (主編號: D)
    - 表格管理

16. **聯絡我們** (主編號: 7)
    - 聯絡我們

17. **相關設定** (主編號: 6)
    - 安露莎問與答
    - 結帳說明
    - 紅利積點兌換說明
    - 版權聲明
    - 隱私權政策
    - 購物與退換貨
    - 會員登入注意事項

18. **系統設定** (主編號: 9)
    - 管理人員
    - 鎖定結帳
    - 個人資料設定
    - 瀏覽人數
    - 網站設定
    - Google 分析

### 選單渲染機制

選單在 `views/admin/admin_left.php` 中渲染：

```php
// 根據管理員類型選擇不同的選單節點
if ($admin_type == 'L'){
    $Menu=$XmlDoc->xpath("/參數設定檔/權限L/選單");
}
elseif ($admin_type == 'C'){
    $Menu=$XmlDoc->xpath("/參數設定檔/權限C/選單");
}
else{
    $Menu=$XmlDoc->xpath("/參數設定檔/權限/選單");
}

// 遍歷選單並檢查權限
for($x=0;$x< count($Menu);$x++){
    // 權限檢查邏輯
    if ($_SESSION['admin_session']['admin_status'] >= $minstatus){
        // 渲染選單項目
    }
}
```

## 2. 硬編碼配置系統

### 系統用途
硬編碼配置系統用於**前台用戶區域**的側邊欄選單，包括：
- 電子表單系統
- 會員專區
- 一般用戶功能區域

### 檔案位置結構

```
views/helper/
├── electronic_form_right_menu.php    # 電子表單選單
├── member_right_menu.php             # 會員專區選單
├── admin_right_menu.php              # 管理員功能選單
├── help_menu.php                     # 說明選單
├── question_menu.php                 # 問卷選單
└── form_menu.php                     # 表單選單
```

### 電子表單側邊欄

**檔案**: `views/helper/electronic_form_right_menu.php`

```php
<div class="mb75">
    <h4><strong>電子表單</strong></h4>
    <a href="eform1_list" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform1'){ echo 'active'; }?>">肌膚諮詢記錄表</a>
    <a href="eform2" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform2'){ echo 'active'; }?>">會員服務追蹤表(肌膚)</a>
    <a href="eform3_list" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform3'){ echo 'active'; }?>">微微卡日記</a>
    <a href="eform4" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform4'){ echo 'active'; }?>">會員服務追蹤表(保健)</a>
    <a href="eform5" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform5'){ echo 'active'; }?>">健康諮詢表</a>
</div>
```

**使用方式**:
```php
<?= $this->block_service->electronic_form_right_menu('eform2'); ?>
```

### 會員專區側邊欄

**檔案**: `views/helper/member_right_menu.php`

**主要功能選單**:
- 檢視購物車
- 訂單查詢
- 型錄下載
- 表單下載
- ARSOA Ai
- 權益規範
- 組織專區

**表單專區子選單**:
- 表單個人資料維護
- 個人體測檢量記錄表
- 鶴力晶 體驗服務表
- 肌膚諮詢記錄表

**問卷專區子選單**:
- 產品體驗
- 電訪紀錄
- 諮詢紀錄
- 試用品

**線上表單子選單**:
- 安露莎信用卡付款授權書 (限特定會員)

### 管理員功能側邊欄

**檔案**: `views/helper/admin_right_menu.php`

根據管理員權限顯示不同功能：

**獎金資料查詢**:
- 月份獎金明細查詢
- 歷史獎金明細查詢

**組織業績查詢**:
- 月份組織業績查詢
- 個人歷史業績查詢
- 會員訂購品項查詢
- 建議售價查詢
- 赴日研修顆星
- 組織宅配訂單查詢

**組織基本資料**:
- 直接推薦資料查詢
- 組織人數統計查詢
- 歷史組織人數查詢
- 月份晉升名單查詢

**產品銷售分析**:
- 期間產品統計查詢
- 年度進貨資料查詢

**固定功能項目**:
- 教育訓練情報
- ARSOA NEWS 月刊
- 表格下載列印
- 商德規範

## 3. Service層整合

### Block Service (`service/block_service.php`)

Block Service 是側邊欄系統的核心服務層：

```php
class Block_service extends CI_Model {
    
    // 電子表單右側選單
    public function electronic_form_right_menu($now_page) {
        $data = array('now_page' => $now_page);
        return $this->load->view('helper/electronic_form_right_menu', $data, TRUE);
    }
    
    // 會員右側分類選單
    public function member_right_prdclass() {
        $data = array();
        return $this->load->view('helper/member_right_prdclass', $data, TRUE);
    }
    
    // 說明選單
    public function help_menu($active = '') {
        $data = array('active' => $active);
        return $this->load->view('helper/help_menu', $data, TRUE);
    }
    
    // 管理者左側功能
    public function admin_left($admin_type) {
        $data['XmlDoc'] = $this->XmlDoc;         
        $data['admin_type'] = $admin_type;     
        return $this->load->view('admin/admin_left', $data, TRUE);
    }
    
    // XML文件載入
    public function PF_LoadXmlDoc($XmlFile) {
        $XmlFile = APPPATH."config/".$XmlFile;
        if (file_exists($XmlFile)){
            $xml=simplexml_load_file($XmlFile) or die ("格式錯誤!");
            return $xml;
        }
    }
}
```

## 4. 配置維護指南

### 4.1 新增XML選單項目

1. **在 `config/setup.xml` 中新增選單**:

```xml
<選單 主選單名稱="新功能" 主編號="X" lnr="lnr-cog">
    <SND 權限檢查="1">
        <權限>2</權限>
    </SND>
    <KIND 權限檢查="1">
        <資料>子功能1</資料>
        <傳回值>X001</傳回值>
        <網址>controller/method/X001</網址>
        <層級>2</層級>
        <權限>2</權限>
    </KIND>
</選單>
```

2. **對應建立Controller方法**:

```php
public function method($kind = '') {
    // 功能實作
}
```

### 4.2 修改硬編碼選單

1. **編輯對應的helper檔案**:

```php
// 在 views/helper/electronic_form_right_menu.php 中新增
<a href="eform6" class="btn btn-outline-secondary btn-block <?php if ($now_page == 'eform6'){ echo 'active'; }?>">新表單</a>
```

2. **在Controller中新增對應方法**:

```php
public function eform6() {
    $data = array(
        'userdata' => $this->userdata,
        'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
    );
    $this->load->view('eeform/eform06', $data);
}
```

### 4.3 權限設定最佳實務

1. **權限層級規劃**:
   - 999: 系統管理員 (所有功能)
   - 50: 專門功能管理員 (如LINE管理)
   - 2: 一般管理員 (基本管理功能)
   - 0: 停用狀態

2. **權限檢查機制**:
```xml
<KIND 權限檢查="1">
    <!-- 設定最低權限等級 -->
    <權限>2</權限>
    
    <!-- 可選：禁止特定權限等級 -->
    <禁權限>50</禁權限>
</KIND>
```

### 4.4 故障排除指南

1. **選單不顯示**:
   - 檢查權限等級設定
   - 確認XML語法正確
   - 驗證Controller路由存在

2. **權限錯誤**:
   - 檢查session中的admin_status
   - 確認XML中權限設定正確
   - 驗證權限檢查邏輯

3. **頁面載入錯誤**:
   - 確認Controller方法存在
   - 檢查View檔案路徑
   - 驗證路由設定

## 5. 系統架構圖

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   setup.xml     │    │  Helper Views   │    │   Controllers   │
│  (XML配置)      │    │   (硬編碼)      │    │                 │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └─────────┐    ┌────────┘             ┌────────┘
                   │    │                      │
                   ▼    ▼                      ▼
            ┌─────────────────────────────────────────┐
            │         Block Service                   │
            │    (service/block_service.php)         │
            └─────────────────────────────────────────┘
                              │
                              ▼
            ┌─────────────────────────────────────────┐
            │         MY_Controller                   │
            │      (core/MY_Controller.php)          │
            └─────────────────────────────────────────┘
                              │
                              ▼
            ┌─────────────────────────────────────────┐
            │         各個頁面View                    │
            │     渲染對應的側邊欄選單                │
            └─────────────────────────────────────────┘
```

## 6. 實際使用範例

### 範例1: 在電子表單頁面中使用側邊欄

```php
// 在 controllers/Eform.php 中
public function eform2() {
    $data = array(
        'userdata' => $this->userdata,
        'apiUrl' => $this->apiBaseUrl . $this->router->fetch_method() . '/submit'
    );
    $this->load->view('eeform/eform02', $data);
}

// 在 views/eeform/eform02.php 中
<aside role="complementary" class="aside col-xl-3 col-md-3 mb130">
    <?= $this->block_service->electronic_form_right_menu('eform2'); ?>
</aside>
```

### 範例2: 在管理後台中使用XML選單

```php
// 在管理Controller中
$data['XmlDoc'] = $this->XmlDoc;
$data['admin_type'] = $this->session->userdata('admin_session')['admin_type'];
$this->load->view('admin/admin_left', $data);
```

### 範例3: 新增帶子選單的XML配置

```xml
<選單 主選單名稱="測試功能" 主編號="T" lnr="lnr-question-circle">
    <SND 權限檢查="1">
        <權限>2</權限>
    </SND>
    <KIND 權限檢查="1">
        <資料>功能設定</資料>
        <傳回值>T001</傳回值>
        <網址>test/list/T001</網址>
        <層級>2</層級>
        <權限>2</權限>
    </KIND>
    <KIND 權限檢查="1">
        <資料>數據查看</資料>
        <傳回值>T002</傳回值>
        <網址>test/data/T002</網址>
        <層級>1</層級>
        <權限>50</權限>
    </KIND>
</選單>
```

## 總結

本專案的側邊欄配置系統採用雙重架構設計：

- **XML配置系統**提供靈活的權限控制和動態選單生成，適用於複雜的管理後台
- **硬編碼配置系統**提供穩定可靠的選單結構，適用於用戶前台功能

兩套系統各有優勢，XML系統適合需要頻繁調整權限和選單的管理功能，而硬編碼系統適合相對固定的用戶功能選單。通過Block Service統一管理，確保了整個系統的一致性和可維護性。