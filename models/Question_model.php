<?php
/*
 *  問卷資料
 */
class Question_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'ap_question';
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
        
    // 新增
    public function reply_insert_data($data)
    {
        $data['crdt']   = date('Y-m-d H:i:s');        
        $this->db_master = $this->load->database('default', true);
        return ($this->db_master->insert('ap_question_reply', $data)) ? true : false;
    }
    
      // 自動編號
    public function reply_insert_id()
    {
        return $this->db_master->insert_id();
    }
     
    // 取資料 - 單筆
    public function reply_find_one($key,$val,$status = 'Y')
    {
        $this->db = $this->load->database('default', true);
        $this->db->from('ap_question_reply');
        $this->db->where($key, $val);
        if ($status == 'Y'){
            $this->db->where('status', 'Y');    
        }
        $result = $this->db->get()->result_array();        
        return (count($result) > 0) ? $result[0] : array();
    }
    
    public function activity_find_one($act_id,$user_id,$p_num)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from('ap_question_reply');
        $this->db->where('c_type','A');
        $this->db->where('p_no', $act_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('p_num', $p_num);        
        $result = $this->db->get()->result_array();        
        return (count($result) > 0) ? $result[0] : array();
    }
        
    // 判斷是否填寫過
    public function check_reply_form($q_id,$user_id)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('rid,status,reply,okdt,checkcode,crdt,c_type,p_no');
        $this->db->from('ap_question_reply');
        $this->db->where('q_id', $q_id);
        $this->db->where('user_id', $user_id);        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    public function reply_find_count($q_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_question_reply');
        $this->db->where('q_id', $q_id);        
        $this->db->where('status', 'Y');
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function activity_reply_find_count($act_id,$q_id,$p_num,$status)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_question_reply');
        $this->db->where('c_type', 'A');
        $this->db->where('p_no', $act_id);        
        $this->db->where('q_id', $q_id);        
        $this->db->where('p_num', $p_num); 
        if ($status != 'ALL'){       
            $this->db->where('status', $status );
        }
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    public function reply_find_all_count($q_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_question_reply');
        $this->db->where('q_id', $q_id);
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
    
    // 修改
    public function reply_update_data($id, $data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('rid', $id);
        return ($this->db_master->update('ap_question_reply', $data)) ? true : false;
    }
    
    // 日期的變更
    public function reply_update_date_data($id,$field,$data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('rid', $id);
        $this->db_master->where($field.' is null', null, false);        
        return ($this->db_master->update('ap_question_reply', $data)) ? true : false;
    }
    
    public function page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );        
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');
        $db->join( 'member m', 'm.c_no = a.c_no','left');
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
					        
        $db->select( 'a.*,u.picture_url,u.display_name,u.follow,u.last_insteractive,m.d_pos,m.d_posn,m.is_org,m.c_name as member_c_name,m.cell1,m.cell2,m.sex,m.mb_status ' );                        
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


    
    public function partners_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array())
    {
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );                
        $db->join( 'ap_member_order_his h', 'h.c_no = a.c_no ');
        $db->join( 'ap_question_reply r', 'r.c_no = a.c_no and r.p_no = h.p_id ','left');        
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
        $db1->select( 'count(distinct h.c_no) as cnt' );         
        
        $query = $db1->get();
        $row = $query->row_array();
     
        $query->free_result();
        $total = $row['cnt'];
    
        $PageCount = ceil($total/$PageSize);
        
        $Page = ($PageCount > $Page) ? $Page : $PageCount;  /* 當所要的頁數大於總頁數,就提供總頁數即可 */
                
        if ($Page==0){$Page=1;}
			  $sysPageCut=ceil(($Page-1)*$PageSize); 
					        
        $db->select( 'a.c_no,a.c_name,h.buy_date,h.send_date,h.last_rid,max(r.okdt) as okdt,count(r.rid) as send_num,sum(case when r.`status` = \'Y\' then 1 else 0 end) as ok_num ' );
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
        //echo "<pre>".print_r($this->db->last_query(), true)."</pre>";
        //exit;
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }
        
    public function find_reply_list($c_type,$id,$p_no,$show_web = 'A')
    {
    	  $this->db = $this->load->database('default', true);    	  
        $this->db->from('ap_question_reply');
        $this->db->where('c_type', $c_type);
        if ($c_type == 'S'){
        	  $this->db->where('user_id', trim($id));
        }else{
            $this->db->where('c_no', trim($id));
        }
        $this->db->where('p_no', $p_no);              
        if ($show_web != 'A'){    
            $this->db->where('show_web', $show_web);
        }
        $this->db->order_by('crdt', 'asc');
        $result = $this->db->get()->result_array();               
        return (count($result) > 0) ? $result : array();
    }
    
    public function excel_data($q_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $sql = "SELECT a.rid,a.user_id,a.display_name,a.c_no,a.c_name,a.okdt,a.reply
                 FROM ap_question_reply a
                 WHERE a.q_id = ?        
                 and status = 'Y'         
                 ORDER BY a.okdt ASC";
        $query = $this->db->query($sql,array($q_id));
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
       
    }        
    
}