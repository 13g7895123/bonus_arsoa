<?php
/*
 *  push_log
 */ 
class Line_push_log extends CI_Model
{
    
    function __construct()
    {
        parent::__construct();

        $this->table = 'line_push_log';
    }
                   
    public function insert_log($user_id,$push_type,$push_id,$push_cont,$http_code,$push_result = '',$db = 'default')
    {
        $push_data  = array(
            'user_id'     => $user_id,
            'push_type'   => $push_type,
            'push_id'     => $push_id,
            'push_cont'   => json_encode($push_cont),
            'http_code'   => $http_code,
            'push_result' => $push_result,
            'cdate'       => date('Y-m-d H:i:s')
        );
        
        $this->db_master = $this->load->database($db, true);
        return ($this->db_master->insert($this->table, $push_data)) ? true : false;
    }
                 
    public function page_list($Swp1,$where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array())
    {
        
        $this->db = $this->load->database('default', true);
        
        $db = $this->db;     
        $db->from( 'line_user u' );        
        if (substr($Swp1,0,1) == 'M'){ // 會員            
            $db->join( $this->table.' a' , 'a.user_id = u.user_id and a.push_type = "member_push"','left');
            $db->join( 'member_line l', 'l.user_id = u.user_id');
            $db->join( 'member m', 'm.c_no = l.c_no');
        }elseif(substr($Swp1,0,1) == 'N'){
        	  $db->join( $this->table.' a' , 'a.user_id = u.user_id  and a.push_type = "member_push"','left');
        	  $db->join( 'member_line l', 'l.user_id = u.user_id','left');
            $db->join( 'member m', 'm.c_no = l.c_no','left');
        	  $db->where("u.user_id NOT IN (select user_id from member_line) ");        	  
        }elseif(substr($Swp1,0,1) == 'A'){
        	  $db->join( $this->table.' a' , 'a.user_id = u.user_id  and a.push_type = "member_push"','left');
        	  $db->join( 'member_line l', 'l.user_id = u.user_id','left');
            $db->join( 'member m', 'm.c_no = l.c_no','left');
        }else{    
        	  $db->join( $this->table.' a' , 'a.user_id = u.user_id  and a.push_type = "member_push"');
        	  $db->join( 'member_line l', 'l.user_id = u.user_id','left');
            $db->join( 'member m', 'm.c_no = l.c_no','left');
        }
						
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
					        
        $db->select( 'a.*,u.user_id as line_user_user_id,u.cdate as line_user_cdate,u.picture_url,u.display_name,u.follow,u.last_insteractive,m.d_pos,m.d_posn,m.is_org,m.c_name as member_c_name,m.c_no as member_c_no,m.cell1,m.cell2,m.sex,m.mb_status ' );                        
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
        //echo "<pre>".print_r($this->db->last_query(), true)."</pre>";
           //      exit;
        $query->free_result();        
        $data = array( 'total' => $total, 'Page' => $Page,'PageCount' => $PageCount, 'rows' => $rows );
        
        unset( $db, $db1 );
        
        return $data;
    }   
}