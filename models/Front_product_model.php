<?php
/**
 * Class Front_product_model 
*/
class Front_product_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function cat_wp_one($table,$where)
    {
        $this->db->select( '*' )
                    ->from( $table );
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $this->db->where_in( $key, $val );
                } else {
                    $this->db->where( $key, $val );
                }
            }
        }
        $query = $this->db->get();
        $rows = $query->row_array();  
        
        return $rows;              
    }
    
    public function prd_list($wp,$no,$d_posn = 10)
    {
        $sql = "select p.*,ap.p_title1,ap.p_title2
                  from product p 
                  join wp1_type w1 on p.wp1_no = w1.wp1_no 
                  left join ap_product ap on ap.p_no = p.p_no ";
        if ($wp == '1'){            
            $sql .= " where p.wp1_no = ? ";
            if ($no == '6' && $d_posn == '60'){  // 一般會員只能限定買特定的輔銷品
                $sql .= " and p.wp2_no = 'S11'  ";
            }
        }        
        if ($wp == '2'){
            $sql .= " where p.wp2_no = ? ";
        }        
        if ($wp == '3'){
            $sql .= " where p.wp3_no = ? ";
        }
        $sql .=  " and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                 order by p.mg_sort,p.pro_order ";
        $query = $this->db->query($sql,array($no));
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;    
    }
    
    public function page_list( $where, $like = array(),$Page,$PageSize, $group_by = array(), $order_by = array()){
        
        $db = $this->db;        
        $db->from( ' product p' );        
        $db->join( ' wp1_type as w1','w1.wp1_no = p.wp1_no','left');
        $db->join( ' wp2_type as w2','w2.wp2_no = p.wp2_no','left');
        $db->join( ' wp3_type as w3','w3.wp3_no = p.wp3_no','left');
        $db->join( ' ap_product as ap','ap.p_no = p.p_no','left');
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
					        
        $db->select( 'p.*,w1.wp1_na,w2.wp2_na,w3.wp3_na,ap.updt,ap.p_title1,ap.p_title2,ap.account,ap.pid,ap.hits,ap.menu_sort,ap.menu_name' );                        
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
    
    public function other_list($p_no,$wp1_no,$limit = 3)
    {
        $other_sql = " select p.* 
                         from product p
                        where p.p_no <> ?
                          and p.wp1_no = ?
                          and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1)
                        ORDER BY rand() 
                        limit ".$limit." ";
        $query = $this->db->query($other_sql, array($p_no,$wp1_no));    
        $other_prddata = $query->result_array();        
        $query->free_result(); 
        
        return $other_prddata;
    }
        
    public function prd_color($p_no)
    {
        $sql = "select c.type_na,c.s_p_no,p.p_name,p.pv,p.d_price,p.r_price,p.c_price, p.is_view, p.is_shop, p.Is_nogoods,p.mg_sort 
                  from product_c c , product p 
                 where c.p_no = ?
                   and p.p_no = c.s_p_no 
                 order by c.type_na,p.mg_sort,c.pro_order ";
        $query = $this->db->query($sql,array($p_no));        
        $rows = $query->result_array();                
        $query->free_result();
        return $rows; 
    }
    
    public function get_data($p_no,$is_list = 'Y')
    {
       
        $this->db->select( 'p.*,w1.wp1_na,w2.wp2_na,w3.wp3_na,w1.wp1_en_name,w2.wp2_en_name,w3.wp3_en_name,ap.body,ap.p_title1,ap.p_title2,ap.tags,ap.tags,ap.psort,ap.nshow,ap.account,ap.pid,ap.menu_sort,ap.menu_name' );
        $this->db->from( ' product p' );        
        $this->db->join( ' wp1_type as w1','w1.wp1_no = p.wp1_no','left');
        $this->db->join( ' wp2_type as w2','w2.wp2_no = p.wp2_no','left');
        $this->db->join( ' wp3_type as w3','w3.wp3_no = p.wp3_no','left');
        $this->db->join( ' ap_product as ap','ap.p_no = p.p_no','left');        
        $this->db->where(' p.p_no', $p_no );
        if ($is_list == 'Y'){
            $this->db->where(' p.is_list','1' );
        }
        $this->db->group_start();
        $this->db->where('ifnull(p.c_price,0) >',0);
        $this->db->or_where('p.is_visual', 1);
        $this->db->group_end();        
        $query = $this->db->get();
        $rows = $query->row_array();                
        
        $query->free_result();      
        
        return $rows;
    }
    
    public function get_data_join($p_no)
    {       
        $this->db->select( 'p.*' );
        $this->db->from( ' product p' );        
        $this->db->where(' p.p_no', $p_no );        
        $query = $this->db->get();
        $rows = $query->row_array();
        $query->free_result();              
        return $rows;
    }
    
    // 紅利商品
    public function get_reward_data($p_no)
    {
        $this->db->select( 'p.*,w1.wp1_na,w2.wp2_na,w3.wp3_na,w1.wp1_en_name,w2.wp2_en_name,w3.wp3_en_name,ap.body,ap.p_title1,ap.p_title2,ap.tags,ap.tags,ap.psort,ap.nshow,ap.account,ap.pid,ap.menu_sort,ap.menu_name' );
        $this->db->from( ' product p' );        
        $this->db->join( ' wp1_type as w1','w1.wp1_no = p.wp1_no','left');
        $this->db->join( ' wp2_type as w2','w2.wp2_no = p.wp2_no','left');
        $this->db->join( ' wp3_type as w3','w3.wp3_no = p.wp3_no','left');
        $this->db->join( ' ap_product as ap','ap.p_no = p.p_no','left');        
        $this->db->where(' p.p_no', $p_no );
        $this->db->where(' p.is_web','1' );
        $this->db->where(' p.is_nogoods','0' );
        $this->db->where(' p.m_mp > ','0' );
        $this->db->order_by( 'p.p_no' );
        $query = $this->db->get();
        $rows = $query->row_array();
        $query->free_result();              
        return $rows;
    }    
}