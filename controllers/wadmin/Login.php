<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_admin_model' );
        
        $this->load->service(array(
            'cache_service'
        ));
        $this->load->library( 'user_agent' );
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function index()
    {
        if ( $this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/main' );
        }
        
        $data_post = $this->input->post( NULL, TRUE );

        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
             
             if ( $data_post['captcha'] > '' && $data_post['account'] > '' && $data_post['password'] > ''){
                 // 先判斷驗證碼     
                 $v_code = $this->input->post( 'captcha' );
                 
                 $this->load->model( 'front_captcha_model' );
                 $v_status = $this->front_captcha_model->check_captcha( $v_code );
                 if ( $v_status === FALSE ) {
                     $this->session->set_flashdata( 'error_message', '認證碼錯誤!' );
                     redirect( 'wadmin/login' );
                 }
                 
                 $this->db->select( '*' )
                      ->from( 'ap_admin' )
                      ->where( 'account', $data_post['account'] )
                      ->where( 'status >', 0 );
                 $result = $this->db->get()->row_array();
                 if ($result){
                     
                     $data = array(
                                   "account" => $data_post['account'],
                                   "password" => $data_post['password'],
                                   "ip" => $this->data['tracking']['ip'],
                                   "crdt" => date('Y-m-d H:i:s')
                              );
                     $rdata = ($this->db->insert('ap_admin_login_log', $data)) ? true : false;
                     if ($rdata){
                         $logid = $this->db->insert_id();
                     }
        
                     if (md5($data_post['password']) == $result['pwd']){
                         $admin_session = array(
                             'admin_id'      => $result['adminid'],
                             'admin_account' => trim($result['account']),
                             'admin_name'    => trim($result['name']),
                             'admin_email'   => trim($result['email']),
                             'admin_status'  => trim($result['status']),
                             'admin_logid'   => $logid
                         );
                   
                         $this->session->set_userdata( 'admin_session', $admin_session );
                         
                         $this->db->where( 'logid', $logid )->update( 'ap_admin_login_log', array('adminid' => $result['adminid']) );
                                                       
                         $this->db->where( 'adminid', $result['adminid'] )->update( 'ap_admin', array('lastlogin_dt' => date('Y-m-d H:i:s')) );
                    
                         redirect( 'wadmin/main' );
                         
                         exit;
                     }
                 }                 
                 $this->session->set_flashdata( 'error_message', '登入失敗!' );
                 redirect( 'wadmin/login' );
            }else{
                 $this->session->set_flashdata( 'error_message', '輸入有誤!' );
                 redirect( 'wadmin/login' );
            }
        }else{
            $data = array(
                'error_message' => $this->session->flashdata( 'error_message' )
            );         
        }
        
        $data['web_page'] = 'login';
        
        $this->layout->view('admin/login', $data);
        
    }
    
}