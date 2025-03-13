<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Profiler Sections
| -------------------------------------------------------------------------
| This file lets you determine whether or not various sections of Profiler
| data are displayed when the Profiler is enabled.
| Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/profiling.html
|
*/
// 共用的 css 檔
$config['autoload_css'] = array(
    'arsoa'
);

// 共用的 js 檔
$config['autoload_js'] = array(
    'arsoa'
);

$config['admin_autoload_css'] = array(
    'bootstrap.min',
    'style',
    'font-awesome',
    'icon-font.min',
    'animate',
    'alertify.core',
    'alertify.default'
);

// 共用的 js 檔
$config['admin_autoload_js'] = array(
    'jquery-migrate-1.2.1',
    'alertify.min',
    'jquery.colorbox',
    'pjsfunc',
    'jquery.nicescroll',
    'scripts',    
    'bootstrap'
);

// css, js 合併輸出, 版本管控
$config['ver_css']             = 'araos.20200918';
$config['css_file_cache_time'] = 3600;
$config['ver_js']              = 'araos.20200918';
$config['js_file_cache_time']  = 3600;
if(in_array(ENVIRONMENT, array("development", "testing"))) {
    $config['ver_css']             = 'dev-araos.20200918';
    $config['css_file_cache_time'] = 3;
    $config['ver_js']              = 'dev-araos.20200918';
    $config['js_file_cache_time']  = 3;
}

$config['line_bot_basic_id']    = '@aqs1972';
$config['line_liff_url']        = '1656832375-578ddKjz';
$config['line_liff_lottery_url'] = '1656832375-kK4ZZVK2';
$config['line_liff_consent_url'] = '1656832375-mvzppxWJ';
$config['line_liff_activity_url'] = '1656832375-ydw771oG';
$config['line_liff_link_url'] = '1656832375-QaO33X2R';

$config['dev_line_liff_url']    = '1656832375-RZOpp1wV';
$config['line_liff_sample_url']    = '1656832375-EmDNNwqm';

$config['line_liff_question_url']        = '1656832375-Vw6mmZ1q';
$config['dev_line_liff_question_url']    = '1656832375-Vw6mmZ1q';

$config['cookies_name']         = 'arsoa_cookieid';

// Line@ 頻道設定值
$config['line_config'] = array(
    'channel_id'           => 1656832368,
    'channel_secret'       => '64909eb2db8677201531ff97c1de937c',
    'channel_access_token' => 'kmoTeB5c0bzwQmYCks3Fp3pP9hauX9cWy6h4qKskgq0woe8e83MeLyU4D+NKDwpXZlG4p3VQ6fmlNWHPEeey6vO1noX8shWqoz5k1793e3j0247AF0bFuD3zjn5Ty14hUmxG36kusDrtWjVxGIZFxAdB04t89/1O/w1cDnyilFU=',
    'api_root'             => 'https://api.line.me/v2',
    'api_data_root'        => 'https://api-data.line.me/v2',
    'line_client_id'       => '1656832375',                             // login 
    'line_client_secret'	 => '2a8f3c37e36b2d58a397dd6663b4aa8a',       // login     
);

$config['dev_line_config'] = array(
    'channel_id'           => 2002001363,
    'channel_secret'       => '414b71d0a2d352512c6e1ad42abeaf0c',
    'channel_access_token' => 'ym5Aq3+j02pzeIaZgPZZuImf/kWCgXhuyJz7imi5Ba8KXd+ow8Q7Qcf3btcaOrudiNUTRpbU4V527egSxjmz4rdi0ac1n2KdLsza48E1VaYd5/6EDHrJ2JHAvfOPsFofoM/i/2Lvh/tOwmc6PF4FogdB04t89/1O/w1cDnyilFU=',
    'api_root'             => 'https://api.line.me/v2',
    'api_data_root'        => 'https://api-data.line.me/v2',
    'line_client_id'       => '1656832375',                             // login 
    'line_client_secret'	 => '2a8f3c37e36b2d58a397dd6663b4aa8a',       // login     
);


$config['sample_html_url']     = 'https://www.arsoa.tw';
$config['lottery_html_url']     = 'https://www.arsoa.tw';

// API、相關網址 位置設定
// web url
$config['web_url']      = 'https://www.arsoa.tw';
if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試          
     $config['web_url']		= 'http://localhost/arsoa';
     $config['line_liff_url']        = '1656832375-RZOpp1wV';    
    // $config['sample_html_url']     = 'http://localhost/arsoa';
}else{
	  if (ENVIRONMENT == 'testing'){
	  	  $config['web_url']      = 'https://beta.arsoa.tw';
	  	  $config['line_liff_url']        = '1656832375-RZOpp1wV';
	  }
}

// cache_service cache 使用類型設定
$config['cache_type'] = ''; # 使用的cache類型 memcached / redis

// cache_service cache資料存取前置詞
$config['cache_name_prefix'] = ENVIRONMENT . '_arsoa_';

/* End of file /config/profiler.php */