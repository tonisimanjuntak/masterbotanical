<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lappenjualan extends CI_Controller {

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
        $data['menu']     = 'lappenjualan';
        $this->load->view('lappenjualan/listdata', $data);
    }

    public function cetak()
    {
        error_reporting(0);
        $this->load->library('Pdf');

        $jeniscetakan = $this->uri->segment(3);
        $statuskonfirmasi = $this->uri->segment(4);
        $idproduk = $this->uri->segment(5);
        $idprodukbatchnumber = $this->uri->segment(6);
        $tglawal  = date('Y-m-d', strtotime($this->uri->segment(7)));
        $tglakhir = date('Y-m-d', strtotime($this->uri->segment(8)));

        $where = " where tglpenjualan between '$tglawal' and '$tglakhir'";

        if ( !empty($statuskonfirmasi) && $statuskonfirmasi!="-" ) {
        	$where .= " and statuskonfirmasi='$statuskonfirmasi'";
        }

        if ( !empty($idproduk) && $idproduk!="-" ) {
        	$where .= " and idproduk='$idproduk'";
        }

        if ( !empty($idprodukbatchnumber) && $idprodukbatchnumber!="-" ) {
        	$where .= " and idprodukbatchnumber='$idprodukbatchnumber'";
        }

        $query = "select * from v_penjualandetail " . $where;
        $rspenjualan = $this->db->query($query);

        $data['rspenjualan']  = $rspenjualan;
        $data['statuskonfirmasi']  = $statuskonfirmasi;
        $data['idproduk']  = $idproduk;
        $data['idprodukbatchnumber']  = $idprodukbatchnumber;
        $data['tglawal']  = $tglawal;
        $data['tglakhir'] = $tglakhir;
        if ($jeniscetakan=='pdf') {
	        $this->load->view('lappenjualan/cetakpdf', $data);        	
        }else{
        	$data['namafile'] = 'download-laporan.xls';
	        $this->load->view('lappenjualan/cetakexcel', $data);
        }
    }

}

/* End of file Lappenjualan.php */
/* Location: ./application/controllers/Lappenjualan.php */