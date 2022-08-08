<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksiproduk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Produksiproduk_model');
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
        $data['menu'] = 'produksiproduk';
        $this->load->view('produksiproduk/listdata', $data);
    }

    public function tambah()
    {
        $data['idproduksi'] = "";
        $data['menu']       = 'produksiproduk';
        $this->load->view('produksiproduk/form', $data);
    }

    public function edit($idproduksi)
    {
        $idproduksi = $this->encrypt->decode($idproduksi);

        if ($this->Produksiproduk_model->get_by_id($idproduksi)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produksiproduk');
            exit();
        };
        $data['idproduksi'] = $idproduksi;
        $data['menu']       = 'produksiproduk';
        $this->load->view('produksiproduk/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Produksiproduk_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idproduksi . '<br>' . $rowdata->tglproduksi;
                $row[] = $rowdata->keterangan;
                $row[] = $rowdata->namaproduk;
                $row[] = $rowdata->beratbruto;
                $row[] = $rowdata->beratnetto;
                $row[] = $rowdata->namapengguna;
                $row[] = '<a href="' . site_url('produksiproduk/edit/' . $this->encrypt->encode($rowdata->idproduksi)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('produksiproduk/delete/' . $this->encrypt->encode($rowdata->idproduksi)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Produksiproduk_model->count_all(),
            "recordsFiltered" => $this->Produksiproduk_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idproduksi = $this->input->post('idproduksi');
        $query      = "select * from v_produksibahan
                        WHERE v_produksibahan.idproduksi='" . $idproduksi . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idproduksi;
                $row[]  = $rowdata->idbahan;
                $row[]  = $rowdata->namabahan;
                $row[]  = format_decimal($rowdata->beratnetto, 2);
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

    public function datatablesourcedetailkaryawan()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idproduksi = $this->input->post('idproduksi');
        $query      = "select * from v_produksikaryawan
                        WHERE v_produksikaryawan.idproduksi='" . $idproduksi . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idproduksi;
                $row[]  = $rowdata->idkaryawan;
                $row[]  = $rowdata->namakaryawan;
                $row[]  = $rowdata->jabatan;
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

    public function delete($idproduksi)
    {
        $idproduksi = $this->encrypt->decode($idproduksi);

        if ($this->Produksiproduk_model->get_by_id($idproduksi)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produksiproduk');
            exit();
        };

        $hapus = $this->Produksiproduk_model->hapus($idproduksi);
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
        redirect('produksiproduk');

    }

    public function simpan()
    {
        $isidatatable         = $_REQUEST['isidatatable'];
        $isidatatablekaryawan = $_REQUEST['isidatatablekaryawan'];
        $idproduksi           = $this->input->post('idproduksi');
        $idproduk             = $this->input->post('idproduk');
        $tglproduksi          = $this->input->post('tglproduksi');
        $caraproduksi         = $this->input->post('caraproduksi');
        $keterangan           = $this->input->post('keterangan');
        $beratbruto           = untitik($this->input->post('beratbruto'));
        $beratnetto           = untitik($this->input->post('beratnetto'));
        $idpengguna           = $this->session->userdata('idpengguna');
        $tglinsert            = date('Y-m-d H:i:s');
        $tglupdate            = date('Y-m-d H:i:s');

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if ($idproduksi == '') {

            $idproduksi = $this->db->query("select create_idproduksi('" . date('Y-m-d') . "') as idproduksi ")->row()->idproduksi;

            $arrayhead = array(
                'idproduksi'   => $idproduksi,
                'tglproduksi'  => $tglproduksi,
                'keterangan'   => $keterangan,
                'idproduk'     => $idproduk,
                'beratbruto'   => $beratbruto,
                'beratnetto'   => $beratnetto,
                'caraproduksi' => $caraproduksi,
                'idpengguna'   => $idpengguna,
                'tglinsert'    => $tglinsert,
                'tglupdate'    => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i          = 0;
            $arraybahan = array();
            foreach ($isidatatable as $item) {
                $idbahan    = $item[2];
                $beratnetto = untitik($item[4]);
                $i++;

                $detail = array(
                    'idproduksi' => $idproduksi,
                    'idbahan'    => $idbahan,
                    'beratnetto' => $beratnetto,
                );

                array_push($arraybahan, $detail);
            }

            //-------------------------------- >> simpan dari datatable karyawan
            $i             = 0;
            $arraykaryawan = array();
            foreach ($isidatatablekaryawan as $item) {
                $idkaryawan = $item[2];
                $jabatan    = $item[4];
                $i++;

                $detail = array(
                    'idproduksi' => $idproduksi,
                    'idkaryawan' => $idkaryawan,
                    'jabatan'    => $jabatan,
                );

                array_push($arraykaryawan, $detail);
            }

            // echo json_encode($arraykaryawan);
            // exit();
            $simpan = $this->Produksiproduk_model->simpan($arrayhead, $arraybahan, $arraykaryawan, $idproduksi);
        } else {

            $arrayhead = array(
                'tglproduksi'  => $tglproduksi,
                'keterangan'   => $keterangan,
                'idproduk'     => $idproduk,
                'beratbruto'   => $beratbruto,
                'beratnetto'   => $beratnetto,
                'caraproduksi' => $caraproduksi,
                'idpengguna'   => $idpengguna,
                'tglupdate'    => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i          = 0;
            $arraybahan = array();
            foreach ($isidatatable as $item) {
                $idbahan    = $item[2];
                $beratnetto = untitik($item[4]);
                $i++;

                $detail = array(
                    'idproduksi' => $idproduksi,
                    'idbahan'    => $idbahan,
                    'beratnetto' => $beratnetto,
                );

                array_push($arraybahan, $detail);
            }

            //-------------------------------- >> simpan dari datatable karyawan
            $i             = 0;
            $arraykaryawan = array();
            foreach ($isidatatablekaryawan as $item) {
                $idkaryawan = $item[2];
                $jabatan    = $item[4];
                $i++;

                $detail = array(
                    'idproduksi' => $idproduksi,
                    'idkaryawan' => $idkaryawan,
                    'jabatan'    => $jabatan,
                );

                array_push($arraykaryawan, $detail);
            }

            $simpan = $this->Produksiproduk_model->update($arrayhead, $arraybahan, $arraykaryawan, $idproduksi);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idproduksi' => $idproduksi));
    }

    public function get_edit_data()
    {
        $idproduksi = $this->input->post('idproduksi');
        $RsData     = $this->Produksiproduk_model->get_by_id($idproduksi)->row();

        $data = array(
            'idproduksi'   => $RsData->idproduksi,
            'tglproduksi'  => $RsData->tglproduksi,
            'keterangan'   => $RsData->keterangan,
            'idproduk'     => $RsData->idproduk,
            'beratnetto'   => $RsData->beratnetto,
            'beratbruto'   => $RsData->beratbruto,
            'caraproduksi' => $RsData->caraproduksi,
        );
        echo (json_encode($data));
    }

}

/* End of file Produksiproduk.php */
/* Location: ./application/controllers/Produksiproduk.php */
