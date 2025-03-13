<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        _timer('*** controllers start ***');

        $this->load->library( 'user_agent' );
        
        if ( $_SERVER['HTTP_HOST'] == 'localhost'){   // 本機測試   
             $this->PATH_INFO = $_SERVER['REQUEST_URI'];  
        }else{
             $this->PATH_INFO = $_SERVER['PATH_INFO'];  
        }
        
        $this->load->library('layout', array('layout' => '../template/admin_layout'));
    }
    
    public function set($kind)
    {
        $this->load->model( 'front_admin_model' );
        
        if ( !$this->front_admin_model->check_admin_login( TRUE ) ) {
            redirect( 'wadmin/login' );
        }
        
	     $data['set'] =explode("\n", $this->block_service->PF_ReadFile("config\set.php"));
        
        $data['web_page'] = 'set';
        
        $data['kind'] = $kind;
        
        $this->admin_session = $this->session->userdata( 'admin_session' );
        
        $data['error_message'] = $this->session->flashdata( 'error_message' );
                              
        $this->layout->view('admin/setedit', $data);
        
    }
    
    public function setsave($kind)
    {
        $data_post = $this->input->post( NULL, TRUE );

        if ( is_array( $data_post ) && sizeof( $data_post ) > 0){
            
            $FileName = "config\set.php";
            
            $body="<?php\n";
            
            $array =explode("\n", $this->block_service->PF_ReadFile($FileName));
                        
            for ($i = 0;$i<count($array);$i++){ 	
            	  $array[$i]=trim($array[$i]);            	
            	  if ($array[$i]!='' && substr_count($array[$i],"?")==0){            		
            		if (substr($array[$i],0,2)=='//'){            			
            			$body.="//".substr($array[$i],2,strlen($array[$i]))."\n";            			
            		}else{	
            			$GLOBALS["str"]=$array[$i];
            			$fieldname="";
            			$fieldvalue="";
            			$fieldtitle="";
            			$fieldmemo="";
            			if (substr($array[$i],0,6)=='DEFINE'){		
            				$fieldname=trim($this->block_service->PF_GetStr($GLOBALS["str"],"\"","\"",1));					
            					$fieldvalue=trim($this->block_service->PF_GetStr($GLOBALS["str"],",\"","\"",1));	
            					$body.="DEFINE(\"".$fieldname."\",\"".$data_post[$fieldname]."\");";						
            					
            					$fieldtitle=$this->block_service->PF_GetStr($GLOBALS["str"],"//","",1);	
            					if (substr_count($fieldtitle,"(")>0){					
            						$fieldtitle=$this->block_service->PF_GetStr($fieldtitle,"","(",1);	
            						$fieldmemo=$this->block_service->PF_GetStr($GLOBALS["str"],"",")",1);	
            						$body.="//".$fieldtitle;
            						$body.=$fieldmemo.")";
            					}else{
            						$body.="//".$fieldtitle;
            					}            					
            			}else{            			    
            					$typ=$this->block_service->PF_GetStr($GLOBALS["str"],"$","[",1);	
            					$fieldname=$this->block_service->PF_GetStr($GLOBALS["str"],"['","']",1);
            					$fieldvalue=$this->block_service->PF_GetStr($GLOBALS["str"],"\"","\"",1);	
            					$body.="\$".$typ."['".$fieldname."']=\"".$data_post[$fieldname]."\";";					
            					
            					$fieldtitle=$this->block_service->PF_GetStr($GLOBALS["str"],"//","",1);	
            					
            					if (substr_count($fieldtitle,"(")>0){					
            						$fieldtitle=$this->block_service->PF_GetStr($fieldtitle,"","(",1);	
            						$fieldmemo=$this->block_service->PF_GetStr($GLOBALS["str"],"",")",1);	
            						$body.="//".$fieldtitle;
            						$body.=$fieldmemo.")";
            					}else{
            						$body.="//".$fieldtitle;
            					}
            				
            			}	
            			$body.="\n";
            		}	
            	
            	}
            	
            }	
	         $body.="?>";
	        	
	         $this->block_service->PF_WriteFile($FileName,$body);
	
	         $this->session->set_flashdata( 'error_message', '編輯成功!' );
            
           redirect( 'wadmin/admin/set/'.$kind );
                 
           exit;
        }
    }
    
}