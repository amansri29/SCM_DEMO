<?php
class Test extends CI_Model
{
    function __construct()
    {
		  parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
    }
    public function abc()
    {
    	echo 'hello how are u';
    }
}