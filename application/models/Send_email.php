<?php
class Send_email extends CI_Model
{
    function __construct()
    {
		  parent::__construct();
        $this->load->database();
        date_default_timezone_set("Asia/Calcutta");
    }
    public function set_smtp_details() {   

         $this->db->select('*');
         $this->db->from('dbo.auth_details');
         $query = $this->db->get();
         $res = $query->row();
	    
	   $config = array(

            'smtp_crypto' => $res->crypto_protocol,
            'protocol'  =>   $res->protocol,
            'smtp_host' =>   $res->smtp_host,
            'smtp_port' =>   $res->smtp_port,
            'smtp_user' =>   $res->smtp_user,
            'smtp_pass' =>   $res->smtp_pass,
            'mailtype'  =>   'html',
            'charset'   =>   'utf-8',
            'wordwrap' => TRUE
        );
      
	  
	    return $config;
	}
	
	public function email($email,$subject,$message)
	{ 
                    $this->load->library('email');

                    //SMTP & mail configuration
                    $config = $this->set_smtp_details();
                    $this->email->initialize($config);
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $this->email->to($email);
                    $this->email->from('websitesmtp@myiswtransport.com','UBIBUS');
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->load->library('encrypt');
                    //Send email
                    if ($this->email->send()) {
                    }
		
	}

		public function delivery_mail($temail,$demail,$cemail,$new_message,$new_subject)
	{
		
                    $this->load->library('email');
                       $email = array(
                           'patidara52@gmail.com',
                            $demail,
                            $cemail,
                           );
                foreach($email as $contact) {

                    //SMTP & mail configuration
                    $this->load->library('email');
                    $config = $this->set_smtp_details();
                    $this->email->initialize($config);
                    $this->email->set_mailtype("html");
                    $this->email->set_newline("\r\n");
                    $this->email->to($contact);
                    $this->email->from('no-reply@golchagroup.com','SCM');
                    $this->email->subject($new_subject);
                    $this->email->message($new_message);
                   // $this->load->library('encrypt');
                    //Send email
                   if(!$this->email->send())
                    {
                        
                        //echo 'Email Not Send';
                    }
                    else
                    {
                        //echo 'Email Send Successfully';
                    }
                
                }
		
	}
}
?>