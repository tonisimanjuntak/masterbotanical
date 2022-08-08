<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaanproduk extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Pengadaanproduk_model');
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
        $data['menu'] = 'pengadaanproduk';
        $this->load->view('pengadaanproduk/listdata', $data);
    }

    public function tambah()
    {
        $data['idpengadaanproduk'] = "";
        $data['menu']             = 'pengadaanproduk';
        $this->load->view('pengadaanproduk/form', $data);
    }

    public function edit($idpengadaanproduk)
    {
        $idpengadaanproduk = $this->encrypt->decode($idpengadaanproduk);

        if ($this->Pengadaanproduk_model->get_by_id($idpengadaanproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengadaanproduk');
            exit();
        };
        $data['idpengadaanproduk'] = $idpengadaanproduk;
        $data['menu']             = 'pengadaanproduk';
        $this->load->view('pengadaanproduk/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pengadaanproduk_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idpengadaanproduk . '<br>' . $rowdata->tglpengadaanproduk;
                $row[] = $rowdata->keterangan;
                $row[] = format_rupiah($rowdata->totalpengadaan);
                $row[] = $rowdata->namapengguna;
                $row[] = '<a href="' . site_url('pengadaanproduk/edit/' . $this->encrypt->encode($rowdata->idpengadaanproduk)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('pengadaanproduk/delete/' . $this->encrypt->encode($rowdata->idpengadaanproduk)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Pengadaanproduk_model->count_all(),
            "recordsFiltered" => $this->Pengadaanproduk_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idpengadaanproduk = $this->input->post('idpengadaanproduk');
        $query            = "select * from v_pengadaanprodukdetail
                        WHERE v_pengadaanprodukdetail.idpengadaanproduk='" . $idpengadaanproduk . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpengadaanproduk;
                $row[]  = $rowdata->idproduk;
                $row[]  = $rowdata->namaproduk;
                $row[]  = format_decimal($rowdata->beratbruto,2);
                $row[]  = format_decimal($rowdata->beratnetto,2);
                $row[]  = format_decimal($rowdata->hargabeli,2);
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

    public function delete($idpengadaanproduk)
    {
        $idpengadaanproduk = $this->encrypt->decode($idpengadaanproduk);

        if ($this->Pengadaanproduk_model->get_by_id($idpengadaanproduk)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengadaanproduk');
            exit();
        };

        $hapus = $this->Pengadaanproduk_model->hapus($idpengadaanproduk);
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
        redirect('pengadaanproduk');

    }

    public function simpan()
    {
        $isidatatable      = $_REQUEST['isidatatable'];
        $idpengadaanproduk  = $this->input->post('idpengadaanproduk');
        $tglpengadaanproduk = $this->input->post('tglpengadaanproduk');
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

        if ($idpengadaanproduk == '') {

            $idpengadaanproduk = $this->db->query("select create_idpengadaanproduk('" . date('Y-m-d') . "') as idpengadaanproduk ")->row()->idpengadaanproduk;

            $arrayhead = array(
                'idpengadaanproduk'  => $idpengadaanproduk,
                'tglpengadaanproduk' => $tglpengadaanproduk,
                'keterangan'        => $keterangan,
                'totalpengadaan'    => $totalpengadaan,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idproduk           = $item[2];
                $beratbruto           = untitik($item[4]);
                $beratnetto           = untitik($item[5]);
                $hargabeli = untitik($item[6]);
                $i++;

                $detail = array(
                    'idpengadaanproduk'  => $idpengadaanproduk,
                    'idproduk'           => $idproduk,
                    'beratbruto'           => $beratbruto,
                    'beratnetto'           => $beratnetto,
                    'hargabeli' => $hargabeli,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Pengadaanproduk_model->simpan($arrayhead, $arraydetail, $idpengadaanproduk);
        } else {

            $arrayhead = array(
                'tglpengadaanproduk' => $tglpengadaanproduk,
                'keterangan'        => $keterangan,
                'totalpengadaan'    => $totalpengadaan,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idproduk           = $item[2];
                $beratbruto           = untitik($item[4]);
                $beratnetto           = untitik($item[5]);
                $hargabeli = untitik($item[6]);
                $i++;

                $detail = array(
                    'idpengadaanproduk'  => $idpengadaanproduk,
                    'idproduk'           => $idproduk,
                    'beratbruto'           => $beratbruto,
                    'beratnetto'           => $beratnetto,
                    'hargabeli' => $hargabeli,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Pengadaanproduk_model->update($arrayhead, $arraydetail, $idpengadaanproduk);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idpengadaanproduk' => $idpengadaanproduk));
    }

    public function get_edit_data()
    {
        $idpengadaanproduk = $this->input->post('idpengadaanproduk');
        $RsData           = $this->Pengadaanproduk_model->get_by_id($idpengadaanproduk)->row();

        $data = array(
            'idpengadaanproduk'  => $RsData->idpengadaanproduk,
            'tglpengadaanproduk' => $RsData->tglpengadaanproduk,
            'keterangan'        => $RsData->keterangan,
            'totalpengadaan'    => format_rupiah($RsData->totalpengadaan),
            'idpengguna'        => $RsData->idpengguna,
        );
        echo (json_encode($data));
    }

}

/* End of file Pengadaanproduk.php */
/* Location: ./application/controllers/Pengadaanproduk.php */