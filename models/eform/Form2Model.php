<?php
class Form2Model extends CI_Model
{
    private $db;

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function createData($data)
    {
        $data = $this->formatMainData($data);
        // $sql = $this->db->set($data)->get_compiled_insert('eform2_main');
        // print_r($sql); die();
        $this->db->insert('eform2_main', $data);
        $insertId = $this->db->insert_id(); 

        return $insertId;
    }

    public function formatMainData($data)
    {
        // Boolean轉換
        $data['order_date_check'] = $data['order_date_check'] == 'true' ? 1 : 0;
        $data['use_member_auth'] = $data['use_member_auth'] == 'true' ? 1 : 0;

        // 日期格式轉換
        $data['birth_date'] = $data['birth_year'] . '-' . $data['birth_month'] . '-' . $data['birth_day'];

        $data['auth_date_year'] = $data['auth_date_year'] == '' ? null : $data['auth_date_year'];
        $data['auth_date_month'] = $data['auth_date_month'] == '' ? null : $data['auth_date_month'];
        $data['auth_date_day'] = $data['auth_date_day'] == '' ? null : $data['auth_date_day'];

        if (isset($data['member_id']) === false) {
            $data['member_id'] = '';
        }

        // 刪除不必要的資料
        unset($data['birth_year']);
        unset($data['birth_month']);
        unset($data['birth_day']);
        unset($data['products']);
        unset($data['card_type']);
        unset($data['bank_name']);
        unset($data['card_number']);
        unset($data['card_expiry_month']);
        unset($data['card_expiry_year']);        

        return $data;
    }

    public function createDetailData($data)
    {
        $this->db->insert('eform2_detail', $data);
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
}