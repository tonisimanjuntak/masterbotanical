<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsumen extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('KoNsumen_model');
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
        $data['menu'] = 'konsumen';
        $this->load->view('konsumen/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idkonsumen'] = '';        
        $data['menu'] = 'konsumen';  
        $this->load->view('konsumen/form', $data);
    }

    public function edit($idkonsumen)
    {       
        $idkonsumen = $this->encrypt->decode($idkonsumen);

        if ($this->KoNsumen_model->get_by_id($idkonsumen)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('konsumen');
            exit();
        };
        $data['idkonsumen'] =$idkonsumen;        
        $data['menu'] = 'konsumen';
        $this->load->view('konsumen/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->KoNsumen_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                if (!empty($rowdata->foto) ) {
                    $foto = '<img src="'.base_url('../uploads/konsumen/'.$rowdata->foto).'" alt="" style="width: 80%;">' ;
                }else{
                    $foto = '<img src="'.base_url('../images/users1.png').'" alt="" style="width: 80%;">' ;
                }
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $foto;
                $row[] = $rowdata->namakonsumen;
                $row[] = $rowdata->jk;
                $row[] = $rowdata->email;
                $row[] = $rowdata->username;
                $row[] = '<a href="'.site_url( 'konsumen/edit/'.$this->encrypt->encode($rowdata->idkonsumen) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('konsumen/delete/'.$this->encrypt->encode($rowdata->idkonsumen) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->KoNsumen_model->count_all(),
                        "recordsFiltered" => $this->KoNsumen_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idkonsumen)
    {
        $idkonsumen = $this->encrypt->decode($idkonsumen);  
        $rsdata = $this->KoNsumen_model->get_by_id($idkonsumen);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('konsumen');
            exit();
        };

        $hapus = $this->KoNsumen_model->hapus($idkonsumen);
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
        redirect('konsumen');        

    }

    public function simpan()
    {       
        $idkonsumen             = $this->input->post('idkonsumen');
        $namakonsumen        = $this->input->post('namakonsumen');
        $jk        = $this->input->post('jk');
        $email        = $this->input->post('email');
        $negara        = $this->input->post('negara');
        $propinsi        = $this->input->post('propinsi');
        $kota        = $this->input->post('kota');
        $desa        = $this->input->post('desa');
        $alamatpengiriman        = $this->input->post('alamatpengiriman');
        $notelp        = $this->input->post('notelp');
        $nowa        = $this->input->post('nowa');

        $username        = $this->input->post('username');
        $password        = $this->input->post('password');
        $password2        = $this->input->post('password2');
        $tglinsert          = date('Y-m-d H:i:s');


        if ( empty($idkonsumen) ) {

            if ($password <> $password2) {
                $pesan = '<div>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <strong>Gagal!</strong> Ulangi password tidak sama ! 
                            </div>
                        </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('konsumen');   
            }

            if (empty($password) || empty($password2) ) {
                $pesan = '<div>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <strong>Gagal!</strong> Password tidak boleh kosong ! 
                            </div>
                        </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('konsumen');   
            }
            
            $idkonsumen = $this->db->query("SELECT create_idkonsumen('".$namakonsumen."') as idkonsumen")->row()->idkonsumen;

            $foto               = $this->upload_foto($_FILES, "file");     

            $data = array(
                            'idkonsumen'   => $idkonsumen, 
                            'namakonsumen'   => $namakonsumen, 
                            'jk'   => $jk, 
                            'email'   => $email, 
                            'negara'   => $negara, 
                            'propinsi'   => $propinsi, 
                            'kota'   => $kota, 
                            'desa'   => $desa, 
                            'alamatpengiriman'   => $alamatpengiriman, 
                            'notelp'   => $notelp, 
                            'nowa'   => $nowa, 
                            'username'   => $username, 
                            'password'   => md5($password), 
                            'foto'   => $foto, 
                        );
            $simpan = $this->KoNsumen_model->simpan($data);      
        }else{ 

            if ($password <> $password2) {
                $pesan = '<div>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <strong>Gagal!</strong> Ulangi password tidak sama ! 
                            </div>
                        </div>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('konsumen');   
            }

            $file_lama = $this->input->post('file_lama');
            $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

            if (empty($password) || empty($password2) ) {
                
                $data = array(
                                'namakonsumen'   => $namakonsumen, 
                                'jk'   => $jk, 
                                'email'   => $email, 
                                'negara'   => $negara, 
                                'propinsi'   => $propinsi, 
                                'kota'   => $kota, 
                                'desa'   => $desa, 
                                'alamatpengiriman'   => $alamatpengiriman, 
                                'notelp'   => $notelp, 
                                'nowa'   => $nowa, 
                                'username'   => $username, 
                                'foto'   => $foto, 
                            );

            }else{

                $data = array(
                                'namakonsumen'   => $namakonsumen, 
                                'jk'   => $jk, 
                                'email'   => $email, 
                                'negara'   => $negara, 
                                'propinsi'   => $propinsi, 
                                'kota'   => $kota, 
                                'desa'   => $desa, 
                                'alamatpengiriman'   => $alamatpengiriman, 
                                'notelp'   => $notelp, 
                                'nowa'   => $nowa, 
                                'username'   => $username, 
                                'password'   => md5($password), 
                                'foto'   => $foto, 
                            );
                
            }



            $simpan = $this->KoNsumen_model->update($data, $idkonsumen);
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
        redirect('konsumen');   
    }
    
    public function get_edit_data()
    {
        $idkonsumen = $this->input->post('idkonsumen');
        $RsData = $this->KoNsumen_model->get_by_id($idkonsumen)->row();

        $data = array( 
                            'idkonsumen'     =>  $RsData->idkonsumen,  
                            'namakonsumen'     =>  $RsData->namakonsumen,  
                            'jk'     =>  $RsData->jk,  
                            'email'     =>  $RsData->email,  
                            'negara'     =>  $RsData->negara,  
                            'propinsi'     =>  $RsData->propinsi,  
                            'kota'     =>  $RsData->kota,  
                            'desa'     =>  $RsData->desa,  
                            'alamatpengiriman'     =>  $RsData->alamatpengiriman,  
                            'notelp'     =>  $RsData->notelp,  
                            'nowa'     =>  $RsData->nowa,  
                            'username'     =>  $RsData->username,  
                            'password'     =>  $RsData->password,  
                            'foto'     =>  $RsData->foto,  
                        );

        echo(json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/konsumen/';
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
            $config['upload_path']          = '../uploads/konsumen/';
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

/* End of file Konsumen.php */
/* Location: ./application/controllers/Konsumen.php */