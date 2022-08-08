<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggilingan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Penggilingan_model');
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
        $data['menu'] = 'penggilingan';
        $this->load->view('penggilingan/listdata', $data);
    }


    public function terima($idbahankeluar)
    {
        $idbahankeluar = $this->encrypt->decode($idbahankeluar);
        $rsbahankeluar = $this->Penggilingan_model->get_by_id_bahankeluar($idbahankeluar);
        if ($rsbahankeluar->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penggilingan');
            exit();
        };

        $data['idbahankeluar'] = $idbahankeluar;
        $data['rowbahankeluar'] = $rsbahankeluar->row();
        $data['menu']             = 'penggilingan';
        $this->load->view('penggilingan/form', $data);
    }

    public function cetaknota($idpenggilingan)
    {
        $idpenggilingan = $this->encrypt->decode($idpenggilingan);

        if ($this->Penggilingan_model->get_by_id($idpenggilingan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penggilingan');
            exit();
        };

        error_reporting(0);
        $this->load->library('Pdf');
        
        $data['idpenggilingan'] = $idpenggilingan;
        $this->load->view('penggilingan/cetaknota', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penggilingan_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idbahankeluar . '<br>' . $rowdata->tglbahankeluar.'<br><small>Keterangan: '.$rowdata->keterangan_keluar.'</small>';
                $row[] = format_decimal($rowdata->totalberatbahan,2);
                if (!empty($rowdata->idpenggilingan)) {
                    $row[] = $rowdata->idpenggilingan . '<br>' . $rowdata->tglpenggilingan.'<br><small>Keterangan: '.$rowdata->keterangan.'</small>';
                }else{
                    $row[] = '';
                }
                $row[] = $rowdata->pemilikremahan;
                $row[] = $rowdata->namapenggiling;
                if (!empty($rowdata->idpenggilingan)) {
                    $row[] = '<a href="' . site_url('penggilingan/cetaknota/' . $this->encrypt->encode($rowdata->idpenggilingan)) . '" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-print"></i></a> | <a href="' . site_url('penggilingan/terima/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                            <a href="' . site_url('penggilingan/delete/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                }else{
                    $row[] = '<span class="btn btn-sm btn-default btn-circle"><i class="fa fa-print"></i></span> | <a href="' . site_url('penggilingan/terima/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                            <span class="btn btn-sm btn-default btn-circle"><i class="fa fa-trash"></i></span>';                    

                }
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Penggilingan_model->count_all(),
            "recordsFiltered" => $this->Penggilingan_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idbahankeluar = $this->input->post('idbahankeluar');
        $query            = "select * from v_bahankeluardetail
                        WHERE v_bahankeluardetail.idbahankeluar='" . $idbahankeluar . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpenggilingan;
                $row[]  = $rowdata->idbahan;
                $row[]  = $rowdata->namabahan;
                $row[]  = format_decimal($rowdata->beratbahankeluar,2);
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

    public function delete($idbahankeluar)
    {
        $idbahankeluar = $this->encrypt->decode($idbahankeluar);

        $rsbahankeluar = $this->Penggilingan_model->get_by_id_bahankeluar($idbahankeluar);
        if ($rsbahankeluar->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penggilingan');
            exit();
        };

        if (!empty($rsbahankeluar->row()->idpenggilingan)) {
            
                $hapus = $this->Penggilingan_model->hapus($idbahankeluar, $rsbahankeluar->row()->idpenggilingan);
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
            redirect('penggilingan');
        }else{
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> nomor penggilingan tidak ditemukan! <br>
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penggilingan');
        }


    }

    public function simpan()
    {
        $idbahankeluar  = $this->input->post('idbahankeluar');
        $idpenggilingan  = $this->input->post('idpenggilingan');
        $tglpenggilingan = $this->input->post('tglpenggilingan');
        $namapenggiling  = $this->input->post('namapenggiling');
        $alamatgudang        = $this->input->post('alamatgudang');
        $pemilikremahan        = $this->input->post('pemilikremahan');
        $keterangan        = $this->input->post('keterangan');
        $diserahkanoleh        = $this->input->post('diserahkanoleh');
        $diterimaoleh        = $this->input->post('diterimaoleh');
        $disetujuioleh        = $this->input->post('disetujuioleh');
        $totalberatbahan    = untitik($this->input->post('totalberatbahan'));
        $idpengguna        = $this->session->userdata('idpengguna');
        $tglinsert = date('Y-m-d H:i:s');
        $tglupdate = date('Y-m-d H:i:s');


        //jika session berakhir
        if (empty($idpengguna)) {
            redirect('penggilingan');
            exit();
        }

        if ($idpenggilingan == '') {

            $idpenggilingan = $this->db->query("select create_idpenggilingan('" . date('Y-m-d') . "') as idpenggilingan ")->row()->idpenggilingan;


            $arrayhead = array(
                'idpenggilingan'  => $idpenggilingan,
                'tglpenggilingan' => $tglpenggilingan,
                'namapenggiling'        => $namapenggiling,
                'alamatgudang'        => $alamatgudang,
                'keterangan'        => $keterangan,
                'pemilikremahan'        => $pemilikremahan,
                'idbahankeluar'        => $idbahankeluar,
                'diserahkanoleh'        => $diserahkanoleh,
                'diterimaoleh'        => $diterimaoleh,
                'disetujuioleh'        => $disetujuioleh,
                'diserahkanoleh'        => $diserahkanoleh,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            

            $simpan = $this->Penggilingan_model->simpan($arrayhead, $idpenggilingan, $idbahankeluar);
        } else {

            $arrayhead = array(
                'tglpenggilingan' => $tglpenggilingan,
                'namapenggiling'        => $namapenggiling,
                'alamatgudang'        => $alamatgudang,
                'keterangan'        => $keterangan,
                'pemilikremahan'        => $pemilikremahan,
                'idbahankeluar'        => $idbahankeluar,
                'diserahkanoleh'        => $diserahkanoleh,
                'diterimaoleh'        => $diterimaoleh,
                'disetujuioleh'        => $disetujuioleh,
                'diserahkanoleh'        => $diserahkanoleh,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );


            $simpan = $this->Penggilingan_model->update($arrayhead, $idpenggilingan, $idbahankeluar);

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
        redirect('penggilingan');
    }

    public function get_edit_data()
    {
        $idbahankeluar = $this->input->post('idbahankeluar');
        $RsData           = $this->Penggilingan_model->get_by_id_bahankeluar($idbahankeluar)->row();

        $data = array(
            'idbahankeluar'  => $RsData->idbahankeluar,
            'idpenggilingan'  => $RsData->idpenggilingan,
            'tglpenggilingan' => ( !empty($RsData->tglpenggilingan) ) ? date('Y-m-d', strtotime($RsData->tglpenggilingan)) : date('Y-m-d'),
            'namapenggiling' => $RsData->namapenggiling,
            'alamatgudang'        => $RsData->alamatgudang,
            'keterangan'        => $RsData->keterangan,
            'pemilikremahan'        => $RsData->pemilikremahan,
            'diserahkanoleh'        => $RsData->diserahkanoleh,
            'diterimaoleh'        => $RsData->diterimaoleh,
            'disetujuioleh'        => $RsData->disetujuioleh,
            'totalberatbahan'    => format_decimal($RsData->totalberatbahan,2),
        );
        echo (json_encode($data));
    }

}

/* End of file Penggilingan.php */
/* Location: ./application/controllers/Penggilingan.php */