<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batchnumber extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Batchnumber_model');
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
        $data['menu'] = 'batchnumber';
        $this->load->view('batchnumber/listdata', $data);
    }

    public function tambah($idproduk)
    {
        $idproduk = $this->encrypt->decode($idproduk);

        if ($this->Batchnumber_model->get_by_id($idproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('batchnumber');
            exit();
        };
        $data['idproduk']      = $idproduk;
        $data['berat']         = '';
        $data['harga']         = '';
        $data['idprodukbatchnumber'] = '';
        $data['menu']          = 'batchnumber';
        $this->load->view('batchnumber/form', $data);
    }

    public function editbatchnumber($idprodukbatchnumber)
    {
        $idprodukbatchnumber = $this->encrypt->decode($idprodukbatchnumber);
        $rsbatchnumber = $this->Batchnumber_model->get_by_id_batchnumber($idprodukbatchnumber);

        if ($rsbatchnumber->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('batchnumber');
            exit();
        };
        $rowbatchnumber = $rsbatchnumber->row();

        $data['idproduk']      = $rowbatchnumber->idproduk;
        $data['idprodukbatchnumber'] = $idprodukbatchnumber;
        $data['rowbatchnumber'] = $rowbatchnumber;
        $data['menu']          = 'batchnumber';
        $this->load->view('batchnumber/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Batchnumber_model->get_datatables();
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
                $row[] = $rowdata->deskripsiproduk;
                $row[] = $rowdata->statusaktif;
                $row[] = $rowdata->jumlahbatch;
                $row[] = '<a href="' . site_url('batchnumber/tambah/' . $this->encrypt->encode($rowdata->idproduk)) . '" class="btn btn-sm btn-info btn-circle"><i class="fa fa-plus-circle"></i> Tambah</a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Batchnumber_model->count_all(),
            "recordsFiltered" => $this->Batchnumber_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function deletebatchnumber($idprodukbatchnumber)
    {
        $idprodukbatchnumber = $this->encrypt->decode($idprodukbatchnumber);
        $idproduk      = $this->Batchnumber_model->get_by_id_batchnumber($idprodukbatchnumber)->row()->idproduk;

        $hapus = $this->Batchnumber_model->hapusbatchnumber($idprodukbatchnumber);
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
        redirect('batchnumber/tambah/' . $this->encrypt->encode($idproduk));

    }


    public function simpanbatchnumber()
    {
        $idproduk      = $this->input->post('idproduk');
        $idprodukbatchnumber = $this->input->post('idprodukbatchnumber');
        $nomorbatch = $this->input->post('nomorbatch');
        $deskripsi = $this->input->post('deskripsi');
        


        if ($idprodukbatchnumber == '') {

            $idprodukbatchnumber = $this->db->query("SELECT create_idprodukbatchnumber('" . $idproduk . "','".date('Y-m-d')."') as idprodukbatchnumber")->row()->idprodukbatchnumber;

            $filebatch = $this->upload_foto($_FILES, "filebatch");


            if (empty($filebatch)) {
            	$pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> file batchnumber harus diupload!
                        </div>
                    </div>';
		        $this->session->set_flashdata('pesan', $pesan);
		        redirect('batchnumber/tambah/' . $this->encrypt->encode($idproduk));
            }
            

            $data = array(
                'idprodukbatchnumber' => $idprodukbatchnumber,
                'idproduk'      => $idproduk,
                'nomorbatch'         => $nomorbatch,
                'deskripsi'         => $deskripsi,
                'stok'         => 0,
                'filebatch'         => $filebatch,
            );
            $simpan = $this->Batchnumber_model->simpanbatchnumber($data);
        } else {

        	$filebatch_lama = $this->input->post('filebatch_lama');
            $filebatch      = $this->update_upload_foto($_FILES, "filebatch", $filebatch_lama);

            if (empty($filebatch)) {
            	$pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> file batchnumber harus diupload!
                        </div>
                    </div>';
		        $this->session->set_flashdata('pesan', $pesan);
		        redirect('batchnumber/tambah/' . $this->encrypt->encode($idproduk));
            }

            $data = array(
                'idproduk'      => $idproduk,
                'nomorbatch'         => $nomorbatch,
                'deskripsi'         => $deskripsi,
                'filebatch'         => $filebatch,
            );
            $simpan = $this->Batchnumber_model->updatebatchnumber($data, $idprodukbatchnumber);
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
        redirect('batchnumber/tambah/' . $this->encrypt->encode($idproduk));
    }

    public function get_edit_data_batchnumber()
    {
        $idprodukbatchnumber = $this->input->post('idprodukbatchnumber');
        $rowdata = $this->db->query("select * from produkbatchnumber where idprodukbatchnumber='$idprodukbatchnumber'")->row();

        $data = array(
            'idprodukbatchnumber'        => $rowdata->idprodukbatchnumber,
            'idproduk'        => $rowdata->idproduk,
            'nomorbatch'        => $rowdata->nomorbatch,
            'deskripsi'        => $rowdata->deskripsi,
            'filebatch'        => $rowdata->filebatch,
            'filelink'        => base_url('../uploads/batchnumber/').$rowdata->filebatch,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/batchnumber/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|PDF|Pdf';
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
            $config['upload_path']   = '../uploads/batchnumber/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|PDF|Pdf';
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


}

/* End of file Batchnumber.php */
/* Location: ./application/controllers/Batchnumber.php */