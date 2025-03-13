<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->service(array(
            'cache_service'
        ));     
    }
    
    public function index()
    {
        
        $admin_session = $this->session->userdata( 'admin_session' );
        
        $this->db->where( 'logid', $admin_session['admin_logid'] )->update( 'ap_admin_login_log', array('logoutdt' => date('Y-m-d H:i:s')) );
                        
        $this->session->unset_userdata( 'admin_session' );
        
        $refer = base_url('wadmin/login');
        
        alert( '您已成功登出！', $refer );            
        
        exit;
    }
    
}