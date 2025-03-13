<?php
/*
 *  活動
 */
class Activity_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'ap_activity';
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
        $this->db->from('ap_activity_charge');
        $this->db->where('act_id', $id);
        $this->db->where('user_id', $user_id);        
        $result = $this->db->get()->result_array();    
             
        return (count($result) > 0) ? $result[0] : array();
    }    
    
    public function charge_find_one($key,$val)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from('ap_activity_charge');
        $this->db->where($key, $val);
        $result = $this->db->get()->result_array();                
        return (count($result) > 0) ? $result[0] : array();
    }
    
    public function charge_last_data($act_id,$user_id)
    {
        $this->db = $this->load->database('default', true);
        $this->db->select('*');
        $this->db->from('ap_activity_charge');        
        $this->db->where('act_id', $act_id);        
        $this->db->where('user_id', $user_id);        
        $this->db->order_by( 'id','desc' );        
        $result = $this->db->get()->result_array();             
        return (count($result) > 0) ? $result[0] : array();
    }    
        
    // 日期的變更
    public function charge_update_date_data($id,$field,$data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('id', $id);
        $this->db_master->where($field.' is null', null, false);        
        return ($this->db_master->update('ap_activity_charge', $data)) ? true : false;
    }
    
    // 修改
    public function charge_update_data($id, $data)
    {
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('id', $id);
        return ($this->db_master->update('ap_activity_charge', $data)) ? true : false;
    }
    
    
    public function charge_find_reg_type_count($act_id,$reg_type)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('ap_activity_charge');
        $this->db->where('act_id', $act_id);        
        $this->db->where('reg_type', $reg_type);        
        $this->db->where('status', 'Y');                
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    }
        
    public function page_list( $table,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;        
        $db->from( $table.' a' );        
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');
        $db->join( 'member m', 'm.c_no = a.referrer_c_no','left');
        $db->join( 'ap_activity s', 'a.act_id = s.act_id','left');
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
        $db->join( 'ap_activity s', 's.act_id = a.act_id');
        $db->join( 'line_user u', 'a.user_id = u.user_id','left');        
        $db->join( 'member k', 'k.c_no = a.relation_c_no','left');    
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
					        
        $db->select( 'a.*,u.picture_url,u.display_name,u.follow,u.last_insteractive,s.act_title,s.act_end,k.c_name as relation_name ' );                        
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
    	                 a.reg_type,a.c_no,m1.c_name,a.relation_c_no,m2.c_name as relation_c_name,a.reg_dt
                 FROM ap_activity_charge a 
                 join ap_activity s on a.act_id = s.act_id
                 left join member m1 on a.c_no = m1.c_no
                 left join member m2 on a.relation_c_no = m2.c_no                 
                 WHERE `a`.`act_id` = ?
                 AND `a`.`status` = 'Y'
                 ORDER BY `a`.`id` ASC";
        $query = $this->db->query($sql,array($id));
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
       
    }        
             
}