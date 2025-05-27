<?php
/**
 * Class Front_order_model 
*/
class Front_order_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
   
    // 放入暫存車
    public function i_cart($c_no,$p_no,$p_num = 1, $days = 0)
    {
        // 如果days為0，則從ap_member_cart中取得days
        if ($days == 0){
            $cartData = $this->db->from('ap_member_cart')
                ->where('c_no',$c_no)
                ->where('p_no',$p_no)
                ->get()
                ->row_array();

            if ($cartData){
                $days = $cartData['days'];
            }
        }

        $sql = "INSERT INTO ap_member_cart (c_no,p_no,p_num,crdt,days) VALUES ('".$c_no."','".$p_no."','".$p_num."',now(),'".$days."')
            ON DUPLICATE KEY UPDATE p_num='".$p_num."',crdt=now(),days='".$days."'";
                         //echo $sql;                         
        $this->db->query($sql);
    }
    
    // 刪除暫存車的產品
    public function d_cart($ctype,$c_no,$p_no=0)
    {
        if ($ctype == 'A'){
            $this->session->unset_userdata( 'ProductList' );
            $this->clearDatabaseCart();
            $this->session->unset_userdata( 'prd_session' );
            return $this->db->delete('ap_member_cart' ,array('c_no' => $c_no));
        }else{
            $p_nostr = '';
            $aprd = explode( ',', $this->session->userdata('ProductList') );
            $aprd = array_filter($aprd, function($item){
                return $item !== '';
            });

            for ($i=0;$i< count($aprd);$i++){
                 if ($aprd[$i] <>  $p_no){
                     if ($p_nostr > ''){ $p_nostr .= ","; }
                     $p_nostr .= $aprd[$i];
                 }
            }      
            if ($p_nostr == ''){
                $this->session->unset_userdata( 'ProductList' );
                $this->clearDatabaseCart();
                $this->session->unset_userdata( 'prd_session' );
            }else{
                $this->session->set_userdata( 'ProductList', $p_nostr );
                $this->setDatabaseCart($p_nostr);
                $this->session->unset_userdata( 'prd_session' )[$p_no];
            }            
            return $this->db->delete('ap_member_cart' ,array('c_no' => $c_no,'p_no' => $p_no));
        }
    }
    
    // 抓運費到session
    public function set_freight()
    {
        $sql = "select p_no,p_name,c_price,m_mp
                  from product 
                 where p_no in ('0000000','A000000')
                 order by p_no ";
        $query = $this->db->query($sql);
        $rows = $query->result_array();                  
        foreach ($rows as $key => $item){
               if ($item['p_no'] == '0000000'){
                   $this->session->set_userdata( 'FC_freight', round($item['c_price']) );
               }else{
                   $this->session->set_userdata( 'FC_freight_mp', round($item['m_mp']) );
               }
        }
    }
    
    // 購物車 LIST 
    public function cart_list($in_p_no)
    {
        $spno = str_replace(',',"','",$in_p_no);        
        if ($this->session->userdata('use_cart') == 'Y'){
            $sql = "select 1 as psort,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                     from product p 
                    where p.p_no in ('".$spno."')
                      and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                    union
                   select 2 as psort,c.s_p_no as p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                     from product p 
                     join product_c c on p.p_no = c.s_p_no 
                    where c.s_p_no in ('".$spno."')
                      and p.is_list=0 and (ifnull(p.c_price,0) > 0 or p.is_visual= 0)  
                    union
                   select 3 as psort,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                     from product p 
                    where p.p_no in ('".$spno."')
                      and p.is_web=1 and p.is_nogoods=0 and p.m_mp > 0  
                     union
                   select 4 as psort,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                     from product p 
                    where p.p_no in ('".$spno."')
                      and p.is_web=1 and p.is_nogoods=0 
                      and p.p_no in ('A0000000','0000000')
                    order by psort,p_no ";
        }else{
           $sql = " select 3 as psort,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                      from product p 
                     where p.p_no in ('".$spno."')
                       and p.is_web=1 and p.is_nogoods=0 and p.m_mp > 0  
                     union
                   select 4 as psort,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt
                     from product p 
                    where p.p_no in ('".$spno."')
                      and p.is_web=1 and p.is_nogoods=0 
                      and p.p_no in ('A0000000','0000000')   
                     order by psort,p_no "; 
        }
        $query = $this->db->query($sql);        
        $rows = $query->result_array();                
        $query->free_result();
        return $rows; 
    }
    
    
    // 登入時放入 session
    public function login_session_cart($c_no,$d_posn)
    {
        if ($this->session->userdata('use_cart') == 'Y'){
            $sql = "select 1 as psort,p.wp1_no,p.wp2_no,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt,a.p_num
                      from product p join ap_member_cart a on p.p_no = a.p_no
                     where a.c_no = ?
                       and p.is_list=1 and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) 
                     union
                    select 2 as psort,p.wp1_no,p.wp2_no,c.s_p_no as p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt,a.p_num
                      from product p join ap_member_cart a on p.p_no = a.p_no
                      join product_c c on p.p_no = c.s_p_no 
                     where a.c_no = ?
                       and p.is_list=0 and (ifnull(p.c_price,0) > 0 or p.is_visual= 0)  
                     union
                    select 3 as psort,p.wp1_no,p.wp2_no,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt,a.p_num
                      from product p join ap_member_cart a on p.p_no = a.p_no
                     where a.c_no = ?
                       and p.is_web=1 and p.is_nogoods=0 and p.m_mp > 0  
                     order by psort,p_no  ";
            $jarray = array($c_no,$c_no,$c_no);         
        }else{  // 只可以買紅利商品
            $sql = "select 4 as psort,p.wp1_no,p.wp2_no,p.p_no,p.p_name,p.c_price,p.pv,p.pro_title1,p.pro_title2,p.m_mp,p.p_mp,p.r_price,p.mp_amt,p.a_pv,p.opv_h,p.a_amt,p.b_amt,a.p_num
                      from product p join ap_member_cart a on p.p_no = a.p_no
                     where a.c_no = ?
                       and p.is_web=1 and p.is_nogoods=0 and p.m_mp > 0  
                     order by psort,p_no  ";
            $jarray = array($c_no);
        }
        $query = $this->db->query($sql,$jarray);
        $rows = $query->result_array();          
        $p_nostr = '';
        foreach ($rows as $key => $item){
                 $can = true;
                 if ($item['psort'] != 4 && $item['wp1_no'] == 6 && $item['wp2_no'] == 'S12' && $d_posn == 60) { //合歡會員  
                 	   $can = false;
                 }
                 if ($can){
                     if ($p_nostr > ''){ $p_nostr .= ","; }
                     $p_nostr .= $item['p_no'];          
                     $prd_session[$item['p_no']]  = $item['p_num'];
                     
                     if ($prd_session[$item['p_no']] > 99){
                         $prd_session[$item['p_no']] = 99;
                     }
                 }
        }
        
        if ($p_nostr > ''){
            $this->session->set_userdata( 'ProductList', $p_nostr );
            $this->setDatabaseCart($p_nostr);
            $this->session->set_userdata( 'prd_session', $prd_session );
        }
    }
    
    // 判斷是否在購物車中
    public function check_cart($p_no)
    {
      
        if (!empty($this->session->userdata('ProductList'))){
            $Fpl = explode( ',', $this->session->userdata('ProductList') );
            $Fpl = array_filter($Fpl, function($item){
                return $item !== '';
            });
            return in_array($p_no, $Fpl);
        }
        return false;
    }
    
    // 判斷車子裡有多少產品
    public function check_cart_num()
    {
        if (!empty($this->session->userdata('ProductList'))){
            $cartItmes = explode( ',', $this->session->userdata('ProductList'));
            $cartItmes = array_filter($cartItmes, function($item) {
                return $item !== '';
            });
            return count($cartItmes);
        }else{
            return 0;  
        }        
    }
    
    // 計算在購物車的數量 
    public function check_cart_prd_num($p_no)
    {
        if (!empty($this->session->userdata('prd_session')[$p_no])){            
            return $this->session->userdata('prd_session')[$p_no];
        }else{
        	  $prd_session = $this->session->userdata('prd_session');	
        	  $prd_session[$p_no] = 1;
        	  $this->session->set_userdata( 'prd_session', $prd_session );
        	  return 1;
        }        
    }
        
    public function ms_cart_list($msconn)
    {
        $cart_data = array();
        $spkey = 'ww_w_isf_b';
        if ($msconn == ''){
            $where  = array ('c_no' => $this->session->userdata('member_session')['c_no'], 'spkey' => $spkey);            
            $sumdetail = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_w_isf_b(?,?)}";            
            $params = [ 
                    [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                    [$this->session->userdata('temp_no'),  SQLSRV_PARAM_IN], 
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $cart_data = $q_data;                   
            }   
            
            if ($this->session->userdata('member_session')['c_no'] == '000000'){
                // $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey));                        
                // $this->db->insert('ap_ms_data', array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey,'data' => json_encode($cart_data),'crdt' => date('Y-m-d')));            
            }
        }
        
        return $cart_data;
    	  
    }
    
    // 計算
    public function ms_get_sumdetail($msconn)
    {
        $sumdetail = array();
        $spkey = 'ww_sumdetail';
        if ($msconn == ''){
            $where  = array ('c_no' => $this->session->userdata('member_session')['c_no'], 'spkey' => $spkey);            
            $sumdetail = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);            
        }else{            
            $spsql = "{CALL ww_sumdetail(?,?)}";            
            $params = [ 
                    [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                    [$this->session->userdata('temp_no'),  SQLSRV_PARAM_IN], 
            ];                          
                         
            $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
            
            if ($q_data){
                $sumdetail = $q_data[0];   
                $sumdetail['comp'] = array();   
                if ($sumdetail['ww_chkcomp']){   // 販促活動
            	      $spsql = "{CALL ww_chkcomp(?,?)}";            
                    $params = [ 
                            [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                            [$this->session->userdata('temp_no'),  SQLSRV_PARAM_IN], 
                    ];           
                    $comp_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
                    $sumdetail['comp'] = $comp_data;   
                }
                $sumdetail['birth'] = array();   
                if ($sumdetail['ww_chkbirth']){ 
                	  $spsql = "{CALL ww_chkbirth(?,?)}";            
                    $params = [ 
                            [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                            [$this->session->userdata('temp_no'),  SQLSRV_PARAM_IN], 
                    ];           
                    $birth_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);                     
                    $sumdetail['birth'] = $birth_data;   
                }
            
            }   
            
            if ($this->session->userdata('member_session')['c_no'] == '000000'){
                $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey));                        
                $this->db->insert('ap_ms_data', array('c_no'=>$this->session->userdata('member_session')['c_no'],'spkey' => $spkey,'data' => json_encode($sumdetail),'crdt' => date('Y-m-d')));            
            }
        }
        
        return $sumdetail;
    }      
    
    // 將車子的產品放到 mssql isf_t
    public function ms_cart_temp($msconn)
    {
        // -- 產生暫存編號  --
        if (empty($this->session->userdata('temp_no')) || $this->session->userdata('temp_no') == ''){
            $this->session->set_userdata( 'temp_no', uniqid());
        }
        // -- 產生暫存編號  --
        
        if ( $msconn == '' ){          
        }else{  
             
            // 先刪temp cart
            $params = array ($this->session->userdata('temp_no'));  
            $this->front_mssql_model->delete_data($msconn,"delete from isf_t where temp_no = ? ",$params);
             
            if (!empty($this->session->userdata('ProductList'))){
                $aprd = explode( ',', $this->session->userdata('ProductList') );
                $aprd = array_filter($aprd, function($item){
                    return $item !== '';
                });

                // 特定產品需要另外取宅配日
                $specialProduct = array('A0010', 'A0011', 'B0009', 'C0006', 'Q0001', 'Q0002', 'Q0003', 'Q0004');

                for ($i=0; $i < count($aprd); $i++){  
                    $days = 0;     
                    if (in_array($aprd[$i], $specialProduct)){
                        $days = $this->fetchDeliveryDate($this->session->userdata('member_session')['c_no'], $aprd[$i]);
                    }

                    // print_r($days); die();
                    
                    $params = array (
                                    'temp_no' => $this->session->userdata('temp_no'),
                                    'p_no'    => $aprd[$i],
                                    'qty'     => $this->check_cart_prd_num($aprd[$i]),
                                    'days'    => $days,
                                    'in_date' => date('Y-m-d H:i:s')
                                    );  
                    $this->front_mssql_model->insert_data($msconn,"isf_t",$params);
                }
            }
        }
    }
    
    public function ms_cart_temp_act($msconn,$data)
    {
        if (count($data) > 0){
            if ( $msconn == '' ){          
            }else{  
                  foreach ($data as $key => $aprd){
                       $params = array (
                                        'temp_no' => $this->session->userdata('temp_no'),
                                        'p_no'    => $aprd['p_no'],
                                        'qty'     => $aprd['qty'],
                                        'gid'     => $aprd['gid'],
                                        'in_date' => date('Y-m-d H:i:s')
                                        );  
                                        
                       $this->front_mssql_model->insert_data($msconn,"isf_t",$params);                       
                  }
             }
        }
    }
    
    // 計算在購物車的產品數量是否超過 
    public function ms_chkorder($msconn)
    {
             $spsql = "{CALL ww_chkorder(?,?)}";            
             $params = [ 
                     [$this->session->userdata('member_session')['c_no'],  SQLSRV_PARAM_IN],
                     [$this->session->userdata('temp_no'),  SQLSRV_PARAM_IN], 
             ];           
             $chkdata = $this->front_mssql_model->get_data($msconn,$spsql,$params)[0];  
             if ($chkdata['pass'] == 0){
             	   return $chkdata['errmsg'];
             }else{
             	   return '';
             }
    }
    
    // 抓出會員有多少紅利
    public function ms_get_mp($msconn,$c_no)
    {
        $mp = 0;
        if ( $msconn == '' ){         
             $mp = 10000;
        }else{  
             $spsql = "{CALL ww_sumdetail(?,?)}";
             $spkey = "ww_sumdetail";
             $params = [ 
                     [$c_no,  SQLSRV_PARAM_IN],
                     ['',  SQLSRV_PARAM_IN], 
             ]; 
                     
             $q_data = $this->front_mssql_model->get_data($msconn,$spsql,$params);  
             if ($q_data){   
                  $mp = $q_data[0]['mp'] + 0;
             }                   
        }
        return $mp;
    }
    
    public function order_detail($msconn,$c_no,$web_no,$order='N')
    {
           $data['order'] = $order;
           $data['html'] = '';
           // 單頭 
           $spkey = 'isf_h';
           if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
                $where  = array ('c_no' => $c_no, 'spkey' => $spkey);            
                $q_data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);                                    
           }else{                 
                $params = array ($c_no,$web_no); 
                $q_data = $this->front_mssql_model->get_data($msconn,"select * from isf_h where c_no = ? and web_no = ?",$params);
                
                if ($c_no == '000000'){
                    $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$c_no,'spkey' => $spkey));                        
                    $this->db->insert('ap_ms_data', array('c_no'=>$c_no,'spkey' => $spkey,'data' => json_encode($q_data),'crdt' => date('Y-m-d')));            
                } 
           }           
           // 單頭 
           
           if ($q_data){
               $data['main'] = $q_data[0];
                              
               $spkey = 'isf_b';
               if ( $_SERVER['HTTP_HOST'] == 'localhost'){ 
                    $where  = array ('c_no' => $c_no, 'spkey' => $spkey);            
                    $p_data = json_decode($this->front_base_model->get_data('ap_ms_data',$where,array(),1)['data'], true);                                    
               }else{                 
                    $params = array ($web_no); 
                    $p_data = $this->front_mssql_model->get_data($msconn,"select * from isf_b where web_no = ?",$params);
                    
                    if ($c_no == '000000'){
                        $this->front_base_model->delete_table('ap_ms_data',array('c_no'=>$c_no,'spkey' => $spkey));                        
                        $this->db->insert('ap_ms_data', array('c_no'=>$c_no,'spkey' => $spkey,'data' => json_encode($p_data),'crdt' => date('Y-m-d')));            
                    } 
               }       
               
               $data['prd'] = $p_data;
               
               if ($data['main']['success']){
                   $data['order_title'] = '訂單付款成功 ';
               }else{
               	   $data['order_title'] = $data['main']['ord_statue'];
               }               
               
               $data['html'] = $this->load->view('helper/order_detail', $data, TRUE);
                
           }
           return $data;
    }
           
    //----求出最新的訂單編號----    
    public function web_no($wtype = 'W')
    {   
         $nOrderID  = $this->front_base_model->PF_SerOrder($wtype.date('Ym'));
         if ($wtype == 'J'){
             $newOrderID = $wtype.substr(date('Y'),-2).date('m').sprintf("%05d",$nOrderID);
         }else{
         	   $newOrderID = $wtype.date('Ym').sprintf("%03d",$nOrderID);
         }
         return $newOrderID;
    }
    
    // 付款完成清掉車
    public function clear_cart($msconn)
    {
        $this->session->unset_userdata( 'ProductList' );        // 產品
        $this->clearDatabaseCart();
        $this->session->unset_userdata( 'prd_session' );        // 數量
        $this->session->unset_userdata( 'sfreight' );           // 運費選擇
        $this->session->unset_userdata( 'act' );                // 活動
        
        if (!empty($this->session->userdata('temp_no'))){
            if ($msconn){             
                // 先刪temp cart 
                $params = array ($this->session->userdata('temp_no'));  
                $this->front_mssql_model->delete_data($msconn,"delete from isf_t where temp_no = ? ",$params);
                
                $this->session->unset_userdata( 'temp_no' );  
            }
        }
    }
        
    // 中信 虛擬 ATM 帳號產生
    public function WebATMAcct($PF_CODE,$PF_NO,$PF_Price,$PF_Date,$PF_PRINT)
    {
        $this->load->model( 'front_base_model' );
        
        $ATMNO = $PF_CODE;
              
        $syear = date('Y',strtotime($PF_Date));
        
        $ATMNO = $ATMNO.substr($syear, -1); 
        
        if ($PF_PRINT == "Y"){
        	 echo $ATMNO ;
        	 echo '<br>';
        	 echo $PF_NO;
        	 echo '<br>';
        }
      
        $DateDiffday = round((strtotime($PF_Date) - strtotime($syear."-01-01"))/3600/24) + 1;
        
        $ATMNO = $ATMNO .sprintf("%03d",$DateDiffday).sprintf("%02d",substr($syear, -2)).sprintf("%04d",$this->front_base_model->PF_SerOrder("A".$syear));
        
        if ($PF_PRINT == "Y"){
        	 echo $ATMNO ;
        	 echo '<br>';
        }
        
        $Fn = 0;
        for ($n = 0;$n < strlen($ATMNO);$n++){
             $Pn = (int)substr($ATMNO,$n, 1);
             switch ($n % 3) {
                    case '1':
                        $nx = 7;
                        break;                
                    case '2':
                        $nx = 1;
                        break;                
                    case '0':
                        $nx = 3;
                        break;                
             }
             $Pa = ($Pn * $nx) % 10;
             if ($PF_PRINT == "Y"){
                 echo $Pn;
                 echo " * ". $nx;
                 echo " / 10 = ". $Pa;
                 echo '<br>';
             }
             $Fn = $Fn + $Pa;
         }
         $Fna1 = $Fn % 10;
         if ($PF_PRINT == "Y"){
        	 echo "[".$Fna1."]";
        	 echo '<br>';
        }
         $F_Price = sprintf("%010d",$PF_Price);
         if ($PF_PRINT == "Y"){
             echo $F_Price;
             echo '<br>';
         }
         $Fn = 0;
         for ($n = 1;$n < 11;$n++){
              $Pn = substr($F_Price,$n-1, 1);
              $nx = 9 - $n;
              if ($nx <= 0){
       	         if ($nx == 0){
       	  	          $nx = 8;
       	         }else{
       	  	          $nx = 7;
       	         }
              }
              $Pa = ($Pn * $nx) % 10;
              if ($PF_PRINT == "Y"){
                  echo "".$n." = ".$Pn;
                  echo " * ". $nx;
                  echo " / 10 = ". $Pa;
                  echo "<br>";
              }
              $Fn = $Fn + $Pa;
         }
         $Fna2 = $Fn % 10;
          
         $Fna3 = ($Fna1 + $Fna2) % 10;
         $Fna4 = 10 - $Fna3;
         if ($Fna4 == 10){ $Fna4 = 0; }
         
         if ($PF_PRINT == "Y"){
             echo $Fna2;
             echo "<br>";
             echo $Fna3;
             echo "<br>";
             echo $Fna4;
             echo '<br>';
         }
         return $ATMNO . $Fna4;
     }

     /**
      * 取得宅配日
      * @param string $c_no 會員編號
      */
     public function fetchDeliveryDate($c_no, $p_no)
     {
        $cartDate = $this->db->from('ap_member_cart')
            ->where('c_no', $c_no)
            ->where('p_no', $p_no)
            ->get()
            ->row_array();
        
        if ($cartDate) {
            return $cartDate['days'];
        }

        return 0;
     }

    // 將購物車存入資料庫
    public function setDatabaseCart($string)
    {
        
        if (strpos($string, ',') !== false) {
            $cart = explode(',',$string);
            $cart = array_filter($cart, function($item){
                return $item !== '';
            });
        }else{
            $cart = $string;
        }        

        foreach ($cart as $_val){

            $insertData = array(
                'c_no' => $this->session->userdata('member_session')['c_no'],
                'p_no' => $_val,
            );
            $this->db->insert('ap_member_cart',$insertData);
        }
    }

    public function clearDatabaseCart()
    {
        if ($this->session->userdata('member_session')['c_no'] != ''){
            $this->db->where('c_no', $this->session->userdata('member_session')['c_no'])->delete('ap_member_cart');
        }
    }
}