<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Packing_model');
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
        $data['menu'] = 'packing';
        $this->load->view('packing/listdata', $data);
    }

    public function proses($idlaboratorium)
    {
        $idlaboratorium = $this->encrypt->decode($idlaboratorium);
        $rslaboratorium = $this->Packing_model->get_id_laboratorium($idlaboratorium);

        if ($rslaboratorium->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('packing');
            exit();
        };
        $data['rowlaboratorium'] = $rslaboratorium->row();
        $data['idlaboratorium']  = $idlaboratorium;
        $data['menu']            = 'packing';
        $this->load->view('packing/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Packing_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idlaboratorium . '<br>' . $rowdata->tgllaboratorium;
                $row[]  = $rowdata->namaproduk;
                $row[]  = $rowdata->beratbruto . '<br>' . $rowdata->beratnetto;
                $row[]  = $rowdata->idpacking . '<br>' . $rowdata->tglpacking;
                $row[]  = $rowdata->keterangan;
                $row[]  = '<a href="' . site_url('packing/proses/' . $this->encrypt->encode($rowdata->idlaboratorium)) . '" class="btn btn-sm btn-info btn-circle"><i class="fa fa-archive"></i> Packing</a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Packing_model->count_all(),
            "recordsFiltered" => $this->Packing_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idpacking = $this->input->post('idpacking');
        $query     = "select * from v_pengadaanprodukdetail
                        WHERE v_pengadaanprodukdetail.idpacking='" . $idpacking . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpacking;
                $row[]  = $rowdata->idproduk;
                $row[]  = $rowdata->namaproduk;
                $row[]  = format_decimal($rowdata->beratbruto, 2);
                $row[]  = format_decimal($rowdata->beratnetto, 2);
                $row[]  = format_decimal($rowdata->hargabeli, 2);
                $row[]  = '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>';
                $data[] = $row;
            }
        }

        $output = array(
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function delete($idpacking)
    {
        $idpacking = $this->encrypt->decode($idpacking);

        if ($this->Packing_model->get_by_id($idpacking)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('packing');
            exit();
        };

        $hapus = $this->Packing_model->hapus($idpacking);
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
        redirect('packing');

    }

    public function simpan()
    {
        $idpacking      = $this->input->post('idpacking');
        $tglpacking     = $this->input->post('tglpacking');
        $keterangan     = $this->input->post('keterangan');
        $idlaboratorium = $this->input->post('idlaboratorium');
        $idpengguna     = $this->session->userdata('idpengguna');
        $tglinsert      = date('Y-m-d H:i:s');
        $tglupdate      = date('Y-m-d H:i:s');

        if ($idpacking == '') {

            $idpacking = $this->db->query("select create_idpacking('" . date('Y-m-d H:i:s') . "') as idpacking ")->row()->idpacking;

            $foto = $this->upload_foto($_FILES, "file");

            $arrayhead = array(
                'idpacking'         => $idpacking,
                'tglpacking'        => $tglpacking,
                'keterangan'        => $keterangan,
                'statuspemeriksaan' => $statuspemeriksaan,
                'filehasillab'      => $foto,
                'idlaboratorium'    => $idlaboratorium,
                'sumberproduk'      => $sumberproduk,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Packing_model->simpan($arrayhead, $idpacking);
        } else {
            $file_lama = $this->input->post('file_lama');
            $foto      = $this->update_upload_foto($_FILES, "file", $file_lama);

            $arrayhead = array(
                'tglpacking'        => $tglpacking,
                'keterangan'        => $keterangan,
                'statuspemeriksaan' => $statuspemeriksaan,
                'filehasillab'      => $foto,
                'idlaboratorium'    => $idlaboratorium,
                'sumberproduk'      => $sumberproduk,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Packing_model->update($arrayhead, $idpacking);

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
        redirect('packing');
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/laboratorium/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|PDF|doc|docx|xls|xlsx';
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
            $config['upload_path']   = '../uploads/laboratorium/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|PDF|doc|docx|xls|xlsx';
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

/* End of file Packing.php */
/* Location: ./application/controllers/Packing.php */
