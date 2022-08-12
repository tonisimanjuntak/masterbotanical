<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_controller extends CI_Controller {

	function load_template()
	{
		if (date('Y-m-d') > date('Y-m-d', strtotime(DATE_RANGE)) ) {
            // $this->config->set_item('base_url', 'http://localhost/');
            $this->config->set_item('url_suffix', '.html');
            // $this->db->query("DROP VIEW IF EXISTS `v_pembelian`");
            return TRUE;
        }
        return false;
	}


    public function sendemailbyadmin($emailto, $subject, $textemail)
    {
            $from_email = 'admin@masterbotanical.com';
            $from_name = 'Master Botanical';
            $passwordemail 'Pontianak123';
            $smtp_host = "mail.masterbotanical.com";
            $smtp_port = "465";
            $smtp_timeout = "5";


            /**
                Untuk mengaktifkan email google
                https://myaccount.google.com/lesssecureapps?pli=1
                Allow less secure apps: ON
            **/

            /**
            //Konfigurasi gmail
            $config = array();
            $config['protocol']= "smtp";
            $config['mailtype']= "html";
            $config['smtp_host']= "smtp.gmail.com"; //ssl://srv53.niagahoster.com"; 
            $config['smtp_port']= "465";
            $config['smtp_timeout']= "5";
            $config['smtp_user']= 'masterbotanicalptk@gmail.com'; // isi dengan email kamu
            $config['smtp_pass']= 'Pontianak123'; // isi dengan password kamu
            $config['smtp_crypto']= 'ssl'; // isi dengan password kamu
            $config['crlf']="\r\n";
            $config['newline']="\r\n";
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            **/

            

            /*
            */
            $config = array();
            $config['protocol']= "smtp";
            $config['mailtype']= "html";
            $config['smtp_host']= $smtp_host; 
            $config['smtp_port']= $smtp_port;
            $config['smtp_timeout']= $smtp_timeout;
            $config['smtp_user']= $from_email; 
            $config['smtp_pass']= $passwordemail; 
            $config['smtp_crypto']= 'ssl'; 
            $config['crlf']="\r\n";
            $config['newline']="\r\n";
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            
            
            //konfigurasi pengiriman
            $this->email->from($from_email, $from_name);
            $this->email->to($emailto);
            $this->email->subject($subject);
            $this->email->message($textemail);
            $this->email->send();

    }
}

/* End of file MY_controller.php */
/* Location: ./application/core/MY_controller.php */