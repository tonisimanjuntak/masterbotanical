<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consultation extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Consultation_model');
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
        $data['menu'] = 'consultation';
        $this->load->view('consultation/listdata', $data);
    }

    public function reply($idconsultation)
    {
        $idconsultation = $this->encrypt->decode($idconsultation);
        $rsconsultation = $this->Consultation_model->get_by_id($idconsultation);

        if ($rsconsultation->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('consultation');
            exit();
        };
        $data['rowconsultation'] = $rsconsultation->row();
        $data['idconsultation'] = $idconsultation;
        $data['menu']   = 'consultation';
        $this->load->view('consultation/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Consultation_model->get_datatables();
        $no     = $_POST['start'];
        $data   = array();

        if ($RsData->num_rows() > 0) {
            foreach ($RsData->result() as $rowdata) {

            	if (empty($rowdata->consulreply)) {
            		$statuspesan = '<span class="badge badge-danger">Belum Dibalas</span>';
            	}else{
            		$statuspesan = '<span class="badge badge-success">Sudah Dibalas</span>';
            	}
                $no++;
                $row   = array();
                $row[] = $no;
                $row[] = tglindonesia($rowdata->tglinsert);
                $row[] = $rowdata->consulname;
                $row[] = $rowdata->consulemail;
                $row[] = $rowdata->consulmessage;
                $row[] = $statuspesan;
                $row[] = '<a href="' . site_url('consultation/reply/' . $this->encrypt->encode($rowdata->idconsultation)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-reply"></i> Replay</a>';
                $data[] = $row;
            }
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->Consultation_model->count_all(),
            "recordsFiltered" => $this->Consultation_model->count_filtered(),
            "data"            => $data,
        );
        echo json_encode($output);
    }


    public function simpan()
    {
        $idconsultation       = $this->input->post('idconsultation');
        $consulreply    = $this->input->post('consulreply');
        $tglreply    = date('Y-m-d H:i:s');
        $idpengguna   = $this->session->userdata('idpengguna');

        $data = array(
            'consulreply'    => $consulreply,
            'tglreply'      => $tglreply,
            'idpengguna'   => $idpengguna,
        );
        $simpan = $this->Consultation_model->update($data, $idconsultation);
        
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
        redirect('consultation');
    }

    public function get_edit_data()
    {
        $idconsultation = $this->input->post('idconsultation');
        $RsData = $this->Consultation_model->get_by_id($idconsultation)->row();

        $data = array(
            'idconsultation'       => $RsData->idconsultation,
            'judulnews'    => $RsData->judulnews,
            'judulnewsseo' => $RsData->judulnewsseo,
            'isinews'      => $RsData->isinews,
            'gambarsampul' => $RsData->gambarsampul,
            'ispublish'    => $RsData->ispublish,
            'tglinsert'    => $RsData->tglinsert,
            'tglupdate'    => $RsData->tglupdate,
            'tglpublish'   => $RsData->tglpublish,
            'idpengguna'   => $RsData->idpengguna,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/news/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = "";
            }

        } else {
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/news/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = $file_lama;
            }
        } else {
            $foto = $file_lama;
        }

        return $foto;
    }

}

/* End of file Consultation.php */
/* Location: ./application/controllers/Consultation.php */