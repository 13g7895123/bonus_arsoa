<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reward extends MY_Controller
{
    
    private $prdsql = ' and p.is_web=1 and p.is_nogoods=0 and p.m_mp > 0 ';
    
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->model( 'front_member_model' );
        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->model( 'front_mssql_model' );
        $this->load->model( 'front_product_model' );
                        
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index($show = 'N')
    {
     
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=reward' );
            exit;
        }        
        if (!($this->session->userdata['is_read_reward'] == '') && $show == 'N'){ // 看過了..可以不用看
            redirect( 'reward/category' );
            exit;
        }
   	  $where  = array ('epostid' => '6102');            
        $remark = $this->front_base_model->get_data('ap_epost',$where,array(),1)['epostbody'];
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        $mp = $this->front_order_model->ms_get_mp($msconn,$this->session->userdata('member_session')['c_no']);
        
        $meta['title2'] = '紅利兌換專區';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $data = array(
            'meta'     => $meta,
            'remark'   => $remark,
            'show'     => $show,
            'mp'       => $mp
        );
        
        if ($this->front_mssql_model->ms_test()){           
          //  $msconn = $this->front_mssql_model->ms_connect();                
        }
   	                        
        _timer('*** before layout ***');
     
        $this->layout->view('reward', $data);
    }   
     
    public function read()
    {
              $this->db->query("UPDATE `member` SET is_read_reward = now() where `c_no`=? ;", array($this->session->userdata('member_session')['c_no']));
				  if ($this->db->affected_rows() > 0 ){
				      $this->session->set_userdata( 'is_read_reward', date('Y-m-d H:i:s'));  
				      redirect( 'reward/category' );
				      exit;
				  }
	 }
     
    public function category($prdtype = 'skin')
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=reward/category/'.$prdtype );
            exit;
        }
                
        $meta['title2'] = '紅利兌換專區';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $data['meta']['canonical'] = site_url();      
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        $mp = $this->front_order_model->ms_get_mp($msconn,$this->session->userdata('member_session')['c_no']);
        
        $data['mp'] = $mp;        
        
        $where  = array ('wp1_no >' => '0');   
        
        $data['wp1'] = $this->front_base_model->get_data('wp1_type',$where);
                   	                        
        _timer('*** before layout ***');
     
        $this->layout->view('reward_category', $data);
    }
    
    public function prdlist()
    {
          $result = array('status' => 0, 'errmsg' => '無紅利產品!');        
             
          $data_post = $this->input->post( NULL, TRUE );
          if ( is_array( $data_post ) && sizeof( $data_post ) > 0){             
               if ($data_post['mp'] > ''){
                   if (substr_count($data_post['mp'],"-")>0){					
                       $tmp = explode('-',$data_post['mp']);
                       if (is_numeric($tmp[0])) {
                           $this->prdsql .= " and p.m_mp >= ".$tmp[0]." "; 
                       }
                       if (is_numeric($tmp[1])) {
                           $this->prdsql .= " and p.m_mp <= ".$tmp[1]." "; 
                       }
                   }else{
                       if (is_numeric($data_post['mp'])) {
                           $this->prdsql .= " and p.m_mp >= ".$data_post['mp']." "; 
                       }
                   }
               }               
               
               $where['wp1_en_name'] = $data_post['prdtype'];
               $cat_data = $this->front_product_model->cat_wp_one("wp1_type",$where);
               
               $sql = "select p.*
                               from product p 
                              where p.wp1_no = '".$cat_data['wp1_no']."'
                                ".$this->prdsql." ";
               if ($cat_data['wp1_no'] == '6'){
               	   $sql .= " order by p.wp2_no , p.pro_order ";                              
               }else{
                   $sql .= " order by p.mg_sort , p.pro_order ";                              
               }
             
             $list_data = $this->front_base_model->small_query($sql);
             if ($list_data){
                 $prdnum = 0;
                 if ($cat_data['wp1_no'] == '6'){
                     $html = '<table class="table table-striped table-hover text-center" style="margin-top:20px;">
						                    <thead>
                                 <tr>
                                  <th class="text-left">產品名稱</th>                              
                                  <th>點數</th>
                                  <th>兌換</th>
                                 </tr>
							                  </thead>
                              <tbody>';
                 }else{    
                     $html = '';
                 }
                 foreach ($list_data as $key => $item)
                 {
                          $prdnum++;                               
                          
                          if ($cat_data['wp1_no'] == '6'){
                              $html .= '<tr>
                                          <td class="text-left">'.$item['p_name'].'</td>
                                          <td>'.number_format($item['m_mp']).' 點</td>
                                          <td>
                                          <a class="btn btn-primary mr-4" href="javascript:void(0);" onclick="incar(\'M\',\''.trim($item["p_no"]).'\','.$prdnum.');" ';                                         
			                                    if ($this->front_order_model->check_cart($item["p_no"])){                                   	           
 	                                           $showcard = " alt=\"我要兌換\" >我要兌換 ";
 	                                        }else{
 	                                        	 $showcard = " onclick=\"incar('M','".trim($item["p_no"])."',".$prdnum.");\" alt=\"我要兌換\" >我要兌換 ";
                                          }
                                          $html .= $showcard;
			      	                            $html .= ' <i class="icon ion-ios-arrow-right"></i></a><input name="num_'.$prdnum.'" id="num_'.$prdnum.'" type="hidden" value="1">
			      	                                  </td>
                                          </tr>';
                          }else{                            
                              $html .= '<div class="col-lg-4 col-md-6 col-sm-6 col-12 mt30">
                                         <div class="tm-product tm-scrollanim scrollanim-action text-center">
                                             <div class="tm-product-topside">
                                                <a href="'.base_url('reward/product/'.$item['p_no']).'" title="'.$item['p_name'].'"><img src="'.base_url($this->block_service->prd_img(sprintf("%08d",substr($item['p_no'], 1)))).'" class="img-fluid" alt="'.$item['p_name'].'"
                                                 onerror="this.src=\''.base_url('public/images/default_arsoa.png').'\';"></a>
                                             </div>
                                             <div class="tm-product-bottomside">
                                                 <h6 class="tm-product-title"><a href="'.base_url('reward/product/'.$item['p_no']).'" title="'.$item['p_name'].'">'.$item['p_name'].'</a></h6>
                                                 <span class="tm-product-price">'.number_format($item['m_mp']).' 點</span>
                                             </div>
                                         </div>
                                     </div>';
                         }
                 } 
                 if ($cat_data['wp1_no'] == '6'){
                     $html .= ' </tbody>
                        </table></p>';
                 }
             }else{
                 $html = '<div class="alert alert-danger" style="margin: 0 auto;margin-top:30px" role="alert">無符合條件的紅利商品！</div>';
             } 
             
             $result = array('status' => 1, 'html' => $html);       
             
          }
          
          $this->output->set_content_type('application/json');            
          echo json_encode($result);
          exit;
      
    }
    
    public function product($p_no)
    {
        if ( !$this->front_member_model->check_member_login( TRUE ) ) {
            redirect( 'member/login?rdurl=reward/product/'.$p_no );
            exit;
        }
        
        if ($p_no == ''){
            redirect( base_url('webmsg/R9999') );
            exit;
        }
        
        $data['prddata'] = $this->front_product_model->get_reward_data($p_no);
        
        if (!$data['prddata']){
            redirect( base_url('webmsg/R9999') );
            exit;
        }
                
        $data['platform'] = ($this->agent->is_mobile()) ? 'MOBILE' : 'DESKTOP';  
        $data['prddata']['body'] = $this->block_service->text_convert($data['platform'],$data['prddata']['body']);
        //echo "<pre>".htmlspecialchars($data['prddata']['body'])."</pre>";
        //exit;
                       
        $meta['title2'] = $data['prddata']['p_name'];
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        if ($data['prddata']['pro_desc'] > ''){
            $meta['description'] = $data['prddata']['pro_desc'];
        }elseif($data['prddata']['p_title1'] > ''){
            $meta['description'] = $data['prddata']['p_title1'];
        }elseif($data['prddata']['p_title2'] > ''){
            $meta['description'] = $data['prddata']['p_title2'];    
        }elseif($data['prddata']['pro_title1'] > ''){
            $meta['description'] = $data['prddata']['pro_title1'];
        }elseif($data['prddata']['pro_title2'] > ''){
            $meta['description'] = $data['prddata']['pro_title2'];
        }
        
        $msconn = $this->front_mssql_model->ms_connect();  
        
        $mp = $this->front_order_model->ms_get_mp($msconn,$this->session->userdata('member_session')['c_no']);
        
        $data['mp'] = $mp;
                
        $data['meta']['canonical'] = site_url();      
        
        $data['meta'] = $meta;
                      
        _timer('*** before layout ***');
     
        $this->layout->view("reward_product", $data);
    } 
}