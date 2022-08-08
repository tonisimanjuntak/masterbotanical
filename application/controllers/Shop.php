<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->cart->product_name_rules = "\+\.\:\-_ a-z0-9\pL";
        //Do your magic here
    }

    public function index()
    {

        $rsproduk = $this->db->query("select * from v_produk");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsproduk']       = $rsproduk;
        $data['idjenis']        = '';
        $data['hidebestseller']        = false;
        $data['menu']           = 'shop';
        $this->load->view('shop/index', $data);

    }

    public function filter($idjenis = '', $orderby = '', $nopage = '')
    {
        $produkWhere = 'where idproduk is not null';

        if (!empty($idjenis)) {
            if ($idjenis != 'all') {
                $idjenis = $this->encrypt->decode($idjenis);
                $produkWhere .= " and idjenis = '$idjenis'";
            }
        }
        $rsproduk = $this->db->query("select * from v_produk $produkWhere");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsproduk']       = $rsproduk;
        $data['idjenis']        = $idjenis;
        $data['hidebestseller']        = true;
        $data['menu']           = 'shop';
        $this->load->view('shop/index', $data);

    }

    public function searchproduct()
    {
        $search = $this->input->post('search');
        $rsproduk = $this->db->query("select * from v_produk where namaproduk like '%".$search."%'");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsproduk']       = $rsproduk;
        $data['idjenis']        = '';
        $data['hidebestseller']        = true;
        $data['menu']           = 'shop';
        $this->load->view('shop/index', $data);

    }


    public function category($idjenis)
    {
        $idjenis  = $this->encrypt->decode($idjenis);
        $rsproduk = $this->db->query("select * from v_produk where idjenis='$idjenis'");

        $rowcompany         = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany'] = $rowcompany;
        $this->load->view('shop/index', $data);

    }


    public function detail($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);
        $rsproduk = $this->db->query("select * from v_produk where idproduk='$idproduk'");

        if ($rsproduk->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('shop');
            exit();
        };

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowproduk']      = $rsproduk->row();
        $data['menu']           = 'shop';
        $this->load->view('shop/detail', $data);

    }

    public function cart()
    {

        $rowcompany         = $this->db->query("select * from company limit 1")->row();
        $data['rowcompany'] = $rowcompany;
        $this->load->view('shop/cart', $data);

    }

    public function checkout()
    {

        $rowcompany         = $this->db->query("select * from company limit 1")->row();
        $data['rowcompany'] = $rowcompany;
        $this->load->view('shop/checkout', $data);

    }

    public function add_to_cart()
    {
        $idproduk = $this->input->post("idproduk");
        $qty      = $this->input->post("qty");

        foreach ($_POST['idprodukharga'] as $answer) {
            $idprodukharga = $answer;
        }
        $rowprodukharga = $this->db->query("select * from v_produkharga where idprodukharga='" . $idprodukharga . "'")->row();

        $harga        = $rowprodukharga->harga;
        $hargadiskon  = $rowprodukharga->harga;
        $berat        = $rowprodukharga->berat;
        $namaproduk   = $rowprodukharga->namaproduk;
        $gambarproduk = $rowprodukharga->gambarproduk;
        $jenis        = $rowprodukharga->namajenis;


        foreach ($_POST['idprodukbatchnumber'] as $idprodukbatchnumber_input) {
            $idprodukbatchnumber = $idprodukbatchnumber_input;
        }
        $rowprodukbatchnumber = $this->db->query("select * from produkbatchnumber where idprodukbatchnumber='" . $idprodukbatchnumber . "'")->row();
        $nomorbatch = $rowprodukbatchnumber->nomorbatch;

        // if ($stok<$qty) {
        //     $pesan = '<script>swal("Stok!", "Maaf, Stok tidak cukup!", "warning")</script>';
        //     $this->session->set_flashdata('pesan', $pesan);
        //     redirect('home/detailbarang/'.$idproduk);
        //     exit();
        // }

        $data = array(
            'id'            => '1' . $idproduk,
            'name'          => str_replace('/', '', $namaproduk),
            'price'         => $harga,
            'qty'           => $qty,
            'idproduk'      => $idproduk,
            'idprodukharga' => $idprodukharga,
            'idprodukbatchnumber' => $idprodukbatchnumber,
            'nomorbatch' => $nomorbatch,
            'foto'          => $gambarproduk,
            'berat'         => $berat,
            'hargabeli'     => 0,
            'hargajual'     => $harga,
            'hargadiskon'   => $hargadiskon,
            'jenis'         => $jenis,
            'subtotal'      => $qty * $hargadiskon,
        );

        $this->cart->insert($data);
        $pesan = '<script>swal("Success!", "product successfully added to shopping cart !", "success")</script>';
        $this->session->set_flashdata('pesan', $pesan);
        // echo $this->loadisicart();
        redirect('shop/detail/' . $this->encrypt->encode($idproduk));
    }

}

/* End of file Shop.php */
/* Location: ./application/controllers/Shop.php */
