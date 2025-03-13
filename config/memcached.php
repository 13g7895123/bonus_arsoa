<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|   See: https://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
if(in_array(ENVIRONMENT, array("development", "testing"))) {
    $config = array(
        'default' => array(
            'hostname' => '',
            'port'     => '11211',
            'weight'   => '1',
        ),
    );
}
else {
    $config = array(
        'default' => array(
            'hostname' => '',
            'port'     => '11211',
            'weight'   => '1',
        )
    );
}