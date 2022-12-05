<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Happyclient extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Happyclient_model');
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
        $data['rowSetting'] = $this->db->query("select * from setting")->row();
        $data['menu'] = 'happyclient';
        $this->load->view('happyclient/listdata', $data);
    }

    public function tambah()
    {
        $data['idhappyclient'] = '';
        $data['menu']   = 'happyclient';
        $this->load->view('happyclient/form', $data);
    }

    public function edit($idhappyclient)
    {
        $idhappyclient = $this->encrypt->decode($idhappyclient);

        if ($this->Happyclient_model->get_by_id($idhappyclient)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('happyclient');
            exit();
        };
        $data['idhappyclient'] = $idhappyclient;
        $data['menu']   = 'happyclient';
        $this->load->view('happyclient/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Happyclient_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

                if (!empty($rowdata->fotoclient)) {
                    $fotoclient = '<img src="' . base_url("../uploads/happyclient/" . $rowdata->fotoclient) . '" alt="" style="width: 80%;">';
                } else {
                    $fotoclient = '<img src="' . base_url("../images/nofoto.png") . '" alt="" style="width: 80%;">';
                }

                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $fotoclient;
                $row[] = '<strong>' . $rowdata->namaclient . '</strong>';
                $row[] = $rowdata->pekerjaan;
                $row[] = $rowdata->statement;
                $row[] = '<a href="' . site_url('happyclient/edit/' . $this->encrypt->encode($rowdata->idhappyclient)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('happyclient/delete/' . $this->encrypt->encode($rowdata->idhappyclient)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Happyclient_model->count_all(),
            "recordsFiltered" => $this->Happyclient_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idhappyclient)
    {
        $idhappyclient = $this->encrypt->decode($idhappyclient);
        $rsdata = $this->Happyclient_model->get_by_id($idhappyclient);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('happyclient');
            exit();
        };

        $hapus = $this->Happyclient_model->hapus($idhappyclient);
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
        redirect('happyclient');

    }

    public function simpan()
    {
        $idhappyclient       = $this->input->post('idhappyclient');
        $namaclient    = $this->input->post('namaclient');
        $pekerjaan    = $this->input->post('pekerjaan');
        $statement      = $this->input->post('statement');

        $tglinsert    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');
        $fotoclient = '';

        if ($idhappyclient == '') {

            $idhappyclient       = $this->db->query("SELECT create_idhappyclient('" . $namaclient . "') as idhappyclient")->row()->idhappyclient;
            $foto         = $this->upload_foto($_FILES, "file");


            $data = array(
                'idhappyclient'       => $idhappyclient,
                'namaclient'    => $namaclient,
                'pekerjaan' => $pekerjaan,
                'statement'      => $statement,
                'fotoclient' => $foto,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
            );
            $simpan = $this->Happyclient_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                'namaclient'    => $namaclient,
                'pekerjaan' => $pekerjaan,
                'statement'      => $statement,
                'fotoclient' => $foto,
                'tglupdate'    => $tglinsert,
                'idpengguna'   => $idpengguna,
            );

            $simpan = $this->Happyclient_model->update($data, $idhappyclient);
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
        redirect('happyclient');
    }

    public function simpanbg()
    {

        $bghappyclient = $this->input->post('bghappyclient');
        $bghappyclient_old = $this->input->post('bghappyclient_old');

        $file_lama = $this->input->post('bghappyclient_old');
        $foto      = $this->uploadBgHappyClient($_FILES, "bghappyclient", $file_lama);

        if (!empty($foto)) {
            
            $simpan = $this->Happyclient_model->simpanbg($foto);

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
        }else{
            $pesan = '<div>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <strong>Gagal!</strong> gambar tidak ditemukan! <br>
                            </div>
                        </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('happyclient');
    }

    public function get_edit_data()
    {
        $idhappyclient = $this->input->post('idhappyclient');
        $RsData = $this->Happyclient_model->get_by_id($idhappyclient)->row();

        $data = array(
            'idhappyclient'       => $RsData->idhappyclient,
            'namaclient'    => $RsData->namaclient,
            'pekerjaan' => $RsData->pekerjaan,
            'statement'      => $RsData->statement,
            'fotoclient' => $RsData->fotoclient,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/happyclient/';
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
            $config['upload_path']   = '../uploads/happyclient/';
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

    public function uploadBgHappyClient($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/pengaturan/';
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

/* End of file Happyclient.php */
/* Location: ./application/controllers/Happyclient.php */