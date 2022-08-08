<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaanlab extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Pemeriksaanlab_model');
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
        $data['menu'] = 'pemeriksaanlab';
        $this->load->view('pemeriksaanlab/listdata', $data);
    }

    public function testlab($idlaboratorium)
    {
        $idlaboratorium = $this->encrypt->decode($idlaboratorium);
        $rsproduksi = $this->Pemeriksaanlab_model->get_id_produksi($idlaboratorium);

        if ($rsproduksi->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pemeriksaanlab');
            exit();
        };
        $data['rowproduksi'] = $rsproduksi->row();
        $data['idlaboratorium'] = $idlaboratorium;
        $data['menu']             = 'pemeriksaanlab';
        $this->load->view('pemeriksaanlab/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pemeriksaanlab_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = $rowdata->idproduksi . '<br>' . $rowdata->tglproduksi;
                $row[] = $rowdata->namaproduk;
                $row[] = $rowdata->beratbruto.'<br>'.$rowdata->beratnetto;
                $row[] = $rowdata->idlaboratorium . '<br>' . $rowdata->tgllaboratorium;
                switch ($rowdata->statuspemeriksaan) {
                    case 'Lulus Test Lab':
                        $row[] = '<span class="badge badge-success">'.$rowdata->statuspemeriksaan.'</span>';
                        break;
                    case 'Gagal Test Lab':
                        $row[] = '<span class="badge badge-danger">'.$rowdata->statuspemeriksaan.'</span>';
                        break;
                    
                    default:
                        $row[] = '<span class="badge badge-warning">'.$rowdata->statuspemeriksaan.'</span>';
                        break;
                }
                $row[] = '<a href="' . site_url('pemeriksaanlab/testlab/' . $this->encrypt->encode($rowdata->idproduksi)) . '" class="btn btn-sm btn-info btn-circle"><i class="fa fa-flask"></i> Test Lab</a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Pemeriksaanlab_model->count_all(),
            "recordsFiltered" => $this->Pemeriksaanlab_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih

        $idlaboratorium = $this->input->post('idlaboratorium');
        $query            = "select * from v_pengadaanprodukdetail
                        WHERE v_pengadaanprodukdetail.idlaboratorium='" . $idlaboratorium . "'";

        $RsData = $this->db->query($query);

        $no   = 0;
        $data = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row    = array();
                $row[]  = $no;
                $row[]  = $rowdata->idlaboratorium;
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

    public function delete($idlaboratorium)
    {
        $idlaboratorium = $this->encrypt->decode($idlaboratorium);

        if ($this->Pemeriksaanlab_model->get_by_id($idlaboratorium)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pemeriksaanlab');
            exit();
        };

        $hapus = $this->Pemeriksaanlab_model->hapus($idlaboratorium);
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
        redirect('pemeriksaanlab');

    }

    public function simpan()
    {
        $idlaboratorium  = $this->input->post('idlaboratorium');
        $tgllaboratorium = $this->input->post('tgllaboratorium');
        $keterangan        = $this->input->post('keterangan');
        $statuspemeriksaan        = $this->input->post('statuspemeriksaan');
        $idproduksi        = $this->input->post('idproduksi');
        $sumberproduk        = $this->input->post('sumberproduk');
        $idpengguna        = $this->session->userdata('idpengguna');
        $tglinsert = date('Y-m-d H:i:s');
        $tglupdate = date('Y-m-d H:i:s');


        if ($idlaboratorium == '') {

            $idlaboratorium = $this->db->query("select create_idlaboratorium('" . date('Y-m-d H:i:s') . "') as idlaboratorium ")->row()->idlaboratorium;

            $foto               = $this->upload_foto($_FILES, "file");     


            $arrayhead = array(
                'idlaboratorium'  => $idlaboratorium,
                'tgllaboratorium' => $tgllaboratorium,
                'keterangan'        => $keterangan,
                'statuspemeriksaan'    => $statuspemeriksaan,
                'filehasillab'    => $foto,
                'idproduksi'    => $idproduksi,
                'sumberproduk'    => $sumberproduk,
                'idpengguna'        => $idpengguna,
                'tglinsert'         => $tglinsert,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Pemeriksaanlab_model->simpan($arrayhead, $idlaboratorium);
        } else {
            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

            $arrayhead = array(
                'tgllaboratorium' => $tgllaboratorium,
                'keterangan'        => $keterangan,
                'statuspemeriksaan'    => $statuspemeriksaan,
                'filehasillab'    => $foto,
                'idproduksi'    => $idproduksi,
                'sumberproduk'    => $sumberproduk,
                'idpengguna'        => $idpengguna,
                'tglupdate'         => $tglupdate,
            );

            $simpan = $this->Pemeriksaanlab_model->update($arrayhead, $idlaboratorium);

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
        redirect('pemeriksaanlab');
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/laboratorium/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|PDF|doc|docx|xls|xlsx';
            $config['remove_space']         = TRUE;
            $config['max_size']             = '2000KB';

            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
             }else{
                 $foto = "";
             }

        }else{
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/laboratorium/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|PDF|doc|docx|xls|xlsx';
            $config['remove_space']         = TRUE;
            $config['max_size']            = '2000KB';
            

            $this->load->library('upload', $config);           
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
            }else{
                $foto = $file_lama;
            }          
        }else{          
            $foto = $file_lama;
        }

        return $foto;
    }


}

/* End of file Pemeriksaanlab.php */
/* Location: ./application/controllers/Pemeriksaanlab.php */