<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jasapengiriman extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Jasapengiriman_model');
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
        $data['menu'] = 'jasapengiriman';
        $this->load->view('jasapengiriman/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idjasapengiriman'] = '';        
        $data['menu'] = 'jasapengiriman';  
        $this->load->view('jasapengiriman/form', $data);
    }

    public function edit($idjasapengiriman)
    {       
        $idjasapengiriman = $this->encrypt->decode($idjasapengiriman);

        if ($this->Jasapengiriman_model->get_by_id($idjasapengiriman)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('jasapengiriman');
            exit();
        };
        $data['idjasapengiriman'] =$idjasapengiriman;        
        $data['menu'] = 'jasapengiriman';
        $this->load->view('jasapengiriman/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Jasapengiriman_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {

                if (!empty($rowdata->logojasapengiriman) ) {
                    $logojasapengiriman = '<img src="'.base_url('../uploads/jasapengiriman/'.$rowdata->logojasapengiriman).'" alt="" style="width: 80%;">' ;
                }else{
                    $logojasapengiriman = '<img src="'.base_url('../images/uploadimages.jpg').'" alt="" style="width: 80%;">' ;
                }

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $logojasapengiriman;
                $row[] = $rowdata->namajasapengiriman;
                $row[] = $rowdata->notelpjasapengiriman;
                $row[] = $rowdata->urltrackshipping;
                $row[] = $rowdata->statusaktif;
                $row[] = '<a href="'.site_url( 'jasapengiriman/edit/'.$this->encrypt->encode($rowdata->idjasapengiriman) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('jasapengiriman/delete/'.$this->encrypt->encode($rowdata->idjasapengiriman) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Jasapengiriman_model->count_all(),
                        "recordsFiltered" => $this->Jasapengiriman_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idjasapengiriman)
    {
        $idjasapengiriman = $this->encrypt->decode($idjasapengiriman);  
        $rsdata = $this->Jasapengiriman_model->get_by_id($idjasapengiriman);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('jasapengiriman');
            exit();
        };

        $hapus = $this->Jasapengiriman_model->hapus($idjasapengiriman);
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
        redirect('jasapengiriman');        

    }

    public function simpan()
    {       
        $idjasapengiriman             = $this->input->post('idjasapengiriman');
        $namajasapengiriman        = $this->input->post('namajasapengiriman');
        $notelpjasapengiriman        = $this->input->post('notelpjasapengiriman');
        $urltrackshipping        = $this->input->post('urltrackshipping');
        $logojasapengiriman        = $this->input->post('logojasapengiriman');
        $statusaktif        = $this->input->post('statusaktif');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idjasapengiriman=='' ) {  

            $idjasapengiriman = $this->db->query("SELECT create_idjasapengiriman() as idjasapengiriman")->row()->idjasapengiriman;


            $foto               = $this->upload_foto($_FILES, "file");     


            $data = array(
                            'idjasapengiriman'   => $idjasapengiriman, 
                            'namajasapengiriman'   => $namajasapengiriman, 
                            'notelpjasapengiriman'   => $notelpjasapengiriman, 
                            'urltrackshipping'   => $urltrackshipping, 
                            'logojasapengiriman'   => $foto, 
                            'statusaktif'   => $statusaktif, 
                        );
            $simpan = $this->Jasapengiriman_model->simpan($data);      
        }else{ 

            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                            'namajasapengiriman'   => $namajasapengiriman, 
                            'notelpjasapengiriman'   => $notelpjasapengiriman, 
                            'urltrackshipping'   => $urltrackshipping, 
                            'logojasapengiriman'   => $foto, 
                            'statusaktif'   => $statusaktif,                      );
            $simpan = $this->Jasapengiriman_model->update($data, $idjasapengiriman);
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
        redirect('jasapengiriman');   
    }
    
    public function get_edit_data()
    {
        $idjasapengiriman = $this->input->post('idjasapengiriman');
        $RsData = $this->Jasapengiriman_model->get_by_id($idjasapengiriman)->row();

        $data = array( 
                            'idjasapengiriman'     =>  $RsData->idjasapengiriman,  
                            'namajasapengiriman'     =>  $RsData->namajasapengiriman,  
                            'notelpjasapengiriman'     =>  $RsData->notelpjasapengiriman,  
                            'urltrackshipping'     =>  $RsData->urltrackshipping,  
                            'logojasapengiriman'     =>  $RsData->logojasapengiriman,  
                            'statusaktif'     =>  $RsData->statusaktif,  
                        );

        echo(json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/jasapengiriman/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
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
            $config['upload_path']          = '../uploads/jasapengiriman/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
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

/* End of file Jasapengiriman.php */
/* Location: ./application/controllers/Jasapengiriman.php */