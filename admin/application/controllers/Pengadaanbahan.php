<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaanbahan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Pengadaanbahan_model');
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
        $data['menu'] = 'pengadaanbahan';
        $this->load->view('pengadaanbahan/listdata', $data);
    }

    public function tambah()
    {
        $data['idpengadaanbahan'] = "";
        $data['menu']             = 'pengadaanbahan';
        $this->load->view('pengadaanbahan/form', $data);
    }

    public function edit($idpengadaanbahan)
    {
        $idpengadaanbahan = $this->encrypt->decode($idpengadaanbahan);

        if ($this->Pengadaanbahan_model->get_by_id($idpengadaanbahan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengadaanbahan');
            exit();
        };
        $data['idpengadaanbahan'] = $idpengadaanbahan;
        $data['menu']             = 'pengadaanbahan';
        $this->load->view('pengadaanbahan/form', $data);
    }

    public function cetaknotaremahan($idpengadaanbahan)
    {
        $idpengadaanbahan = $this->encrypt->decode($idpengadaanbahan);

        if ($this->Pengadaanbahan_model->get_by_id($idpengadaanbahan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bahankeluar');
            exit();
        };

        error_reporting(0);
        $this->load->library('Pdf');
        
        $data['idpengadaanbahan'] = $idpengadaanbahan;
        $this->load->view('pengadaanbahan/cetaknotaremahan', $data);
    }

    public function cetaknotapowder($idpengadaanbahan)
    {
        $idpengadaanbahan = $this->encrypt->decode($idpengadaanbahan);

        if ($this->Pengadaanbahan_model->get_by_id($idpengadaanbahan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bahankeluar');
            exit();
        };

        error_reporting(0);
        $this->load->library('Pdf');
        
        $data['idpengadaanbahan'] = $idpengadaanbahan;
        $this->load->view('pengadaanbahan/cetaknotapowder', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pengadaanbahan_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idpengadaanbahan . '<br>' . $rowdata->tglpengadaanbahan;
                $row[] = $rowdata->keterangan;
                $row[] = $rowdata->namasupplier;
                $row[] = format_rupiah($rowdata->totalpengadaan);
                $row[] = $rowdata->namapengguna;
                $row[] = '<a href="' . site_url('pengadaanbahan/cetaknotaremahan/' . $this->encrypt->encode($rowdata->idpengadaanbahan)) . '" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-print">(R)</i></a> | <a href="' . site_url('pengadaanbahan/cetaknotapowder/' . $this->encrypt->encode($rowdata->idpengadaanbahan)) . '" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-print">(P)</i></a> <br> <a href="' . site_url('pengadaanbahan/edit/' . $this->encrypt->encode($rowdata->idpengadaanbahan)) . '" class="btn btn-sm btn-warning btn-circle mt-1"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('pengadaanbahan/delete/' . $this->encrypt->encode($rowdata->idpengadaanbahan)) . '" class="btn btn-sm btn-danger btn-circle mt-1" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Pengadaanbahan_model->count_all(),
            "recordsFiltered" => $this->Pengadaanbahan_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idpengadaanbahan = $this->input->post('idpengadaanbahan');
        $query            = "select * from v_pengadaanbahandetail
                        WHERE v_pengadaanbahandetail.idpengadaanbahan='" . $idpengadaanbahan . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpengadaanbahan;
                $row[]  = $rowdata->idbahan;
                $row[]  = $rowdata->namabahan;
                $row[]  = format_decimal($rowdata->beratbruto,2);
                $row[]  = format_decimal($rowdata->beratnetto,2);
                $row[]  = $rowdata->qty;
                $row[]  = format_decimal($rowdata->hargasatuan,2);
                $row[]  = format_decimal($rowdata->subtotal,2);
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

    public function delete($idpengadaanbahan)
    {
        $idpengadaanbahan = $this->encrypt->decode($idpengadaanbahan);

        if ($this->Pengadaanbahan_model->get_by_id($idpengadaanbahan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengadaanbahan');
            exit();
        };

        $hapus = $this->Pengadaanbahan_model->hapus($idpengadaanbahan);
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
        redirect('pengadaanbahan');

    }

    public function simpan()
    {
        $isidatatable      = $_REQUEST['isidatatable'];
        $idpengadaanbahan  = $this->input->post('idpengadaanbahan');
        $idsupplier  = $this->input->post('idsupplier');
        $tglpengadaanbahan = $this->input->post('tglpengadaanbahan');
        $keterangan        = $this->input->post('keterangan');
        $totalpengadaan    = untitik($this->input->post('totalpengadaan'));
        $idpengguna        = $this->session->userdata('idpengguna');
        $tglinsert = date('Y-m-d H:i:s');
        $tglupdate = date('Y-m-d H:i:s');

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if ($idpengadaanbahan == '') {

            $idpengadaanbahan = $this->db->query("select create_idpengadaanbahan('" . date('Y-m-d') . "') as idpengadaanbahan ")->row()->idpengadaanbahan;

            $arrayhead = array(
                'idpengadaanbahan'  => $idpengadaanbahan,
                'tglpengadaanbahan' => $tglpengadaanbahan,
                'keterangan'        => $keterangan,
                'totalpengadaan'    => $totalpengadaan,
                'idsupplier'        => $idsupplier,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idbahan           = $item[2];
                $beratbruto           = untitik($item[4]);
                $beratnetto           = untitik($item[5]);
                $qty           = $item[6];
                $hargasatuan = untitik($item[7]);
                $subtotal = untitik($item[8]);
                $i++;

                $detail = array(
                    'idpengadaanbahan'  => $idpengadaanbahan,
                    'idbahan'           => $idbahan,
                    'beratbruto'           => $beratbruto,
                    'beratnetto'           => $beratnetto,
                    'hargasatuan' => $hargasatuan,
                    'qty'           => $qty,
                    'subtotal'           => $subtotal,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Pengadaanbahan_model->simpan($arrayhead, $arraydetail, $idpengadaanbahan);
        } else {

            $arrayhead = array(
                'tglpengadaanbahan' => $tglpengadaanbahan,
                'keterangan'        => $keterangan,
                'totalpengadaan'    => $totalpengadaan,
                'idsupplier'        => $idsupplier,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idbahan           = $item[2];
                $beratbruto           = untitik($item[4]);
                $beratnetto           = untitik($item[5]);
                $qty           = $item[6];
                $hargasatuan = untitik($item[7]);
                $subtotal = untitik($item[8]);
                $i++;

                $detail = array(
                    'idpengadaanbahan'  => $idpengadaanbahan,
                    'idbahan'           => $idbahan,
                    'beratbruto'           => $beratbruto,
                    'beratnetto'           => $beratnetto,
                    'hargasatuan' => $hargasatuan,
                    'qty'           => $qty,
                    'subtotal'           => $subtotal,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Pengadaanbahan_model->update($arrayhead, $arraydetail, $idpengadaanbahan);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idpengadaanbahan' => $idpengadaanbahan));
    }

    public function get_edit_data()
    {
        $idpengadaanbahan = $this->input->post('idpengadaanbahan');
        $RsData           = $this->Pengadaanbahan_model->get_by_id($idpengadaanbahan)->row();

        $data = array(
            'idpengadaanbahan'  => $RsData->idpengadaanbahan,
            'tglpengadaanbahan' => $RsData->tglpengadaanbahan,
            'idsupplier' => $RsData->idsupplier,
            'keterangan'        => $RsData->keterangan,
            'totalpengadaan'    => format_rupiah($RsData->totalpengadaan),
            'idpengguna'        => $RsData->idpengguna,
        );
        echo (json_encode($data));
    }

}

/* End of file Pengadaanbahan.php */
/* Location: ./application/controllers/Pengadaanbahan.php */
