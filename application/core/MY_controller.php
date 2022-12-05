<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function loadInfoCompany()
    {
        $rowsetting = $this->db->query("select * from setting limit 1")->row();
        $rowcompany = $this->db->query("select * from company limit 1")->row();
        if (!empty($rowsetting->logousaha)) {
            $logo = base_url('uploads/pengaturan/'.$rowsetting->logousaha);
        }else{
            $logo = base_url('images/logo.jp`g');                    
        }                

        if ($rowsetting->intervalslider==0 || empty($rowsetting->intervalslider)) {
            $intervalslider = 1;
        }else{
            $intervalslider = $rowsetting->intervalslider;
        }

        $data = array(
            'matauang' => $rowcompany->matauang,
            'namacompany' => $rowcompany->namacompany,
            'intervalslider' => $intervalslider*1000,
            'logo' => $logo,
        );
        $this->session->set_userdata($data);
        
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */