<?php if ( !defined( 'BASEPATH' ) )
    exit( 'No direct script access allowed' );

/************郵件伺服器設定******************/

$config['protocol']     = 'smtp';
$config['mailtype']     = 'html';
$config['charset']      = 'utf-8';
$config['newline']      = "\r\n";

if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試 
$config['smtp_host']    = 'smtp.mailgun.org';
$config['smtp_port']    = '587';
$config['smtp_timeout'] = '5';
$config['smtp_crypto']  = 'tls';
$config['smtp_user']    = 'postmaster@mg.049.tw';    // 填 Google App Domain Mail 也可以
$config['smtp_pass']    = '0fcf008d4719eb4f4985943c0e3005bb-9b463597-0234d569';
$config['crlf']         = "\r\n";
$config['wordwrap']     = true;
}else{
$config['smtp_host']    = 'email-smtp.ap-northeast-1.amazonaws.com';
$config['smtp_port']    = '587';
$config['smtp_crypto']  = 'tls';
$config['smtp_user']    = 'AKIA4PRTZBV4UUIALFPW';        //SMTP 帳號
$config['smtp_pass']    = 'BFV+xy5n2ricdSblnw2+8SLfWxC2R8be/gmScX32VnYc';                        //SMTP 密碼
}