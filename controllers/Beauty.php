<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beauty extends MY_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->library('ui');

        $this->load->model( 'front_base_model' );
        $this->load->model( 'front_order_model' );
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index($Page=1)
    {
        $meta['title2'] = '美麗分享';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $meta['canonical'] = site_url();      
        
        $where  = array ('kind' => 'S001','nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        $order_by = array ('begindate'=> 'desc');   
        $data['beauty_banner'] = $this->front_base_model->get_data('ap_func_data',$where,$order_by);
        if ($data['beauty_banner']){
            foreach ($data['beauty_banner'] as $key => $item){
                //  -- 記數 -- S            
                $this->front_base_model->count_pageview('ap_func_data','beauty_banner','hits','id',$item['id']);   
                //  -- 記數 -- E
            } 
        }
        
        $data['meta'] = $meta;
        
        $Page = ( $Page > 0 ) ? $Page : 1;
        
        $data['PageSize'] = 10;
        
        $where  = array ('ifShow' => '1');        
        
        $order_by = array ('cdate'=>'desc');   
        
        $like = array();
        
        $data['list'] = $this->block_service->page_list( 'ab_share',$where, // where
            $like,   // like
            $Page,
            $data['PageSize']
            , NULL  // group by
            , $order_by  // order by
            );        
      
        $data['Page'] = $data['list']['Page'];
        $data['RecordCount'] = $data['list']['total'];        
        $data['PageCount'] = $data['list']['PageCount']; //總頁數                
        
        $meta['url'] = base_url('beauty');
        $meta['image'] = base_url('public/func/202005252225190PYJ.jpg');
        $data['meta'] = $meta;
                        
        $data['js'] = array(
            'main'
        );

        _timer('*** before layout ***');
     
        $this->layout->view('beauty', $data);
    }   
     
    public function share()
    {
        $meta['title2'] = '美麗分享-我要分享';
        $meta['title1'] = FC_Web.' - '.$meta['title2'];
        $meta['canonical'] = site_url();      
                
        $data['meta'] = $meta;
         
        $data['js'] = array(
            'main'
        );
        
        $where  = array ('epostid' => 'S004');    
        
        $data['remark'] = $this->front_base_model->get_data('ap_epost',$where,array(),1);
        
        $data['class']  = $this->front_base_model->get_data('ap_itemclass',array('classtype' => 'S'),array('classsort'=>'asc'));
        
        $data['city']  = $this->front_base_model->get_data('city',array('cityshow' => 1),array('cityno'=>'asc'));        
        
        $params = array(
                          'cityno'      => '',
                          'postal'    => '',
                          'address'   => ''
        );                    
        $data['params'] = $params;
        
        $data['set'] = array( 'sex'  => array("女", "男"), //性別
                              'job'  => array("學生", "上班族", "家庭主婦", "其他"),//職業
                              'skin' => array("中性肌膚", "乾性肌膚", "油性肌膚", "混合性肌膚", "敏感性肌膚"),//膚質
                              'effect' => array("清潔度", "保濕", "清爽", "美白", "抗黑斑、雀斑", "抗痘痘、粉刺", "抗皺紋、細紋")//使用效果
                            );    
        
        _timer('*** before layout ***');
     
        $this->layout->view('beauty_share', $data);
    }
    
    
    public function save()
    {
        $result = array('status' => 0, 'errmsg' => '操作有誤!');        
        $data_post = $this->input->post( NULL, FALSE );
        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){    
            if (isset($data_post['ct_captcha'])){
					 $captcha = strtoupper(htmlspecialchars(stripslashes(trim($data_post['ct_captcha']))));					
					 $this->load->library('securimage/securimage');			
			       $img=new Securimage();
					 if($img->check( $captcha ) ==false ) {
					       $result['errmsg'] = '驗證碼輸入有誤';
							 echo json_encode($result);
							 exit();	
					 }			
				}else{
				    $result['errmsg'] = '驗證碼未輸入';
				    echo json_encode($result);
					  exit();	
				}
            // -- 圖檔上傳 -- 
            $file_data = $this->block_service->PF_Upload("beauty",true,"jpg;jpge",array('img_width'=>FC_ImgSize,'img_height'=>FC_ImgSize));	            
            if (isset($file_data['files1']['error']) && $file_data['files1']['error'] > 0){
                $result['errmsg'] = $file_data['files1']['error'];
				        echo json_encode($result);
					      exit();	
            }
            
            $indata = array(
                          'ifShow'  => '0',
                          'nickname' => trim($data_post['nickname']),
                          'uname' => trim($data_post['uname']),
                          'sex' => trim($data_post['sex']),
                          'age' => trim($data_post['age']),
                          'email' => trim($data_post['email']),
                          'job' => trim($data_post['job']),
                          'city' => $this->front_base_model->city_title(trim($data_post['cityno'])),
                          'area' => $this->front_base_model->town_title(trim($data_post['postal'])),
                          'zip' => trim($data_post['postal']),
                          'address' => trim($data_post['address']),
                          'skin' => trim($data_post['skin']),
                          'effect' => implode(",",$data_post['effect']),
                          'prd_class1' => $this->front_base_model->one_data('classtitle','ap_itemclass',array('classid'=>trim($data_post['prd_class1']))),
                          'prd_class2' => trim($data_post['prd_class2']),                          
                          'subject' => trim($data_post['subject']),        
                          'content' => trim($data_post['content']),   
                          'cdate' => date('Y-m-d H:i:s'),
                          'IP' => $this->block_service->client_ip()
                      );
             
             if (isset($file_data['files1']['name'])){
                 $indata['Files'] = $file_data['files1']['name'];
             }
             
             $id = $this->front_base_model->insert_table('ab_share',$indata);
             if ($id > 0){
                 $result['status'] = 1;
                 $result['id'] = $id;
             }else{
                 $result['errmsg'] = '資料送出失敗!';
             }
        }     
        $this->output->set_content_type('application/json');            
        echo json_encode($result);
        exit;
    }
}