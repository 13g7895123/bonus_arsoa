<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Redis settings
| -------------------------------------------------------------------------
| Your Redis servers can be specified below.
|
|   See: http://codeigniter.org.cn/user_guide/libraries/caching.html?highlight=redis#redis
|
*/

if(in_array(ENVIRONMENT, array("development", "testing"))) {
    $config = array(
        'socket_type' => 'tcp',
        'host'        => '',
        'password'    => '',
        'port'        => 6379,
        'timeout'     => 0
    );
}
else{
    $config = array(
        'socket_type' => 'tcp',
        'host'        => '',
        'password'    => '',
        'port'        => 6379,
        'timeout'     => 0
    );
}