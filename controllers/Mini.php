<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mini extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->load->service(array('cache_service'));
    }
    
    // header cache
    private function _caching_headers($file, $timestamp) 
    {
        $gmt_mtime = gmdate('r', $timestamp);
        header('ETag: "'.md5($timestamp.$file).'"');
        header('Last-Modified: '.$gmt_mtime);
        header('Cache-Control: must-revalidate, max-age=604800');
        
        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $gmt_mtime || str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == md5($timestamp.$file)) {
                header('HTTP/1.1 304 Not Modified');
                exit();
            }
        }
    }

    // compress css
    private function _compress_css($buffer) 
    {       
        /* remove comments */
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
                
        return $buffer;
    } 

    /*
     *  mini js
     */
    public function js($cache_name = '')
    {
        if(ENVIRONMENT == 'production') {
            self::_caching_headers($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
        }

        require(APPPATH .'/libraries/JSMin.php');
        $cont = '';
        $js   = '';
        $do_type = '';
        if($cache_name != '') {
            $cont = $this->cache_service->_get_cache_data('js='.sha1($cache_name).'_file');
            if(empty($cont) || in_array(ENVIRONMENT, array("development", "testing"))) {
                $cache_name = str_replace(".css", "", $cache_name);
                $file = json_decode(base64_decode(urldecode($cache_name)), true);
                $file = isset($file['file']) ? $file['file'] : array();
                if (count($file) > 0) {
                    foreach ($file as $v) {
                        if(!empty($v) && file_exists(APPPATH.'/public/js/'.$v.'.js')) {
                            $js .= file_get_contents(APPPATH.'/public/js/'.$v.'.js').PHP_EOL;
                        }
                    }
                }
                $cont  = '/* js cache file time: '.date("Y-m-d H:i:s").' */ ';
                $cont .= JSMin::minify($js);
                $this->cache_service->_save_cache_data('js='.sha1($cache_name).'_file', array('cont'=>$cont), $this->config->item('js_file_cache_time'));
            }
            else {
                $cont = $cont['cont'];
            }
        }

        header("Content-type: application/x-javascript; charset=UTF-8");
        echo $cont;
    }   

    /*
     *  mini css
     */
    public function css($cache_name = '')
    {
        if(ENVIRONMENT == 'production') {
            self::_caching_headers($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
        }
        
        $cont = '';
        $css  = '';
        if($cache_name != '') {
            $cont = $this->cache_service->_get_cache_data('css='.sha1($cache_name).'_file');
            if(empty($cont) || in_array(ENVIRONMENT, array("development", "testing"))) {                
                $cache_name = str_replace(".css", "", $cache_name);
                $file = json_decode(base64_decode(urldecode($cache_name)), true);
                $file = isset($file['file']) ? $file['file'] : array();
                if(count($file) > 0) {                    
                    foreach ($file as $v) {
                        if(!empty($v) && file_exists(APPPATH.'/public/css/'.$v.'.css')) {
                            $css .= file_get_contents(APPPATH.'/public/css/'.$v.'.css');
                        }
                    }
                    $css = str_replace(PHP_EOL, "", $css);
                }
                $cont  = '/* css cache file time: '.date("Y-m-d H:i:s").' */ ';
                $cont .= self::_compress_css($css);
                $this->cache_service->_save_cache_data('css='.sha1($cache_name).'_file', array('cont' => $cont), $this->config->item('css_file_cache_time'));
            }
            else {
                $cont = $cont['cont'];
            }
        }

        header("Content-type: text/css");
        echo $cont;
    }
    
    public function admin_css($cache_name = '')
    {
        if(ENVIRONMENT == 'production') {
            self::_caching_headers($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
        }

        $cont = '';
        $css  = '';
        if($cache_name != '') {
            $cont = $this->cache_service->_get_cache_data('css='.sha1($cache_name).'_file');            
            echo $cont;
            if(empty($cont) || in_array(ENVIRONMENT, array("development", "testing"))) {     
                $cache_name = str_replace(".css", "", $cache_name);                
                $file = json_decode(base64_decode(urldecode($cache_name)), true);                
                $file = isset($file['file']) ? $file['file'] : array();
                if(count($file) > 0) {
                    foreach ($file as $v) {                        
                        if(!empty($v) && file_exists(APPPATH.'/public/admin/css/'.$v.'.css')) {
                            $css .= file_get_contents(APPPATH.'/public/admin/css/'.$v.'.css');
                        }
                    }
                    $css = str_replace(PHP_EOL, "", $css);
                }
                $cont  = '/* css cache file time: '.date("Y-m-d H:i:s").' */ ';
                $cont .= self::_compress_css($css);                
                $this->cache_service->_save_cache_data('css='.sha1($cache_name).'_file', array('cont' => $cont), $this->config->item('css_file_cache_time'));
            }
            else {
                $cont = $cont['cont'];
            }
        }

        header("Content-type: text/css");
        echo $cont;
    }
    
    public function admin_js($cache_name = '')
    {
        if(ENVIRONMENT == 'production') {
            self::_caching_headers($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
        }

        require(APPPATH .'/libraries/JSMin.php');
        $cont = '';
        $js   = '';
        $do_type = '';
        if($cache_name != '') {
            $cont = $this->cache_service->_get_cache_data('js='.sha1($cache_name).'_file');
            if(empty($cont) || in_array(ENVIRONMENT, array("development", "testing"))) {
                $cache_name = str_replace(".js", "", $cache_name);
                $file = json_decode(base64_decode(urldecode($cache_name)), true);
                $file = isset($file['file']) ? $file['file'] : array();
                if (count($file) > 0) {
                    foreach ($file as $v) {
                        if(!empty($v) && file_exists(APPPATH.'/public/admin/js/'.$v.'.js')) {
                            $js .= file_get_contents(APPPATH.'/public/admin/js/'.$v.'.js').PHP_EOL;
                        }
                    }
                }
                $cont  = '/* js cache file time: '.date("Y-m-d H:i:s").' */ ';
                $cont .= JSMin::minify($js);
                $this->cache_service->_save_cache_data('js='.sha1($cache_name).'_file', array('cont'=>$cont), $this->config->item('js_file_cache_time'));
            }
            else {
                $cont = $cont['cont'];
            }
        }

        header("Content-type: application/x-javascript; charset=UTF-8");
        echo $cont;
    }   
}

/* End of file controller/Mini.php */