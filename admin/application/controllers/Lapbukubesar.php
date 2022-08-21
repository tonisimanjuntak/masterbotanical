<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lapbukubesar extends CI_Controller {

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
        $data['menu']     = 'lapbukubesar';
        $this->load->view('lapbukubesar/listdata', $data);
    }

    public function cetak()
    {
        error_reporting(0);
        $this->load->library('Pdf');

        $jeniscetakan = $this->uri->segment(3);
        $jenisakun = $this->uri->segment(4);
        $kdakun = $this->uri->segment(5);
        $tglawal  = date('Y-m-d', strtotime($this->uri->segment(6)));
        $tglakhir = date('Y-m-d', strtotime($this->uri->segment(7)));

        $where = " where tgljurnal between '$tglawal' and '$tglakhir'";
        $where_lalu = " where tgljurnal < '$tglawal' and year(tgljurnal)='".date('Y', strtotime($tglawal))."'";

        if ($jenisakun=='3') {
        	$where .= " and kdakun3='$kdakun'";        	
        	$where_lalu .= " and kdakun3='$kdakun'";        	
        	$namaakun = $this->db->query("select namaakun3 from akun3 where kdakun3='$kdakun'")->row()->namaakun3;
        }else{
        	$where .= " and kdakun4='$kdakun'";        	
        	$where_lalu .= " and kdakun4='$kdakun'";        	
        	$namaakun = $this->db->query("select namaakun4 from akun4 where kdakun4='$kdakun'")->row()->namaakun4;
        }


        $order_by = " order by tgljurnal asc";
        $query = "select * from v_jurnaldetail ". $where.$order_by;
        $rsjurnal = $this->db->query($query);
        
        $query_lalu = "select sum(debet) as debet, sum(kredit) as kredit from v_jurnaldetail ". $where_lalu;
        $rowjurnal_lalu = $this->db->query($query_lalu)->row();

        $data['rsjurnal']  = $rsjurnal;
        $data['rowjurnal_lalu']  = $rowjurnal_lalu;
        $data['kdakun']  = $kdakun;
        $data['namaakun']  = $namaakun;
        $data['tglawal']  = $tglawal;
        $data['tglakhir'] = $tglakhir;
        if ($jeniscetakan=='pdf') {
	        $this->load->view('lapbukubesar/cetakpdf', $data);        	
        }else{
        	$data['namafile'] = 'download-laporan.xls';
	        $this->load->view('lapbukubesar/cetakexcel', $data);
        }
    }

    public function get_akun4()
    {
    	$rsakun = $this->db->query("select * from akun4 order by kdakun4");
    	echo json_encode($rsakun->result() );
    }

    public function get_akun3()
    {
    	$rsakun = $this->db->query("select * from akun3 order by kdakun3");
    	echo json_encode($rsakun->result() );
    }

}

/* End of file Lapbukubesar.php */
/* Location: ./application/controllers/Lapbukubesar.php */