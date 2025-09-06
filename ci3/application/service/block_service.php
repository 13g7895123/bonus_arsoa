<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Block_service extends MY_Service
{
    public function __construct()
    {
        parent::__construct();
    }

    // Electronic form right menu
    public function electronic_form_right_menu($now_page)
    {
        $data = array('now_page' => $now_page);
        return $this->load->view('helper/electronic_form_right_menu', $data, TRUE);
    }
    
    // Load HTML footer - simplified version
    public function load_html_footer()
    {
        return '<footer class="footer mt-auto py-3">
                    <div class="container text-center">
                        <span class="text-muted">© 2025 EForm System. All rights reserved.</span>
                    </div>
                </footer>';
    }
    
    // Load HTML header - simplified version
    public function load_html_header($web_page = '')
    {
        return '<header class="header">
                    <div class="container">
                        <h1>EForm System</h1>
                    </div>
                </header>';
    }
}