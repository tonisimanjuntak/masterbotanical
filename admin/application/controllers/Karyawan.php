<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Karyawan_model');
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
        $data['menu'] = 'karyawan';
        $this->load->view('karyawan/listdata', $data);
    }

    public function tambah()
    {
        $data['idkaryawan'] = '';
        $data['menu']       = 'karyawan';
        $this->load->view('karyawan/form', $data);
    }

    public function edit($idkaryawan)
    {
        $idkaryawan = $this->encrypt->decode($idkaryawan);

        if ($this->Karyawan_model->get_by_id($idkaryawan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('karyawan');
            exit();
        };
        $data['idkaryawan'] = $idkaryawan;
        $data['menu']       = 'karyawan';
        $this->load->view('karyawan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Karyawan_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->foto)) {
                    $foto = '<img src="' . base_url('../uploads/karyawan/' . $rowdata->foto) . '" alt="" style="width: 80%;">';
                } else {
                    $foto = '<img src="' . base_url('../images/users1.png') . '" alt="" style="width: 80%;">';
                }
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $foto;
                $row[] = $rowdata->namakaryawan;
                $row[] = $rowdata->jk;
                $row[] = $rowdata->jabatan;
                $row[] = $rowdata->notelp;
                $row[] = $rowdata->email;
                $row[] = '<a href="' . site_url('karyawan/edit/' . $this->encrypt->encode($rowdata->idkaryawan)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('karyawan/delete/' . $this->encrypt->encode($rowdata->idkaryawan)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Karyawan_model->count_all(),
            "recordsFiltered" => $this->Karyawan_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idkaryawan)
    {
        $idkaryawan = $this->encrypt->decode($idkaryawan);
        $rsdata     = $this->Karyawan_model->get_by_id($idkaryawan);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('karyawan');
            exit();
        };

        $hapus = $this->Karyawan_model->hapus($idkaryawan);
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
        redirect('karyawan');

    }

    public function simpan()
    {
        $idkaryawan   = $this->input->post('idkaryawan');
        $namakaryawan = $this->input->post('namakaryawan');
        $jk           = $this->input->post('jk');
        $jabatan      = $this->input->post('jabatan');
        $notelp       = $this->input->post('notelp');
        $email        = $this->input->post('email');
        $tglinsert    = date('Y-m-d H:i:s');

        if ($password != $password2) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Ulangi password tidak sama !
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('karyawan');
        }

        if (empty($idkaryawan)) {
            $idkaryawan = $this->db->query("SELECT create_idkaryawan('" . $namakaryawan . "') as idkaryawan")->row()->idkaryawan;

            $foto = $this->upload_foto($_FILES, "file");

            $data = array(
                'idkaryawan'   => $idkaryawan,
                'namakaryawan' => $namakaryawan,
                'jk'           => $jk,
                'jabatan'      => $jabatan,
                'notelp'       => $notelp,
                'email'        => $email,
                'foto'         => $foto,
            );
            $simpan = $this->Karyawan_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                'namakaryawan' => $namakaryawan,
                'jk'           => $jk,
                'jabatan'      => $jabatan,
                'notelp'       => $notelp,
                'email'        => $email,
                'foto'         => $foto);
            $simpan = $this->Karyawan_model->update($data, $idkaryawan);
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
        redirect('karyawan');
    }

    public function get_edit_data()
    {
        $idkaryawan = $this->input->post('idkaryawan');
        $RsData     = $this->Karyawan_model->get_by_id($idkaryawan)->row();

        $data = array(
            'idkaryawan'   => $RsData->idkaryawan,
            'namakaryawan' => $RsData->namakaryawan,
            'jk'           => $RsData->jk,
            'jabatan'      => $RsData->jabatan,
            'notelp'       => $RsData->notelp,
            'email'        => $RsData->email,
            'foto'         => $RsData->foto,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/karyawan/';
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
            $config['upload_path']   = '../uploads/karyawan/';
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

/* End of file Karyawan.php */
/* Location: ./application/controllers/Karyawan.php */
