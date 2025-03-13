<?php
/*
 *  抽獎
 */
class Lottery_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'ap_lottery';
    }
    
    // 取資料 - 單筆
    public function find_one($key,$val, $preview = FALSE)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from($this->table);
        $this->db->where($key, $val);
        if (!$preview){
            $this->db->where('status', 'Y');
        }
        $result = $this->db->get()->result_array();               
        
        return (count($result) > 0) ? $result[0] : array();
    }
                 
    // 判斷是否已申請過
    public function charge_check($id,$user_id)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('*');
        $this->db->from('ap_lottery_charge');
        $this->db->where('lot_id', $id);
        $this->db->where('user_id', $user_id);        
        $this->db->order_by( 'lot_id','desc' );        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    public function charge_find_one($key,$val)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from('ap_lottery_charge');
        $this->db->where($key, $val);
        $result = $this->db->get()->result_array();                
        return (count($result) > 0) ? $result[0] : array();
    }
    
    public function charge_last_data($lot_id,$user_id)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('*');
        $this->db->from('ap_lottery_charge');        
        $this->db->where('lot_id', $lot_id);        
        $this->db->where('user_id', $user_id);        
        $this->db->order_by( 'id','desc' );        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    public function charge_last_lot_key_data($lot_id,$user_id,$lot_key)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('*');
        $this->db->from('ap_lottery_charge');        
        $this->db->where('lot_id', $lot_id);        
        $this->db->where('user_id', $user_id);        
        $this->db->where('lot_key', $lot_key);  
        $this->db->order_by( 'id','desc' );        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    // 判斷是否已申請過 姓名+生日
    public function charge_check_name_bday($id,$uname,$bday)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('*');
        $this->db->from('ap_lottery_charge');
        $this->db->where('lot_id', $id);
        $this->db->where('uname', $uname);        
        $this->db->where('bday', $bday);        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    // 日期的變更
    public function charge_update_date_data($id,$field,$data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('id', $id);
        $this->db_master->where($field.' is null', null, false);        
        return ($this->db_master->update('ap_lottery_charge', $data)) ? true : false;
    }
    
    // 修改
    public function charge_update_data($id, $data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('id', $id);
        return ($this->db_master->update('ap_lottery_charge', $data)) ? true : false;
    }
    
    
    public function charge_find_count($lot_id,$s_type,$status = '')
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_lottery_charge');
        $this->db->where('lot_id', $lot_id);        
        $this->db->where('status', $s_type);        
        if ($status == 'Y'){
            $this->db->where('status', 'Y');
        }
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function charge_find_dis_count($lot_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(distinct user_id) as cnt');
        $this->db->from('ap_lottery_charge');
        $this->db->where('lot_id', $lot_id);        
        $this->db->where('status != ', 'N');                
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function charge_find_use_count($lot_id,$lot_key)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_lottery_charge');
        $this->db->where('lot_id', $lot_id);        
        $this->db->where('lot_key', $lot_key);        
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }   
    
    public function charge_disable_count($lot_id,$status = '')
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(distinct a.user_id) as cnt');    	  
        $this->db->from('ap_lottery_charge a');
        $this->db->join( 'line_user u', 'a.user_id = u.user_id');
        $this->db->where('a.lot_id', $lot_id);        
        $this->db->where('u.follow', 'disable');  
        if ($status == 'Y'){
            $this->db->where('a.status', 'Y');
        }      
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );        
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');
        $db->join( 'member m', 'm.c_no = a.referrer_c_no','left');
        $db->join( 'ap_lottery s', 'a.lot_id = s.lot_id','left');
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $db->where_in( $key, $val );
                } else {
                    $db->where( $key, $val );
                }
            }
        }
        if ( is_array( $like ) && sizeof( $like ) > 0 ) {
                $this->db->group_start();
                foreach ( $like as $key => $val ) {
                    $db->or_like( $key, $val );
                }
                $this->db->group_end();
        }
        
        $db1 = clone $db;
        $db1->select( 'count(*) as cnt' );         
        
        $query = $db1->get();
        $row = $query->row_array();
        $query->free_result();
        $total = $row['cnt'];
        
        $PageCount = ceil($total/$PageSize);
        
        $Page = ($PageCount > $Page) ? $Page : $PageCount;  /* 當所要的頁數大於總頁數,就提供總頁數即可 */
                
        if ($Page==0){$Page=1;}
			  $sysPageCut=ceil(($Page-1)*$PageSize); 
					        
        $db->select( 'a.*,u.picture_url,u.display_name,u.follow,u.last_insteractive,m.c_name as member_c_name,s.s_title ' );                        
        //if ( is_array( $limit ) && sizeof( $limit ) == 2 ) {
            $db->limit( $PageSize, $sysPageCut );
        //}
        if ( is_array( $order_by ) ) {
            foreach ( $order_by as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $db->order_by( $val );
                } else {
                    $db->order_by( $key, $val );
                }
            }
        }
        $query = $db->get();
        $rows = $query->result_array();
        //echo "<pre>".print_r($db->last_query(), true)."</pre>";
             //    exit;
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
    
    // 自動編號
    public function insert_id()
    {
        return $this->db_master->insert_id();
    }
        
    public function charge_page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array())
    {
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );                                
        $db->join( 'ap_lottery s', 's.lot_id = a.lot_id');
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');        
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $db->where_in( $key, $val );
                } else {
                    $db->where( $key, $val );
                }
            }
        }
        if ( is_array( $like ) && sizeof( $like ) > 0 ) {
                $this->db->group_start();
                foreach ( $like as $key => $val ) {
                    $db->or_like( $key, $val );
                }
                $this->db->group_end();
        }
        
        $db1 = clone $db;
        $db1->select( 'count(*) as cnt' );         
        
        $query = $db1->get();
        $row = $query->row_array();
        $query->free_result();
        $total = $row['cnt'];
        
        $PageCount = ceil($total/$PageSize);
        
        $Page = ($PageCount > $Page) ? $Page : $PageCount;  /* 當所要的頁數大於總頁數,就提供總頁數即可 */
                
        if ($Page==0){$Page=1;}
			  $sysPageCut=ceil(($Page-1)*$PageSize); 
					        
        $db->select( 'a.*,u.picture_url,u.display_name,u.follow,u.last_insteractive,s.lot_title as lot_title_main,s.lot_config ' );                        
        //if ( is_array( $limit ) && sizeof( $limit ) == 2 ) {
            $db->limit( $PageSize, $sysPageCut );
        //}
        if ( is_array( $order_by ) ) {
            foreach ( $order_by as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $db->order_by( $val );
                } else {
                    $db->order_by( $key, $val );
                }
            }
        }
        $query = $db->get();
        $rows = $query->result_array();
     //   echo "<pre>".print_r($db->last_query(), true)."</pre>";
       //         exit;
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
    
    public function excel_data($id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $sql = "SELECT a.id,a.user_id,a.display_name,
    	                 (a.lot_key+1) as lot_key,a.lot_title,a.c_no,a.name,a.mobile,a.postal,a.address,a.lot_dt
                 FROM ap_lottery_charge a
                 WHERE `a`.`lot_id` = ?
                 AND `a`.`status` = 'Y'
                 ORDER BY `a`.`id` ASC";
        $query = $this->db->query($sql,array($id));
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
       
    }        
             
    // 檢查申請試用包是否為會員
    public function ms_chknamebdate($msconn,$cname,$bdate,$tel)
    {        
        $data = array();        
        $spkey = 'ww_chknamebdate'.$cname.''.$bdate.''.$tel;
        if ($msconn == ''){
        	  $where  = array ('c_no' => 'sample', 'spkey' => $spkey);      
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_chknamebdate(?,?,?)}";            
            $params = [ 
                    		[$cname,  SQLSRV_PARAM_IN],
                    		[$bdate,  SQLSRV_PARAM_IN],
                    		[$tel,  SQLSRV_PARAM_IN],
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data[0];                                      
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){             	
                 $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'sample','spkey' => $spkey));                        
                 $this->db->insert('ap_ms_data', array('c_no'=>'sample','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                        
            }
        }        
        return $data;    	  
    }  
    
     // 判斷 SP 是否可過
    public function ms_s_check($msconn,$lot_id,$user_id,$referrer_c_no)
    {
        $data = array();
        $bdate = date('Y/m/d',strtotime($bdate));
        $spkey = 'ww_s_check'.$name.$bdate;
        if ($msconn == ''){
        	  $where  = array ('c_no' => 'sample', 'spkey' => $spkey);      
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_s_check(?,?,?)}";            
            $params = [ 
                    		[$lot_id,  SQLSRV_PARAM_IN],
                    		[$user_id,  SQLSRV_PARAM_IN], 
                    		[$referrer_c_no,  SQLSRV_PARAM_IN], 
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data[0];                   
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){             	
                 $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'sample','spkey' => $spkey));                        
                 $this->db->insert('ap_ms_data', array('c_no'=>'sample','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                        
            }
        }        
        return $data;    	  
    }  
    
    public function partners_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array())
    {
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );                        
        $db->join( 'ap_question_reply r', 'r.user_id = a.user_id and r.p_no = a.lot_id and r.c_type = "S" ','left');        
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $db->where_in( $key, $val );
                } else {
                    $db->where( $key, $val );
                }
            }
        }
        if ( is_array( $like ) && sizeof( $like ) > 0 ) {
                $this->db->group_start();
                foreach ( $like as $key => $val ) {
                    $db->or_like( $key, $val );
                }
                $this->db->group_end();
        }
        
        
        
        $db1 = clone $db;
        $db1->select( 'count(distinct a.user_id) as cnt' );         
        
        $query = $db1->get();
        $row = $query->row_array();
     
        $query->free_result();
        $total = $row['cnt'];
    
        $PageCount = ceil($total/$PageSize);
        
        $Page = ($PageCount > $Page) ? $Page : $PageCount;  /* 當所要的頁數大於總頁數,就提供總頁數即可 */
                
        if ($Page==0){$Page=1;}
			  $sysPageCut=ceil(($Page-1)*$PageSize); 
					        
        $db->select( 'a.lot_id,a.user_id,a.uname,a.tel,a.outdt,a.send_date,a.last_rid,max(r.okdt) as okdt,count(r.rid) as send_num,sum(case when r.`status` = \'Y\' then 1 else 0 end) as ok_num ' );
        //if ( is_array( $limit ) && sizeof( $limit ) == 2 ) {
            $db->limit( $PageSize, $sysPageCut );
        //}
        
        if( ! empty($group_by) && is_array($group_by)) {
			      foreach($group_by as $value) {
				            $db->group_by($value);
			      }
		    }
       
        if ( is_array( $order_by ) ) {
            foreach ( $order_by as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $db->order_by( $val );
                } else {
                    $db->order_by( $key, $val );
                }
            }
        }
        $query = $db->get();
        $rows = $query->result_array();

        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
}