<?php
/**
 * Class Front_admin_model 
*/
class Front_base_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insert_table($aptable,$data)
    {      
        $this->db->insert($aptable, $data);
        $insert_id = $this->db->insert_id();        
        return $insert_id;
    }
    
    public function update_table($aptable,$data,$where)
    {      
        if ( is_array( $where ) && sizeof( $where ) > 0 ) {
            foreach ( $where as $key => $val ) {
                if ( is_array( $val ) ) {
                    $this->db->where_in( $key, $val );
                } else {
                    $this->db->where( $key, $val );
                }
            }
        }
        $this->db->update( $aptable, $data );       
    }
     
    public function delete_table($aptable,$where)
    {
        return $this->db->delete($aptable ,$where);
    }
    
    public function get_memu_data()
    {
        $query = "select p.p_no,p.p_name,ap.menu_name
                    from product p 
                    join ap_product as ap on ap.p_no = p.p_no
                   where p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                    and ap.menu_sort BETWEEN 1 and 2
                  ORDER BY ap.menu_sort  ";
        $query = $this->db->query($query);        
        $rows = $query->result_array();                
        $query->free_result();      
        return $rows;
    }
    
    // ÂsÄý¼Æ    
    public function count_pageview($utable,$pagecode,$field,$keyid,$id)
    {
        $pagecode = 'view_ad_'.$pagecode;
        
        $uphits = false;
        if (!empty($this->session->userdata( $pagecode ))){
            $ad_id = $this->session->userdata( $pagecode );
            if (!in_array($id,$ad_id)){
                $uphits = true;
            }
        }else{
            $uphits = true;
        }
        if ($uphits){
            $ad_id[] = $id;
            
            $upsql = "update ".$utable." set ".$field." = ".$field." + 1  where ".$keyid." = ? ; ";                                
            $this->db->query($upsql, array($id));                        
        }
        $this->session->set_userdata( $pagecode, $ad_id );    
    }
       
    public function get_data($aptable,$where,$order_by = array(),$limit = '')
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
        if ($limit > ''){
            $this->db->limit( $limit );
        }        
        $query = $this->db->get();
        if ($limit == 1){
            $rows = $query->row_array();                
        }else{
            $rows = $query->result_array();        
        }
        $query->free_result();      
        return $rows;
    }
    /*
    $aa= $this->front_base_model->one_data('citytitle,cityshow','city',array('cityno'=>'01'));
    echo "<pre>".print_r($aa,true)."</pre>";exit;
    exit;
    */
    public function one_data($select,$table,$where)
    {
       
        $this->db->select( $select )
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
        $query->free_result();  
        if (strpos($select, ',') === false){
            return $rows[$select];
        }else{
            return $rows;
        }
    }
    
    public function city_title($cityno)
    {
        $title = '';
        if ($cityno > ''){
            $this->db->select( 'citytitle' )
                       ->from( 'city' )
                       ->where('cityno',$cityno);
            $query = $this->db->get();         
            $rows = $query->row_array();                                
            $title = $rows['citytitle'];
        }
        return $title;
    }    
    
    public function town_title($postal)
    {
        $title = '';
        if ($postal > ''){
            $this->db->select( 'towntitle' )
                       ->from( 'town' )
                       ->where('postal',$postal);
            $query = $this->db->get();         
            $rows = $query->row_array();                                
            $title = $rows['towntitle'];
        }
        return $title;
    }
    
    public function city_town($postal)
    {
        $title = '';
        if ($postal > ''){
            $this->db->select( 'c.citytitle,t.towntitle' )
                       ->from( 'town t' )
                       ->join( 'city c','t.cityno = c.cityno' )
                       ->where('t.postal',$postal);
            $query = $this->db->get();         
            $rows = $query->row_array();                                
            $title = $rows['citytitle'].$rows['towntitle'];
        }
        return $title;
    }
    
    public function count_total($aptable,$where)
    {
        $query = $this->db->select( 'count(*) as total' )                          
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
        return $rows['total'];
    }
        
    public function small_query($sql)
    {       
        $query = $this->db->query($sql);
        $rows = $query->result_array();        
        $query->free_result();        
        return $rows;      
    }
        
    public function PF_SerOrder($sertitle)
    {
        $where  = array ('sertitle' => $sertitle);                 
        $SerOrder_data = $this->get_data('ap_serorder',$where);
        if ($SerOrder_data) {             
            $upsql = "update ap_serorder set serorder=serorder+1 where sertitle = ? ; ";                                
            $this->db->query($upsql, array($sertitle));
            
            $where  = array ('sertitle' => $sertitle);                 
            $SerOrder_data = $this->get_data('ap_serorder',$where)[0];            
            $sorderstr = $SerOrder_data['serorder'];
        }else{
   	        $sorderstr = 1;   	
   	        $this->db->insert('ap_serorder', array('sertitle' => $sertitle,'serorder' => 1));
        }
        return $sorderstr;
    }
}