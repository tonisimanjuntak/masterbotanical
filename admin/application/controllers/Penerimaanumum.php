<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penerimaanumum extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Penerimaanumum_model');
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
        $data['menu'] = 'penerimaanumum';
        $this->load->view('penerimaanumum/listdata', $data);
    }

    public function tambah()
    {
        $data['idpenerimaanumum'] = "";
        $data['menu']              = 'penerimaanumum';
        $this->load->view('penerimaanumum/form', $data);
    }

    public function edit($idpenerimaanumum)
    {
        $idpenerimaanumum = $this->encrypt->decode($idpenerimaanumum);

        if ($this->Penerimaanumum_model->get_by_id($idpenerimaanumum)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penerimaanumum');
            exit();
        };
        $data['idpenerimaanumum'] = $idpenerimaanumum;
        $data['menu']              = 'penerimaanumum';
        $this->load->view('penerimaanumum/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penerimaanumum_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idpenerimaanumum . '<br>' . $rowdata->tglpenerimaanumum;
                $row[] = $rowdata->keterangan;
                $row[] = format_rupiah($rowdata->totalpenerimaanumum);
                $row[] = $rowdata->namapengguna;
                $row[] = '<a href="' . site_url('penerimaanumum/edit/' . $this->encrypt->encode($rowdata->idpenerimaanumum)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('penerimaanumum/delete/' . $this->encrypt->encode($rowdata->idpenerimaanumum)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Penerimaanumum_model->count_all(),
            "recordsFiltered" => $this->Penerimaanumum_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idpenerimaanumum = $this->input->post('idpenerimaanumum');
        $query             = "select * from v_pengeluaranumumdetail
                        WHERE v_pengeluaranumumdetail.idpenerimaanumum='" . $idpenerimaanumum . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpenerimaanumum;
                $row[]  = $rowdata->kdakun4;
                $row[]  = $rowdata->namaakun4;
                $row[]  = $rowdata->jumlahpengeluaran;
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

    public function delete($idpenerimaanumum)
    {
        $idpenerimaanumum = $this->encrypt->decode($idpenerimaanumum);

        if ($this->Penerimaanumum_model->get_by_id($idpenerimaanumum)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penerimaanumum');
            exit();
        };

        $hapus = $this->Penerimaanumum_model->hapus($idpenerimaanumum);
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
        redirect('penerimaanumum');

    }

    public function simpan()
    {
        $isidatatable         = $_REQUEST['isidatatable'];
        $idpenerimaanumum    = $this->input->post('idpenerimaanumum');
        $tglpenerimaanumum   = $this->input->post('tglpenerimaanumum');
        $keterangan           = $this->input->post('keterangan');
        $totalpenerimaanumum = untitik($this->input->post('totalpenerimaanumum'));
        $idpengguna           = $this->session->userdata('idpengguna');

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if ($idpenerimaanumum == '') {

            $idpenerimaanumum = $this->db->query("select create_idpenerimaanumum('" . date('Y-m-d') . "') as idpenerimaanumum ")->row()->idpenerimaanumum;

            $arrayhead = array(
                'idpenerimaanumum'    => $idpenerimaanumum,
                'tglpenerimaanumum'   => $tglpenerimaanumum,
                'keterangan'           => $keterangan,
                'totalpenerimaanumum' => $totalpenerimaanumum,
                'idpengguna'           => $idpengguna,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $kdakun4           = $item[2];
                $jumlahpengeluaran = untitik($item[4]);
                $i++;

                $detail = array(
                    'idpenerimaanumum' => $idpenerimaanumum,
                    'kdakun4'           => $kdakun4,
                    'jumlahpengeluaran' => $jumlahpengeluaran,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Penerimaanumum_model->simpan($arrayhead, $arraydetail, $idpenerimaanumum);
        } else {

            $arrayhead = array(
                'idpenerimaanumum'    => $idpenerimaanumum,
                'tglpenerimaanumum'   => $tglpenerimaanumum,
                'keterangan'           => $keterangan,
                'totalpenerimaanumum' => $totalpenerimaanumum,
                'idpengguna'           => $idpengguna,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $kdakun4           = $item[2];
                $jumlahpengeluaran = untitik($item[4]);
                $i++;

                $detail = array(
                    'idpenerimaanumum' => $idpenerimaanumum,
                    'kdakun4'           => $kdakun4,
                    'jumlahpengeluaran' => $jumlahpengeluaran,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Penerimaanumum_model->update($arrayhead, $arraydetail, $idpenerimaanumum);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idpenerimaanumum' => $idpenerimaanumum));
    }

    public function get_edit_data()
    {
        $idpenerimaanumum = $this->input->post('idpenerimaanumum');
        $RsData            = $this->Penerimaanumum_model->get_by_id($idpenerimaanumum)->row();

        $data = array(
            'idpenerimaanumum'    => $RsData->idpenerimaanumum,
            'tglpenerimaanumum'   => $RsData->tglpenerimaanumum,
            'keterangan'           => $RsData->keterangan,
            'totalpenerimaanumum' => format_rupiah($RsData->totalpenerimaanumum),
            'idpengguna'           => $RsData->idpengguna,
        );
        echo (json_encode($data));
    }

}

/* End of file Penerimaanumum.php */
/* Location: ./application/controllers/Penerimaanumum.php */