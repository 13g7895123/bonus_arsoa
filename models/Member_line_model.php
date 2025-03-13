<?php
/*
 *  Member_line 資料
 */
class Member_line_model extends CI_Model
{
    private $db;
    private $db_master;
    private $table;

    function __construct()
    {
        parent::__construct();

        $this->table = 'member_line';
    }

    // 新增
    public function insert_data($data)
    {
        $data['cdate']   = date('Y-m-d H:i:s');        
        $this->db_master = $this->load->database('default', true);
        return ($this->db_master->insert($this->table, $data)) ? true : false;
    }

    // 修改
    public function update_data($id, $data,$db = 'default')
    {
        $this->db_master = $this->load->database($db, true);
        $this->db_master->where('bid', $id);
        return ($this->db_master->update($this->table, $data)) ? true : false;
    }

    // 刪除
    public function delete_data($user_id)
    {
        $data['status']  = 'delete';
        $this->db_master = $this->load->database('default', true);
        $this->db_master->where('user_id', $user_id);
        return ($this->db_master->update($this->table, $data)) ? true : false;
    }

    // 取資料 - 單筆
    public function find_one($key,$val,$db = 'default')
    {
        $this->db = $this->load->database($db, true);
        $this->db->from($this->table);
        $this->db->where($key, $val);
        $result = $this->db->get()->result_array();
        return (count($result) > 0) ? $result[0] : array();
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

    /*
     *  條件式查詢
     */
    public function find_all($param = array(), $limit = array(), $order = array(), $where_in = array(), $where_not_in = array())
    {
        self::_query_find_all($param, $where_in, $where_not_in);

        if(!empty($limit) && $limit != 'all') {
            if(is_array($limit)) {
                $this->db->limit($limit[1], $limit[0]);
            }
            else {
                $this->db->limit($limit);
            }
        }

        if(!empty($order) && is_array($order)) {
            foreach($order as $field => $sort) {
                $this->db->order_by($field, $sort);
            }
        }

        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return (count($result) > 0) ? $result : array();
    }

    /*
     *  條件式筆數計算
     */
    public function count_all($param = array(), $where_in = array(), $where_not_in = array())
    {
        self::_query_find_all($param, $where_in, $where_not_in);
        $total = $this->db->count_all_results();
        return $total;
    }

    // 組成sql內容 - find_all, count_all
    private function _query_find_all($param, $where_in, $where_not_in)
    {
        $this->db = $this->load->database('default', true);
        $this->db->from($this->table);

        if(isset($param['select']) && !empty($param['select'])) {
            $this->db->select($param['select']);
            unset($param['select']);
        }

        if(!empty($param)) {
            foreach($param as $key=>$value) {
                if(!empty($value) || $value == '') {
                    if($value === '*notNull') {
                        $this->db->where($key . ' IS NOT NULL', null, false);
                    }
                    else {
                        $this->db->where($key, $value);
                    }
                }
                else {
                    $this->db->where($key . ' IS NULL', null, false);
                }
            }
        }
        $this->db->where('status', 'normal');

        if(!empty($where_in) && is_array($where_in)) {
            foreach($where_in as $index => $value) {
                if(!empty($value)) {
                    $this->db->where_in($index, $value);
                }
            }
        }

        if(!empty($where_not_in) && is_array($where_not_in)) {
            foreach($where_not_in as $index => $value) {
                if(!empty($value)) {
                    $this->db->where_not_in($index, $value);
                }
            }
        }
    }
}