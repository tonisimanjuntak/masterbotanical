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
                $row[] = $rowdata->namaproduk;
                $row[] = $rowdata->keterangan;
                $row[] = $rowdata->beratbruto;
                $row[] = $rowdata->beratnetto;
                $row[] = format_rupiah($rowdata->hargabeli);
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
        $idpengadaanproduk  = $this->input->post('idpengadaanproduk');
        $tglpengadaanproduk = $this->input->post('tglpengadaanproduk');
        $keterangan        = $this->input->post('keterangan');
        $idproduk        = $this->input->post('idproduk');
        $beratbruto        = untitik($this->input->post('beratbruto'));
        $beratnetto        = untitik($this->input->post('beratnetto'));
        $hargabeli        = untitik($this->input->post('hargabeli'));
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
                'idproduk'    => $idproduk,
                'beratbruto'    => $beratbruto,
                'beratnetto'    => $beratnetto,
                'hargabeli'    => $hargabeli,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Pengadaanproduk_model->simpan($arrayhead, $idpengadaanproduk);
        } else {

            $arrayhead = array(
                'tglpengadaanproduk' => $tglpengadaanproduk,
                'keterangan'        => $keterangan,
                'idproduk'    => $idproduk,
                'beratbruto'    => $beratbruto,
                'beratnetto'    => $beratnetto,
                'hargabeli'    => $hargabeli,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Pengadaanproduk_model->update($arrayhead, $idpengadaanproduk);

        }

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : '.$eror['code'].' '.$eror['message'].'
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('pengadaanproduk');   
    }

    public function get_edit_data()
    {
        $idpengadaanproduk = $this->input->post('idpengadaanproduk');
        $RsData           = $this->Pengadaanproduk_model->get_by_id($idpengadaanproduk)->row();

        $data = array(
            'idpengadaanproduk'  => $RsData->idpengadaanproduk,
            'tglpengadaanproduk' => $RsData->tglpengadaanproduk,
            'keterangan'        => $RsData->keterangan,
            'idproduk'        => $RsData->idproduk,
            'beratbruto'        => $RsData->beratbruto,
            'beratnetto'        => $RsData->beratnetto,
            'hargabeli'    => format_rupiah($RsData->hargabeli),
            'idpengguna'        => $RsData->idpengguna,
        );
        echo (json_encode($data));
    }

}

/* End of file Pengadaanproduk.php */
/* Location: ./application/controllers/Pengadaanproduk.php */