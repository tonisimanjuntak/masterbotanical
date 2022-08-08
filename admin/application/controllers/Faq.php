<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Faq_model');
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
        $data['menu'] = 'faq';
        $this->load->view('faq/listdata', $data);
    }

    public function tambah()
    {
        $data['idfaq'] = '';
        $data['menu']   = 'faq';
        $this->load->view('faq/form', $data);
    }

    public function edit($idfaq)
    {
        $idfaq = $this->encrypt->decode($idfaq);

        if ($this->Faq_model->get_by_id($idfaq)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('faq');
            exit();
        };
        $data['idfaq'] = $idfaq;
        $data['menu']   = 'faq';
        $this->load->view('faq/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Faq_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = '<strong>' . $rowdata->pertanyaan . '</strong><br><small>'.$rowdata->jawaban.'</small>';
                $row[] = $rowdata->ispublish;
                $row[] = '<a href="' . site_url('faq/edit/' . $this->encrypt->encode($rowdata->idfaq)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('faq/delete/' . $this->encrypt->encode($rowdata->idfaq)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Faq_model->count_all(),
            "recordsFiltered" => $this->Faq_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idfaq)
    {
        $idfaq = $this->encrypt->decode($idfaq);
        $rsdata = $this->Faq_model->get_by_id($idfaq);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('faq');
            exit();
        };

        $hapus = $this->Faq_model->hapus($idfaq);
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
        redirect('faq');

    }

    public function simpan()
    {
        $idfaq       = $this->input->post('idfaq');
        $pertanyaan    = $this->input->post('pertanyaan');
        $jawaban      = $this->input->post('jawaban');
        $ispublish    = $this->input->post('ispublish');
        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');

        if ($idfaq == '') {

            $idfaq       = $this->db->query("SELECT create_idfaq('" . $pertanyaan . "') as idfaq")->row()->idfaq;

            $data = array(
                'idfaq'       => $idfaq,
                'pertanyaan'    => $pertanyaan,
                'jawaban'      => $jawaban,
                'ispublish'    => $ispublish,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
            );
            $simpan = $this->Faq_model->simpan($data);
        } else {

            $data = array(
                'pertanyaan'    => $pertanyaan,
                'jawaban'      => $jawaban,
                'ispublish'    => $ispublish,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
            );

            $simpan = $this->Faq_model->update($data, $idfaq);
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
        redirect('faq');
    }

    public function get_edit_data()
    {
        $idfaq = $this->input->post('idfaq');
        $RsData = $this->Faq_model->get_by_id($idfaq)->row();

        $data = array(
            'idfaq'       => $RsData->idfaq,
            'pertanyaan'    => $RsData->pertanyaan,
            'jawaban'      => $RsData->jawaban,
            'ispublish'    => $RsData->ispublish,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/pages/';
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
            $config['upload_path']   = '../uploads/pages/';
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

/* End of file Faq.php */
/* Location: ./application/controllers/Faq.php */