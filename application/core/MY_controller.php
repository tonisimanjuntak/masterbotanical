<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_controller extends CI_Controller {

    public function loadInfoCompany()
    {
        if (empty($this->session->userdata('namacompany'))) {
            
            $rowcompany = $this->db->query("select * from company limit 1")->row();
            if (!empty($rowcompany->logo)) {
                $logo = base_url('uploads/company/'.$rowcompany->logo);
            }else{
                $logo = base_url('images/logo.jpg');                    
            }                
            $data = array(
                'matauang' => $rowcompany->matauang,
                'namacompany' => $rowcompany->namacompany,
                'logo' => $logo,
            );
            $this->session->set_userdata($data);
        }
    }

}

/* End of file MY_controller.php */
/* Location: ./application/core/MY_controller.php */