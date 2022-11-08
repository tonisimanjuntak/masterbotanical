<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->loadInfoCompany();
        // $this->load->model('Pages_model.php');
    }

    public function is_login()
    {
        $idkonsumen = $this->session->userdata('idkonsumen');
        if (empty($idkonsumen)) {
            $pesan = '<script>swal("Login First!", "You have to login first to continue!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login'); 
            exit();
        }
    } 


    public function read($judulpageseo)
    {
    	$idkonsumen = $this->session->userdata('idkonsumen');
        $rowpages = $this->db->query("select * from v_pages where judulpageseo='".$judulpageseo."'");
        if ($rowpages->num_rows()==0) {
        	$pesan = '<script>swal("Upps!", "Your news not found!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect(site_url()); 
            exit();
        }

        if (empty($countviews)) {
        	$countviews = 0;
        }

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowpages']         = $rowpages->row();
        $data['menu']           = 'pages';
        $this->load->view('pages/read', $data);

    }

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */