<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Chart_model');
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

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['menu']           = 'chart';
        $this->load->view('chart/index', $data);
    }

    public function removeitem($id)
    {
        $data = array(
            'rowid' => $id,
            'qty'   => 0,
        );

        $this->cart->update($data);
        $pesan = '<script>swal("Success!", "Product successfully remove from your shopping cart!", "success")</script>';
        $this->session->set_flashdata('pesan', $pesan);
        redirect('chart');
    }

    public function checkout()
    {
        $this->is_login();

        if ($this->cart->total_items() <= 0) {
            $pesan = '<script>swal("Upps!", "You dont have any product in your cart!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('chart');
        }

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowkonsumen             = $this->db->query("select * from konsumen where idkonsumen='".$this->session->userdata('idkonsumen')."'")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowkonsumen'] = $rowkonsumen;
        $data['menu']           = 'chart';
        $this->load->view('chart/checkout', $data);
    }

    public function submitcheckout()
    {
        if ($this->cart->total_items() <= 0) {
            $pesan = '<script>swal("Upps!", "You dont have any product in your cart!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('chart');
        }

        $idbank           = $this->input->post('idbank');
        $negara           = $this->input->post('negara');
        $propinsi         = $this->input->post('propinsi');
        $kota             = $this->input->post('kota');
        $desa             = $this->input->post('desa');
        $alamat           = $this->input->post('alamat');
        $idjasapengiriman = $this->input->post('idjasapengiriman');
        $tglpenjualan     = null;
        $tglcheckout     = date('Y-m-d H:i:s');
        $tglinsert        = date('Y-m-d H:i:s');
        $idkonsumen       = $this->session->userdata('idkonsumen');
        $keterangan       = null;
        $metodepembayaran = 'Transfer';
        $totalpenjualan   = $this->cart->total();
        $idkonsumen = $this->session->userdata('idkonsumen');

        $idpenjualan = $this->db->query("select create_idpenjualan('" . date('Y-m-d') . "') as idpenjualan ")->row()->idpenjualan;

        $arrayhead = array(
            'idpenjualan'      => $idpenjualan,
            'tglpenjualan'     => $tglcheckout,
            'idkonsumen'       => $idkonsumen,
            'keterangan'       => $keterangan,
            'metodepembayaran' => $metodepembayaran,
            'totalpenjualan'   => $totalpenjualan,
            'negara'           => $negara,
            'propinsi'         => $propinsi,
            'kota'             => $kota,
            'desa'             => $desa,
            'alamatpengiriman' => $alamat,
            'idjasapengiriman' => $idjasapengiriman,
            'statuskonfirmasi' => 'Menunggu',
            'statuspengiriman' => 'Belum Dikirim',
            'idjasapengiriman' => $idjasapengiriman,
            'isfrontend' => 'Yes',
            'idbank' => $idbank,
            'tglcheckout'        => $tglcheckout,
            'tglinsert'        => $tglinsert,
            'tglupdate'        => $tglinsert,
        );

        //-------------------------------- >> simpan dari cart
        $i           = 0;
        $arraydetail = array();

        if (count($this->cart->contents()) > 0) {
            foreach ($this->cart->contents() as $items) {

                $idprodukharga = $items['idprodukharga'];
                $idproduk      = $items['idproduk'];
                $idprodukbatchnumber      = $items['idprodukbatchnumber'];
                $beratproduk   = untitik($items['berat']);
                $hargaproduk   = untitik($items['hargajual']);
                $qty           = untitik($items['qty']);
                $subtotal      = untitik($items['subtotal']);
                $i++;

                $detail = array(
                    'idpenjualan' => $idpenjualan,
                    'idproduk'    => $idproduk,
                    'idprodukbatchnumber'    => $idprodukbatchnumber,
                    'beratproduk' => $beratproduk,
                    'hargaproduk' => $hargaproduk,
                    'qty'         => $qty,
                    'subtotal'    => $subtotal,
                );

                array_push($arraydetail, $detail);

            }
        }

        // var_dump($arraydetail);
        // exit();
        $simpan = $this->Chart_model->simpan($arrayhead, $arraydetail, $idpenjualan);

        if (!$simpan) {
            //jika gagal
            // $eror = $this->db->error();         
            $pesan = '<script>swal("Failed!", "Your Cart failed to save!", "warning")</script>';
            exit();
        }else{
            $pesan = '<script>swal("Success!", "Your Cart success to save!", "success")</script>';
            $this->cart->destroy();
        }

        // jika berhasil akan sampai ke tahap ini

        $this->session->set_flashdata('pesan', $pesan);
        redirect('myaccount/orderhistory');

    }

}

/* End of file Chart.php */
/* Location: ./application/controllers/Chart.php */
