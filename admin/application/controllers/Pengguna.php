<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Pengguna_model');
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
        $data['menu'] = 'pengguna';
        $this->load->view('pengguna/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idpengguna'] = '';        
        $data['menu'] = 'pengguna';  
        $this->load->view('pengguna/form', $data);
    }

    public function edit($idpengguna)
    {       
        $idpengguna = $this->encrypt->decode($idpengguna);

        if ($this->Pengguna_model->get_by_id($idpengguna)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('pengguna');
            exit();
        };
        $data['idpengguna'] =$idpengguna;        
        $data['menu'] = 'pengguna';
        $this->load->view('pengguna/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Pengguna_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->foto) ) {
                    $foto = '<img src="'.base_url('../uploads/pengguna/'.$rowdata->foto).'" alt="" style="width: 80%;">' ;
                }else{
                    $foto = '<img src="'.base_url('../images/users1.png').'" alt="" style="width: 80%;">' ;
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $foto;
                $row[] = $rowdata->namapengguna;
                $row[] = $rowdata->jk;
                $row[] = $rowdata->email;
                $row[] = $rowdata->username;
                $row[] = '<a href="'.site_url( 'pengguna/edit/'.$this->encrypt->encode($rowdata->idpengguna) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('pengguna/delete/'.$this->encrypt->encode($rowdata->idpengguna) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Pengguna_model->count_all(),
                        "recordsFiltered" => $this->Pengguna_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idpengguna)
    {
        $idpengguna = $this->encrypt->decode($idpengguna);  
        $rsdata = $this->Pengguna_model->get_by_id($idpengguna);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengguna');
            exit();
        };

        $hapus = $this->Pengguna_model->hapus($idpengguna);
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
        redirect('pengguna');        

    }

    public function simpan()
    {       
        $idpengguna             = $this->input->post('idpengguna');
        $namapengguna        = $this->input->post('namapengguna');
        $jk        = $this->input->post('jk');
        $email        = $this->input->post('email');
        $username        = $this->input->post('username');
        $password        = $this->input->post('password');
        $password2        = $this->input->post('password2');
        $tglinsert          = date('Y-m-d H:i:s');

        if ($password <> $password2) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Ulangi password tidak sama ! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('pengguna');   
        }

        if ( empty($idpengguna) ) {
            $idpengguna = $this->db->query("SELECT create_idpengguna('".$namapengguna."') as idpengguna")->row()->idpengguna;

            $foto               = $this->upload_foto($_FILES, "file");     

            $data = array(
                            'idpengguna'   => $idpengguna, 
                            'namapengguna'   => $namapengguna, 
                            'jk'   => $jk, 
                            'email'   => $email, 
                            'username'   => $username, 
                            'password'   => md5($password), 
                            'foto'   => $foto, 
                        );
            $simpan = $this->Pengguna_model->simpan($data);      
        }else{ 

            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

            $data = array(
                            'namapengguna'   => $namapengguna, 
                            'jk'   => $jk, 
                            'email'   => $email, 
                            'username'   => $username, 
                            'password'   => md5($password), 
                            'foto'   => $foto,                      );
            $simpan = $this->Pengguna_model->update($data, $idpengguna);
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
        redirect('pengguna');   
    }
    
    public function get_edit_data()
    {
        $idpengguna = $this->input->post('idpengguna');
        $RsData = $this->Pengguna_model->get_by_id($idpengguna)->row();

        $data = array( 
                            'idpengguna'     =>  $RsData->idpengguna,  
                            'namapengguna'     =>  $RsData->namapengguna,  
                            'jk'     =>  $RsData->jk,  
                            'email'     =>  $RsData->email,  
                            'username'     =>  $RsData->username,  
                            'password'     =>  $RsData->password,  
                            'foto'     =>  $RsData->foto,  
                        );

        echo(json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/pengguna/';
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
            $config['upload_path']          = '../uploads/pengguna/';
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

/* End of file Pengguna.php */
/* Location: ./application/controllers/Pengguna.php */