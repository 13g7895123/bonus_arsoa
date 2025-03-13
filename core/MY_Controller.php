<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {   
        date_default_timezone_set('Asia/Taipei');
        
        parent::__construct();
        _timer();

        self::_master();
    }

    // master data
    private function _master() 
    {
        // 判斷 https  SSL        
        if (!($_SERVER['HTTP_HOST'] == 'localhost' || ENVIRONMENT == 'testing')){
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https' && $_SERVER['HTTP_HOST'] == 'www.arsoa.tw'  && $_SERVER['HTTP_HOST'] != 'localhost') {
                echo '<script>if (window.location.protocol != "https:")window.location.href = "https:" + window.location.href.substring(window.location.protocol.length);</script>';
                exit;
            }
        }
        
        $this->load->service( 'block_service' );            
        
        if (!empty($_SESSION['admin_session'])){
            if ($_SESSION['admin_session']['admin_status'] == '50'){
                $this->load->service( 'line_service' );
                
                $this->message['quota'] = $this->line_service->quota();
                $this->message['consumption'] = $this->line_service->consumption();
                $this->message['canpush'] = $this->message['quota'] - $this->message['consumption'];    
            }
        }
        
        $session_id = session_id();
        
        $this->data['platform'] = ( $this->agent->is_mobile() ) ? 'MOBILE' : 'DESKTOP';
                            
        // -- 記錄瀏覽LOG -- S        
        $cookie_id = '';
        if (isset($_COOKIE[$this->config->item('cookies_name')])){      // 判斷有 cookie id
            $cookie_id = trim($_COOKIE[$this->config->item('cookies_name')]);
        }
        if ($cookie_id == ''){ // 沒有要產出並寫入使用者 cookie
            $cookie_id = $this->session->userdata($this->config->item('cookies_name'));             
            if ($cookie_id == ''){                
                $cookie_id = "A_".date('YmdHis')."_".$session_id;                
                $this->session->set_userdata($this->config->item('cookies_name'),$cookie_id);            
            } 
            $cookie = array(
                'name'   => $this->config->item('cookies_name'),
                'value'  => $cookie_id,
                'expire' => 525600,
                'domain' => 'arsoa.tw',
                'path'   => '/'
                //'secure' => TRUE
            );
            if (isset($_SERVER['HTTP_HOST'])){
              //  $cookie['domain'] = $_SERVER['HTTP_HOST'];
            }                        
            $this->input->set_cookie($cookie);
        }                
        // -- 記錄瀏覽LOG -- E 
        
        $this->data['tracking'] = array(        
                  'ip'            => $this->block_service->client_ip(),
                  'session_id'    => $session_id,             
                  'cookie_id'     => $cookie_id
        );
        
        $this->XmlDoc = $this->block_service->PF_LoadXmlDoc('setup.xml');
        
        $GLOBALS['include_img'] = "N";       // 圖檔上傳相關 CSS,JS 載入判斷
        $GLOBALS['include_date_js'] = "N";   // 日期選擇 CSS,JS 載入判斷
        $GLOBALS['include_datetime_js'] = "N";   // 日期選擇 CSS,JS 載入判斷
        $GLOBALS['include_tag_js'] = "N";   // tags
        $GLOBALS['ModifyStatus'] = false;
        
        // BP 是否顯示
        $FC_bpshow = "N";
        if (isset($this->session->userdata('member_session')['c_no'])){
            if (!($this->session->userdata('member_session')['c_no'] == "081553" || $this->session->userdata('member_session')['d_posn'] >= 60)){        
                $FC_bpshow = "Y";
            }
        }
        
        DEFINE("FC_bpshow",$FC_bpshow);
                
        DEFINE("FC_ImgLimit",'jpg;jpge;gif;png');
        DEFINE("FC_FileLimit",FC_ImgLimit.";".FC_OtherFileLimit);
        DEFINE("FC_delimg",array('300_','300_300','200_300'));        
        DEFINE("FC_Email",$this->config->item( 'FC_Email' ));//系統EMAIL
        DEFINE("FC_CorpEmail",$this->config->item( 'FC_CorpEmail' ));//公司EMAIL
        
    }  
    
}

/* End of file MY_Controller.php */