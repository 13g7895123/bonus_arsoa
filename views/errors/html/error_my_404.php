<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci = get_instance();
$ci->load->service( 'block_service' );    

$login_data = $ci->block_service->err404($ci);
      
exit;

?>