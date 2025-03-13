<?php
/**
 * Class Front_captcha_model
 * 驗證碼
 */
class Front_captcha_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->_table_name = 'captcha';
    }

    public function check_captcha( $v_code ) {

        $this->load->library( 'securimage/securimage' );

        return $this->securimage->check( $v_code );
        //        $expiration = time() - 7200; // Two hour limit
        //
        //        $this->db->where( 'captcha_time < ', $expiration )
        //                 ->delete( 'captcha' );
        //
        //        // Then see if a captcha exists:
        //        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        //        $binds = array( $v_code, $this->input->ip_address(), $expiration );
        //        $query = $this->db->query( $sql, $binds );
        //        $row = $query->row();
        //
        //        return ( $row->count == 0 ) ? FALSE : TRUE;
    }
}