<?php
/**
 * Class Front_join_model 
*/
class Front_join_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
    }
   
    // 判斷此會員是否已加入過
    public function ms_chkname($msconn,$name,$bdate)
    {
        $data = array();
        $bdate = date('Y/m/d',strtotime($bdate));
        $spkey = 'ww_j_chkcname'.$name.$bdate;
        if ($msconn == ''){
        	  $where  = array ('c_no' => 'join', 'spkey' => $spkey);      
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_j_chkcname(?,?)}";            
            $params = [ 
                    		[$name,  SQLSRV_PARAM_IN],
                    		[$bdate,  SQLSRV_PARAM_IN], 
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data[0];                   
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){             	
                 $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'join','spkey' => $spkey));                        
                 $this->db->insert('ap_ms_data', array('c_no'=>'join','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                        
            }
        }        
        return $data;    	  
    }  
    
    // 檢查入會者身分證號是否重複(有輸入身份證號才做)
    public function ms_chkidno($msconn,$idno)
    {
        $data = array();        
        $spkey = 'ww_j_chkidno'.$idno;
        if ($msconn == ''){
        	  $where  = array ('c_no' => 'join', 'spkey' => $spkey);      
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_j_chkidno(?)}";            
            $params = [ 
                    		[$idno,  SQLSRV_PARAM_IN],
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data[0];                                      
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){             	
                 $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'join','spkey' => $spkey));                        
                 $this->db->insert('ap_ms_data', array('c_no'=>'join','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                        
            }
        }        
        return $data;    	  
    }   
    
    // 檢查推薦人資料是否存在
    public function ms_chkdname($msconn,$cname,$cno)
    {
        $data = array();        
        $spkey = 'ww_j_chkdname'.$cname.''.$cno;
        if ($msconn == ''){
        	  $where  = array ('c_no' => 'join', 'spkey' => $spkey);      
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_j_chkdname(?,?)}";            
            $params = [ 
                    		[$cname,  SQLSRV_PARAM_IN],
                    		[$cno,  SQLSRV_PARAM_IN],
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data[0];                                      
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){             	
                 $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'join','spkey' => $spkey));                        
                 $this->db->insert('ap_ms_data', array('c_no'=>'join','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                        
            }
        }        
        return $data;    	  
    }  
    
    // 首簽酵素宅配
    public function ms_chkpromo($msconn,$arsoa_join_key)
    {
    	      $spkey = 'ww_j_chkpromo_'.$arsoa_join_key;
    	      if ($msconn == ''){
        	       $where  = array ('c_no' => 'join', 'spkey' => $spkey);      
                 $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
            }else{  
    	           $spsql = "{CALL ww_j_chkpromo(?)}";            
                 $params = [ 
                         		[$arsoa_join_key,  SQLSRV_PARAM_IN],
                 ];                          
                              
                 $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
                 
                 if ($q_data){
                     $data = $q_data;                                      
                 }   
                 
                 //$this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'join','spkey' => $spkey));                        
                 //$this->db->insert('ap_ms_data', array('c_no'=>'join','spkey' => $spkey,'data' => json_encode($data),'crdt' => date('Y-m-d')));                                    
            }
            return $data;    	    	 
    }
    
    public function ms_pckpro($itype,$msconn,$joindata,$arsoa_join_jid = '')
    {
        $data = array();
        $spkey = 'ww_j_pckpro'.$itype.''.json_encode($joindata);
        
        if ($itype == '1'){      // 取得各入會方式的必選產品                            
                $spsql = "{CALL ww_j_pckpro1(?)}";            
                $params = [ 
                        [$joindata['jointype'],  SQLSRV_PARAM_IN],
                ]; 
        }elseif($itype == '2'){  // 取得各入會方式的自選產品       
                $spsql = "{CALL ww_j_pckpro2(?)}";            
        		    $params = [ 
        		            [$joindata['jointype'],  SQLSRV_PARAM_IN],
        		    ]; 
        }elseif($itype == '3'){	 // 取得贈品 	    
                $spsql = "{CALL ww_j_pckpro3(?)}";            
        		    $params = [ 
        		            [$joindata['arsoa_join_key'],  SQLSRV_PARAM_IN],
        		    ];                          
        }elseif($itype == '4'){	 // 取得紅利產品 	    
                $spsql = "{CALL ww_j_pckpro4(?,?,?)}";            
        		    $params = [ 
        		            [$joindata['jointype'],  SQLSRV_PARAM_IN],
        		            [$joindata['mp'],  SQLSRV_PARAM_IN],
        		            [$joindata['arsoa_join_key'],  SQLSRV_PARAM_IN],
        		    ];                          		    
        }elseif($itype == 'mp'){	 // 取得紅利點數
        	      $spsql = "{CALL ww_j_pckpro_mp(?)}";            
        		    $params = [ 
        		            [$joindata['arsoa_join_key'],  SQLSRV_PARAM_IN],
        		    ]; 
        }elseif($itype == 'sumdetail'){	 // 取得加總數字
        	      $spsql = "{CALL ww_j_sumdetail(?)}";            
        		    $params = [ 
        		            [$joindata['arsoa_join_key'],  SQLSRV_PARAM_IN],
        		    ]; 		            		    
        }elseif($itype == 'jsf_b'){	 // 查詢採購車明細欄位
        	      $spsql = "{CALL ww_j_jsf_b(?)}";            
        		    $params = [ 
        		            [$joindata['arsoa_join_key'],  SQLSRV_PARAM_IN],
        		    ]; 				    
        }
        		        
        if ($msconn == ''){
            $where  = array ('c_no' => 'join', 'spkey' => $spkey);                    
            $data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{                                     
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $data = $q_data;                   
            }   
            
            if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){
                $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>'join','spkey' => $spkey));                        
                $this->db->insert('ap_ms_data', array('c_no'=>'join','spkey' => $spkey,'spsql' => $spsql,'params' => json_encode($params),'data' => json_encode($data),'crdt' => date('Y-m-d')));            
            }
        }   
        if ($itype == 'mp'){	
        	  if ($data){
        	  	  $data = (int)$data[0]['mp12'];
        	  }else{
        	  	  $data = 0;
        	  }
        }elseif($itype == 'sumdetail'){	 // 取得加總數字
        	  if ($data){
        	  	  $data = $data[0];
        	  }        	
        }
        
        return $data;    	  
    }  
    
     // 我要結帳 前檢查
    public function ms_chkjoin($msconn,$arsoa_join_key)
    {
             $spsql = "{CALL ww_j_chkorder(?)}";            
             $params = [ 
                     [$arsoa_join_key,  SQLSRV_PARAM_IN],
             ];           
             if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
             	   return '';
             }else{
                 $chkdata = $this->front_mssql_model->get_data($msconn,$spsql,$params)[0];  
                 if ($chkdata['pass'] == 0){
                 	   return $chkdata['errmsg'];
                 }else{
                 	   return '';
                 }
             }
    }
    
    // 資料
    public function order_detail($msconn,$join_no,$checkcode)
    {
           $data = array();
           // 單頭 
           $spkey = 'jsf_h';
           if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
                $where  = array ('c_no' => $join_no, 'spkey' => $spkey);                           
                $q_data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);                                             
           }else{                 
                $params = array ($join_no,$checkcode); 
                $q_data = $this->front_mssql_model->get_data($msconn,"select * from jsf_h where join_no = ? and checkcode = ?",$params);
                
                if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){
                    $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$join_no,'spkey' => $spkey));                        
                    $this->db->insert('ap_ms_data', array('c_no'=>$join_no,'spkey' => $spkey,'data' => json_encode($q_data),'crdt' => date('Y-m-d')));            
                } 
           }           
           // 單頭 
           
           if ($q_data){
               $data['main'] = $q_data[0];
                              
               $spkey = 'jsf_b';
               if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
                    $where  = array ('c_no' => $join_no, 'spkey' => $spkey);            
                    $p_data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);                                    
               }else{                 
                    $params = array ($join_no); 
                    $p_data = $this->front_mssql_model->get_data($msconn,"select * from jsf_b where join_no = ?",$params);
                    
                    if ( $_SERVER['HTTP_HOST'] == 'beta.arsoa.tw'){
                        $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$join_no,'spkey' => $spkey));                        
                        $this->db->insert('ap_ms_data', array('c_no'=>$join_no,'spkey' => $spkey,'data' => json_encode($p_data),'crdt' => date('Y-m-d')));            
                    } 
               }       
               
               $data['prd'] = $p_data;                
           }
           return $data;
    }
       
        
    // 產品放入 暫存 內
    //public function in_join_cart($jid,$arsoa_join_pckpro,$itype,$p_no,$pid,$price,$p_num)
    public function in_join_cart($jid,$arsoa_join_pckpro,$itype,$p_no,$pid,$p_num)
    {
    	       $status = 1;
    	       $p_no  = trim($p_no);
    	       $p_num = (int)$p_num;
    	       $data = array();
    	       if ($p_num > 99){
             	   $p_num = 99;
             }             
    	       if ($arsoa_join_pckpro[$itype]){    	       	   
    	       	   if (self::check_cart($arsoa_join_pckpro,$itype,$p_no)){
    	       	   	   foreach ($arsoa_join_pckpro[$itype] as $key => $item){
    	       	   	       if ($p_no == $item['p_no']){
    	       	   	       	   $item['qty'] = $p_num;
    	       	   	       }
    	       	   	       $data[] = array (
    	       	                     'p_no'  => $item['p_no'],
    	       	                     'pid'   => $item['pid'],
    	       	                     'qty'   => $item['qty'],
    	       	                     'price' => $item['price'],
    	       	                   );    	       	       
    	       	   	   }
    	       	   	   $status = 0;
    	       	   }else{    	       	   	   
    	       	   	   $data = $arsoa_join_pckpro[$itype];
    	       	   	   $data[] = array (
    	       	                     'p_no' => $p_no,
    	       	                     'pid' => $pid,
    	       	                     'qty' => $p_num,
    	       	                     //'price' => $price,
    	       	                   );    	       	       
    	       	   }
    	       }else{
    	       	   $data[] = array (
    	       	                     'p_no' => $p_no,
    	       	                     'pid' => $pid,
    	       	                     'qty' => $p_num,
    	       	                     //'price' => $price,
    	       	                   );
    	       }    	       
    	           	       
    	       self::update_pckpro($jid,$itype,$data);    	       
             return $status;    	
    }
    
    // 判斷是否在購物車中
    public function check_cart($arsoa_join_pckpro,$itype,$p_no)
    {      
    	  if ($arsoa_join_pckpro[$itype]){    	  	  
    	  	  foreach ($arsoa_join_pckpro[$itype] as $key => $item)
    	  	  {
    	  	  	       if (trim($item['p_no']) == trim($p_no)){
    	  	  	       	   return true;
    	  	  	       }
    	  	  }
    	  }
    	  return false;    	  
    }
    
    // 判斷車子裡有多少產品
    public function check_cart_num($arsoa_join_pckpro,$itype)
    {
        if ($arsoa_join_pckpro[$itype]){
        	  return count($arsoa_join_pckpro[$itype]);
        }else{
        	  return 0;  
        }  
    }
    
    // 判斷車子產品多少錢
    public function check_cart_amt($arsoa_join_pckpro,$itype)
    {
        $amt = 0;
        if ($arsoa_join_pckpro[$itype]){        	  
        	  foreach ($arsoa_join_pckpro[$itype] as $key => $item){
                          $item['p_no'] = trim($item['p_no']);
                          $amt += $item['price']*$item['qty'];                                
            }        	          	  
        }
        return $amt;  
    }
    
    // 判斷車子產品多少紅利
    public function check_cart_reward($arsoa_join_pckpro,$itype)
    {
        $m_mp = 0;
        if ($arsoa_join_pckpro[$itype]){        	  
        	  foreach ($arsoa_join_pckpro[$itype] as $key => $item){
                          $item['p_no'] = trim($item['p_no']);
                          $m_mp += $item['price']*$item['qty'];                                
            }        	          	  
        }
        return $m_mp;  
    }
    
    
    // 計算在購物車的數量 
    public function check_cart_prd_num($arsoa_join_pckpro,$itype,$p_no)
    {
        if ($arsoa_join_pckpro[$itype]){
        	  foreach ($arsoa_join_pckpro[$itype] as $key => $item)
    	  	  {
    	  	  	       if (trim($item['p_no']) == trim($p_no)){
    	  	  	       	   return $item['qty'];
    	  	  	       }
    	  	  }
        }else{
        	  return 0;
        }
    }
    
    // 將車子的產品放到 mssql isf_t
    public function ms_jsf_temp($msconn,$arsoa_join_jid,$type,$sfor = 1,$efor = 4)
    {
        
        if ( $msconn == '' ){          
        }else{               
             
             $arsoa_join_data = $this->front_base_model->get_data('ap_member_join_new',array('jid'=>$arsoa_join_jid,'pay_statue'=>'N'),'',1);                         
             for ($i = $sfor;$i<= $efor;$i++){
            	    $arsoa_join_pckpro[$i] = json_decode($arsoa_join_data['pckpro'.$i], true);  
             }
             
             // 先刪temp cart 
             $params = array ($arsoa_join_data['cookie_key']);  
             $this->front_mssql_model->delete_data($msconn,"delete from jsf_t where temp_no = ? ",$params);
                          
             if ($type == 'S'){
                 for ($itype=$sfor;$itype <= $efor;$itype++){
                     if ($arsoa_join_pckpro[$itype]){                      
                          foreach ($arsoa_join_pckpro[$itype] as $key => $item){
                               $params = array (
                                                'temp_no'  => $arsoa_join_data['cookie_key'],
                                                'bdate'    => date('Y/m/d',strtotime($arsoa_join_data['bday'])),
                                                'jointype' => $arsoa_join_data['jointype'],                                            
                                                'gid'      => $itype,
                                                'pid'      => $item['pid'],
                                                'p_no'     => $item['p_no'],
                                                'qty'      => $item['qty'],
                                                'in_date'  => date('Y-m-d H:i:s')
                                                );  
                               $this->front_mssql_model->insert_data($msconn,"jsf_t",$params);
                          }
                     }
                 }
             }
        }
    }
    
    // 修改資料庫
    public function update_pckpro($jid,$itype,$data)
    {
            $up_data = array(
                             'pckpro'.$itype => json_encode($data),
                             'updt' => date('Y-m-d H:i:s')
                             );            
            $where = array ('jid' => $jid);   
     				$this->front_base_model->update_table('ap_member_join_new',$up_data ,$where);                     
    }
}