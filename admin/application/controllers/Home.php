<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    

    public function __construct()
    {
        parent::__construct();
        $this->is_login();

        //Do your magic here
    }

    public function is_login()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (empty($idpengguna)) {
            $pesan = '<div class="alert alert-danger">Session telah berakhir. Silahkan login kembali . . . </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login');
            exit();
        }
    }

    public function index()
    {
        $data["menu"] = "Home";
        $this->load->view("home", $data);
    }


    public function getinfobox()
    {

        $sebulan = date('Y-m-d', strtotime('-1 month', date('Y-m-d')) );

        $jlhorder = $this->db->query("SELECT COUNT(*) AS jlhorder FROM penjualan WHERE isfrontend = 'Yes' AND statuskonfirmasi='Menunggu'")->row()->jlhorder;

        $jlhnewkonsumen = $this->db->query("SELECT COUNT(*) AS jlhnewkonsumen FROM konsumen WHERE tglinsert BETWEEN '".$sebulan."' AND '".date('Y-m-d')."'");

        $jlhfreeconsultation = 0;

        $jlhoutofstock = 0;


    }
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
