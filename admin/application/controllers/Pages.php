<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pages_model');
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
        $data['menu'] = 'pages';
        $this->load->view('pages/listdata', $data);
    }

    public function tambah()
    {
        $data['idpage'] = '';
        $data['menu']   = 'pages';
        $this->load->view('pages/form', $data);
    }

    public function edit($idpage)
    {
        $idpage = $this->encrypt->decode($idpage);

        if ($this->Pages_model->get_by_id($idpage)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('pages');
            exit();
        };
        $data['idpage'] = $idpage;
        $data['menu']   = 'pages';
        $this->load->view('pages/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pages_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                if (!empty($rowdata->gambarsampul)) {
                    $gambarsampul = '<img src="' . base_url("../uploads/pages/" . $rowdata->gambarsampul) . '" alt="" style="width: 80%;">';
                } else {
                    $gambarsampul = '<img src="' . base_url("../images/nofoto.png") . '" alt="" style="width: 80%;">';
                }

                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $gambarsampul;
                $row[] = '<strong>' . $rowdata->judulpage . '</strong><br>Dibuat Tgl. ' . tglindonesia($rowdata->tglinsert) . ', Diubah Tgl. ' . tglindonesia($rowdata->tglupdate);
                $row[] = $rowdata->namapengguna;
                $row[] = $rowdata->ispublish;
                $row[] = '<a href="' . site_url('pages/edit/' . $this->encrypt->encode($rowdata->idpage)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('pages/delete/' . $this->encrypt->encode($rowdata->idpage)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Pages_model->count_all(),
            "recordsFiltered" => $this->Pages_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idpage)
    {
        $idpage = $this->encrypt->decode($idpage);
        $rsdata = $this->Pages_model->get_by_id($idpage);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pages');
            exit();
        };

        $hapus = $this->Pages_model->hapus($idpage);
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
        redirect('pages');

    }

    public function simpan()
    {
        $idpage       = $this->input->post('idpage');
        $judulpage    = $this->input->post('judulpage');
        $isipage      = $this->input->post('isipage');
        $ispublish    = $this->input->post('ispublish');
        $tglpublish   = $this->input->post('tglpublish');
        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');
        $gambarsampul = '';

        if ($idpage == '') {

            $idpage       = $this->db->query("SELECT create_idpage('" . $judulpage . "') as idpage")->row()->idpage;
            $foto         = $this->upload_foto($_FILES, "file");
            $judulpageseo = $this->db->query("SELECT create_judulpageseo('" . textToHtml($judulpage) . "') as judulpageseo")->row()->judulpageseo;

            if ($ispublish == 'Ya') {
                $tglpublish = date('Y-m-d H:i:s');
            } else {
                $tglpublish = null;
            }

            $data = array(
                'idpage'       => $idpage,
                'judulpage'    => $judulpage,
                'judulpageseo' => $judulpageseo,
                'isipage'      => $isipage,
                'gambarsampul' => $foto,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
                'tglpublish'   => $tglpublish,
                'ispublish'    => $ispublish,
            );
            $simpan = $this->Pages_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            if (empty($tglpublish) && $ispublish == 'Ya') {
                $tglpublish = date('Y-m-d H:i:s');

                $data = array(
                    'judulpage'    => $judulpage,
                    'isipage'      => $isipage,
                    'gambarsampul' => $foto,
                    'tglupdate'    => $tglinsert,
                    'idpengguna'   => $idpengguna,
                    'tglpublish'   => $tglpublish,
                    'ispublish'    => $ispublish,
                );

            } else {
                $data = array(
                    'judulpage'    => $judulpage,
                    'isipage'      => $isipage,
                    'gambarsampul' => $foto,
                    'tglupdate'    => $tglinsert,
                    'idpengguna'   => $idpengguna,
                    'ispublish'    => $ispublish,
                );
            }

            $simpan = $this->Pages_model->update($data, $idpage);
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
        redirect('pages');
    }

    public function get_edit_data()
    {
        $idpage = $this->input->post('idpage');
        $RsData = $this->Pages_model->get_by_id($idpage)->row();

        $data = array(
            'idpage'       => $RsData->idpage,
            'judulpage'    => $RsData->judulpage,
            'judulpageseo' => $RsData->judulpageseo,
            'isipage'      => $RsData->isipage,
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

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */
