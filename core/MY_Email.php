<?php
 
class MY_Email extends CI_Email
{
    /**
     * Set Email Subject
     *
     * @access    public
     * @param     string
     * @return    void
     */
    function subject($subject)
    {
        $subject = '=?'. $this->charset .'?B?'. base64_encode($subject) .'?=';
        $this->_set_header('Subject', $subject);
    }
}