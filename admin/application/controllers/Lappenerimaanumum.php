<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lappenerimaanumum extends CI_Controller {

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
        $data['menu']     = 'lappenerimaanumum';
        $this->load->view('lappenerimaanumum/listdata', $data);
    }

    public function cetak()
    {
        error_reporting(0);
        $this->load->library('Pdf');

        $jeniscetakan = $this->uri->segment(3);
        $kdakun4 = $this->uri->segment(4);
        $tglawal  = date('Y-m-d', strtotime($this->uri->segment(5)));
        $tglakhir = date('Y-m-d', strtotime($this->uri->segment(6)));

        $where = " where tglpenerimaanumum between '$tglawal' and '$tglakhir'";

        if ( !empty($kdakun4) && $kdakun4!="-" ) {
        	$where .= " and kdakun4='$kdakun4'";
        }

        $query = "select * from v_penerimaanumumdetail " . $where;
        $rspenerimaanumum = $this->db->query($query);

        $data['rspenerimaanumum']  = $rspenerimaanumum;
        $data['kdakun4']  = $kdakun4;
        $data['tglawal']  = $tglawal;
        $data['tglakhir'] = $tglakhir;
        if ($jeniscetakan=='pdf') {
	        $this->load->view('lappenerimaanumum/cetakpdf', $data);        	
        }else{
        	$data['namafile'] = 'download-laporan.xls';
	        $this->load->view('lappenerimaanumum/cetakexcel', $data);
        }
    }

}

/* End of file Lappenerimaanumum.php */
/* Location: ./application/controllers/Lappenerimaanumum.php */