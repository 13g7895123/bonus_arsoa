<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_product_model' );
        $this->load->model( 'front_mssql_model' );
                      
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    // 產品放入購物車
    public function incart()
    {
                  
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
      
        $result = array('status' => 0, 'errcode' => '', 'errmsg' => '');

        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
             $result['p_no']   = $data_post['p_no'];
             $result['num']    = $data_post['num'];
             $result['ptype']  = $data_post['ptype'];     
             
             $this->db->select( "p.*" )
                      ->from( 'product p' )                      
                      ->where( 'p_no', $data_post['p_no'] );
             $prd_data = $this->db->get()->row_array();
             if ($prd_data){
                 if (!is_numeric($data_post['num'])) {
                      $result['errmsg'] = "操作有誤！";
                      echo json_encode($result);
                      exit;
                 }
                 if ($result['ptype'] == 'M'){   // 紅利商品 
                     if ($prd_data['is_web'] == 0){
                          $result['errmsg'] = "此紅利商品未上架！";
                          echo json_encode($result);
                          exit;
                     }
                     if ($prd_data['is_nogoods'] == 1){
                          $result['errmsg'] = "此紅利商品未上架！";
                          echo json_encode($result);
                          exit;
                     }
                     if ($prd_data['m_mp'] == 0){
                          $result['errmsg'] = "此紅利商品未上架！";
                          echo json_encode($result);
                          exit;
                     }
                 }else{
                     if ($prd_data['is_nogoods'] == 1){
                          $result['errmsg'] = "此商品已售完缺貨中！";
                          echo json_encode($result);
                          exit;
                     }
                     if ($prd_data['is_shop'] == 0){
                          $result['errmsg'] = "此商品未上架！";
                          echo json_encode($result);
                          exit;
                     }
                 }
                 if (empty($this->session->userdata('ProductList'))){
                     $this->session->set_userdata( 'ProductList', $prd_data['p_no'] );
                     
                     $result['errmsg'] = "已加入購物車！";
                     $result['status'] = 1;
                 }else{
                     if ($this->front_order_model->check_cart($prd_data['p_no'])){                          
                         $result['errmsg'] = "已存在購物車！";
                     }else{
                         $this->session->set_userdata( 'ProductList', $this->session->userdata('ProductList').",".$prd_data['p_no'] );
                         $prd_session = $this->session->userdata('prd_session');
                         
                         $result['status'] = 1;
                     }
                 } 
                 if ($result['status']){
                     $prd_session[$prd_data['p_no']]  = $data_post['num'];
                         
                     $this->session->set_userdata( 'prd_session', $prd_session );
                         
                     // 暫存車
                     $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'],$prd_data['p_no'],$data_post['num']);                         
                     
                     $result['errmsg'] = "已加入購物車！";
                 }
             }else{
                 $result['errmsg'] = "此商品未上架！";                 
             }
         }
         $result['prd_num'] = $this->front_order_model->check_cart_num();  
         echo json_encode($result);
         exit;
    }   
     
    // 購物車檢視
    public function cart()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                  
            if ($data_post['edit'] == 'E'){
                if ($data_post['sfreight'] == 0 || $data_post['sfreight'] == 1 || $data_post['sfreight'] == 2){
                    $this->session->set_userdata( 'sfreight',$data_post['sfreight'] );
                }   
                if (isset($data_post['del_prd']) && $data_post['del_prd']){
                    foreach ($data_post['del_prd'] as $dprd){
                        $this->front_order_model->d_cart('D',$this->session->userdata('member_session')['c_no'],$dprd);
                    }  
                }
                $aprd = explode( ',', $this->session->userdata('ProductList') );
                for ($i=0;$i< count($aprd);$i++){
                    for ($k = 1;$k<= $data_post['p_num'];$k++){
                        if ($aprd[$i] == $data_post['p_no_'.$k]){
                            $prd_session[$aprd[$i]]  = $data_post['num_'.$k];
                            $this->session->set_userdata( 'prd_session', $prd_session );
                            
                            $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'],$aprd[$i],$data_post['num_'.$k]);       
                        }
                    }
                }
                redirect( 'order/cart' );
             }      
             redirect( 'order/checkout' );
             exit;
        }

        $msconn = $this->front_mssql_model->ms_connect();  
        
        // 將車子的產品放到 mssql isf_t
        $this->front_order_model->($msconn);
        
        $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
        
        $cart_data = array();
        if (!empty($this->session->userdata('ProductList'))){
            $cart_data = $this->front_product_model->cart_list($this->session->userdata('ProductList'));            
        }        
                        
        $meta['title2'] = '購物車';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        
        $data = array(
            'meta'        => $meta,
            'web_page'    => 'cart',          
            'sumdetail'   => $sumdetail,
            'cart_data'   => $cart_data
        );
        $data['meta']['canonical'] = site_url();      
        
        $where  = array ('epostid' => '6101');            
        $data['cart_remark'] = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
                       
        _timer('*** before layout ***');
        
        $this->layout->view('cart', $data);
    }
    
    // 購物車結帳
    public function checkout()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        if ($this->front_order_model->check_cart_num() == 0){
            alert('您尚未將產品放入購物車！');
        }
          
        $meta['title2'] = '購物車結帳';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $msconn = $this->front_mssql_model->ms_connect();
        
        $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
        
        if ($sumdetail['is_freight'] <> '0'){  // 抓運費
            if ($this->session->userdata('sfreight') == '2'){                
                $sumdetail['mp'] -= $this->session->userdata('FC_freight_mp');
            }
        }  
        if ($sumdetail['mp'] < 0){
            alert('紅利點數不足，請至購物車調整！',base_url('order/cart'));
        }
          
        $cart_data = array();
        if (!empty($this->session->userdata('ProductList'))){
            $cart_data = $this->front_product_model->cart_list($this->session->userdata('ProductList'));            
        }
              
        $data = array(
            'meta'           => $meta,
            'web_page'       => 'checkout',
            'city'           => $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc')),
            'sumdetail'      => $sumdetail,
            'cart_data'      => $cart_data
        );                               
                               
        _timer('*** before layout ***');
        
        $this->layout->view('checkout', $data);
    }
    
    // 地址顯示
    public function set_address_show($asort)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $result = array('status' => 0, 'errmsg' => '', 'params' => '');   
        
        $address_list = $this->front_member_model->get_address($this->session->userdata('member_session')['c_no']);
                
        if (!$address_list){  // 地址是空的塞入會員的值
             $indata = array(
                            'c_no' => $this->session->userdata('member_session')['c_no'],
                            'c_name' => $this->session->userdata('member_session')['c_name'],
                            'postal' => $this->session->userdata('member_session')['zip_dl'],
                            'address' => $this->session->userdata('member_session')['addr_dl'],
                            'tel' => $this->session->userdata('member_session')['cell1'],
                            'sort' => 0,
                            'crdt' => date('Y-m-d H:i:s'),
                            'updt' => date('Y-m-d H:i:s')
                           );
                           
             $this->front_base_model->insert_table('ap_member_address',$indata);            
        }
        $address_list = $this->front_member_model->get_address($this->session->userdata('member_session')['c_no']);  
             
        $nadr = 0;     
        $html = '';
        if ($address_list){                            
                 foreach ($address_list as $key => $item){                                   
                          $nadr++;
                          $nclass = '';
                          $nc = '';
                          if ($nadr == 1 && $asort == 0){
                              $nclass = ' checked';
                              $nc = ' active';
                          }else{
                              if ($asort == $item['aid']){
                                  $nclass = ' checked';
                                  $nc = ' active';
                              }
                          }
                          $html .= '<label id="addrid_'.$nadr.'" class="btn btn-outline-secondary col-xs-12 col-sm-12 col-md-4 col-lg-4 p-3 mb-3 rounded text-left'.$nc.'" >
                                    <input type="radio" name="set_addr" id="set_addr" value="'.$item['aid'].'" autocomplete="off" '.$nclass.'>
		                                    <h5>'.htmlspecialchars($item['c_name']).'</h5>
                                        <h6 class="card-subtitle mb-2">'.htmlspecialchars($item['tel']).'</h6>
                                        <p >'.$item['postal'].' '.$item['address'].'</p>
                                        <a href="javascript:void(0);" onclick="set_address('.$item['aid'].');" class="float-right text-white">編輯</a>
                                    </label>';
			        }
		  } 
		  
		  $result['addr_num'] = $nadr;
		  $result['html'] = $html;
				
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;
        
    }
    
    // 地址取出
    public function set_address($aid = 0)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $result = array('status' => 0, 'errmsg' => '', 'params' => '');   
        if ($aid > 0){
            $params = $this->front_base_model->get_data('ap_member_address',array('c_no'=>$this->session->userdata('member_session')['c_no'],'aid'=>$aid),'',1);
            if ($params['postal'] > ''){
                $params['cityno'] = $this->front_base_model->get_data('town',array('postal'=>$params['postal']),'',1)['cityno'];                
                $params['town'] = $this->front_base_model->get_data('town',array('cityno' => $params['cityno'] ),array('postal'=>'asc'));
            } 
            $result['status'] = 1;
            $result['params'] = $params;
        }
        
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;
    }
    
    //  地址存檔
    public function set_address_save()
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        
        $result = array('status' => 0, 'errcode' => '', 'errmsg' => '操作有誤!');

        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){          
             if ($data_post['addr_name'] > '' && $data_post['addr_address'] > '' && $data_post['addr_tel'] > ''){
                 $where = array ('c_no'=> $this->session->userdata('member_session')['c_no']);             
                 $cnt = $this->front_base_model->count_total('ap_member_address',$where);
                 
                 $data = array(
                                'c_name'  => trim($data_post['addr_name']),
                                'postal'  => trim($data_post['addr_postal']),
                                'address' => trim($data_post['addr_address']),
                                'tel'     => trim($data_post['addr_tel'])
                             );
                 // -- 如果4個欄位在資料庫已有 就 UPDATE 
                 $params = $this->front_base_model->get_data('ap_member_address',$data,'',1);
                 if ($params){
                     $data_post['addr_id'] = $params['aid'];
                 }
                 // -- 預設地址 S
                 if (!isset($data_post['addr_set'])){
                     $data_post['addr_set'] = 'N';
                 }
                 if (trim($data_post['addr_set']) == 'Y' || $cnt == 0){
                     $data['sort'] = 0;
                 }else{
                     $data['sort'] = 99;
                 }
                 // -- 預設地址 E
                 
                 if ($data_post['addr_id'] == 0){  // 新增
                     if ($cnt >= 6){
                         $result['errmsg'] = '您只能有6筆地址設定！';
                     }else{
                         $data['crdt'] = date('Y-m-d H:i:s');
                         $data['updt'] = date('Y-m-d H:i:s');
                         $data['c_no'] = $this->session->userdata('member_session')['c_no'];                 
                         $aid = $this->front_base_model->insert_table('ap_member_address',$data);
                         $result['status'] = 1;
                     }
                 }else{
                     $data['updt'] = date('Y-m-d H:i:s');
                     $where = array ('aid' => $data_post['addr_id'],'c_no'=> $this->session->userdata('member_session')['c_no']);                              
                     $this->front_base_model->update_table('ap_member_address',$data ,$where);  
                     $result['status'] = 1;
                     $aid = $data_post['addr_id'];
                 }
                 // -- 預設地址 S
                 if ($cnt >= 1 && $data['sort'] == 0){
                     $where = array ('aid<>' => $data_post['addr_id'],'c_no'=> $this->session->userdata('member_session')['c_no']);                              
                     $this->front_base_model->update_table('ap_member_address',array('sort' => 99 ) ,$where);  
                 }
                 $result['addr_id'] =  $aid;
             }
        }
        echo json_encode($result);
        exit;
    }
    
    // 付款囉 產生訂單
    public function pay()
    {
          if ( !$this->front_member_model->check_member_login( TRUE ) ) {
               redirect( 'member/login' );
          }
        
          //--結帳鎖定通知--
          $this->block_service->dataset();            
          //--結帳鎖定通知--  
          
          if ($this->front_order_model->check_cart_num() <= 0){
              alert('您尚未將產品放入購物車！');
              exit;
          }
            
          $data_post = $this->input->post();
          if ( is_array( $data_post ) && sizeof( $data_post ) > 0)
          {                         
               $web_no = $this->front_order_model->web_no(); // 訂單單號
              
               $web_data = $this->front_base_model->get_data('web_base',array('1'=>1),'',1);        
               if ($web_data){
                   $bv_date = trim($web_data["bv_date"]);
               }
               // 抓地址
               $recv_data = $this->front_base_model->get_data('ap_member_address',array('c_no'=>$this->session->userdata('member_session')['c_no'],'aid'=>$data_post['set_addr']),'',1);
               
               if (!$recv_data){
                   alert('收件人資訊，設定有誤！');
                   exit;
               }
               $msconn = $this->front_mssql_model->ms_connect();
               
               // -- 主檔 UPDATE -- 
               $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
               
               $add_p_no  = '';                              
               if ($sumdetail['is_freight'] <> '0'){  // 抓運費
                   if ($this->session->userdata( 'sfreight') == '2'){
                       $add_p_no = ",A000000";
                       $sumdetail['m_mp'] += $this->session->userdata('FC_freight_mp');                       
                       $sumdetail['mp'] -= $this->session->userdata('FC_freight_mp');
                   }else{
                       $add_p_no = ",0000000";
                       $sumdetail['amt'] += $this->session->userdata('FC_freight');
                   }
               }
               
               if ($sumdetail['mp'] < 0){
                   alert('紅利點數不足，請至購物車調整！',base_url('order/cart'));
               }
               $CheckCode = uniqid();
               //　訂單主檔　
               $paramsh = array(
                             'success'    => '0',
                             'web_no'     => $web_no,
                             'c_no'       => $this->session->userdata('member_session')['c_no'],
                             'c_name'     => $this->session->userdata('member_session')['c_name'],
                             'd_posn'     => $this->session->userdata('member_session')['d_posn'],
                             'bv_date'    => $bv_date,
                             'recv_name'  => $recv_data['c_name'],
                             'zip_dl'     => $recv_data['postal'],
                             'addr_dl'    => $recv_data['address'],
                             'cell1'      => $recv_data['tel'],                             
                             'e_mail'     => $data_post['email'],
                             'idno'       => $data_post['idno'],
                             'pay_type'   => $data_post['paytype'],
                             'send_type'  => '貨運',                             
                             'amt'        => 0,
                             'a_pv'       => 0,
                             'b_pv'       => 0,
                             'a_amt'      => 0,
                             'b_amt'      => 0,
                             'u_amt'      => 0,
                             'pay_amt'    => 0,                             
                             'mp_amt'     => 0,
                             'bf_mp'      => 0,
                             'r_mp'       => 0,
                             'p_mp'       => 0,
                             'm_mp'       => 0,                             
                             'ord_statue' => '付款未完成',
                             'CheckCode'  => $CheckCode,
                             'or_date'    => date('Y-m-d H:i:s')
                         );
               
               $this->front_mssql_model->insert_data($msconn,"isf_h",$paramsh);
               
               // 訂單單身產品
               $cart_data = $this->front_product_model->cart_list($this->session->userdata('ProductList').$add_p_no);                           
               foreach ($cart_data as $key => $item){             
                        if ($item["p_no"] == 'A000000' || $item["p_no"] == '0000000'){  //  運費
                            $qty = 1; 
                        }else{
                            $qty = $this->front_order_model->check_cart_prd_num(trim($item["p_no"]));
                        }
                        $paramsb = array(
                                         'web_no'     => $web_no,
                                         'p_no'       => trim($item['p_no']), 
                                         'p_name'     => trim($item['p_name']), 
                                         'r_price'    => trim($item['r_price']),                                          
                                         'c_price'    => trim($item['c_price']),                                          
                                         'pv'         => trim($item['pv']), 
                                         'p_mp'       => trim($item['p_mp']), 
                                         'm_mp'       => trim($item['m_mp']), 
                                         'mp_amt'     => trim($item['mp_amt']), 
                                         'qty'        => $qty, 
                                         'a_pv'       => trim($item['a_pv']), 
                                         'opv_h'      => trim($item['opv_h']), 
                                         'a_amt'      => trim($item['a_amt']), 
                                         'b_amt'      => trim($item['b_amt'])
                                   );                               
                        $this->front_mssql_model->insert_data($msconn,"isf_b",$paramsb);
               }               
               
               $purchAmt = $sumdetail['amt'];
                              
               $uparams = array (
                          'amt'     => $sumdetail['amt'],    // 總金額+運費
                          'a_amt'   => $sumdetail['a_amt'],
                          'b_amt'   => $sumdetail['b_amt'],
                          'u_amt'   => $sumdetail['u_amt'],
                          'a_pv'    => $sumdetail['a_pv'],
                          'b_pv'    => $sumdetail['b_pv'],
                          'mp_amt'  => $sumdetail['mp_amt'],
                          'r_mp'    => $sumdetail['r_mp'],
                          'p_mp'    => $sumdetail['p_mp'],                          
                          'm_mp'    => $sumdetail['m_mp']    // 使用的紅利
                       );               
               // -- 主檔 UPDATE -- 
               
               if ($sumdetail['amt'] == 0 && $data_post['paytype'] == 'F'){   // 紅利積點兌換
                   $uparams['ord_statue'] = '付款成功';
                   $uparams['success']    = 1;
                   $uparams['pay_date']   = date('Y-m-d H:i:s');
               }
               $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no));   
               
               if ($sumdetail['amt'] == 0 && $data_post['paytype'] == 'F'){   // 紅利積點兌換
                   
                   //$this->send_order_mail($msconn,$this->session->userdata('member_session')['c_no'],$web_no);  // 寄信通知
                   
                   $this->front_order_model->clear_cart($msconn);  // 成功清空購物車
                   
                   redirect( 'order/orderview/'.$web_no );
                   
                   exit;
               }
               
               include APPPATH.'libraries/auth_mpi_mac.php';           
               
               $MerchantName = mb_convert_encoding($this->config->item('pay')['MerchantName'], 'BIG-5', "UTF-8");   // 設定特店網站或公司名稱
          
               if ( $_SERVER['HTTP_HOST'] == 'www.arsoa.tw'){
                    $OrderDetail = '訂單';
               }else{
                    $OrderDetail = '測試訂單'; 
               }
               $OrderDetail = mb_convert_encoding($OrderDetail, 'BIG-5', "UTF-8").":".$web_no;  
                                       
               $action = '';
                   
               if ($data_post['paytype'] == 'C'){  // 信用卡            
                   $MerchantID = $this->config->item('pay')['card_MerchantID'];        
                   $TerminalID = $this->config->item('pay')['card_TerminalID'];     
                   /*
                   txType
                   交易方式，長度為一碼數字： 0 ：一般交易， 1 ：分期交易， 2 ：紅利折抵一般交易。 4 ：紅利折抵分期交易
                   */
                   $txType="0"; 
                   /*
                   Option
                   產品代碼、分期期數或產品代碼加分期期數，純數字。 (1) 一般特店請填「1」。 
                   (2) 分期特店請填長度為一到兩碼的分期期數。 (3) 紅利特店請填長度為固定兩碼的產品代碼。 (4) 紅利分期特店長度為三到四碼，前兩碼固定為產品代碼，後 一碼或兩碼為分期期數。
                   */
                   $Option="1"; 
                   $Key = $this->config->item('pay')['card_key'];   // 壓碼字串               
                   $AuthResURL = $this->config->item('pay')['card_AuthResURL'];  // 回傳網址              
                   /*
                   AutoCap
                   是否自動請款。 0–不自動請款 1–自動請款
                   */
                   $AutoCap="1"; 
                   /*
                   Customize
                   設定刷卡頁顯示特定語系或客制化頁面。 1–繁體中文 2–簡體中文 3–英文 5–客制化頁面 
                   */
                   $Customize="1"; 
                   
                   $debug="0"; /* debug 預設(進行交易時)請填 0，偵錯時請填 1。*/
                                 
                   $MACString=auth_in_mac($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$debug); 
                       
                   //   echo"InMac=$MACString\n<br><br>"; 
                   
                   $URLEnc=get_auth_urlenc($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$MACString,$debug); 
                   
                   //  echo"UrlEnc=$URLEnc\n"; 
                   
                   $action = $this->config->item('pay')['card_action'];
                   
                   $merID = $this->config->item('pay')['card_merID'];
              
               }else{
                   $MerchantID = $this->config->item('pay')['webatm_MerchantID'];        
                   $TerminalID = $this->config->item('pay')['webatm_TerminalID'];   
                   
                   $txType="9"; 
                   $Option=""; 
                   $Key=$this->config->item('pay')['webatm_key'];
                   $AuthResURL=$this->config->item('pay')['webatm_AuthResURL'];          
                   $AutoCap=""; 
                   $Customize="1";               
                   $debug="1"; /* debug 預設(進行交易時)請填 0，偵錯時請填 1。*/
                   
                   $MACString=auth_in_mac($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$debug);     
                   
                   $WebATMAcct="81881"; 
                   
                   $storeName = $MerchantName; 
                   $billShortDesc="";  // 訂單摘要
                   /* 
                   $atmdate = date('Y-m-d',strtotime('+3 day')); // + 3 天
                   
                   $WebATMAcct = $this->front_order_model->WebATMAcct($this->config->item('pay')['webatm_acct'],$web_no ,$purchAmt,$atmdate,"N");  //轉入帳號
                   echo $WebATMAcct;
                   exit;
                   */
                   
                   $note="";    // 其它交易資訊
                   
                   $AuthResURL = $this->config->item('pay')['webatm_AuthResURL']; 
                    
                   $ATMEnc=get_auth_atmurlenc($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$storeName,$AuthResURL,$billShortDesc,$WebATMAcct,$note,$MACString,$debug);       
                   
                   // echo $MACString."<BR>\n"; 
                   // echo $ATMEnc."<BR>\n"; 
                                 
                   if ($payment == 'A'){  // 虛擬 ATM
                    
                   }else{                 // WEBATM
                       $action = $this->config->item('pay')['webatm_action'];
                       $merID = $this->config->item('pay')['webatm_merID'];
                       $URLEnc = $ATMEnc;
                   }
               }
                              
               if ($action > ''){
                ?><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                 <title>arsoa pay</title></head><body bgcolor="#FFFFFF">   
                  <form id="keyinorder" name="keyinorder" method="post" action="<?=$action?>">
                     <table width="540" bgcolor="#999999" style="display:none">     
                        <tr>      
                           <td width="100%">       
                             網路特店編號(MerID)：<input type="hidden" name="merID" value="<?=$merID?>" >      
                           </td>     
                        </tr>     
                        <tr>      
                           <td width="100%">加密值： <input type="hidden" name="URLEnc" value="<?=$URLEnc?>">      </td>  
                       </tr>    
                       <tr bgColor=#aedcff>               
                           <td align="middle">      
                              <input name="imageField" type="submit" value="Pay by credit card" border=0 height="32" width="161">    
                           </td>     
                       </tr>      
                     </table>   
                  </form>  
                  </body>
                </html> 
                <script>document.keyinorder.submit();</script>
                <?php          
               }
          }
    }
    //  https://www.arsoa.tw/order/auth/C  信用卡
    //  https://www.arsoa.tw/order/auth/W  WEBATM
    //  https://www.arsoa.tw/order/auth/A  虛擬ATM
    
    public function auth($payment = 'C',$test = '')
    {
         
        include APPPATH.'libraries/auth_mpi_mac.php'; 
        
        $debug = "0"; 
        $sendmail = 'N'; 
        $CheckCode = '';
        if ($payment == 'C'){
            $data_post = $this->input->post();
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
                 $merID = $data_post['merID'];  
                 $EncRes = $data_post['URLResEnc'];  // 回傳的密文，請參考3.8特店網站設定AuthResURL(加密專用)取得URLResEnc  
       
                 $Key = $this->config->item('pay')['card_key'];                  
                 $EncArray=gendecrypt($EncRes,$Key,$debug);                  
                 
                 if ($test == 'Y'){
                     foreach($EncArray AS $name => $val){  
                         echo $name ."=>". urlencode(trim($val,"\x00..\x08")) ."<br>\n"; 
                     }       
                 }
                                 
                 $status = isset($EncArray['status']) ? $EncArray['status'] : ""; // 交易狀態碼
                 $errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : "";   // 交易錯誤碼
                 $errdesc = isset($EncArray['errdesc']) ? $EncArray['errdesc'] : "";   // 交易錯誤訊息
                 $merid = isset($EncArray['merid']) ? $EncArray['merid'] : "";   // 特店代碼
                 $authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";  // 交易授權碼
                 $authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";   // 交易金額
                 $web_no = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";  //訂單編號      
                 $xid = isset($EncArray['xid']) ? $EncArray['xid'] : "";  //授權之交易序號
                 $Last4digitPAN = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";   //卡號末四碼
                 $authresurl = isset($EncArray['authresurl']) ? $EncArray['authresurl'] : "";            // 回傳網址
                 
                 $OffsetAmt = isset($EncArray['OffsetAmt']) ? $EncArray['OffsetAmt'] : "";       
                 $OriginalAmt = isset($EncArray['OriginalAmt']) ? $EncArray['OriginalAmt'] : "";       
                 $UtilizedPoint = isset($EncArray['UtilizedPoint']) ? $EncArray['UtilizedPoint'] : "";       
                 $Option = isset($EncArray['numberofpay']) ? $EncArray['numberofpay'] : ""; // 分期期數
                 
                 /*
                    //紅利交易時請帶入prodcode 
                   $Option = isset($EncArray['prodcode']) ? $EncArray['prodcode'] : ""; 
                 
                   $CardNumber = isset($EncArray['cardnumber']) ? $EncArray['cardnumber'] : "";  // 隱碼卡號
                   $CardNo  = isset($EncArray['cardno']) ? $EncArray['cardno'] : "";//(僅供優化環境使用)       
                   $EInvoice  = isset($EncArray['einvoice']) ? $EncArray['einvoice'] : "";//(僅供優化環境使用) 
                 */                                  
                 $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$web_no,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option,$Last4digitPAN,$Key,$debug);    
                 if  ($MACString == $EncArray['outmac']){                      
                      $msconn = $this->front_mssql_model->ms_connect();  
                      
                      $params = array ($web_no); 
                      $data = $this->front_mssql_model->get_data($msconn,"select web_no,c_no,pay_type,isnull(pay_date,'') as pay_date,CheckCode from isf_h where web_no = ?",$params);
                      
                      if (count($data) > 0){
                          if ($test == 'Y'){
                              echo "<pre>".print_r($data[0],true)."</pre>";
                          }
                      
                          $data = $data[0];
                          
                          if (trim($data['pay_date']) <> '1900-01-01 00:00:00.000'){
                              alert( $web_no.' 此訂單已經交易過！',base_url('order/orderlist') );
                              exit;                              
                          }
                          $c_no = trim($data['c_no']);
                          
                          $CheckCode = trim($data['CheckCode']);
                          
                          $uparams = array (
                                             'buysafeord'   => $xid,  
                                             'status'       => $status
                                           );
                                    
                          if ($status == '0'){ // 付款成功                             
                              $uparams['success'] = 1;
                              $uparams['Last4digitPAN'] = $Last4digitPAN;
                              $uparams['ord_statue'] = '付款成功';
                              $uparams['pay_amt'] = $authAmt;
                              
                              $sendmail = 'Y';                              
                            
                              $this->front_order_model->clear_cart($msconn);  // 刷卡成功清空購物車
                          }else{               // 付款失敗
                              $uparams['ord_statue'] = '付款失敗';
                              $uparams['pay_amt'] = 0;
                          }
                          if ($test == 'Y'){
                              echo "<pre>".print_r($uparams,true)."</pre>";
                          }
                          $uparams['ApproveCode'] = $authCode;
                          $uparams['errcode']     = $errCode;
                          $uparams['errmsg']      = $errdesc;
                          $uparams['pay_date']    = date('Y-m-d H:i:s');
                          
                          //echo "<pre>".print_r($uparams,true)."</pre>";                 
                        
                          $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no,'c_no'=>$c_no));   
                          
                          $this->front_member_model->member_cookie_login();
                          
                      }else{
                       
                          alert( '操作有誤煩請重新訂購(ER01)！',base_url('order/cart') );
                          exit;
                      }
                 }else{
                      alert( '操作有誤煩請重新訂購(ER02)！',base_url('order/cart') );
                      exit;
                 }                 
            }else{
                 alert( '操作有誤煩請重新訂購(ER03)！',base_url('order/cart') );
                 exit;
            }                         
      }elseif($payment = 'W'){
            $EncRes = $data_post['URLResEnc'];
            
          /*  $EncRes="EB243846DC2350DFD452F93B258426A4C84D7A6DA685C7E0CF1AC76554EE0F21B1CC9B44F6A070D5BB4D53231C5ECB81B829673EE7E6E44DD1F08F86E565B0009D3C592578C23DF3DFD06D9356AC029E67C350772FA5554A2A10315670163AE112B9ADE26FC1F7D0974574B0450EA3F900C2583D76E464BAAF25AEB008AA8B611FCB7BD4ED85071C29C1A373C8AF34F7B16501DC5CD423E4442A99BEB3DDF8FE947B240B6366DB04AA9D0C3B01C1CB8375E9D00086EBCD18DD2330CBDA8B41D3C48CEFB0D5202AEAD258A662AB07682AFC7D28FEB711784D";  
            $Key="StS33NFssFN33StSStS33NFs";             
            */
            $Key = $this->config->item('pay')['webatm_key'];                  
             
            $EncArray=gendecrypt($EncRes,$Key,$debug);     

            $MACString=''; 
            $URLEnc=''; 
             
            foreach($EncArray AS $name => $val){  
                    $URLEnc = $URLEnc .$name ."=>". urlencode(trim($val,"\x00..\x08")) ."<br>"; 
            }  
       
            $status = isset($EncArray['status']) ? $EncArray['status'] : ""; 
            $errCode = isset($EncArray['errcode']) ? $EncArray['errcode'] : ""; 
            $authCode = isset($EncArray['authcode']) ? $EncArray['authcode'] : "";  // 交易金資序號
            $authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : ""; // 交易金額
            $web_no = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";                      // 訂單編號
            $OffsetAmt = isset($EncArray['feecharge']) ? $EncArray['feecharge'] : "";       // 手續費
            $OriginalAmt = isset($EncArray['originalamt']) ? $EncArray['originalamt'] : ""; 
            $UtilizedPoint = isset($EncArray['utilizedpoint']) ? $EncArray['utilizedpoint'] : ""; 
            $Option = isset($EncArray['option']) ? $EncArray['option'] : ""; 
            $Last4digitPAN = isset($EncArray['last4digitpan']) ? trim($EncArray['last4digitpan'],"\x00..\x08") : ""; 
            
            $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$web_no,$OffsetAmt,$OriginalAmt,$UtilizedPoint, $Option,$Last4digitPAN,$Key,$debug);    
            
            echo $MACString."<BR>\n";     
            
            echo $URLEnc."<BR>\n";  
 
            if ($EncArray['outmac']== $MACString){ echo ' the result is right! ';}
            exit;
      }
      
     // echo "<pre>".print_r($this->session->userdata('member_session'),true)."</pre>";
      
      if ($sendmail == 'Y'){ //付款成功寄信通知
        //  $this->send_order_mail($msconn,$c_no,$web_no);  // 寄信通知
      }
      
    //  exit;
      redirect( 'order/orderview/'.$web_no );
      exit;
      ?>
      <html>
      <head>
      <title><?=FC_Web?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      </head>
      <body>
      <form method="post" name="goorder" action="<?=base_url('order/orderview')?>" >
      <input type="hidden" name="wd" value="<?=$web_no?>">
      <input type="hidden" name="sc" value="<?=$CheckCode?>">
      <input type="hidden" name="Order" value="Y">
      </form>
      </body>
      </html>
      <script>
      //document.goorder.submit();
      </script>
      <?php
      exit;
    }
    
    public function orderview($web_no)
    {
           if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                redirect( 'member/login' );
           }
        
           $msconn = $this->front_mssql_model->ms_connect();  
           
           $order_detail = $this->front_order_model->order_detail($msconn,$this->session->userdata('member_session')['c_no'],$web_no);
           
           if ($order_detail){
                             
               $meta['title2'] = '訂單檢視';
               $meta['title1'] = FC_Web.' - '.$meta['title2'];
               $data['meta']['canonical'] = site_url();      
              
               $data['meta'] = $meta;
               $data['web_page'] = 'orderview';
               $data['meta'] = $meta;        
               
               $data['order_detail'] = $order_detail['html'];
               
               $where  = array ('epostid' => '6101');            
               $data['cart_remark'] = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
                              
               $this->layout->view('orderview', $data);               
           }else{
               alert( '無此訂單！');
               exit;
           }
    }
      
    // 訂單列表
    public function orderlist()
    {
           if ( !$this->front_member_model->check_member_login( TRUE ) ) {
               redirect( 'member/login' );
           }
           
           $msconn = $this->front_mssql_model->ms_connect();  
           
           $params = array ($this->session->userdata('member_session')['c_no']); 
           $orderdata = $this->front_mssql_model->get_data($msconn,"select top 30 * from isf_h where c_no = ? order by or_date desc ",$params);
           
           $meta['title2'] = '訂單列表';
           $meta['title1'] = FC_Web.' - '.$meta['title2'];
           $data['meta']['canonical'] = site_url();      
              
           $data['meta'] = $meta;
           $data['web_page'] = 'orderlist';
           $data['orderlist'] = $orderdata;
               
           $this->layout->view('orderlist', $data);                  
    }
    
    public function send_order_mail($msconn,$c_no,$web_no)
    {
           $order = $this->front_order_model->order_detail($msconn,$c_no,$web_no);
           
           $Subject = FC_Web." 訂單成立通知(".$web_no.")";
           
	  	     $Body = '<!DOCTYPE html>
	  	            <html lang="zh-TW">
	  	            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />                  
	  	            <body style="padding:15px; margin:0px; color:#696969; line-height:1.5;">
	  	            	<div style="border:#dddddd 1px solid; margin: 10px auto; width: 96%; max-width:800px; padding:0px 2%;">
	  	            		<div style="text-align:center; border-bottom:#dddddd 1px solid; padding:10px 0px;font-size:24px;text-decoration:none;color:#003b8f;">
	  	            		<a href="'.base_url().'" target="_blank"><img src="'.base_url().'public/images/logo.png" style="max-width: 125px;" alt="'.FC_Web.'"></a></div>
	  	            		<div style="padding:5px 15px 30px 15px; background: #FFFFFF; font-family:Lucida Grande, Helvetica, Arial, sans-serif;">
	  	            			<h4 style="color:#1a1a1a;">親愛的 '.$order['main']['c_name'].' 您好：<br><br>您所訂購的明細如下：</h4>	  	            			
	  	            			<p>'.$order['html'].'</p>	  	            			
	  	            		</div>
	  	            		<div style="text-align:center; border-top: #dddddd solid 1px; font-size:12px; width: 100%; padding:10px 0px; color:#999;">	  	            	
	  	            			<a href="'.base_url().'" target="_blank">© '.date('Y').' '.FC_Company.'</a>
	  	            		</div>
	  	            	</div>
	  	            </body>                  
	  	            </html>';
	  	            
	  	  $this->send_email($order['main']['e_mail'],$Subject,$Body);	
      
    }
          
}