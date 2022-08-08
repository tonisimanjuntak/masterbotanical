<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whychooseus extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Whychooseus_model');
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
        $data['menu'] = 'whychooseus';
        $this->load->view('whychooseus/form', $data);
    }

    public function simpan()
    {
        $deskripsi     = trim($this->input->post('deskripsi')) ;        
        $tglupdate    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');

        $file_lama = $this->input->post('file_lama');
        $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

        $data = array(
            'deskripsi'        => $deskripsi,
            'gambarsampul'      => $foto,
            'tglupdate'      => $tglupdate,
            'idpengguna'      => $idpengguna,
        );
        $simpan = $this->Whychooseus_model->update($data);

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
        redirect('whychooseus');
    }


    public function get_edit_data()
    {
        $RsData = $this->db->query("select * from utilwhychooseus")->row();

        $data = array(
            'gambarsampul'       => $RsData->gambarsampul,
            'deskripsi'    => $RsData->deskripsi,
            'tglupdate' => $RsData->tglupdate,
            'idpengguna'      => $RsData->idpengguna,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/whychooseus/';
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
            $config['upload_path']   = '../uploads/whychooseus/';
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

}

/* End of file Whychooseus.php */
/* Location: ./application/controllers/Whychooseus.php */