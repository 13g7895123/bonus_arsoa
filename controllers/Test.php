<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');
        $this->load->model( 'front_mssql_model' );       
        $this->load->model( 'front_member_model' );  
        $this->load->model( 'front_order_model' );  
        $this->load->model( 'front_base_model' );  
        $this->load->model( 'Member_line_model' );
        
        $this->load->service(array(
            'cache_service',
            'line_service',
            'api_line_service'
        ));        
    }
    
    public function info()
    {
     // phpinfo();
      exit;
    }
    
    public function ttt()
    {
        
         $msg = $this->block_service->question_send_line(26,'question_corn_1');
                                                                                                          
         //$this->front_member_model->member_line_bind('000000','test','U1f8c9566bd3519855409230932767d38');
         exit;
    }
    
    public function tt($type,$key = '')
    {
        $this->load->helper('cookie');
        
        if ($type == 'delcookie'){          
            if ($key == ''){
                $key = 'cookie_key';
            }
            delete_cookie($key);
        }
        if ($type == 'cookie'){
            echo "<pre>".print_r($_COOKIE,true)."</pre>";
        }
        if ($type == 'session'){
            echo "<pre>".print_r($this->session->userdata,true)."</pre>";     
        }
        exit;
    }
    
    public function email()
    {
        $obj = &get_instance();

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'email-smtp.ap-northeast-1.amazonaws.com';
        $config['smtp_user'] = 'AKIA4PRTZBV4UUIALFPW';
        $config['smtp_pass'] = 'BFV+xy5n2ricdSblnw2+8SLfWxC2R8be/gmScX32VnYc';
        $config['smtp_port'] = '587';
        $config['newline'] = "\r\n";
        $config['smtp_crypto'] = 'tls';
        $obj->email->initialize($config);
        
        $obj->email->set_mailtype('html');
        // don't html_escape email header variables
        $obj->email->from('info@arsoa.tw', 'ARSoA');
        //$obj->email->reply_to($from_email, $from_name);
        $obj->email->to('abyzcase@gmail.com');
        $obj->email->subject('subject');
        $obj->email->message('bddd');
        $obj->email->send();
    }
    
    //寄信
	protected function send_email_sdk($to=null, $subject=null, $content=null, $from=0, $from_name=0)
	{	
	   	
	   $params = array(
	   		    'region' =>'ap-northeast-1',
	   		    'key'    => 'AKIA4PRTZBV4UUIALFPW',
       	    'secret' => 'BFV+xy5n2ricdSblnw2+8SLfWxC2R8be/gmScX32VnYc',
	   		    'version'=>'latest'
	   );
	   $SesClient = new SesClient($params);
	   	
	   if(!$from && !$from_name){
	   		$sender_email = 'info@arsoa.tw';
	   		$Source = 'ARSOA 安露莎';
	   }else{
	      $sender_email = $from;
	   		$Source = $from_name;
	   }    
	   $char_set = 'UTF-8';
	   	
	   try {		   
	   	    $result = $SesClient->sendEmail([
	   	        'Destination' => [
	   	             'ToAddresses' => [$to],
	   	             'BccAddresses' => ['info@arsoa.tw']
	   	        ],
	   	        'ReplyToAddresses' => [$sender_email],		        
	   	        'Source' => $sender_email,
	   	        'ConfigurationSetName' => 'ses-logs',
	   	        'Message' => [
	   	          'Body' => [
	   	              'Html' => [
	   	                  'Charset' => $char_set,
	   	                  'Data' => $content,
	   	              ],
	   	              'Text' => [
	   	                  'Charset' => $char_set,
	   	                  'Data' => $content,
	   	              ],
	   	          ],
	   	          'Subject' => [
	   	              'Charset' => $char_set,
	   	              'Data' => $subject,
	   	          ],
	   	        ]
	   	     ]);		     
	   	     $messageId = $result['MessageId'];
              //echo("Email sent! Message ID: $messageId"."\n");
	   	} catch (AwsException $e) {
	   	    // output error message if fails
	   	    echo $e->getMessage();
	   	    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
	   	    echo "\n";
	   	}

	}
	  public function session()
    {
      echo "<pre>".print_r($this->session->userdata,true)."</pre>";exit;
    }
    
    public function index()
    {
      
            $atmdate = date('Y-m-d',strtotime('+3 day')); // + 3 天
                   
                   $WebATMAcct = $this->front_order_model->WebATMAcct('81881','W202008070','1460', $atmdate,"N");  //轉入帳號
                   echo $WebATMAcct;
                   exit;
                   
      
      $syear = 2021;
      echo sprintf("%04d",$this->front_base_model->PF_SerOrder("A".$syear));
      exit;
        
        $test_config['protocol'] = 'smtp';
        $test_config['mailtype'] = 'html';
        $test_config['smtp_host'] = 'email-smtp.ap-northeast-1.amazonaws.com';
        $test_config['smtp_port'] = '587';
        $test_config['smtp_crypto'] = 'tls';
        $test_config['smtp_user'] = 'AKIA4PRTZBV4UUIALFPW';
        $test_config['smtp_pass'] = 'BFV+xy5n2ricdSblnw2+8SLfWxC2R8be/gmScX32VnYc';
        $test_config['validation']      = "false"; 
        $test_config['charset'] = 'utf-8';
        $test_config['newline']      = "\r\n"; 
        
        $this->email->initialize($test_config);
        $this->email->set_newline("\r\n");
        
        $this->email->from('info@arsoa.tw', 'From at Test.com');
        
        $this->email->to('abyzcase@gmail.com');
        
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        
        if (!$this->email->send()){
            $this->email->print_debugger();
        }
        
        exit;
        
        $this->send_email('abyzcase@gmail.com','test','Body');	

        exit;
        
        $this->session->unset_userdata( 'member_session' );
        $this->front_member_model->member_cookie_login();
        echo "<pre>".print_r($this->session->userdata,true)."</pre>";
        exit;
        
        $msconn = $this->front_mssql_model->ms_connect();       
        $data = $this->front_mssql_model->get_data($msconn,"{CALL ww_q_monpv('2020-04-25','000000')}",array());
        echo "<pre>".print_r($data,true)."</pre>";exit;       
        
      /* 
         $params = [ 
           ['202005',  SQLSRV_PARAM_IN],     
           ['071157',  SQLSRV_PARAM_IN],     
           ['3',  SQLSRV_PARAM_IN],     
           ['1',  SQLSRV_PARAM_IN],     
           [&$c_name, SQLSRV_PARAM_OUT] 
       ]; 
       echo "<pre>".print_r($params,true)."</pre>";
        $params = array('202005','071157','1','1');
        
        $this->front_mssql_model->get_sp_data('mm_q_test3',$params);
        
       exit;
       */
       if ($this->front_mssql_model->ms_test()){
           echo "OK";     
       }else{
           echo "NOK";     
       }
       exit;
       /* 
       echo "[".date('H:i:s')." ".microtime()."]<br>";     
       $telnet = shell_exec("ping 192.168.1.21");
       echo "<pre>".print_r($telnet,true)."</pre>";
       echo "[".date('H:i:s')." ".microtime()."]<br>";     
       echo '<br>';
       echo '<br>';
       */
       $connect = @fsockopen("192.168.1.12", 1433);
       echo "[".date('H:i:s')." ".microtime()."]<br>";     
       if($connect){
           echo 'OK<br>';
           fclose($connect);
       }else{
           echo 'ERROR<br>';
       }
       echo "[".date('H:i:s')." ".microtime()."]<br>";     
       echo 'xxxxx';
       exit;

       
       $telnet = shell_exec("telnet 192.168.1.21 1433");
       echo "<pre>".print_r($telnet,true)."</pre>";exit;
        
       exit;
        echo "[".date('H:i:s')." ".microtime()."]<br>";     
       if (!$this->front_mssql_model->ms_test()){
           echo "!!!<br>";     
       }
       echo "[".date('H:i:s')." ".microtime()."]<br>";     
       echo 'OK';
       exit;
       $msconn = $this->front_mssql_model->ms_connect();       
       
       $c_no = 'c_no';
       /*     
       $params = [ 
           ['3500',  SQLSRV_PARAM_IN],     
           ['3',  SQLSRV_PARAM_IN],     
           [&$c_no, SQLSRV_PARAM_OUT] 
       ]; 
            
       $data = $this->front_mssql_model->get_data($msconn,"{CALL mm_q_test3(?,?,?)}",$params);
       echo "<pre>".print_r($data,true)."</pre>";exit;            
       */
       echo "[".date('H:i:s')." ".microtime()."]";
       
       $c_name = 'c_name';
            
       $params = [ 
           ['202005',  SQLSRV_PARAM_IN],     
           ['071157',  SQLSRV_PARAM_IN],     
           ['3',  SQLSRV_PARAM_IN],     
           ['1',  SQLSRV_PARAM_IN],     
           [&$c_name, SQLSRV_PARAM_OUT] 
       ]; 
            
       $data = $this->front_mssql_model->get_data($msconn,"{CALL mm_q_test2(?,?,?,?,?)}",$params);
       echo "<pre>".print_r($data,true)."</pre>";          
       echo "[".date('H:i:s')." ".microtime()."]";
       /*       
       $c_name = 'c_name';
       $d_pos = 'd_pos';
            
       $params = [ 
           ['202005',  SQLSRV_PARAM_IN],     
           ['200721',  SQLSRV_PARAM_IN],     
           ['3',  SQLSRV_PARAM_IN],     
           ['1',  SQLSRV_PARAM_IN],     
           [&$c_name, SQLSRV_PARAM_OUT], 
           [&$d_pos, SQLSRV_PARAM_OUT], 
       ]; 
            
       $data = $this->front_mssql_model->get_data($msconn,"{CALL mm_q_test1(?,?,?,?,?,?)}",$params);
       echo "<pre>".print_r($data,true)."</pre>";exit;            
       // ---------------------------
       $params = array (3);  
       $this->front_mssql_model->delete_data($msconn,"delete from test where int1 = ?",$params);       
       // ---------------------------
       $params = array ('文字測試4','6','文字測試122',date('Y-m-d H:i:s'),1);  
       $this->front_mssql_model->update_data($msconn,"update test set varc1 = ? ,char1 = ?,nvar1 = ?,date2=? where int1 = ?",$params);
       // ---------------------------       
       $params = array (3,'文字測試1','1233','文字測試2',date('Y-m-d'),date('Y-m-d H:i:s'));  
       $this->front_mssql_model->insert_data($msconn,"INSERT INTO test (int1,varc1,char1,nvar1,date1,date2) VALUES (?, ?, ?, ?, ?, ?) ",$params);
       */
       
       $params = array ('1'); 
       $data = $this->front_mssql_model->get_data($msconn,"select * from test where 1 = ? ",$params);
        
       echo "<pre>".print_r($data,true)."</pre>";
       
       
       
       
       
       $this->front_mssql_model->ms_close($msconn);       
       
       exit;
       
    }   
}