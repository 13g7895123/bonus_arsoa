<?php
/**
 * Class Front_mssql_model 
*/
class Front_mssql_model extends MY_Model {

    public function __construct() {
        parent::__construct();        
    }
    
    // ���եi���i�H�s��D��    
    public function ms_test()
    {
           if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // �������� 
                return true;           
           }
           
           $connect = @fsockopen($this->config->item('mssql')['hostname'], 1433);       
           if($connect){
               fclose($connect);
               return true;           
           }else{
               return false;
           }
       
           /*
           $connectionInfo = array("Database"=>$this->config->item('mssql')['database'],"Uid"=>$this->config->item('mssql')['username'],"Pwd"=>$this->config->item('mssql')['password'],'LoginTimeout'=>1);//,'LoginTimeout'=>2
           $conn = sqlsrv_connect($this->config->item('mssql')['hostname'], $connectionInfo); 
           if( $conn ) {
              sqlsrv_close($conn);
              return true;
           }else{
              return false;
           }
           */
    }
    
    public function ms_connect()
    {
         if ($_SERVER['HTTP_HOST'] == 'localhost'){
             return '';
         }else{
             $connectionInfo = array("Database"=>$this->config->item('mssql')['database'],"Uid"=>$this->config->item('mssql')['username'],"Pwd"=>$this->config->item('mssql')['password'], 'ReturnDatesAsStrings'=> true,"CharacterSet" => "UTF-8");
             //echo "<pre>".print_r($connectionInfo,true)."</pre>";exit;
             $conn = sqlsrv_connect($this->config->item('mssql')['hostname'], $connectionInfo); 
             if( $conn ) {
                return $conn;
             }else{
                if (ENVIRONMENT == 'production'){
                    redirect( base_url('webmsg/MS9999') );
   	                exit;
                }else{
                    echo "<pre>".print_r($connectionInfo,true)."</pre>";
                    echo "Connection could not be established.<br />";
                    die( print_r( sqlsrv_errors(), true));
                }
             }
         }
    }
    
    public function ms_close($conn)
    {
           sqlsrv_close($conn);
    }
    /*
       SP 
       $c_name = 'c_name';
            
       $params = [ 
           ['202005',  SQLSRV_PARAM_IN],     
           ['071157',  SQLSRV_PARAM_IN],     
           ['1',  SQLSRV_PARAM_IN],     
           ['1',  SQLSRV_PARAM_IN],     
           [&$c_name, SQLSRV_PARAM_OUT] 
       ]; 
            
       $data = $this->front_mssql_model->get_data($msconn,"{CALL mm_q_test2(?,?,?,?,?)}",$params);
       // --------------
       $params = array ('1'); 
       $data = $this->front_mssql_model->get_data($msconn,"select * from test where 1 = ? ",$params);
       
    */
    public function get_data($msconn,$tsql,$params)
    {
        $data = array();
        if ($msconn == ''){          
        }else{
            $stmt = sqlsrv_query($msconn, $tsql, $params);  
            
            if ($stmt) {  
                  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { 
                        $data[] = $row;
                  }
            } else {  
                  echo "Row insertion failed.\n";  
                  die(print_r(sqlsrv_errors(), true));  
            }  
            
            sqlsrv_free_stmt($stmt);  
        }
        return $data;
       
    }
    
    /*
    $params = array('202005','071157','1','1');
    $this->front_mssql_model->get_sp_data($msconn,'mm_q_test3',$params);
    */
    public function get_sp_data($msconn,$tsql,$aparams)
    {
        $data = array();
        
        if ($msconn == ''){          
        }else{
            $qstr = '';
            $params = array();
            foreach ($aparams as $key => $item){
                     if ($qstr > ''){ $qstr .= ','; } 
                     $qstr .= "?";
                     $params[] = array($item,SQLSRV_PARAM_IN);
            }
                    
            $tsql = "{CALL ".$tsql."(".$qstr.",?)}";
            
            $stmt = sqlsrv_query($msconn, $tsql, $params);  
            
            if ($stmt) {  
                  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { 
                        $data[] = $row;
                  }
            } else {  
                  echo "Row insertion failed.\n";  
                  die(print_r(sqlsrv_errors(), true));  
            }  
            
            sqlsrv_free_stmt($stmt);  
        }
        return $data;       
    }
       
       
    /*
       $params = array (
                          'temp_no' => $this->session->userdata('temp_no'),
                          'p_no'    => $aprd[$i],
                          'qty'     => $this->check_cart_prd_num($aprd[$i]),
                          'in_date' => date('Y-m-d H:i:s')
                       );  
       $this->front_mssql_model->insert_data($msconn,"isf_t",$params);
    */
    public function insert_data($msconn,$table,$params,$getid = 'N')
    {
       if ($msconn){
           $fsql = array();
           $qsql = array();
           $vsql = array();
           
           foreach ($params as $key => $value){                
                    $fsql[] = $key;
                    $qsql[] = '?';
                    $vsql[] = $value;
           }       
           $tsql = "insert into ".$table." (".implode(",",$fsql).") VALUES (".implode(",",$qsql).") ";       
           
           if ($getid == 'Y'){
               $tsql .= ";SELECT SCOPE_IDENTITY() AS ID";
           }
                  
           $stmt = sqlsrv_query( $msconn, $tsql, $vsql);
           if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
           }       
           
           if ($getid == 'Y'){
               $id = $this->lastId($stmt); 
               sqlsrv_free_stmt($stmt);  
               return $id;
           }
           sqlsrv_free_stmt($stmt);  
       }
    }
    /*
       $params = array (
                          'temp_no' => $this->session->userdata('temp_no'),
                          'p_no'    => $aprd[$i],
                          'qty'     => $this->check_cart_prd_num($aprd[$i]),
                          'in_date' => date('Y-m-d H:i:s')
                       );  
       $where = array (
                          'int1' => 1
                       );                  
       $this->front_mssql_model->update_data($msconn,"isf_t",$params,$where);       
    */
    public function update_data($msconn,$table,$params,$where)
    {
       if ($msconn){
           $vsql = array();
           
           $sql = '';
           foreach ($params as $key => $value){                
                    if ($sql > ''){ $sql .= ","; }
                    $sql .= $key." = ? ";
                    $vsql[] = $value;
           }  
           $wsql = '';
           foreach ($where as $key => $value){                
                    if ($wsql > ''){ $wsql .= " and "; }
                    $wsql .= $key." = ? ";
                    $vsql[] = $value;
           }  
           $usql = "update ".$table." set ".$sql." where ".$wsql;
           
           $stmt = sqlsrv_query( $msconn, $usql, $vsql);
           if( $stmt === false ) {
                die( print_r( sqlsrv_errors(), true));
           }       
           
           sqlsrv_free_stmt($stmt);  
       }
    }
    
    /*    
    $params = array ('��r����4','6','��r����122',date('Y-m-d H:i:s'),1);  
    $this->front_mssql_model->update_data($msconn,"update test set varc1 = ? ,char1 = ?,nvar1 = ?,date2=? where int1 = ?",$params);
    */
    public function sql_update_data($msconn,$tsql,$params)
    {
              
       $stmt = sqlsrv_query( $msconn, $tsql, $params);
       if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
       }       
       
       sqlsrv_free_stmt($stmt);  
    }
    
    /*
    $params = array (3);  
    $this->front_mssql_model->delete_data($msconn,"delete from test where int1 = ?",$params);       
    */
    public function delete_data($msconn,$tsql,$params)
    {
       
       $stmt = sqlsrv_query( $msconn, $tsql, $params);
       if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
       }       
       
       sqlsrv_free_stmt($stmt);  
    }
    
    public function lastId($queryID) { 
         sqlsrv_next_result($queryID); 
         sqlsrv_fetch($queryID); 
         return sqlsrv_get_field($queryID, 0); 
    } 
    
    public function order_page_list( $msconn,$tsql,$params)
    {         
        $data = array();
        if ($msconn == ''){          
        }else{
            $stmt = sqlsrv_query($msconn, $tsql, $params);  
            
            if ($stmt) {  
                  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { 
                        $data[] = $row;
                  }
            } else {  
                  echo "Row insertion failed.\n";  
                  die(print_r(sqlsrv_errors(), true));  
            }  
            
            sqlsrv_free_stmt($stmt);  
        }
        return $data;
       
    }
    
}