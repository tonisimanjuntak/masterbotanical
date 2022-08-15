<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->cart->product_name_rules = "\+\.\:\-_ a-z0-9\pL";
        $this->load->library('pagination');
        $this->load->model('Shop_model');
        //Do your magic here
    }

    public function index()
    {

        // $rsproduk = $this->db->query("select * from v_produk");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $total_rows = $this->Shop_model->count_all();

        //konfigurasi pagination
        $config['base_url'] = site_url('shop/index/'); //site url
        $config['total_rows'] = $total_rows; //total row
        $config['per_page'] = 6;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 
        // Membuat Style pagination untuk BootStrap v4
        $config['display_prev_link'] = FALSE;
        $config['display_prev_link'] = FALSE;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['data'] = $this->Shop_model->get_all($config["per_page"], $data['page']);           
 
        $data['pagination'] = $this->pagination->create_links();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        // $data['rsproduk']       = $rsproduk;
        $data['idjenis']        = '';
        $data['idorderby']        = '';
        $data['hidebestseller']        = false;
        $data['menu']           = 'shop';
        $this->load->view('shop/index', $data);

    }

    public function filter($idjenis = '', $idorderby = '')
    {
        $idjenisencrypt = $idjenis;

        $produkWhere = 'where idproduk is not null';
        if (!empty($idjenis)) {
            if ($idjenis != 'all') {                
                $idjenis = $this->encrypt->decode($idjenis);
                $produkWhere .= " and idjenis = '$idjenis'";
            }
        }


        $orderby = " order by namaproduk ";
        if ( !empty($idorderby) && ( $idorderby=='name' || $idorderby=='price') || $idorderby == 'category' ) {
            switch ($idorderby) {
                case 'category':
                    $orderby = " order by namajenis ";
                    break;
                case 'price':
                    $orderby = " order by lowestprice ";
                    break;                
                default:
                    $orderby = " order by namaproduk ";
                    break;
            }
        }
        $rsproduk = $this->db->query("select * from v_produk $produkWhere $orderby");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();



        $total_rows = $this->Shop_model->count_all_filter($idjenis);

        //konfigurasi pagination
        $config['base_url'] = site_url('shop/filter/'.$idjenisencrypt.'/'.$idorderby .'/'); //site url
        $config['total_rows'] = $total_rows; //total row
        $config['per_page'] = 6;  //show record per halaman
        $config["uri_segment"] = 5;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 
        // Membuat Style pagination untuk BootStrap v4
        $config['display_prev_link'] = FALSE;
        $config['display_prev_link'] = FALSE;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['data'] = $this->Shop_model->get_all_filter($config["per_page"], $data['page'], $idjenis);           
 
        $data['pagination'] = $this->pagination->create_links();


        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsproduk']       = $rsproduk;
        $data['idjenis']        = $idjenis;
        $data['idorderby']        = $idorderby;
        $data['hidebestseller']        = true;
        $data['menu']           = 'shop';
        $this->load->view('shop/filter', $data);

    }

    public function searchproduct()
    {
        $search = $this->input->post('search');
        $rsproduk = $this->db->query("select * from v_produk where namaproduk like '%".$search."%'");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();


        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['data']       = $rsproduk;
        $data['idjenis']        = '';
        $data['hidebestseller']        = true;
        $data['search']           = $search;
        $data['menu']           = 'shop';

        $this->load->view('shop/search', $data);

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
