<?php
class Form5Model extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data)
    {
        $data['create_at'] = date('Y-m-d H:i:s');
        // $sql = $this->db->set($data)->get_compiled_insert('eform5_main');
        $this->db->insert('eform5_main', $data);

        return true;
    }

    // 格式化信用卡資料
    public function fetchCreditCardDataFormat($data)
    {
        return array(
            'card_type' => $data['cardType'],
            'number' => $data['creditCardNumber'],
            'month' => $data['creditCardExpireMonth'],
            'year' => $data['creditCardExpireYear'],
            'bank' => $data['creditCardBank'],
            'three_code' => $data['creditCardCvv'],
            'english_name' => $data['creditCardEnglishName'],
        );
    }

    /**
     * 取得最新的序號
     * @param string $c_code 會員編號
     * @return void
     */
    public function fetchLatestForm5SerialNumber($c_code = '')
    {
        $form5Data = $this->db->from('eform5_main as m')
            ->join('eform_file as f', 'm.image_id = f.id')
            ->where('m.c_name', $c_code)
            ->order_by('m.image_id', 'desc')
            ->limit(1)
            ->get()
            ->row_array();

        if (empty($form5Data)) {
            return 1;
        }

        $path = $form5Data['path'];

        // 取出路徑最後一段檔名
        $fileName = basename($path);
        
        // 分離副檔名取得序號部分
        $fileNameExceptExt = explode('.', $fileName)[0];

        // 判斷分隔符號是底線還是連字號
        $separator = strpos($fileNameExceptExt, '_') !== false ? '_' : '-';

        // 取會員編號後的字串為序號
        $serialNumber = explode($separator, $fileNameExceptExt)[1];

        $serialNumber = (strlen($serialNumber) == 17) ? 1 : $serialNumber + 1;
        
        return $serialNumber;
    }
}