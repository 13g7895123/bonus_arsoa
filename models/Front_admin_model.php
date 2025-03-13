<?php
/**
 * Class Front_admin_model 
*/
class Front_admin_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function check_admin_login($bool = FALSE)
    {

        $admin_session = $this->session->userdata('admin_session');
        if (isset($admin_session['admin_id']) && $admin_session['admin_id'] > 0) {
            return $bool ? TRUE : array(
                'status' => TRUE,
                'data'   => $admin_session
            );
        }

        return $bool ? FALSE : array('status' => FALSE);
    }

    public function epost( $kind ) 
    {
        $query = $this->db->select( '*' )
                          ->from( 'ap_epost' )
                          ->where( 'epostid', $kind )
                          ->get();
        $rows = $query->result_array();        
        if (empty($rows)){
            $this->db->insert('ap_epost', array('epostid' => $kind,'updt' => date('Y-m-d H:i:s')));
        }
        $query->free_result();      
        return $rows;
    }
    
    public function item_list($where)
    {
        $this->db->select( '*' )
                          ->from( 'ap_itemclass' );
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $this->db->where_in( $key, $val );
                } else {
                    $this->db->where( $key, $val );
                }
            }
        }   
        $this->db->order_by( 'classsort' , 'asc' );
        $result = $this->db->get()->result_array();
        return $result;
    }
  
    public function list_data($aptable,$where, $order_by = array())
    {
        $this->db->select( '*' )
                          ->from( $aptable );
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $this->db->where_in( $key, $val );
                } else {
                    $this->db->where( $key, $val );
                }
            }
        }   
        if ( is_array( $order_by ) ) {
            foreach ( $order_by as $key => $val ) {
                if ( is_numeric( $key ) ) {
                    $this->db->order_by( $val );
                } else {
                    $this->db->order_by( $key, $val );
                }
            }
        }
        $query = $this->db->get();
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
    }
    
    public function get_data($aptable,$where)
    {
        $this->db->select( '*' )
                          ->from( $aptable );
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
        $query->free_result();      
        return $rows;
    }
    
    public function func_data($edit)
    {
        $query = $this->db->select( '*' )
                          ->from( 'ap_func_data' )
                          ->where( 'id', $edit )
                          ->get();
        $rows = $query->row_array();                
        $query->free_result();      
        return $rows;
    }
    
    public function admin_data($edit)
    {
        $query = $this->db->select( '*' )
                          ->from( 'ap_admin' )
                          ->where( 'adminid', $edit )
                          ->get();
        $rows = $query->row_array();                
        $query->free_result();      
        return $rows;
    }    
      
    public function viewcount_total()
    {
        $query="select sum(hits) as total from ap_viewcount where kind =  'View' ";
        $result = $this->db->query($query)->result_array();
        return $result;
    }
    
    public function viewcount($StartDate,$EndDate)
    {  
      
        $query = "select hits,createdate from ap_viewcount where kind = 'View' ";
        $query .=" and (date_format( createdate , '%Y-%m-%d' ) >= ? and date_format( createdate , '%Y-%m-%d' ) <=  ?) order by createdate  ";
        $query = $this->db->query($query,array($StartDate,$EndDate));
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
    }
    
    public function viewcount_mon()
    {  
        $query = "select sum(hits) as hits,date_format( createdate , '%Y-%m' ) as createdate from ap_viewcount where kind = 'View' group by date_format( createdate , '%Y-%m' ) order by date_format( createdate , '%Y-%m' ) limit 12 ";
        $query = $this->db->query($query);        
        $rows = $query->result_array();                
        $query->free_result();        
        return $rows;      
    }
    
}