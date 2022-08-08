<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahankeluar extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Bahankeluar_model');
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
        $data['menu'] = 'bahankeluar';
        $this->load->view('bahankeluar/listdata', $data);
    }

    public function tambah()
    {
        $data['idbahankeluar'] = "";
        $data['menu']             = 'bahankeluar';
        $this->load->view('bahankeluar/form', $data);
    }

    public function edit($idbahankeluar)
    {
        $idbahankeluar = $this->encrypt->decode($idbahankeluar);

        if ($this->Bahankeluar_model->get_by_id($idbahankeluar)->num_rows() < 1) {
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

        if ($this->sudahAdaPenggilingan($idbahankeluar)) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upps!</strong> Data ini sudah dilakukan penggilingan!!, Batalkan penggilingan jika ingin mengubah data ini
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bahankeluar');
            exit();
        }

        $data['idbahankeluar'] = $idbahankeluar;
        $data['menu']             = 'bahankeluar';
        $this->load->view('bahankeluar/form', $data);
    }

    public function cetaknota($idbahankeluar)
    {
        $idbahankeluar = $this->encrypt->decode($idbahankeluar);

        if ($this->Bahankeluar_model->get_by_id($idbahankeluar)->num_rows() < 1) {
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
    	
    	$data['idbahankeluar'] = $idbahankeluar;
        $this->load->view('bahankeluar/cetaknota', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Bahankeluar_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idbahankeluar . '<br>' . $rowdata->tglbahankeluar;
                $row[] = $rowdata->keterangan;
                $row[] = $rowdata->nomorkendaraan;
                $row[] = $rowdata->dikirimoleh;
                $row[] = $rowdata->diperiksaoleh;
                $row[] = $rowdata->diterimaoleh;
                $row[] = '<a href="' . site_url('bahankeluar/cetaknota/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-print"></i></a> | <a href="' . site_url('bahankeluar/edit/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('bahankeluar/delete/' . $this->encrypt->encode($rowdata->idbahankeluar)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Bahankeluar_model->count_all(),
            "recordsFiltered" => $this->Bahankeluar_model->count_filtered(),
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
                $row[]  = $rowdata->idbahankeluar;
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

        if ($this->Bahankeluar_model->get_by_id($idbahankeluar)->num_rows() < 1) {
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

        if ($this->sudahAdaPenggilingan($idbahankeluar)) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upps!</strong> Data ini sudah dilakukan penggilingan!!, Batalkan penggilingan jika ingin menghapus data ini
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bahankeluar');
            exit();
        }

        $hapus = $this->Bahankeluar_model->hapus($idbahankeluar);
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
        redirect('bahankeluar');

    }

    public function simpan()
    {
        $isidatatable      = $_REQUEST['isidatatable'];
        $idbahankeluar  = $this->input->post('idbahankeluar');
        $tglbahankeluar = $this->input->post('tglbahankeluar');
        $tglbahankeluar2 = $this->input->post('tglbahankeluar2');
        $nomorkendaraan  = $this->input->post('nomorkendaraan');
        $keterangan        = $this->input->post('keterangan');
        $dikirimoleh        = $this->input->post('dikirimoleh');
        $diperiksaoleh        = $this->input->post('diperiksaoleh');
        $diterimaoleh        = $this->input->post('diterimaoleh');
        $totalberatbahan    = untitik($this->input->post('totalberatbahan'));
        $idpengguna        = $this->session->userdata('idpengguna');
        $tglinsert = date('Y-m-d H:i:s');
        $tglupdate = date('Y-m-d H:i:s');
        $tanggaldatetime = date('Y-m-d', strtotime($tglbahankeluar)).' '.date('H:i:s', strtotime($tglbahankeluar2));

        //jika session berakhir
        if (empty($idpengguna)) {
            echo json_encode(array('msg' => "Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }

        if ($idbahankeluar == '') {

            $idbahankeluar = $this->db->query("select create_idbahankeluar('" . date('Y-m-d') . "') as idbahankeluar ")->row()->idbahankeluar;


            $arrayhead = array(
                'idbahankeluar'  => $idbahankeluar,
                'tglbahankeluar' => $tanggaldatetime,
                'nomorkendaraan'        => $nomorkendaraan,
                'keterangan'        => $keterangan,
                'dikirimoleh'        => $dikirimoleh,
                'diperiksaoleh'        => $diperiksaoleh,
                'diterimaoleh'        => $diterimaoleh,
                'totalberatbahan'    => $totalberatbahan,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idbahan           = $item[2];
                $beratbahankeluar           = untitik($item[4]);
                $i++;

                $detail = array(
                    'idbahankeluar'  => $idbahankeluar,
                    'idbahan'           => $idbahan,
                    'beratbahankeluar'           => $beratbahankeluar
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Bahankeluar_model->simpan($arrayhead, $arraydetail, $idbahankeluar);
        } else {

            $arrayhead = array(
                'tglbahankeluar' => $tanggaldatetime,
                'nomorkendaraan'        => $nomorkendaraan,
                'keterangan'        => $keterangan,
                'dikirimoleh'        => $dikirimoleh,
                'diperiksaoleh'        => $diperiksaoleh,
                'diterimaoleh'        => $diterimaoleh,
                'totalberatbahan'    => $totalberatbahan,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            //-------------------------------- >> simpan dari datatable
            $i           = 0;
            $arraydetail = array();
            foreach ($isidatatable as $item) {
                $idbahan           = $item[2];
                $beratbahankeluar           = untitik($item[4]);
                $i++;

                $detail = array(
                    'idbahankeluar'  => $idbahankeluar,
                    'idbahan'           => $idbahan,
                    'beratbahankeluar'           => $beratbahankeluar
                );

                array_push($arraydetail, $detail);
            }

            $simpan = $this->Bahankeluar_model->update($arrayhead, $arraydetail, $idbahankeluar);

        }

        if (!$simpan) {
            //jika gagal
            $eror = $this->db->error();
            echo json_encode(array('msg' => 'Kode Eror: ' . $eror['code'] . ' ' . $eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini
        echo json_encode(array('success' => true, 'idbahankeluar' => $idbahankeluar));
    }

    public function get_edit_data()
    {
        $idbahankeluar = $this->input->post('idbahankeluar');
        $RsData           = $this->Bahankeluar_model->get_by_id($idbahankeluar)->row();

        $data = array(
            'idbahankeluar'  => $RsData->idbahankeluar,
            'tglbahankeluar' => date('Y-m-d', strtotime($RsData->tglbahankeluar)),
            'tglbahankeluar2' => date('H:i:s', strtotime($RsData->tglbahankeluar)),
            'nomorkendaraan' => $RsData->nomorkendaraan,
            'keterangan'        => $RsData->keterangan,
            'dikirimoleh'        => $RsData->dikirimoleh,
            'diperiksaoleh'        => $RsData->diperiksaoleh,
            'diterimaoleh'        => $RsData->diterimaoleh,
            'totalberatbahan'    => format_decimal($RsData->totalberatbahan,2),
        );
        echo (json_encode($data));
    }

    function sudahAdaPenggilingan($idbahankeluar)
    {
        $jlhrow = $this->db->query("select count(*) as jlhrow from v_penggilingan_listdata where idbahankeluar='$idbahankeluar' and idpenggilingan is not null and idpenggilingan<>''")->row()->jlhrow;
        if ($jlhrow>0) {
            return true;
        }else{
            return false;
        }
    }

}

/* End of file Bahankeluar.php */
/* Location: ./application/controllers/Bahankeluar.php */