<?php
/*
 *  LINE群組貼標訊息傳送
 */
class Line_ta_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'line_ta';
    }
      
    public function find_count($ta_id,$status)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('count(*) as cnt');
        $this->db->from('line_ta_member');
        $this->db->where('ta_id', $ta_id);        
        $this->db->where('status',$status);
        $result = $this->db->get()->row_array();        
        return $result['cnt'];
    } 
    
    public function find_list_all($ta_id)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('t.*,m.user_id as member_user_id ');
    	  $this->db->join( 'member_line m', 'm.c_no = t.c_no','left');
        $this->db->from('line_ta_member t');
        $this->db->where('t.ta_id', $ta_id);        
        $result = $this->db->get()->result_array();                        
        return (count($result) > 0) ? $result : array();
    }    
           
    public function find_list($ta_id,$status)
    {
    	  $this->db = $this->load->database('default', true);
    	  $this->db->select('t.*,m.user_id as member_user_id ');
    	  $this->db->join( 'member_line m', 'm.c_no = t.c_no','left');
        $this->db->from('line_ta_member t');
        $this->db->where('t.ta_id', $ta_id);        
        $this->db->where('t.status',$status);        
        $result = $this->db->get()->result_array();                        
        return (count($result) > 0) ? $result : array();
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
}