<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->model( 'front_base_model' );        
        $this->load->model( 'front_order_model' );    
        $this->load->library( 'user_agent' );
        $this->load->library('layout', array('layout' => '../template/layout'));
    }
    
    public function index()
    {
        
        $where  = array ('kind' => 'B000','nshow' => 'Y','begindate <=' => date('Y-m-d H:i:s'),'ifnull(closedate,now()) >=' => date('Y-m-d H:i:s') );
        $order_by = array ('begindate'=> 'desc');        
        $data['index_banner'] = $this->front_base_model->get_data('ap_func_data',$where,$order_by,1);        
        $data['mvurl'] = '';
        if ($data['index_banner']){
            $mvurl = $data['index_banner']['aurl'];
            if ($mvurl > ''){          
                $mv = $this->block_service->Get_youtube_id($mvurl,'C');
                if ($mv > ''){
                    $data['mvurl'] = "https://www.youtube.com/embed/".$mv."?autoplay=1&mute=1";
                }else{
                    $mvid = $this->block_service->Get_vimeo_id($mvurl);
                    if ($mvid > ''){
                        $data['mvurl'] = "https://player.vimeo.com/video/".$mvid."?title=0&byline=0&portrait=0&autoplay=1&autopause=0&muted=1&background=1&loop=1";
                    }                
                }
            }
            
            //  -- 記數 -- S            
            $this->front_base_model->count_pageview('ap_func_data','index','hits','id',$data['index_banner']['id']);   
            //  -- 記數 -- E
        }else{
            $data['index_banner']['title'] = '與自然調和的生活模式';
            $data['index_banner']['descr'] = 'Ideas Come from Natural';
            $data['index_banner']['body'] = 'We create high quality products to help<br>the life interested & better';
            $data['index_banner']['field1'] = '202005182034410FnJ.jpg';
            $data['index_banner']['field2'] = '是安露莎的企業理念';
        }
        if ($data['mvurl'] == ''){
            $data['mvurl'] = "https://player.vimeo.com/video/422698448?title=0&byline=0&portrait=0&autoplay=1&autopause=0&muted=1&background=1&loop=1";
        }
                
        $data['meta']['canonical'] = site_url();
                
        $data['css'] = array(
            'jquery.pagepiling'
        );
        
        $data['js'] = array(
            'index',
            'fullpage'
        );

        _timer('*** before layout ***');
     
        $this->layout->view('index', $data);
    }   


}