<?php
class CompleteModel extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    // 取得會員簽名圖片
    public function getSignatureImage($session, $cookie)
    {
        $joinData = $this->db->select('signature_id')
            ->from('ap_member_join_new')
            ->where('session_id', $session)
            ->where('cookie_key', $cookie)
            ->get()
            ->row_array();

        if (empty($joinData)) {
            return false;
        }

        $fileData = $this->db->from('eform_file')
            ->where('id', $joinData['signature_id'])
            ->get()
            ->row_array();

        if (empty($fileData)) {
            return false;
        }

        return $fileData['path'];
    }

    /** 
     * 儲存成PDF
     * @param string $memberCode 會員編號
     * @return void
     */
    public function savePdf($memberCode, $data)
    {
        // 引入PDF
        require_once APPPATH.'third_party/tcpdf/tcpdf.php';
        $this->load->library('tcpdf');

        $pdf = new TCPDF(); // 創建一個TCPDF實例

        $pdf->SetCreator(FC_Web);
        $pdf->SetAuthor(FC_Web);
        $pdf->SetTitle($memberCode . '_' . date('Ymd_His'));
        $pdf->SetSubject($memberCode . '_' . date('Ymd_His'));

        $data['title'] = $memberCode . '_' . date('Ymd_His');
        // $html = $this->load->view('member_join/step_complete', $data, true); // 轉換 View 為 HTML

        $css = file_get_contents(APPPATH . 'public/css/pdf.css');
        $filename = $memberCode . '_' . date('Ymd_His') . '.pdf';
        $savePath = APPPATH . 'public/func/eform/member_join/' . $filename;

        $pdf->AddPage();
        $pdf->SetFont('msungstdlight', '', 12);

        $html = "<style>$css</style>";
        $html .= $this->getInputData($memberCode, $data);   // 登錄資料
        $html .= '<br><br>';
        $html .= $this->getOrderData($data);                // 訂單資訊
        $html .= '<br><br>';
        $html .= $this->getSignature();                     // 簽名

        $pdf->writeHTML($html, true, false, true, false, '');

        // 簽名圖片
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // 取得頁面寬度（含邊界）
        $pageWidth = $pdf->getPageWidth();
        $marginLeft = $pdf->getMargins()['left'];
        $marginRight = $pdf->getMargins()['right'];

        // 計算圖片最大可用寬度
        $imageWidth = $pageWidth - $marginLeft - $marginRight;

        $imageFile = APPPATH . $data['signature'];
        $pdf->Image($imageFile, $marginLeft, $y - 5, $imageWidth, 20, '', '', '', false, 300);

        $pdf->Output($savePath, 'F');
    }

    // 登錄資料
    private function getInputData($memberCode, $data)
    {
        $sex = $data['order_detail']['main']['sex'] == 'M' ? '男' : '女';

        $html = '<table border="1" cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td colspan='4'>登錄資料</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td colspan='4'>會員編號: {$memberCode}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td>姓名: {$data['order_detail']['main']['uname']}</td>";
        $html .= "<td>性別: {$sex}</td>";
        $html .= "<td>身份證字號: {$data['order_detail']['main']['idno']}</td>";
        $html .= "<td>生日: {$data['order_detail']['main']['bday']}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td>連絡電話: {$data['order_detail']['main']['tel']}</td>";
        $html .= "<td>E-mail: {$data['order_detail']['main']['email']}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td colspan='4'>通訊地址: {$data['order_detail']['main']['postal']} {$data['order_detail']['main']['address']}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<table cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td>推薦人姓名: {$data['order_detail']['main']['referrer_name']}</td>";
        $html .= "<td>推薦人編號: {$data['order_detail']['main']['referrer_c_no']}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    // 訂單資訊
    private function getOrderData($data)
    {
        $html = '<table border="1" cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td colspan='4'>訂單資訊</td>";
        $html .= '</tr>';
        $html .= '</table>';

        $html .= '<br><br>';

        $html .= '<table border="1" cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td>品名</td>";
        $html .= "<td>建議售價</td>";
        $html .= "<td>數量</td>";
        $html .= "<td>金額</td>";
        $html .= '</tr>';

        foreach ($data['order_detail']['prd'] as $_val) {
            $html .= '<tr>';
            $html .= "<td>{$_val['p_name']}</td>";
            $html .= "<td>{$_val['r_price']}</td>";
            $html .= "<td>{$_val['qty']}</td>";
            $html .= "<td>{$_val['a_amt']}</td>";
            $html .= '</tr>';
        }

        $html .= '</table>';

        $html .= '<table border="1" cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td>總額</td>";
        $html .= "<td>-</td>";
        $html .= "<td>-</td>";
        $html .= "<td>{$data['order_detail']['main']['a_amt']}</td>";
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    // 簽名
    private function getSignature()
    {
        $html = '<table border="1" cellpadding="4">';
        $html .= '<tr>';
        $html .= "<td colspan='4'>會員簽名</td>";
        $html .= '</tr>';
        $html .= '</table>';

        return $html;
    }

    public function sendSms($mobile='', $message='')
    {
        if (empty($mobile) || empty($message)) {
            echo json_encode(["status" => "error", "message" => "手機號碼和訊息內容不得為空"]);
            return false;
        }

        // 發送參數
        $params = [
            'username' => $this->smsConfig('username'),
            'password' => $this->smsConfig('password'),
            'dstaddr'  => $mobile,
            'encoding' => 'BIG5', // 可改為 UCS2（簡體）或 ASCII
            'smbody'   => $message,
            'rtype'    => 'JSON'
        ];

        // 發送 API 請求
        $response = $this->sendRequest($this->smsConfig('api_url'), $params);

        // 記錄簡訊發送結果
        $this->smsLog($mobile, $message, json_encode($response));
        
        return true;
    }

    private function smsConfig($type)
    {
        $config = array(
            'api_url' => 'https://www.smsgo.com.tw/sms_gw/sendsms.aspx',
            'query_url' => 'https://www.smsgo.com.tw/sms_gw/query.aspx',
            'balance_url' => 'https://www.smsgo.com.tw/sms_gw/query_point.aspx',
            'username' => 'arsoa203@arsoa.tw',
            'password' => '0227063111',
        );

        return $config[$type];
    }

    /**
     * 發送 HTTP GET 請求
     */
    private function sendRequest($url, $data) {
        $query_string = http_build_query($data);
        $full_url = $url . '?' . $query_string;

        $ch = curl_init($full_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 如果是 HTTPS，避免 SSL 問題

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * 簡訊記錄
     * @param string $mobile 手機號碼
     * @param string $message 訊息內容
     * @param string $result 發送結果
     * @return void
     */
    private function smsLog($mobile, $message, $result)
    {
        $this->db->insert('sms_log', [
            'phone' => $mobile,
            'message' => $message,
            'result' => $result,
        ]);
    }
}