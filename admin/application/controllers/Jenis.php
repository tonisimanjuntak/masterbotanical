<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Jenis_model');
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
        $data['menu'] = 'jenis';
        $this->load->view('jenis/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idjenis'] = '';        
        $data['menu'] = 'jenis';  
        $this->load->view('jenis/form', $data);
    }

    public function edit($idjenis)
    {       
        $idjenis = $this->encrypt->decode($idjenis);

        if ($this->Jenis_model->get_by_id($idjenis)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('jenis');
            exit();
        };
        $data['idjenis'] =$idjenis;        
        $data['menu'] = 'jenis';
        $this->load->view('jenis/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Jenis_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->gambarjenis) ) {
                    $foto = '<img src="'.base_url('../uploads/jenis/'.$rowdata->gambarjenis).'" alt="" style="width: 80%;">' ;
                }else{
                    $foto = '<img src="'.base_url('../images/uploadimages.jpg').'" alt="" style="width: 80%;">' ;
                }

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $foto;
                $row[] = $rowdata->namajenis;
                $row[] = $rowdata->deskripsijenis;
                $row[] = $rowdata->statusaktif;
                $row[] = '<a href="'.site_url( 'jenis/edit/'.$this->encrypt->encode($rowdata->idjenis) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('jenis/delete/'.$this->encrypt->encode($rowdata->idjenis) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Jenis_model->count_all(),
                        "recordsFiltered" => $this->Jenis_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idjenis)
    {
        $idjenis = $this->encrypt->decode($idjenis);  
        $rsdata = $this->Jenis_model->get_by_id($idjenis);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('jenis');
            exit();
        };

        $hapus = $this->Jenis_model->hapus($idjenis);
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
        redirect('jenis');        

    }

    public function simpan()
    {       
        $idjenis             = $this->input->post('idjenis');
        $namajenis        = $this->input->post('namajenis');
        $statusaktif        = $this->input->post('statusaktif');
        $gambarjenis        = $this->input->post('gambarjenis');
        $deskripsijenis        = $this->input->post('deskripsijenis');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idjenis=='' ) {

            $idjenis = $this->db->query("SELECT create_idjenis() as idjenis")->row()->idjenis;

            $foto               = $this->upload_foto($_FILES, "file");     


            $data = array(
                            'idjenis'   => $idjenis, 
                            'namajenis'   => $namajenis, 
                            'statusaktif'   => $statusaktif, 
                            'gambarjenis'   => $foto, 
                            'deskripsijenis'   => $deskripsijenis, 
                        );
            $simpan = $this->Jenis_model->simpan($data);      
        }else{ 

            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                            'namajenis'   => $namajenis, 
                            'statusaktif'   => $statusaktif, 
                            'gambarjenis'   => $foto, 
                            'deskripsijenis'   => $deskripsijenis,                      );
            $simpan = $this->Jenis_model->update($data, $idjenis);
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
        redirect('jenis');   
    }
    
    public function get_edit_data()
    {
        $idjenis = $this->input->post('idjenis');
        $RsData = $this->Jenis_model->get_by_id($idjenis)->row();

        $data = array( 
                            'idjenis'     =>  $RsData->idjenis,  
                            'namajenis'     =>  $RsData->namajenis,  
                            'statusaktif'     =>  $RsData->statusaktif,  
                            'gambarjenis'     =>  $RsData->gambarjenis,  
                            'deskripsijenis'     =>  $RsData->deskripsijenis,  
                        );

        echo(json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/jenis/';
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
            $config['upload_path']          = '../uploads/jenis/';
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

/* End of file Jenis.php */
/* Location: ./application/controllers/Jenis.php */