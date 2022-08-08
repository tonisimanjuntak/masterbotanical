<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabinfo extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Tabinfo_model');
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
    	$rowtabinfo = $this->db->query("select * from utiltabinfo")->row();
        $data['menu'] = 'tabinfo';
        $data['rowtabinfo'] = $rowtabinfo;
        $this->load->view('tabinfo/form', $data);
    }

    public function simpan()
    {
        $tab1icon     = $this->input->post('tab1icon');
        $tab1judul        = $this->input->post('tab1judul');
        $tab1deskripsi      = $this->input->post('tab1deskripsi');
        $tab1idpage      = $this->input->post('tab1idpage');

        $tab2icon     = $this->input->post('tab2icon');
        $tab2judul        = $this->input->post('tab2judul');
        $tab2deskripsi      = $this->input->post('tab2deskripsi');
        $tab2idpage      = $this->input->post('tab2idpage');

        $tab3icon     = $this->input->post('tab3icon');
        $tab3judul        = $this->input->post('tab3judul');
        $tab3deskripsi      = $this->input->post('tab3deskripsi');
        $tab3idpage      = $this->input->post('tab3idpage');

        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');

        if (empty($tab1idpage)) {
        	$tab1idpage= NULL;
        }
        if (empty($tab2idpage)) {
        	$tab2idpage= NULL;
        }
        if (empty($tab3idpage)) {
        	$tab3idpage= NULL;
        }


        $data = array(
            'tab1icon'        => $tab1icon,
            'tab1judul'      => $tab1judul,
            'tab1deskripsi'      => $tab1deskripsi,
            'tab1idpage'      => $tab1idpage,
            'tab2icon'        => $tab2icon,
            'tab2judul'      => $tab2judul,
            'tab2deskripsi'      => $tab2deskripsi,
            'tab2idpage'      => $tab2idpage,
            'tab3icon'        => $tab3icon,
            'tab3judul'      => $tab3judul,
            'tab3deskripsi'      => $tab3deskripsi,
            'tab3idpage'      => $tab3idpage,
        );
        $simpan = $this->Tabinfo_model->update($data);

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
        redirect('tabinfo');
    }

    public function get_edit_data()
    {
        $idslider = $this->input->post('idslider');
        $RsData   = $this->Tabinfo_model->get_by_id($idslider)->row();

        $data = array(
            'idslider'     => $RsData->idslider,
            'judul'        => $RsData->judul,
            'catatan'      => $RsData->catatan,
            'gambarslider' => $RsData->gambarslider,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/slider/';
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
            $config['upload_path']   = '../uploads/slider/';
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

/* End of file Tabinfo.php */
/* Location: ./application/controllers/Tabinfo.php */