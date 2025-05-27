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
        if (!$this->front_member_model->check_member_login( TRUE ) ) {
            //$refer = '';  //上一頁
            //if (isset($_SERVER['HTTP_REFERER'])){
            //    $refer = "?rdurl=".$_SERVER['HTTP_REFERER'];
            //}          
            //alert('請先登入！',base_url('member/login'.$refer));
            //redirect( 'member/login' );
            $result = array('status' => 0, 'errcode' => 'notlogin', 'errmsg' => '請先登入！');              
            echo json_encode($result);
            exit;
        }
        $result = array('status' => 0, 'errcode' => '', 'errmsg' => '');  
        
        if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'test'){
            $result['errmsg'] = "管理者不能使用會員身份，將產品放入購物車(A90)！";
            echo json_encode($result);
            exit;
        }
      
        $data_post = $this->input->post();
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
            $result['p_no']   = $data_post['p_no'];
            $result['num']    = $data_post['num'];
            $result['ptype']  = $data_post['ptype'];     
             
            if ($data_post['ptype'] == 'S'){   // 販促活動
                if ($this->session->userdata('use_cart') == 'N'){
                    $result['errmsg'] = "您只能兌換紅利商品(S01)！";
                    echo json_encode($result);
                    exit;
                }
                 
                $where  = array ('id' => $data_post['p_no'], 'nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );             
                $list = $this->front_base_model->get_data('ap_sale',$where,array(),1);
                if ($list){
                    if (!(strtotime($list['show_stdt']) <= strtotime(date('Y-m-d H:i:s')) && ($list['show_eddt'] == '' || strtotime($list['show_eddt']) >= strtotime(date('Y-m-d H:i:s'))))){                    
                        $result['errmsg'] = "活動尚未開始(S02)！";
                        echo json_encode($result);
                        exit;
                    }        
                   //  if ($this->session->userdata('member_session')['c_no'] == '000000' || $this->session->userdata('member_session')['c_no'] == '200764'){ 
                    if ($list['qty'] == 0){
                        $result['errmsg'] = $list['qtext'];
                        echo json_encode($result);
                        exit;
                    }
                   //  }
                    if ($list['product'] == ''){
                        $result['errmsg'] = "無此販促活動(S03)！";
                        echo json_encode($result);
                        exit;
                    }
                    $prddata = json_decode($list['product'], true);
                     
                    $product_num = $prddata;                     
                     
                    $sqlin = array();
                    foreach ($prddata as $key => $item){
                        $sqlin[] = $key;
                    }
                    $pid = implode("','",array_unique($sqlin));
                    $sql = "select p.p_no,p.p_name,p.is_visual,p.c_price
                            from product p
                            where p.p_no in ('".$pid."')  
                            and (ifnull(p.c_price,0) > 0 or p.is_visual= 1) "; //and p.is_list=1
                    $pdata = $this->front_base_model->small_query($sql);                  
                    if ($pdata){                         
                        if (count($product_num) == count($pdata)){
                            foreach ($pdata as $key => $prd_data){
                                if (empty($this->session->userdata('ProductList'))){
                                    $this->session->set_userdata( 'ProductList', $prd_data['p_no'] );   
                                    $this->front_order_model->setDatabaseCart($prd_data['p_no']);
                                }else{
                                    if (!$this->front_order_model->check_cart($prd_data['p_no'])){       
                                        $cartString = $this->session->userdata('ProductList').",".$prd_data['p_no'];
                                        $this->session->set_userdata( 'ProductList', $cartString );    
                                        $this->front_order_model->setDatabaseCart($cartString);
                                    }
                                    $prd_session = $this->session->userdata('prd_session');
                                } 
                                if (empty($prd_session[$prd_data['p_no']])){
                                    $prd_session[$prd_data['p_no']] = 0;
                                }
                                       
                                $prd_session[$prd_data['p_no']]  += $product_num[$prd_data['p_no']];                                               
                                if ($prd_session[$prd_data['p_no']] > 99){
                                    $prd_session[$prd_data['p_no']] = 99;
                                }
                                $this->session->set_userdata( 'prd_session', $prd_session );
                                
                                // 暫存車
                                $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'], $prd_data['p_no'], $product_num[$prd_data['p_no']]);                                       
                            }                             
                            $result['errmsg'] = "販促活動，已加入購物車！";
                            $result['status'] = 1;
                        }else{
                            $result['errmsg'] = "無此販促活動(S04)！";
                            echo json_encode($result);
                            exit;
                        }
                    }else{
                        $result['errmsg'] = "無此販促活動(S05)！";
                        echo json_encode($result);
                        exit;
                    }
                 }else{
                     $result['errmsg'] = "無此販促活動(S99)！";
                     echo json_encode($result);
                     exit;
                 }
             }else{             
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
                         if ($prd_data['wp1_no'] == 6){
                         	   //if ($prd_data['wp2_no'] == 'S12' && $this->session->userdata('member_session')['d_posn'] == 60) {
                         	   //    $result['errmsg'] = "權限不足，無法購買輔銷品！";
                             //    echo json_encode($result);
                             //    exit;
                         	   //}  	
                         }                         
                     }else{
                         if ($this->session->userdata('use_cart') == 'N'){
                             $result['errmsg'] = "您只能兌換紅利商品！";
                             echo json_encode($result);
                             exit;
                         }else{
                             if ($prd_data['wp1_no'] == '6' && $prd_data['wp2_no'] == 'S12' && $this->session->userdata('member_session')['d_posn'] == 60){
                             	    $result['errmsg'] = "此輔銷品無法購買！";
                                  echo json_encode($result);
                                  exit;
                             }
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
                     }
                                          
                     if (empty($this->session->userdata('ProductList'))){
                         $this->session->set_userdata( 'ProductList', $prd_data['p_no'] );
                         $this->front_order_model->setDatabaseCart($prd_data['p_no']);
                         
                         $result['errmsg'] = "已加入購物車！";
                         $result['status'] = 1;
                     }else{
                         if ($this->front_order_model->check_cart($prd_data['p_no'])){                          
                             $result['errmsg'] = "已存在購物車！";
                         }else{
                            $cartString = $this->session->userdata('ProductList').",".$prd_data['p_no'];
                            $this->session->set_userdata( 'ProductList', $cartString );
                            $this->front_order_model->setDatabaseCart($cartString);
                            $result['status'] = 1;
                         }
                         $prd_session = $this->session->userdata('prd_session');
                     } 
                     if ($result['status']){
                         if (empty($prd_session[$prd_data['p_no']])){
                         	   $prd_session[$prd_data['p_no']] = 0;
                         }
                                       
                         $prd_session[$prd_data['p_no']]  += $data_post['num'];                             
                         
                         if ($prd_session[$prd_data['p_no']] > 99){
                         	   $prd_session[$prd_data['p_no']] = 99;
                         }
                         $this->session->set_userdata( 'prd_session', $prd_session );
                             
                         // 暫存車
                         $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'],$prd_data['p_no'],$data_post['num']);                         
                         
                         $result['errmsg'] = "已加入購物車！";
                     }
                 }else{
                     $result['errmsg'] = "此商品未上架！";                 
                 }
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
        if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'test'){
        	  alert('管理者不能使用會員身份，進入購物車(A91)！',base_url('member/main'));
            exit;
        }
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        $data_post = $this->input->post();

        // 當購物車沒有資料時，確認資料庫是否有
        if ($this->session->userdata('ProductList') == ''){
            $cartData = $this->db->from('ap_member_cart')
                ->where('c_no',$this->session->userdata('member_session')['c_no'])
                ->get()
                ->result_array();

            if ($cartData){
                $pNoData = array_column($cartData, 'p_no');
                $sessionData = implode(',',$pNoData);
                $this->session->set_userdata('ProductList', $sessionData);
                $this->front_order_model->setDatabaseCart($sessionData);

                $this->db->insert('check_use_db_cart', array('data' => $sessionData));
            }
        }

        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                  
             if ($data_post['edit'] == 'E'){
                if ($data_post['sfreight'] == 0 || $data_post['sfreight'] == 1 || $data_post['sfreight'] == 2){
                    $this->session->set_userdata( 'sfreight',$data_post['sfreight'] );
                }   
                // 移除購物車
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
                 
                 // -- 活動加購 -- S
                $act_p_no = array();                
                foreach ($data_post as $key => $item){
                if (substr_count($key,'act_comp_')){
                    foreach ($item as $key1 => $item1){ 		                              	   	
                        $act_p_no[] = $item1;
                    }
                }
                if (substr_count($key,'act_birth_')){
                    foreach ($item as $key1 => $item1){ 		                              	   	
                        $act_p_no[] = $item1;
                    }
                }
                }                 
                 $this->session->set_userdata( 'act' , $act_p_no );
                 // -- 活動加購 -- E
                 
                 redirect( 'order/cart' );
             }      
             redirect( 'order/checkout' );
             exit;
        }

        // 將車子的產品放到 mssql isf_t
        $this->front_order_model->ms_cart_temp($msconn);
        
        if (empty($this->session->userdata( 'act' ))){
        	  $this->session->set_userdata( 'act',array() );
        }
            
        $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);            
        $act_data = array();
        if (count($sumdetail['comp']) > 0){   // 活動                
            foreach ($sumdetail['comp'] as $key => $item){ 		                              	   	
                if ($item['gisgive'] || in_array(trim($item['p_no']),$this->session->userdata( 'act' ))){
                    $act_data[] = $item;                	        	 
                } 
            }  
        }
        if (count($sumdetail['birth']) > 0){   // 活動                
            foreach ($sumdetail['birth'] as $key => $item){ 		                              	   	
                if ($item['gisgive'] || in_array(trim($item['p_no']),$this->session->userdata( 'act' ))){
                    $act_data[] = $item;                	        	 
                } 
            }                  
        }
        if (count($act_data) > 0){
            $this->front_order_model->ms_cart_temp_act($msconn,$act_data);    
            $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
        }
            
        //     echo "<pre>".print_r($sumdetail,true)."</pre>";
        // print_r('test cart:::');
        // print_r($this->session->userdata('ProductList'));
        
        // log_message('debug', 'My variable: ' . print_r($this->session->userdata('ProductList'), true));
        
        $cart_data = array();
        if (!empty($this->session->userdata('ProductList'))){
            $cart_data = $this->front_order_model->ms_cart_list($msconn);      
            $change_chk = false;
            $prd_session = $this->session->userdata('prd_session');	
            foreach ($cart_data as $key => $item){                    
                $p_no   = trim($item["p_no"]);
                $p_num = $this->front_order_model->check_cart_prd_num($p_no);                    
                if ($item["maxqty"] < $p_num){
                    $prd_session[$p_no]  = $item["maxqty"] ;
                    $this->session->set_userdata( 'prd_session', $prd_session );
                    $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'],$p_no,$item["maxqty"]);    
                    $change_chk = true;
                }
            }          
            if ($change_chk){
                $this->front_order_model->ms_cart_temp($msconn);
                $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
            }
            //$cart_data = $this->front_order_model->cart_list($this->session->userdata('ProductList'));                
        }               
        $meta['title2'] = '購物車';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];        
        
        $data = array(
            'meta'        => $meta,
            'web_page'    => 'cart',          
            'sumdetail'   => $sumdetail,
            'cart_data'   => $cart_data
        );

        // print_r($cart_data); die();

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
        
        if ($this->session->userdata('login_type') == 'admin' || $this->session->userdata('login_type') == 'test'){
        	  alert('管理者不能使用會員身份，進入購物車(A91)！',base_url('member/main'));
            exit;
        }
                        
        //--結帳鎖定通知--
        $this->block_service->dataset('member','checkout');            
        //--結帳鎖定通知--  
          
        $meta['title2'] = '購物車結帳';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $msconn = $this->front_mssql_model->ms_connect();
        
        $chkordererrmsg = $this->front_order_model->ms_chkorder($msconn);
        if ($chkordererrmsg > ''){
            alert($chkordererrmsg,base_url('order/cart'));
            exit;
        }
        
        $sumdetail = $this->front_order_model->ms_get_sumdetail($msconn);
        
        $add_p_no  = '';                              
        if ($sumdetail['is_freight'] <> '0'){  // 抓運費
            if ($this->session->userdata( 'sfreight') == '2'){
              //  $add_p_no = ",A000000";
              //  $sumdetail['m_mp'] += $this->session->userdata('FC_freight_mp');                       
              //  $sumdetail['mp'] -= $this->session->userdata('FC_freight_mp');
            }else{
              //  $add_p_no = ",0000000";
              //  $sumdetail['amt'] += $this->session->userdata('FC_freight');
            }
        }
               
        if ($sumdetail['mp'] < 0){
            alert('紅利點數不足，請至購物車調整！',base_url('order/cart'));
        }
          
        $cart_data = array();
        if (!empty($this->session->userdata('ProductList'))){
            $cart_data = $this->front_order_model->ms_cart_list($msconn);
            //$cart_data = $this->front_order_model->cart_list($this->session->userdata('ProductList').$add_p_no);            
        }
              
        $data = array(
            'meta'           => $meta,
            'web_page'       => 'checkout',
            'city'           => $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc')),
            'email'          => $this->front_member_model->member_get_data($this->session->userdata('member_session')['c_no'],'email'),
            'sumdetail'      => $sumdetail,
            'cart_data'      => $cart_data
        );                  
        
      //  $data['js'] = array(
       //     'set_addr'
      //  );             
                               
        _timer('*** before layout ***');
        // print_r($this->session->userdata('ProductList')); die();
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
        	   if ($this->session->userdata('member_session')['addr_dl'] > '' && $this->session->userdata('member_session')['cell1'] > ''){
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
        }
        $address_list = $this->front_member_model->get_address($this->session->userdata('member_session')['c_no']);  
             
        $nadr = 0;     
        $html = '';
        if ($address_list){                            
                 foreach ($address_list as $key => $item){                                   
                          $nadr++;
                          $nclass = '';
                          $nc = '';
                          $delstr = '';
                          if ($nadr == 1 && $asort == 0){
                              $nclass = ' checked';
                              $nc = ' active';
                          }else{
                              if ($asort == $item['aid']){
                                  $nclass = ' checked';
                                  $nc = ' active';
                              }
                          }
                          if ($nadr > 1){
                              $delstr = '<a href="javascript:void(0);" onclick="del_address('.$item['aid'].');" style="margin-top: -35px;" class="float-right text-white">刪除</a>';
                          }
                          $html .= '<label id="addrid_'.$nadr.'" class="btn btn-outline-secondary col-xs-12 col-sm-12 col-md-4 col-lg-4 p-3 mb-3 rounded text-left'.$nc.'" >
                                       <input type="radio" name="set_addr" id="set_addr" value="'.$item['aid'].'" autocomplete="off" '.$nclass.'>
		                                    <h5>'.htmlspecialchars($item['c_name']).'</h5>'.$delstr.'
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
    
    // 地址刪除
    public function set_address_del($aid)
    {
    	  if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login' );
        }
        $result = array('status' => 0);              
        if ($aid > 0){
            $this->front_base_model->delete_table('ap_member_address',array('c_no'=>$this->session->userdata('member_session')['c_no'],'aid' => $aid));                        
            $result = array('status' => 1);              
        }
        
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
                                'tel'     => trim($data_post['addr_tel']),
                                'c_no'    => $this->session->userdata('member_session')['c_no']
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
          $this->block_service->dataset('member','pay');            
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
               if (isset($data_post['set_addr'])){
                   $recv_data = $this->front_base_model->get_data('ap_member_address',array('c_no'=>$this->session->userdata('member_session')['c_no'],'aid'=>$data_post['set_addr']),'',1);               
                   if (!$recv_data){
                       alert('收件人資訊，設定有誤！');
                       exit;
                   }
               }else{
               	   alert('收件人資訊，設定有誤！');
                   exit;
               }   
               
               $msconn = $this->front_mssql_model->ms_connect();
               
               $chkordererrmsg = $this->front_order_model->ms_chkorder($msconn);
               if ($chkordererrmsg > ''){
                   alert($chkordererrmsg,base_url('order/cart'));
                   exit;
               }
               
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
               
               if (isset($data_post['save_email']) && $data_post['save_email'] == 'Y' && $data_post['email'] > ''){
               	   $this->front_member_model->member_save_data($this->session->userdata('member_session')['c_no'],'email',$data_post['email']); 
               }
               
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
                          //   'idno'       => $data_post['idno'],
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
               
               $cart_data = $this->front_order_model->ms_cart_list($msconn);
               
               if ($add_p_no > ''){  // 運費
                   // 訂單單身產品
                   //$scart_data = $this->front_order_model->cart_list($this->session->userdata('ProductList').$add_p_no);                           
                   $scart_data = $this->front_order_model->cart_list($add_p_no)[0];
                   array_push($cart_data, $scart_data);
               }
               
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
                                         'b_pv'       => trim($item['b_pv']), 
                                         'opv'        => trim($item['opv']),
                                         'opv_h'      => trim($item['opv_h']), 
                                         'a_amt'      => trim($item['a_amt']), 
                                         'b_amt'      => trim($item['b_amt'])
                                   );                               
                        $this->front_mssql_model->insert_data($msconn,"isf_b",$paramsb);
               }            
               
               if (count($sumdetail['comp']) > 0){   // 活動                
                   foreach ($sumdetail['comp'] as $key => $item){ 		     
	          	 	   	        if ($item['qty'] > 0 && ($item['gisgive'] || (!empty($this->session->userdata( 'act' )) && in_array(trim($item['p_no']),$this->session->userdata( 'act' ))))){  
	          	 	   	        	  $paramsb = array(
                                         'web_no'     => $web_no,
                                         'p_no'       => trim($item['p_no']), 
                                         'p_name'     => trim($item['p_name']), 
                                         'r_price'    => 0,                                          
                                         'c_price'    => $item['c_price'], 
                                         'pv'         => 0, 
                                         'p_mp'       => $item['p_mp'], 
                                         'm_mp'       => 0, 
                                         'mp_amt'     => 0, 
                                         'qty'        => $item['qty'], 
                                         'a_pv'       => 0, 
                                         'opv'        => trim($item['opv']),
                                         'opv_h'      => trim($item['opv_h']), 
                                         'a_amt'      => 0, 
                                         'b_amt'      => 0
                                   );                               
                                $this->front_mssql_model->insert_data($msconn,"isf_b",$paramsb);    	          	 	   	        	
	          	 	   	        }
	          	 	   }
               }
	          	 if (count($sumdetail['birth']) > 0){	          	 	  
	          	 	   foreach ($sumdetail['birth'] as $key => $item){ 		     
	          	 	   	        if ($item['qty'] > 0 && ($item['gisgive'] || (!empty($this->session->userdata( 'act' )) && in_array(trim($item['p_no']),$this->session->userdata( 'act' ))))){  
	          	 	   	        	  $paramsb = array(
                                         'web_no'     => $web_no,
                                         'p_no'       => trim($item['p_no']), 
                                         'p_name'     => trim($item['p_name']), 
                                         'r_price'    => 0,                                          
                                         'c_price'    => $item['c_price'], 
                                         'pv'         => 0, 
                                         'p_mp'       => $item['p_mp'], 
                                         'm_mp'       => 0, 
                                         'mp_amt'     => 0, 
                                         'qty'        => $item['qty'], 
                                         'a_pv'       => 0, 
                                         'opv'        => trim($item['opv']),
                                         'opv_h'      => trim($item['opv_h']), 
                                         'a_amt'      => 0, 
                                         'b_amt'      => 0
                                   );                               
                                $this->front_mssql_model->insert_data($msconn,"isf_b",$paramsb);    	          	 	   	        	
	          	 	   	        }
	          	 	   }
	          	 } 
               
              // if ($data_post['paytype'] == 'A' && $this->session->userdata('member_session')['c_no'] == '000000'){  // ATM 測試
                 //  $sumdetail['amt'] = 1;	   
              // }
               
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
                   $uparams['ord_statue'] = trim('付款成功 ');
                   $uparams['success']    = 1;
                   $uparams['pay_date']   = date('Y-m-d H:i:s');
               }
               $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no));
               
               if ($sumdetail['amt'] == 0 && $data_post['paytype'] == 'F'){   // 紅利積點兌換
                   
                   $this->send_order_mail($msconn,$this->session->userdata('member_session')['c_no'],$web_no);  // 寄信通知
                   
                   $this->front_order_model->clear_cart($msconn);  // 成功清空購物車
                   
                   redirect( 'order/orderview/'.$web_no.'/Y' );
                   
                   exit;
               }
               
               $MerchantName = mb_convert_encoding($this->config->item('pay')['MerchantName'], 'BIG-5', "UTF-8");   // 設定特店網站或公司名稱
          
               if ( ENVIRONMENT == 'production' ){
                    $OrderDetail = '訂單';
               }else{
                    $OrderDetail = '測試訂單'; 
               }
               $OrderDetail = mb_convert_encoding($OrderDetail, 'BIG-5', "UTF-8").":".$web_no;  
                                       
               $action = '';
                   
               if ($data_post['paytype'] == 'C'){  // 信用卡            
                   include APPPATH.'libraries/auth_mpi_mac.php';
                   
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
                   $AutoCap="0"; 
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
                   $debug="0"; /* debug 預設(進行交易時)請填 0，偵錯時請填 1。*/                   
                   $billShortDesc="";  // 訂單摘要
                   
                   $atmdate = date('Y-m-d',strtotime('+1 day')); // + 3 天
                   
                   $WebATMAcct = $this->front_order_model->WebATMAcct($this->config->item('pay')['webatm_acct'],$web_no ,$purchAmt,$atmdate,"N");  //轉入帳號
                   
                   $uparams['WebATMAcct']   = $WebATMAcct;
                   $uparams['ord_statue']   = '等待付款';
                   
                   $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no));
                   
                   $this->front_order_model->clear_cart($msconn);  // 成功清空購物車
                   
                   redirect( 'order/orderview/'.$web_no );
                   
                   exit;
                   
                   $MACString=auth_in_mac($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$MerchantName,$AuthResURL,$OrderDetail,$AutoCap,$Customize,$debug);     
                   
                   $storeName = $MerchantName; 
                   
                   $AuthResURL = $this->config->item('pay')['webatm_AuthResURL']; 
                    
                   $ATMEnc=get_auth_atmurlenc($MerchantID,$TerminalID,$web_no,$purchAmt,$txType,$Option,$Key,$storeName,$AuthResURL,$billShortDesc,$WebATMAcct,$note,$MACString,$debug);       
                   
                   $uparams = array();                   
                   $uparams['WebATMAcct']  = $WebATMAcct;               
                   
                   if ($data_post['paytype'] == 'A'){  // 虛擬 ATM
                       $uparams['ord_statue']  = '等待付款';
                   }else{                 // WEBATM
                       $action = $this->config->item('pay')['webatm_action'];
                       $merID = $this->config->item('pay')['webatm_merID'];
                       $URLEnc = $ATMEnc;
                   }
                   $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no));
                   
                   if ($data_post['paytype'] == 'A'){  // 虛擬 ATM                        
                       $this->front_order_model->clear_cart($msconn);  // 成功清空購物車
                   
                       redirect( 'order/orderview/'.$web_no );
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
    
    /*
      https://www.arsoa.tw/order/auth/C  信用卡
      https://www.arsoa.tw/order/auth/W  WEBATM
      https://www.arsoa.tw/order/auth/A  虛擬ATM
    */
   
    public function auth($payment = 'C',$test = '')
    {
        
        $paycheck = 'N';        
        $debug = "0"; 
        $sendmail = 'N'; 
        $CheckCode = '';
        if ($payment == 'C'){
            $data_post = $this->input->post();
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){                              
                 include APPPATH.'libraries/auth_mpi_mac.php'; 
                 
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
                 $last4digitpan = isset($EncArray['last4digitpan']) ? $EncArray['last4digitpan'] : "";   //卡號末四碼
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
                                                
                 $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$web_no,$OffsetAmt,$OriginalAmt,$UtilizedPoint,$Option,$last4digitpan,$Key,$debug);    
                
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
                              $uparams['Last4digitPAN'] = $last4digitpan;
                              $uparams['ord_statue'] = trim('付款成功 ');
                              $uparams['pay_amt'] = $authAmt;
                              
                              $sendmail = 'Y';                              
                              $paycheck = 'Y';
                          }else{               // 付款失敗
                              $uparams['ord_statue'] = '付款失敗';
                              $uparams['pay_amt'] = 0;
                          }
                          if ($test == 'Y'){
                              echo "<pre>".print_r($uparams,true)."</pre>";
                          }
                          $uparams['ApproveCode'] = $authCode;
                          $uparams['errcode']     = $errCode;
                          $uparams['errmsg']      = ''; //$errdesc;
                          $uparams['pay_date']    = date('Y-m-d H:i:s');
                          
                          $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no,'c_no'=>$c_no));   
                        
                          $chklogin = $this->front_member_model->member_cookie_login($c_no);
                          
                          if ($chklogin && $sendmail == 'N'){
                              // 交易失敗  登入時將上次未買的產品放到 session
                              $this->front_order_model->login_session_cart(trim($c_no),$this->session->userdata('member_session')['d_posn']);                             
                          }
                          if ($status == '0'){  // 刷卡成功清空購物車 
                          	  $this->front_order_model->clear_cart($msconn);  
                          }
                      }else{
                       
                          alert( '操作有誤煩請重新訂購(PAY01)！',base_url('order/cart') );
                          exit;
                      }
                 }else{
                      alert( '操作有誤煩請重新訂購(PAY02)！',base_url('order/cart') );
                      exit;
                 }                 
            }else{
                 alert( '操作有誤煩請重新訂購(PAY03)！',base_url('order/cart') );
                 exit;
            }                 
      }elseif($payment = 'A'){      
                       
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                     $clientIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
                     $temp = explode(',' , $clientIpAddress);
                     $clientIpAddress = $temp[0];                     
            } else {
                    $clientIpAddress = $_SERVER['REMOTE_ADDR'];
            }            	               
            $data_post = $this->input->post();
            /*
            $indata = array(
            	                   'pdata' => json_encode($data_post),
            	                   'crdt' => date('Y-m-d H:i:s'),
            	                   'ip'   => substr($clientIpAddress,0,100)
            	                  );
            	   $this->front_base_model->insert_table('ap_order_atm',$indata);
            */	   
            if (is_array( $data_post ) && sizeof( $data_post ) > 0){                                      
            	   //MsgID
            	   //TxNoID  TransactionNo
            	   //body   
            	   
            	   $indata = array(
            	                   'pdata' => json_encode($data_post),
            	                   'crdt' => date('Y-m-d H:i:s'),
            	                   'ip'   => substr($clientIpAddress,0,100)
            	                  );
            	   $this->front_base_model->insert_table('ap_order_atm',$indata);
            	   
            	    /*
            	   
            	    $data = "{\"MsgID\":\"2\",\"TransactionNo\":\"6926191949324558\",\"body\":\"1635402261842109110403122000148   00000000000010010911041949320113692619C+98919040301011000920300**9788*           81881000000000000000000000692619                                                                                                                                                                   \"}";
            
                  $data_post = json_decode($data, true);
                  */
                            
                  if ($data_post['body'] == ''){
                      header('HTTP/1.1 543 fail');	       
                      echo 'ERROR(E01)';
                      exit;
                  }
                  
                  $atm['WebATMAcct']     = $this->config->item('pay')['webatm_acct'] . substr($data_post['body'],20,11);
                  $atm['buysafeord']     = substr($data_post['body'],74,10);
                  $atm['pay_amt']        = (int)substr($data_post['body'],34,13);
                  $atm['paydate1']       = 1911+(int)substr($data_post['body'],49,3) . "/".(int)substr($data_post['body'],52,2)."/".(int)substr($data_post['body'],54,2);
                  $atm['paydate2']       = substr($data_post['body'],56,2) . ":". substr($data_post['body'],58,2).":". substr($data_post['body'],60,2);
                  $atm['paydate']        = $atm['paydate1']." ".$atm['paydate2'];
                  
                  $msconn = $this->front_mssql_model->ms_connect();  
                  
                  $params = array ($atm['WebATMAcct']); 
                  $data = $this->front_mssql_model->get_data($msconn,"select web_no,c_no,pay_type,isnull(pay_date,'') as pay_date,CheckCode from isf_h where WebATMAcct = ?",$params);
                            
                  if (count($data) > 0){
                             
                                if ($test == 'Y'){
                                    echo "<pre>".print_r($data[0],true)."</pre>";
                                }
                            
                                $data = $data[0];
                                
                                if (trim($data['pay_date']) <> '1900-01-01 00:00:00.000'){  // 重覆送
                                    header('HTTP/1.1 250 Repeat '.$data_post['TransactionNo']);
                                    exit;                              
                                }
                                
                                //---由於延後付款,故需將會計日期重塞---s
         	                      $web_data = $this->front_base_model->get_data('web_base',array(),'',1);        
                                if ($web_data){            
                                    $bv_date = date('Y-m-d',strtotime($web_data['bv_date']));
                                }
                                //---由於延後付款,故需將會計日期重塞---e
                                
                                $uparams = array (
                                                   'buysafeord'   => $atm['buysafeord'],
                                                   'status'       => '0',
                                                   'success'      => '1',
                                                   'pay_amt'      => $atm['pay_amt'],
                                                   'ord_statue'   => trim('付款成功 '),
                                                   'pay_date'     => $atm['paydate'],
                                                   'bv_date'      => $bv_date,
                                                   //'ApproveCode'  => trim($data_post['TransactionNo'])
                                                 );
                                
                                $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>trim($data['web_no'])));   
                                
                                $this->send_order_mail($msconn,$data['c_no'],$data['web_no']);  // 寄信通知
                                
                                header('HTTP/1.1 200 OK');
                  }else{               
                                header('HTTP/1.1 543 fail');	  
                  }       
            }else{
                 header('HTTP/1.1 543 fail');	                 
            }
            
            echo date('Y-m-d H:i:s');
            echo '<br>';            
            /*
            TransactionNo  = trim(Request.form("TransactionNo"))
body           = trim(Request.form("body"))
MsgID          = trim(Request.form("MsgID"))

if body = "" then 
	 call PF_mailerror("","實體ATM Error")
	 response.end
end if

WebATMAcct     = FC_A_CODE & mid(body,21,11)
buysafeord     = mid(body,75,10)
pay_amt        = clng(mid(body,35,13))
paydate1       = 1911+clng(mid(body,50,3)) & "/"&mid(body,53,2)&"/"&mid(body,55,2)
paydate2       = mid(body,57,2) & ":"& mid(body,59,2)&":"& mid(body,61,2)
paydate        = paydate1 &" "&paydate2

err1 = "WebATMAcct=["&WebATMAcct&"]"
err1 = err1 & "buysafeord=["&buysafeord&"]"
err1 = err1 & "pay_amt=["&pay_amt&"]"
err1 = err1 & "paydate=["&paydate&"]"
call PF_mailerror(WebATMAcct&"--1","實體ATM GO"&err1)

set conn = Get_ConnString(conn,FC_DBString)   '連結資料庫   
sSQLCmd="select web_no,pay_type,isnull(pay_date,'1900/1/1') as pay_date,CheckCode from ISF_H "
sSQLCmd = sSQLCmd & " where WebATMAcct = '"&ReplaceSQLstr(WebATMAcct)&"' "
Set rs = Get_rs(conn,sSQLCmd)
if not rs.eof then   	
   Fweb_no   = trim(rs("web_no"))
   CheckCode = trim(rs("CheckCode"))   
   if rs("pay_date") = "1900/1/1" then 
   	  
   	  '---由於延後付款,故需將會計日期重塞---s
   	  sSQLCmd="select top 1 * from web_base "
      Set rs1 = Get_rs(conn,sSQLCmd)
      if not rs1.eof then
         if isdate(rs1("bv_date")) then bv_date = FormatDateTime(rs1("bv_date"),2)
      end if
      rs1.close     
      '---由於延後付款,故需將會計日期重塞---e
   	
   	  sSQLCmd = "update ISF_H set buysafeord  = '"&ReplaceSQLstr(buysafeord)&"', "
   	  sSQLCmd = sSQLCmd & " status = '0', "
   	  sSQLCmd = sSQLCmd & " success = 1, "
   	  sSQLCmd = sSQLCmd & " ord_statue = '付款成功', "
   	  sSQLCmd = sSQLCmd & " pay_type = '實體ATM', "
   	  sSQLCmd = sSQLCmd & " bv_date = '"&bv_date&"', "
   	  sSQLCmd = sSQLCmd & " pay_amt = "&ReplaceSQLstr(pay_amt)&", "
   	  sSQLCmd = sSQLCmd & " pay_date  = '"&ReplaceSQLstr(paydate)&"' "
      sSQLCmd = sSQLCmd & " where web_no = '"&ReplaceSQLstr(Fweb_no)&"' "   
      call PF_mailerror(WebATMAcct&"--2","實體ATM"&sSQLCmd)
      
      Get_rs_execute conn,sSQLCmd
      if err then errmsg("please check your inputs.")
      	
      call Order_mail(Fweb_no)     
            
      response.Write "OK"
   else
      call PF_mailerror(WebATMAcct&"--3","實體ATM 連續入帳")
      response.Write "PAYCHK"
   end if   
else	
	    call PF_mailerror(WebATMAcct&"--4","實體ATM 有問題")
	    response.Write "Error"
end if
rs.close
            */
            exit;
      }elseif($payment = 'W'){
            $data_post = $this->input->get();
            if ( is_array( $data_post ) && sizeof( $data_post ) > 0){     
                 //$test = 'Y';
                 $EncRes = $data_post['URLResEnc'];
                 if ($EncRes > ''){
                     if ($test == 'Y'){
                         echo "URLResEnc=[".$EncRes."]";
                     }
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
                     $authAmt = isset($EncArray['authamt']) ? $EncArray['authamt'] : "";     // 交易金額
                     $web_no = isset($EncArray['lidm']) ? $EncArray['lidm'] : "";                      // 訂單編號
                     $feecharge = isset($EncArray['feecharge']) ? $EncArray['feecharge'] : "";       // 手續費
                     $OriginalAmt = isset($EncArray['originalamt']) ? $EncArray['originalamt'] : ""; 
                     $payerbankid = isset($EncArray['payerbankid']) ? $EncArray['payerbankid'] : ""; 
                     $UtilizedPoint = isset($EncArray['utilizedpoint']) ? $EncArray['utilizedpoint'] : ""; 
                     $Option = isset($EncArray['option']) ? $EncArray['option'] : ""; 
                     $last4digitpan = isset($EncArray['last4digitpan']) ? trim($EncArray['last4digitpan'],"\x00..\x08") : ""; 
                     
                     $MACString = auth_out_mac($status,$errCode,$authCode,$authAmt,$web_no,$feecharge,$OriginalAmt,$UtilizedPoint, $Option,$last4digitpan,$Key,$debug);    
                     
                     if ($test == 'Y'){ 
                         echo $URLEnc."<BR><BR>\n";  
                         echo "MACString=[".$MACString."]<br>";
                         echo "outmac=[".$EncArray['outmac']."]<br>";                      
                     }   
                     
                     if ($web_no == ''){
                         alert( '付款失敗，煩請重新訂購(PAY999)！',base_url('order/cart') );
                         exit;
                     }
                     
                     $msconn = $this->front_mssql_model->ms_connect();  
                      
                     $params = array($web_no); 
                     $data = $this->front_mssql_model->get_data($msconn,"select web_no,c_no,pay_type,isnull(pay_date,'') as pay_date,CheckCode from isf_h where web_no = ?",$params);
                     
                     if ($EncArray['outmac'] == $MACString){ 
                         if (count($data) > 0){
                             $data = $data[0];
                             if ($test == 'Y'){
                                 echo "<pre>".print_r($data,true)."</pre>";
                             }                            
                             if (trim($data['pay_date']) <> '1900-01-01 00:00:00.000'){
                                 alert( $web_no.' 此訂單已經交易過！',base_url('order/orderlist') );
                                 exit;                              
                             }
                             $c_no = trim($data['c_no']);
                             
                             $CheckCode = trim($data['CheckCode']);
                             
                             if ($data['pay_type'] == 'W'){ // 網路刷卡 web_atm
   	                             if ($status == '0'){
   	                                 $uparams['success'] = 1;
   	                                 $uparams['feeCharge'] = $feecharge;
                                     $uparams['Last4digitPAN'] = $last4digitpan;
                                     $uparams['payerBankId'] = $payerbankid;
                                     $uparams['ord_statue'] = trim('付款成功 ');
                                     $uparams['pay_amt'] = $authAmt;
                                     
                                     $sendmail = 'Y';                              
                                     
                                     $paycheck = 'Y';
                                     
                                     $this->front_order_model->clear_cart($msconn);  // 刷卡成功清空購物車
   	                             }else{                     // 付款失敗
                                     $uparams['ord_statue'] = '付款失敗';
                                     $uparams['pay_amt'] = 0;
                                 }   	                             
   	                         }else{
   	                             if ($status == '0'){
   	                                 $uparams['success'] = 1;
                                     $uparams['feeCharge'] = $feecharge;
                                     $uparams['payerBankId'] = $payerbankid;
                                     $uparams['Last4digitPAN'] = $last4digitpan;
                                     $uparams['ord_statue'] = trim('付款成功 ');
                                     $uparams['pay_amt'] = $authAmt;
                                     
                                     $sendmail = 'Y';               
                                     $paycheck = 'Y';               
                                 }else{
                                      // 付款失敗
                                     $uparams['ord_statue'] = '付款失敗';
                                     $uparams['pay_amt'] = 0;
                                 }   	     
                             }
                             $uparams['ApproveCode'] = $authcode;
                             $uparams['errcode']     = $errCode;
                             $uparams['errmsg']      = $errdesc;
                             $uparams['pay_date']    = date('Y-m-d H:i:s');
                             
                             echo "<pre>".print_r($uparams,true)."</pre>";                 
                             
                             $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no,'c_no'=>$c_no));   
                             
                             if ($data['pay_type'] == 'W'){ 
                                 $this->front_member_model->member_cookie_login($c_no);
                             }
                          }
                      }else{ 
                          if (count($data) > 0){
                             $data = $data[0];
                             if ($test == 'Y'){
                                 echo "<pre>".print_r($data,true)."</pre>";
                             }                            
                             if (trim($data['pay_date']) <> '1900-01-01 00:00:00.000'){
                                 alert( $web_no.' 此訂單已經交易過！',base_url('order/orderlist') );
                                 exit;                              
                             }
                             $c_no = trim($data['c_no']);
                             $uparams['ord_statue'] = '付款失敗';
                             $uparams['pay_amt'] = 0;
                             $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('web_no'=>$web_no,'c_no'=>$c_no));   
                          }   
                          alert( '操作有誤煩請重新訂購(PAY04)！',base_url('order/cart') );
                          exit;
                      }                     
                 }else{
                     alert( '操作有誤煩請重新訂購(PAY05)！',base_url('order/cart') );
                     exit;
                 }
            }else{
                 alert( '操作有誤煩請重新訂購(PAY06)！',base_url('order/cart') );
                 exit;
            }
      }
      
      if ($sendmail == 'Y'){ //付款成功寄信通知
          $this->send_order_mail($msconn,$c_no,$web_no);  // 寄信通知
          redirect( 'order/orderview/'.$web_no.'/Y' );
          exit;
      }
      
      if ($paycheck == 'N'){
          alert( '付款失敗，煩請重新訂購(PAY99)！',base_url('order/cart') );
          exit;
      }
      
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
    
    public function orderview($web_no,$order = 'N')
    {
           if ( !$this->front_member_model->check_member_login( TRUE ) ) {
                redirect( 'member/login' );
           }
        
           $msconn = $this->front_mssql_model->ms_connect();  
           
           $order_detail = $this->front_order_model->order_detail($msconn,$this->session->userdata('member_session')['c_no'],$web_no,$order);
           
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
           
           $data_post = $this->input->post();
           if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
                if (count($data_post['cancel_no']) > 0){
                    foreach ($data_post['cancel_no'] as $key => $item){
                             $uparams['ord_statue'] = '取消訂單';                             
                             $uparams['pay_date']   = date('Y-m-d H:i:s');                
                             
                             $this->front_mssql_model->update_data($msconn,"isf_h",$uparams,array('c_no'=>$this->session->userdata('member_session')['c_no'],'web_no'=>$item));
                    }  
                    redirect( 'order/orderlist' );
                }                
           }
           
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
    
    public function send_order_mail($msconn,$c_no,$web_no,$html = 'N')
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
	  	            			<h4 style="color:#1a1a1a;">親愛的 '.$order['main']['c_name'].' 您好：
	  	            			<br><br>您的訂單明細如下：</h4>	  	            			
	  	            			<p>'.$order['html'].'</p>	  	            			
	  	            		</div>
	  	            		<div style="text-align:center; border-top: #dddddd solid 1px; font-size:12px; width: 100%; padding:10px 0px; color:#999; clear: both;">	  	            	
	  	            			<a href="'.base_url().'" target="_blank">© '.date('Y').' '.FC_Company.'</a>
	  	            		</div>
	  	            	</div>
	  	            </body>                  
	  	            </html>';
	  	            
	  	     if ($html == 'Y'){
	  	         echo $Body;
	  	         exit;           
	  	     }
	  	     
	  	     if (trim($order['main']['e_mail']) > ''){  // 有 EMAIL 才寄送通知
	  	         $this->block_service->send_email($order['main']['e_mail'],$Subject,$Body);	
	  	     }
	  	     
	  	     $this->block_service->send_email(FC_Email,$Subject,$Body);	
    }
    
    public function mail_test($show = 'N')
    {
     //  echo 'HI';
       $msconn = $this->front_mssql_model->ms_connect();   
       $this->send_order_mail($msconn,'000000','W202008053',$show);   
       echo 'OK';
       exit;
    }
    
    public function testatm()
    {
        
          $web_no = 'W202011006';
          
          $purchAmt = 1;
          
          $atmdate = date('Y-m-d',strtotime('+1 day')); // + 3 天
                   
          $WebATMAcct = $this->front_order_model->WebATMAcct($this->config->item('pay')['webatm_acct'],$web_no ,$purchAmt,$atmdate,"Y"); 
          
          echo $WebATMAcct;
          
          exit;
    }

    public function inCartNew()
    {
        $result = array('success' => false);
        $postData = $this->input->post();
        $p_no = $postData['sel_prd'][0];
        $days = $postData['days'];

        // 確認是否已經在購物車
        $nowProductList = explode(',', $this->session->userdata('ProductList'));
        if (in_array($p_no, $nowProductList)){
            $result['msg'] = '此商品已經在購物車中';
            
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
            return;
        }

        // 加入購物車
        $this->session->set_userdata('ProductList', $this->session->userdata('ProductList').",".$p_no);
        $this->front_order_model->i_cart($this->session->userdata('member_session')['c_no'], $p_no, 1, $days);                                       

        $result['success'] = true;
        $result['msg'] = '加入購物車成功';

        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($result));
        return;
    }
          
}