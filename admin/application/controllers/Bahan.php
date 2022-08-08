<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Bahan_model');
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
        $data['menu'] = 'bahan';
        $this->load->view('bahan/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idbahan'] = '';        
        $data['menu'] = 'bahan';  
        $this->load->view('bahan/form', $data);
    }

    public function edit($idbahan)
    {       
        $idbahan = $this->encrypt->decode($idbahan);

        if ($this->Bahan_model->get_by_id($idbahan)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('bahan');
            exit();
        };
        $data['idbahan'] =$idbahan;        
        $data['menu'] = 'bahan';
        $this->load->view('bahan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Bahan_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idbahan;
                $row[] = $rowdata->namabahan;
                $row[] = '<a href="'.site_url( 'bahan/edit/'.$this->encrypt->encode($rowdata->idbahan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('bahan/delete/'.$this->encrypt->encode($rowdata->idbahan) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Bahan_model->count_all(),
                        "recordsFiltered" => $this->Bahan_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idbahan)
    {
        $idbahan = $this->encrypt->decode($idbahan);  
        $rsdata = $this->Bahan_model->get_by_id($idbahan);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('bahan');
            exit();
        };

        $hapus = $this->Bahan_model->hapus($idbahan);
        if ($hapus) {       
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        }else{
            $eror = $this->db->error();         
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('bahan');        

    }

    public function simpan()
    {       
        $idbahan             = $this->input->post('idbahan');
        $namabahan        = $this->input->post('namabahan');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idbahan=='' ) {  
            $idbahan = $this->db->query("SELECT create_idbahan('".$namabahan."') as idbahan")->row()->idbahan;

            $data = array(
                            'idbahan'   => $idbahan, 
                            'namabahan'   => $namabahan, 
                        );
            $simpan = $this->Bahan_model->simpan($data);      
        }else{ 

            $data = array(
                            'namabahan'   => $namabahan,                      );
            $simpan = $this->Bahan_model->update($data, $idbahan);
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
        redirect('bahan');   
    }
    
    public function get_edit_data()
    {
        $idbahan = $this->input->post('idbahan');
        $RsData = $this->Bahan_model->get_by_id($idbahan)->row();

        $data = array( 
                            'idbahan'     =>  $RsData->idbahan,  
                            'namabahan'     =>  $RsData->namabahan,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Bahan.php */
/* Location: ./application/controllers/Bahan.php */