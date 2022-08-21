<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapbukukasumum extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
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
        $tglawal    = $this->input->post('tglawal');
        $tglakhir   = $this->input->post('tglakhir');
        $id_pegawai = $this->session->userdata('id_pegawai');

        if (empty($tglawal)) {
            $tglawal  = date('Y-m-d');
            $tglakhir = date('Y-m-d');
        }

        $data['tglawal']  = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['menu']     = 'lapbukukasumum';
        $this->load->view('lapbukukasumum/listdata', $data);
    }

    public function cetak()
    {
        error_reporting(0);
        $this->load->library('Pdf');

        $jeniscetakan = $this->uri->segment(3);
        $tglawal  = date('Y-m-d', strtotime($this->uri->segment(4)));
        $tglakhir = date('Y-m-d', strtotime($this->uri->segment(5)));

        $where = " where tgl between '$tglawal' and '$tglakhir'";


        $query = "select * from v_bukukasumum " . $where;
        $rsbukukas = $this->db->query($query);

        $data['rsbukukas']  = $rsbukukas;
        $data['tglawal']  = $tglawal;
        $data['tglakhir'] = $tglakhir;
        if ($jeniscetakan=='pdf') {
	        $this->load->view('lapbukukasumum/cetakpdf', $data);        	
        }else{
        	$data['namafile'] = 'download-laporan.xls';
	        $this->load->view('lapbukukasumum/cetakexcel', $data);
        }
    }

}

/* End of file Lapbukukasumum.php */
/* Location: ./application/controllers/Lapbukukasumum.php */