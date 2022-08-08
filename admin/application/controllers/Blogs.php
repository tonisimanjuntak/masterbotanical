<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Blogs_model');
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
        $data['menu'] = 'blogs';
        $this->load->view('blogs/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idblogs'] = '';        
        $data['menu'] = 'blogs';  
        $this->load->view('blogs/form', $data);
    }

    public function edit($idblogs)
    {       
        $idblogs = $this->encrypt->decode($idblogs);

        if ($this->Blogs_model->get_by_id($idblogs)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('blogs');
            exit();
        };
        $data['idblogs'] =$idblogs;        
        $data['menu'] = 'blogs';
        $this->load->view('blogs/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Blogs_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<strong>'.$rowdata->judulblogs.'</strong><br>Dibuat Tgl. '.tglindonesia($rowdata->tglinsert).', Diubah Tgl. '.tglindonesia($rowdata->tglupdate);
                $row[] = $rowdata->namapengguna;
                $row[] = $rowdata->ispublish;
                $row[] = '<a href="'.site_url( 'blogs/edit/'.$this->encrypt->encode($rowdata->idblogs) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('blogs/delete/'.$this->encrypt->encode($rowdata->idblogs) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Blogs_model->count_all(),
                        "recordsFiltered" => $this->Blogs_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idblogs)
    {
        $idblogs = $this->encrypt->decode($idblogs);  
        $rsdata = $this->Blogs_model->get_by_id($idblogs);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('blogs');
            exit();
        };

        $hapus = $this->Blogs_model->hapus($idblogs);
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
        redirect('blogs');        

    }

    public function simpan()
    {       
        $idblogs             = $this->input->post('idblogs');
        $judulblogs        = $this->input->post('judulblogs');
        $isiblogs        = $this->input->post('isiblogs');
        $ispublish        = $this->input->post('ispublish');
        $tglinsert          = date('Y-m-d H:i:s');
        $idpengguna        = $this->session->userdata('idpengguna');
        $gambarblogs = '';

        if ( $idblogs=='' ) {  

            $idblogs = $this->db->query("SELECT create_idblogs('".$judulblogs."') as idblogs")->row()->idblogs;

            $foto               = $this->upload_foto($_FILES, "file");     

            $data = array(
                            'idblogs'   => $idblogs, 
                            'judulblogs'   => $judulblogs, 
                            'isiblogs'   => $isiblogs, 
                            'tglinsert'   => $tglinsert, 
                            'tglupdate'   => $tglinsert, 
                            'idpengguna'   => $idpengguna, 
                            'ispublish'   => $ispublish, 
                            'gambarblogs'   => $foto, 
                        );
            $simpan = $this->Blogs_model->simpan($data);      
        }else{

            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama); 

            $data = array(
                            'judulblogs'   => $judulblogs, 
                            'isiblogs'   => $isiblogs, 
                            'tglupdate'   => $tglinsert, 
                            'idpengguna'   => $idpengguna, 
                            'ispublish'   => $ispublish, 
                            'gambarblogs'   => $foto,                      
                        );
            $simpan = $this->Blogs_model->update($data, $idblogs);
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
        redirect('blogs');   
    }
    
    public function get_edit_data()
    {
        $idblogs = $this->input->post('idblogs');
        $RsData = $this->Blogs_model->get_by_id($idblogs)->row();

        $data = array( 
                            'idblogs'     =>  $RsData->idblogs,  
                            'judulblogs'     =>  $RsData->judulblogs,  
                            'isiblogs'     =>  $RsData->isiblogs,  
                            'tglinsert'     =>  $RsData->tglinsert,  
                            'tglupdate'     =>  $RsData->tglupdate,  
                            'idpengguna'     =>  $RsData->idpengguna,  
                            'ispublish'     =>  $RsData->ispublish,  
                            'gambarblogs'     =>  $RsData->gambarblogs,  
                        );

        echo(json_encode($data));
    }


    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/blogs/';
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
            $config['upload_path']          = '../uploads/blogs/';
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

/* End of file Blogs.php */
/* Location: ./application/controllers/Blogs.php */