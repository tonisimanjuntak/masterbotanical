<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Bank_model');
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
        $data['menu'] = 'bank';
        $this->load->view('bank/listdata', $data);
    }

    public function tambah()
    {
        $data['idbank'] = '';
        $data['menu']   = 'bank';
        $this->load->view('bank/form', $data);
    }

    public function edit($idbank)
    {
        $idbank = $this->encrypt->decode($idbank);

        if ($this->Bank_model->get_by_id($idbank)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('bank');
            exit();
        };
        $data['idbank'] = $idbank;
        $data['menu']   = 'bank';
        $this->load->view('bank/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Bank_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->logobank)) {
                    $logobank = '<img src="' . base_url('../uploads/bank/' . $rowdata->logobank) . '" alt="" style="width: 80%;">';
                } else {
                    $logobank = '<img src="' . base_url('../images/nofoto.png') . '" alt="" style="width: 80%;">';
                }
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $logobank;
                $row[] = $rowdata->namabank;
                $row[] = $rowdata->negara;
                $row[] = $rowdata->cabang;
                $row[] = $rowdata->norekening;
                $row[] = $rowdata->statusaktif;
                $row[] = '<a href="' . site_url('bank/edit/' . $this->encrypt->encode($rowdata->idbank)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('bank/delete/' . $this->encrypt->encode($rowdata->idbank)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Bank_model->count_all(),
            "recordsFiltered" => $this->Bank_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idbank)
    {
        $idbank = $this->encrypt->decode($idbank);
        $rsdata = $this->Bank_model->get_by_id($idbank);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bank');
            exit();
        };

        $hapus = $this->Bank_model->hapus($idbank);
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
        redirect('bank');

    }

    public function simpan()
    {
        $idbank      = $this->input->post('idbank');
        $namabank    = $this->input->post('namabank');
        $negara      = $this->input->post('negara');
        $cabang      = $this->input->post('cabang');
        $norekening  = $this->input->post('norekening');
        $statusaktif = $this->input->post('statusaktif');
        $tglinsert   = date('Y-m-d H:i:s');

        if (empty($idbank)) {
            $idbank = $this->db->query("SELECT create_idbank('" . $namabank . "') as idbank")->row()->idbank;

            $logobank = $this->upload_logobank($_FILES, "file");

            $data = array(
                'idbank'      => $idbank,
                'namabank'    => $namabank,
                'negara'      => $negara,
                'cabang'      => $cabang,
                'norekening'  => $norekening,
                'statusaktif' => $statusaktif,
                'logobank'    => $logobank,
            );
            $simpan = $this->Bank_model->simpan($data);
        } else {

            $file_lama = $this->input->post('file_lama');
            $logobank  = $this->update_upload_logobank($_FILES, "file", $file_lama);

            $data = array(
                'namabank'    => $namabank,
                'negara'      => $negara,
                'cabang'      => $cabang,
                'norekening'  => $norekening,
                'statusaktif' => $statusaktif,
                'logobank'    => $logobank,
            );
            $simpan = $this->Bank_model->update($data, $idbank);
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
        redirect('bank');
    }

    public function get_edit_data()
    {
        $idbank = $this->input->post('idbank');
        $RsData = $this->Bank_model->get_by_id($idbank)->row();

        $data = array(
            'idbank'      => $RsData->idbank,
            'namabank'    => $RsData->namabank,
            'negara'      => $RsData->negara,
            'cabang'      => $RsData->cabang,
            'norekening'  => $RsData->norekening,
            'logobank'    => $RsData->logobank,
            'statusaktif' => $RsData->statusaktif,
        );

        echo (json_encode($data));
    }

    public function upload_logobank($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/bank/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $logobank = $this->upload->data('file_name');
                $size     = $this->upload->data('file_size');
                $ext      = $this->upload->data('file_ext');
            } else {
                $logobank = "";
            }

        } else {
            $logobank = "";
        }
        return $logobank;
    }

    public function update_upload_logobank($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/bank/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($nama)) {
                $logobank = $this->upload->data('file_name');
                $size     = $this->upload->data('file_size');
                $ext      = $this->upload->data('file_ext');
            } else {
                $logobank = $file_lama;
            }
        } else {
            $logobank = $file_lama;
        }

        return $logobank;
    }

}

/* End of file Bank.php */
/* Location: ./application/controllers/Bank.php */
