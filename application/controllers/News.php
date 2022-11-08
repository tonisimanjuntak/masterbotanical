<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->loadInfoCompany();
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

    public function index()
    {
    	$idkonsumen = $this->session->userdata('idkonsumen');
        $rsnews = $this->db->query("select * from v_news where ispublish = 'Ya' order by tglinsert desc");
        $rsnewsmostviewed = $this->db->query("select * from v_news where ispublish = 'Ya' order by countviews desc limit 5");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsnews']         = $rsnews;
        $data['rsnewsmostviewed']         = $rsnewsmostviewed;
        $data['menu']           = 'news';
        $this->load->view('news/index', $data);

    }


    public function read($judulnewsseo)
    {
    	$idkonsumen = $this->session->userdata('idkonsumen');
        $rownews = $this->db->query("select * from v_news where judulnewsseo='".$judulnewsseo."'");
        if ($rownews->num_rows()==0) {
        	$pesan = '<script>swal("Upps!", "Your news not found!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('news'); 
            exit();
        }
        $countviews = $rownews->row()->countviews;
        if (empty($countviews)) {
        	$countviews = 0;
        }
        $countviews++;
        $this->db->query("update news set countviews=".$countviews." where judulnewsseo='".$judulnewsseo."'");
        $rsnewsmostviewed = $this->db->query("select * from v_news where ispublish = 'Ya' order by countviews desc limit 5");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rownews']         = $rownews->row();
        $data['rsnewsmostviewed']         = $rsnewsmostviewed;
        $data['menu']           = 'news';
        $this->load->view('news/read', $data);

    }


}

/* End of file News.php */
/* Location: ./application/controllers/News.php */