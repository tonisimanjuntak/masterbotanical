<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Supplier_model');
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
        $data['menu'] = 'supplier';
        $this->load->view('supplier/listdata', $data);
    }

    public function tambah()
    {
        $data['idsupplier'] = '';
        $data['menu']       = 'supplier';
        $this->load->view('supplier/form', $data);
    }

    public function edit($idsupplier)
    {
        $idsupplier = $this->encrypt->decode($idsupplier);

        if ($this->Supplier_model->get_by_id($idsupplier)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('supplier');
            exit();
        };
        $data['idsupplier'] = $idsupplier;
        $data['menu']       = 'supplier';
        $this->load->view('supplier/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Supplier_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->namasupplier;
                $row[] = $rowdata->alamatsupplier;
                $row[] = $rowdata->notelp;
                $row[] = $rowdata->email;
                $row[] = $rowdata->statusaktif;
                $row[] = '<a href="' . site_url('supplier/edit/' . $this->encrypt->encode($rowdata->idsupplier)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('supplier/delete/' . $this->encrypt->encode($rowdata->idsupplier)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Supplier_model->count_all(),
            "recordsFiltered" => $this->Supplier_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function delete($idsupplier)
    {
        $idsupplier = $this->encrypt->decode($idsupplier);
        $rsdata     = $this->Supplier_model->get_by_id($idsupplier);
        if ($rsdata->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('supplier');
            exit();
        };

        $hapus = $this->Supplier_model->hapus($idsupplier);
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
        redirect('supplier');

    }

    public function simpan()
    {
        $idsupplier     = $this->input->post('idsupplier');
        $namasupplier   = $this->input->post('namasupplier');
        $alamatsupplier = $this->input->post('alamatsupplier');
        $notelp         = $this->input->post('notelp');
        $email          = $this->input->post('email');
        $statusaktif    = $this->input->post('statusaktif');
        $tglinsert      = date('Y-m-d H:i:s');

        if ($idsupplier == '') {
            $idsupplier = $this->db->query("SELECT create_idsupplier('" . $namasupplier . "') as idsupplier")->row()->idsupplier;

            $data = array(
                'idsupplier'     => $idsupplier,
                'namasupplier'   => $namasupplier,
                'alamatsupplier' => $alamatsupplier,
                'notelp'         => $notelp,
                'email'          => $email,
                'statusaktif'    => $statusaktif,
                'tglinsert'      => $tglinsert,
                'tglupdate'      => $tglinsert,
            );
            $simpan = $this->Supplier_model->simpan($data);
        } else {

            $data = array(
                'namasupplier'   => $namasupplier,
                'alamatsupplier' => $alamatsupplier,
                'notelp'         => $notelp,
                'email'          => $email,
                'statusaktif'    => $statusaktif,
                'tglupdate'      => $tglinsert,
            );
            $simpan = $this->Supplier_model->update($data, $idsupplier);
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
        redirect('supplier');
    }

    public function get_edit_data()
    {
        $idsupplier = $this->input->post('idsupplier');
        $RsData     = $this->Supplier_model->get_by_id($idsupplier)->row();

        $data = array(
            'idsupplier'     => $RsData->idsupplier,
            'namasupplier'   => $RsData->namasupplier,
            'alamatsupplier' => $RsData->alamatsupplier,
            'notelp'         => $RsData->notelp,
            'email'          => $RsData->email,
            'statusaktif'    => $RsData->statusaktif,
        );

        echo (json_encode($data));
    }

}

/* End of file Supplier.php */
/* Location: ./application/controllers/Supplier.php */
