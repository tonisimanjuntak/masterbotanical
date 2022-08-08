<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Slider_model');
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
        $data['menu'] = 'slider';
        $this->load->view('slider/listdata', $data);
    }

    public function tambah()
    {
        $data['idslider'] = '';
        $data['menu']     = 'slider';
        $this->load->view('slider/form', $data);
    }

    public function edit($idslider)
    {
        $idslider = $this->encrypt->decode($idslider);

        if ($this->Slider_model->get_by_id($idslider)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('slider');
            exit();
        };
        $data['idslider'] = $idslider;
        $data['menu']     = 'slider';
        $this->load->view('slider/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Slider_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                if (!empty($rowdata->gambarslider)) {
                    $gambarslider = '<img src="' . base_url("../uploads/slider/" . $rowdata->gambarslider) . '" alt="" style="width: 80%;">';
                } else {
                    $gambarslider = '<img src="' . base_url("../images/nofoto.png") . '" alt="" style="width: 80%;">';
                }

                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $gambarslider;
                $row[] = '<strong>' . $rowdata->judul . '</strong>';
                $row[] = $rowdata->catatan;
                $row[] = '<a href="' . site_url('slider/edit/' . $this->encrypt->encode($rowdata->idslider)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('slider/delete/' . $this->encrypt->encode($rowdata->idslider)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Slider_model->count_all(),
            "recordsFiltered" => $this->Slider_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idslider)
    {
        $idslider = $this->encrypt->decode($idslider);
        $rsdata   = $this->Slider_model->get_by_id($idslider);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('slider');
            exit();
        };

        $hapus = $this->Slider_model->hapus($idslider);
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
        redirect('slider');

    }

    public function simpan()
    {
        $idslider     = $this->input->post('idslider');
        $judul        = $this->input->post('judul');
        $catatan      = $this->input->post('catatan');
        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');
        $gambarslider = '';

        if ($idslider == '') {

            $foto = $this->upload_foto($_FILES, "file");
            $data = array(
                'judul'        => $judul,
                'catatan'      => $catatan,
                'gambarslider' => $foto,
            );
            $simpan = $this->Slider_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                'judul'        => $judul,
                'catatan'      => $catatan,
                'gambarslider' => $foto,
            );

            $simpan = $this->Slider_model->update($data, $idslider);
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
        redirect('slider');
    }

    public function get_edit_data()
    {
        $idslider = $this->input->post('idslider');
        $RsData   = $this->Slider_model->get_by_id($idslider)->row();

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

/* End of file Slider.php */
/* Location: ./application/controllers/Slider.php */
