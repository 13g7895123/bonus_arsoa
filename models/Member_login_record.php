<?php
/**
 * Class Member_login_record 
*/
class Member_login_record extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
   
    // 登入記錄
    public function login_record($login_type,$rdurl = '')
    {
    	  if (!empty($this->session->userdata('login_code'))){
    	  	  
    	  	  $this->front_base_model->update_table('ap_member_login_record',array('rdurl' => $rdurl,'login_type' => $login_type),array('login_code='=>$this->session->userdata('login_code')));                              
             	  	
    	  }else{
    	  	  $login_code = md5('login_'.uniqid());
    	  	  
    	  	  $idata = array(
    	  	                'login_type' => $login_type,
    	  	                'login_code' => $login_code,
    	  	                'rdurl'      => trim($rdurl),
    	  	                'ip'         => $this->block_service->client_ip(),
    	  	                'crdt'       => date('Y-m-d H:i:s'),    	  	                
    	  	                );
    	  	  $this->db->insert('ap_member_login_record', $idata);
    	  	  $record_id = $this->db->insert_id();
    	  	  
    	  	  $this->session->set_userdata( 'login_code'    , $login_code );
    	  	  $this->session->set_userdata( 'login_record_id' , $record_id );
    	  }    
    	  return $this->session->userdata('login_code');          
    }
    
     // 取資料 - 單筆
    public function find_one($login_code = '')
    {
    	  if ($login_code == ''){
    	  	  if (!empty($this->session->userdata('login_code'))){
    	  	      $login_code = $this->session->userdata('login_code');
    	  	  }
    	  }
    	  if ($login_code > ''){
            $this->db->select('*');
            $this->db->from('ap_member_login_record');
            $this->db->where('login_code', $this->session->userdata('login_code'));            
            $result = $this->db->get()->result_array();            
            return (count($result) > 0) ? $result[0] : array();
        }
        return array();
    }
        
    
    // 登入成功 update c_no
    public function clear_record()
    {
        if (!empty($this->session->userdata('login_code'))){
            
            $this->front_base_model->update_table('ap_member_login_record',array('c_no' => $this->session->userdata('member_session')['c_no'],"updt" => date('Y-m-d H:i:s')),array('login_code='=>$this->session->userdata('login_code')));                  
            
            $this->session->unset_userdata( 'login_code' );
            $this->session->unset_userdata( 'login_record_id' );

        }
    }
  
}