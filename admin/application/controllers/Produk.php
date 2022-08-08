<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produk_model');
        $this->load->library('image_lib');
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
        $data['menu'] = 'produk';
        $this->load->view('produk/listdata', $data);
    }

    public function tambah()
    {
        $data['idproduk'] = '';
        $data['menu']     = 'produk';
        $this->load->view('produk/form', $data);
    }

    public function edit($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);

        if ($this->Produk_model->get_by_id($idproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('produk');
            exit();
        };
        $data['idproduk'] = $idproduk;
        $data['menu']     = 'produk';
        $this->load->view('produk/form', $data);
    }

    public function harga($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);

        if ($this->Produk_model->get_by_id($idproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('produk');
            exit();
        };
        $data['idproduk']      = $idproduk;
        $data['berat']         = '';
        $data['harga']         = '';
        $data['idprodukharga'] = '';
        $data['menu']          = 'produk';
        $this->load->view('produk/harga', $data);
    }

    public function detailgambar($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);

        if ($this->Produk_model->get_by_id($idproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('produk');
            exit();
        };
        $data['idproduk']      = $idproduk;
        $data['berat']         = '';
        $data['harga']         = '';
        $data['idprodukharga'] = '';
        $data['menu']          = 'produk';
        $this->load->view('produk/detailgambar', $data);
    }

    public function editharga($idprodukharga)
    {
        $idprodukharga = $this->encrypt->decode($idprodukharga);
        $rsprodukharga = $this->Produk_model->get_by_id_harga($idprodukharga);

        if ($rsprodukharga->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('produk');
            exit();
        };
        $rowprodukharga = $rsprodukharga->row();

        $data['idproduk']      = $rowprodukharga->idproduk;
        $data['berat']         = $rowprodukharga->berat;
        $data['harga']         = format_rupiah($rowprodukharga->harga);
        $data['idprodukharga'] = $idprodukharga;
        $data['rowprodukharga'] = $rowprodukharga;
        $data['menu']          = 'produk';
        $this->load->view('produk/harga', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Produk_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->gambarproduk)) {
                    $gambarproduk = base_url('../uploads/produk/' . $rowdata->gambarproduk);
                } else {
                    $gambarproduk = base_url('../images/nofoto.png');
                }
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = '<img src="' . $gambarproduk . '" alt="" style="width: 80%;"><br>' . $rowdata->namaproduk;
                $row[] = $rowdata->namajenis;
                $row[] = $rowdata->deskripsiproduk;
                $row[] = $rowdata->statusaktif;
                $row[] = '<a href="' . site_url('produk/harga/' . $this->encrypt->encode($rowdata->idproduk)) . '" class="btn btn-sm btn-info btn-circle"><i class="fa fa-dollar-sign"></i></a> | <a href="' . site_url('produk/detailgambar/' . $this->encrypt->encode($rowdata->idproduk)) . '" class="btn btn-sm btn-success btn-circle"><i class="fa fa-file-image"></i></a> | <a href="' . site_url('produk/edit/' . $this->encrypt->encode($rowdata->idproduk)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('produk/delete/' . $this->encrypt->encode($rowdata->idproduk)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Produk_model->count_all(),
            "recordsFiltered" => $this->Produk_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idproduk = $this->input->post('idproduk');
        $query    = "select * from produkharga
                        WHERE produkharga.idproduk='" . $idproduk . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idproduk;
                $row[]  = format_decimal($rowdata->berat, 2);
                $row[]  = format_rupiah($rowdata->harga);
                $row[]  = '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>';
                $data[] = $row;
            }
        }

        $output = array(
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function delete($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);
        $rsdata   = $this->Produk_model->get_by_id($idproduk);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produk');
            exit();
        };

        $hapus = $this->Produk_model->hapus($idproduk);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk');

    }

    public function deleteharga($idprodukharga)
    {
        $idprodukharga = $this->encrypt->decode($idprodukharga);
        $idproduk      = $this->Produk_model->get_by_id_harga($idprodukharga)->row()->idproduk;

        $hapus = $this->Produk_model->hapusharga($idprodukharga);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk/harga/' . $this->encrypt->encode($idproduk));

    }

    public function deletedetailgambar($idprodukimage)
    {
        $idprodukimage = $this->encrypt->decode($idprodukimage);
        $idproduk      = $this->Produk_model->get_by_id_image($idprodukimage)->row()->idproduk;

        $hapus = $this->Produk_model->hapusdetailgambar($idprodukimage);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk/detailgambar/' . $this->encrypt->encode($idproduk));

    }

    public function simpan()
    {
        $idproduk        = $this->input->post('idproduk');
        $namaproduk      = $this->input->post('namaproduk');
        $idjenis         = $this->input->post('idjenis');
        $statusaktif     = $this->input->post('statusaktif');
        $deskripsiproduk = $this->input->post('deskripsiproduk');
        $tglinsert       = date('Y-m-d H:i:s');

        if ($idproduk == '') {

            $idproduk = $this->db->query("SELECT create_idproduk('" . $namaproduk . "') as idproduk")->row()->idproduk;

            $foto = $this->upload_foto($_FILES, "file");

            $data = array(
                'idproduk'        => $idproduk,
                'namaproduk'      => $namaproduk,
                'idjenis'         => $idjenis,
                'statusaktif'     => $statusaktif,
                'deskripsiproduk' => $deskripsiproduk,
                'gambarproduk'    => $foto,
            );
            $simpan = $this->Produk_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                'namaproduk'      => $namaproduk,
                'idjenis'         => $idjenis,
                'statusaktif'     => $statusaktif,
                'deskripsiproduk' => $deskripsiproduk,
                'gambarproduk'    => $foto,

            );
            $simpan = $this->Produk_model->update($data, $idproduk);
        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk');
    }

    public function simpanharga()
    {
        $idproduk      = $this->input->post('idproduk');
        $idprodukharga = $this->input->post('idprodukharga');
        $berat         = $this->input->post('berat');
        $hargasebelumdiskon         = untitik($this->input->post('hargasebelumdiskon'));
        $harga         = untitik($this->input->post('harga'));

        if ($harga > $hargasebelumdiskon) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Harga Diskon!</strong> Harga diskon tidak boleh lebih besar dari harga normal! 
                        </div>
                    </div>';            
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produk/harga/' . $this->encrypt->encode($idproduk));
        }


        if ($harga=='0' || $hargasebelumdiskon == '0') {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Harga!</strong> Harga normal dan harga diskon tidak boleh nol! 
                        </div>
                    </div>';            
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produk/harga/' . $this->encrypt->encode($idproduk));
        }


        if ($idprodukharga == '') {

            $idprodukharga = $this->db->query("SELECT create_idprodukharga('" . $idproduk . "') as idprodukharga")->row()->idprodukharga;

            $data = array(
                'idprodukharga' => $idprodukharga,
                'idproduk'      => $idproduk,
                'berat'         => $berat,
                'hargasebelumdiskon'         => $hargasebelumdiskon,
                'harga'         => $harga,
            );
            $simpan = $this->Produk_model->simpanharga($data);
        } else {

            $data = array(
                'idproduk' => $idproduk,
                'berat'    => $berat,
                'hargasebelumdiskon'         => $hargasebelumdiskon,
                'harga'    => $harga,
            );
            $simpan = $this->Produk_model->updateharga($data, $idprodukharga);
        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk/harga/' . $this->encrypt->encode($idproduk));
    }

    public function simpandetailgambar()
    {
        $idproduk = $this->input->post('idproduk');
        $foto     = $this->upload_foto_detail($_FILES, "gambarproduk");

        $data = array(
            'idproduk'             => $idproduk,
            'gambarproduk'         => $foto,
            'deskripsiprodukimage' => null,
        );
        $simpan = $this->Produk_model->simpandetailgambar($data);

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('produk/detailgambar/' . $this->encrypt->encode($idproduk));
    }

    public function get_edit_data()
    {
        $idproduk = $this->input->post('idproduk');
        $RsData   = $this->Produk_model->get_by_id($idproduk)->row();

        $data = array(
            'idproduk'        => $RsData->idproduk,
            'namaproduk'      => $RsData->namaproduk,
            'idjenis'         => $RsData->idjenis,
            'statusaktif'     => $RsData->statusaktif,
            'deskripsiproduk' => $RsData->deskripsiproduk,
            'gambarproduk'    => $RsData->gambarproduk,
        );

        echo (json_encode($data));
    }


    public function get_edit_data_harga()
    {
        $idprodukharga = $this->input->post('idprodukharga');
        $rowdata = $this->db->query("select * from v_produkharga where idprodukharga='$idprodukharga'")->row();

        $data = array(
            'idprodukharga'        => $rowdata->idprodukharga,
            'idproduk'        => $rowdata->idproduk,
            'berat'         => $rowdata->berat,
            'harga'      => format_rupiah($rowdata->harga),
            'hargasebelumdiskon'     => format_rupiah($rowdata->hargasebelumdiskon),
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/produk/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = "";
            }

        } else {
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/produk/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = $file_lama;
            }
        } else {
            $foto = $file_lama;
        }

        return $foto;
    }

    public function upload_foto_detail($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/produkdetail/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = "";
            }

        } else {
            $foto = "";
        }
        return $foto;
    }

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
