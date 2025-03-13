<?php
/*
 *  產品體驗管理
 */
class Question_prd_set_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'ap_question_prd_set';
    }
        
    public function order_find_count($p_id,$send = 'N')
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_member_order_his');
        $this->db->where('p_id', $p_id);   
        if ($send == 'Y'){
            $this->db->where('send_num >',0);   	
        }        
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function question_reply_send_find_count($p_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(distinct a.c_no) as cnt');    	  
        $this->db->from('ap_question_reply a');        
        $this->db->where('a.c_type', 'P');        
        $this->db->where('a.p_no', $p_id);                
        $this->db->where('a.status', 'Y');
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function product_reply_send_find_count($p_id,$c_no)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');    	  
        $this->db->from('ap_question_reply a');        
        $this->db->where('a.c_type', 'P');        
        $this->db->where('a.p_no', $p_id);
        $this->db->where('a.c_no', $c_no);
        $this->db->where('a.status', 'Y');
        $result = $this->db->get()->row_array();               
        return $result['cnt'];
    }
    
    public function product_reply_send_find_qid_count($p_id,$c_no,$q_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');    	  
        $this->db->from('ap_question_reply a');        
        $this->db->where('a.c_type', 'P');        
        $this->db->where('a.p_no', $p_id);
        $this->db->where('a.c_no', $c_no);
        $this->db->where('a.q_id', $q_id);
        $this->db->where('a.status', 'Y');
        $result = $this->db->get()->row_array();               
        return $result['cnt'];
    }
    
    public function product_reply_send_find_one($p_id,$c_no,$q_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('*');    	  
        $this->db->from('ap_question_reply a');        
        $this->db->where('a.c_type', 'P');        
        $this->db->where('a.p_no', $p_id);
        $this->db->where('a.c_no', $c_no);
        $this->db->where('a.q_id', $q_id);
        $this->db->where('a.status', 'Y');        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }
    
    public function reply_page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array())
    {
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );                
        $db->join( 'member m', 'm.c_no = a.c_no','left');
        $db->join( 'member_line l', 'l.c_no = a.c_no','left');
        $db->join( 'ap_question_prd_set q', 'q.p_id = a.p_id','left');
        $db->join( 'line_user u', 'l.user_id = u.user_id','left');
        //$db->join( 'ap_member_order_his h', 'h.p_no = a.p_no and h.c_no = a.c_no','left');
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
					        
        $db->select( 'a.*,u.user_id,u.picture_url,u.display_name,u.follow,u.last_insteractive,m.d_pos,m.d_posn,m.is_org,m.c_name as member_c_name,m.cell1,m.cell2,m.sex,m.mb_status,q.p_name,q.line_push,u1.c_no as p_c_no,u1.c_name as p_u_name,u1.d_pos as p_d_pos ' );                        
        $db->join( 'member u1', 'u1.c_no = m.d_spno','left');
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
       
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
    
    
    public function page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );        
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');
        $db->join( 'member m', 'm.c_no = a.referrer_c_no','left');
        $db->join( 'ap_sample s', 'a.s_id = s.s_id','left');
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
        $db->join( 'member m', 'm.c_no = a.referrer_c_no','left');
        $db->join( 'ap_sample s', 's.s_id = a.s_id');
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
    	  $sql = "SELECT a.id,a.user_id,a.display_name,case a.s_type when 'S' then '業務' when 'I' then 'IG' when 'F' then 'FB' when 'L' then 'Line' end as s_tyle,
    	                 a.referrer_c_no,a.referrer_name,a.uname,a.sex,a.bday,a.tel,a.postal,a.address,a.sel_sample,a.crdt,a.outdt
                 FROM ap_sample_charge a
                 LEFT JOIN member m ON `m`.`c_no` = `a`.`referrer_c_no`
                 JOIN ap_sample s ON `s`.`s_id` = `a`.`s_id`
                 LEFT JOIN line_user u ON `a`.`user_id` = `u`.`user_id`
                 WHERE `a`.`s_id` = ?
                 AND `a`.`status` <> 'D'
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
    public function ms_s_check($msconn,$s_id,$user_id,$referrer_c_no)
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
                    		[$s_id,  SQLSRV_PARAM_IN],
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
        $db->join( 'ap_question_reply r', 'r.user_id = a.user_id and r.p_no = a.s_id and r.c_type = "S" ','left');        
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
					        
        $db->select( 'a.s_id,a.user_id,a.uname,a.tel,a.outdt,a.send_date,a.last_rid,max(r.okdt) as okdt,count(r.rid) as send_num,sum(case when r.`status` = \'Y\' then 1 else 0 end) as ok_num ' );
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
    
    public function order_his_find_count($p_id,$c_no)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_member_order_his');
        $this->db->where('p_id', $p_id);
        $this->db->where('c_no', $c_no);
        $result = $this->db->get()->row_array();                
        return $result['cnt'];
    }
}