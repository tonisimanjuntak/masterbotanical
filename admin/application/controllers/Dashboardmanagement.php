<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardmanagement extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Dashboardmanagement_model');
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
        $data["menu"] = "dashboardmanagement";
        $this->load->view("dashboardmanagement", $data);
    }


    public function getinfobox()
    {

        $sebulan = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d'))) );

        $jlhorder = $this->db->query("SELECT COUNT(*) AS jlhorder FROM penjualan WHERE isfrontend = 'Yes' AND statuskonfirmasi='Menunggu'")->row()->jlhorder;

        $jlhnewkonsumen = $this->db->query("SELECT COUNT(*) AS jlhnewkonsumen FROM konsumen WHERE tglinsert BETWEEN '".$sebulan."' AND '".date('Y-m-d')."'")->row()->jlhnewkonsumen;

        $jlhfreeconsultation = $this->db->query("SELECT COUNT(*) AS jlhfreeconsultation FROM consultation WHERE tglreply IS NULL")->row()->jlhfreeconsultation;

        $jlhoutofstock = $this->db->query("SELECT COUNT(*) AS jlhoutofstock FROM v_produkstok WHERE statusaktif='Aktif' AND stok=0")->row()->jlhoutofstock;;

        $data = array(
                    'jlhorder' => $jlhorder, 
                    'jlhnewkonsumen' => $jlhnewkonsumen, 
                    'jlhfreeconsultation' => $jlhfreeconsultation, 
                    'jlhoutofstock' => $jlhoutofstock, 
                );

        echo json_encode($data);
    }

    public function getchartbulanini()
    {
        $rspenjualanbulanini = $this->Dashboardmanagement_model->getchartbulanini();
        $tanggalpenjualan = array();
        $totalpenjualan = array();
        $totalsemua = 0;

        if ($rspenjualanbulanini->num_rows()>0) {
            foreach ($rspenjualanbulanini->result() as $row) {
                $tanggalpenjualan[] = $row->tanggal;
                $totalpenjualan[] = $row->totalpenjualan;
                $totalsemua += $row->totalpenjualan;
            }
        }

        echo json_encode( array('tanggalpenjualan' => $tanggalpenjualan, 'totalpenjualan' => $totalpenjualan, 'totalsemua' => $totalsemua ));
    }

}

/* End of file Dashboardmanagement.php */
/* Location: ./application/controllers/Dashboardmanagement.php */