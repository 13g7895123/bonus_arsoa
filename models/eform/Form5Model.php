<?php
class Form5Model extends CommonModel
{

    function __construct()
    {
        parent::__construct();
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
}