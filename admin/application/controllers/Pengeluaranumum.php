<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaranumum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Pengeluaranumum_model');
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
        $data['menu'] = 'pengeluaranumum';
        $this->load->view('pengeluaranumum/listdata', $data);
    }

    public function tambah()
    {
        $data['idpengeluaranumum'] = "";
        $data['menu']              = 'pengeluaranumum';
        $this->load->view('pengeluaranumum/form', $data);
    }

    public function edit($idpengeluaranumum)
    {
        $idpengeluaranumum = $this->encrypt->decode($idpengeluaranumum);

        if ($this->Pengeluaranumum_model->get_by_id($idpengeluaranumum)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengeluaranumum');
            exit();
        };
        $data['idpengeluaranumum'] = $idpengeluaranumum;
        $data['menu']              = 'pengeluaranumum';
        $this->load->view('pengeluaranumum/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pengeluaranumum_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idpengeluaranumum . '<br>' . $rowdata->tglpengeluaranumum;
                $row[] = $rowdata->keterangan;
                $row[] = format_dollar($rowdata->totalpengeluaranumum);
                $row[] = $rowdata->namapengguna;
                $row[] = '<a href="' . site_url('pengeluaranumum/edit/' . $this->encrypt->encode($rowdata->idpengeluaranumum)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('pengeluaranumum/delete/' . $this->encrypt->encode($rowdata->idpengeluaranumum)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Pengeluaranumum_model->count_all(),
            "recordsFiltered" => $this->Pengeluaranumum_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idpengeluaranumum = $this->input->post('idpengeluaranumum');
        $query             = "select * from v_pengeluaranumumdetail
                        WHERE v_pengeluaranumumdetail.idpengeluaranumum='" . $idpengeluaranumum . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idpengeluaranumum;
                $row[]  = $rowdata->kdakun4;
                $row[]  = $rowdata->namaakun4;
                $row[]  = format_dollar($rowdata->jumlahpengeluaran);
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

    public function delete($idpengeluaranumum)
    {
        $idpengeluaranumum = $this->encrypt->decode($idpengeluaranumum);

        if ($this->Pengeluaranumum_model->get_by_id($idpengeluaranumum)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengeluaranumum');
            exit();
        };

        $hapus = $this->Pengeluaranumum_model->hapus($idpengeluaranumum);
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
        redirect('pengeluaranumum');

    }

    public function simpan()
    {
        $isidatatable         = $_REQUEST['isidatatable'];
        $idpengeluaranumum    = $this->input->post('idpengeluaranumum');
        $tglpengeluaranumum   = $this->input->post('tglpengeluaranumum');
        $keterangan           = $this->input->post('keterangan');
        $totalpengeluaranumum = untitik($this->input->post('totalpengeluaranumum'));
        $idpengguna           = $this->session->userdata('idpengguna');

        

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if ($idpengeluaranumum == '') {

            $idpengeluaranumum = $this->db->query("select create_idpengeluaranumum('" . date('Y-m-d') . "') as idpengeluaranumum ")->row()->idpengeluaranumum;

            $arrayhead = array(
                'idpengeluaranumum'    => $idpengeluaranumum,
                'tglpengeluaranumum'   => $tglpengeluaranumum,
                'keterangan'           => $keterangan,
                'totalpengeluaranumum' => $totalpengeluaranumum,
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
                    'idpengeluaranumum' => $idpengeluaranumum,
                    'kdakun4'           => $kdakun4,
                    'jumlahpengeluaran' => $jumlahpengeluaran,
                );

                array_push($arraydetail, $detail);
            }
            

            $simpan = $this->Pengeluaranumum_model->simpan($arrayhead, $arraydetail, $idpengeluaranumum);
        } else {

            $arrayhead = array(
                'idpengeluaranumum'    => $idpengeluaranumum,
                'tglpengeluaranumum'   => $tglpengeluaranumum,
                'keterangan'           => $keterangan,
                'totalpengeluaranumum' => $totalpengeluaranumum,
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
                    'idpengeluaranumum' => $idpengeluaranumum,
                    'kdakun4'           => $kdakun4,
                    'jumlahpengeluaran' => $jumlahpengeluaran,
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Pengeluaranumum_model->update($arrayhead, $arraydetail, $idpengeluaranumum);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idpengeluaranumum' => $idpengeluaranumum));
    }

    public function get_edit_data()
    {
        $idpengeluaranumum = $this->input->post('idpengeluaranumum');
        $RsData            = $this->Pengeluaranumum_model->get_by_id($idpengeluaranumum)->row();

        $data = array(
            'idpengeluaranumum'    => $RsData->idpengeluaranumum,
            'tglpengeluaranumum'   => $RsData->tglpengeluaranumum,
            'keterangan'           => $RsData->keterangan,
            'totalpengeluaranumum' => format_dollar($RsData->totalpengeluaranumum),
            'idpengguna'           => $RsData->idpengguna,
        );
        echo (json_encode($data));
    }

}

/* End of file Pengeluaranumum.php */
/* Location: ./application/controllers/Pengeluaranumum.php */
