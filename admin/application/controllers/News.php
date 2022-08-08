<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('News_model');
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
        $data['menu'] = 'news';
        $this->load->view('news/listdata', $data);
    }

    public function tambah()
    {
        $data['idnews'] = '';
        $data['menu']   = 'news';
        $this->load->view('news/form', $data);
    }

    public function edit($idnews)
    {
        $idnews = $this->encrypt->decode($idnews);

        if ($this->News_model->get_by_id($idnews)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('news');
            exit();
        };
        $data['idnews'] = $idnews;
        $data['menu']   = 'news';
        $this->load->view('news/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->News_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                if (!empty($rowdata->gambarsampul)) {
                    $gambarsampul = '<img src="' . base_url("../uploads/news/" . $rowdata->gambarsampul) . '" alt="" style="width: 80%;">';
                } else {
                    $gambarsampul = '<img src="' . base_url("../images/nofoto.png") . '" alt="" style="width: 80%;">';
                }

                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $gambarsampul;
                $row[] = '<strong>' . $rowdata->judulnews . '</strong><br>Dibuat Tgl. ' . tglindonesia($rowdata->tglinsert) . ', Diubah Tgl. ' . tglindonesia($rowdata->tglupdate);
                $row[] = $rowdata->namapengguna;
                $row[] = $rowdata->ispublish;
                $row[] = '<a href="' . site_url('news/edit/' . $this->encrypt->encode($rowdata->idnews)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('news/delete/' . $this->encrypt->encode($rowdata->idnews)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->News_model->count_all(),
            "recordsFiltered" => $this->News_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idnews)
    {
        $idnews = $this->encrypt->decode($idnews);
        $rsdata = $this->News_model->get_by_id($idnews);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('news');
            exit();
        };

        $hapus = $this->News_model->hapus($idnews);
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
        redirect('news');

    }

    public function simpan()
    {
        $idnews       = $this->input->post('idnews');
        $judulnews    = $this->input->post('judulnews');
        $isinews      = $this->input->post('isinews');
        $ispublish    = $this->input->post('ispublish');
        $tglpublish   = $this->input->post('tglpublish');
        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');
        $gambarsampul = '';

        if ($idnews == '') {

            $idnews       = $this->db->query("SELECT create_idnews('" . $judulnews . "') as idnews")->row()->idnews;
            $foto         = $this->upload_foto($_FILES, "file");
            $judulnewsseo = $this->db->query("SELECT create_judulnewsseo('" . textToHtml($judulnews) . "') as judulnewsseo")->row()->judulnewsseo;

            if ($ispublish == 'Ya') {
                $tglpublish = date('Y-m-d H:i:s');
            } else {
                $tglpublish = null;
            }

            $data = array(
                'idnews'       => $idnews,
                'judulnews'    => $judulnews,
                'judulnewsseo' => $judulnewsseo,
                'isinews'      => $isinews,
                'gambarsampul' => $foto,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
                'tglpublish'   => $tglpublish,
                'ispublish'    => $ispublish,
            );
            $simpan = $this->News_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            if (empty($tglpublish) && $ispublish == 'Ya') {
                $tglpublish = date('Y-m-d H:i:s');

                $data = array(
                    'judulnews'    => $judulnews,
                    'isinews'      => $isinews,
                    'gambarsampul' => $foto,
                    'tglupdate'    => $tglinsert,
                    'idpengguna'   => $idpengguna,
                    'tglpublish'   => $tglpublish,
                    'ispublish'    => $ispublish,
                );

            } else {
                $data = array(
                    'judulnews'    => $judulnews,
                    'isinews'      => $isinews,
                    'gambarsampul' => $foto,
                    'tglupdate'    => $tglinsert,
                    'idpengguna'   => $idpengguna,
                    'ispublish'    => $ispublish,
                );
            }

            $simpan = $this->News_model->update($data, $idnews);
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
        redirect('news');
    }

    public function get_edit_data()
    {
        $idnews = $this->input->post('idnews');
        $RsData = $this->News_model->get_by_id($idnews)->row();

        $data = array(
            'idnews'       => $RsData->idnews,
            'judulnews'    => $RsData->judulnews,
            'judulnewsseo' => $RsData->judulnewsseo,
            'isinews'      => $RsData->isinews,
            'gambarsampul' => $RsData->gambarsampul,
            'ispublish'    => $RsData->ispublish,
            'tglinsert'    => $RsData->tglinsert,
            'tglupdate'    => $RsData->tglupdate,
            'tglpublish'   => $RsData->tglpublish,
            'idpengguna'   => $RsData->idpengguna,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/news/';
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
            $config['upload_path']   = '../uploads/news/';
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

/* End of file News.php */
/* Location: ./application/controllers/News.php */