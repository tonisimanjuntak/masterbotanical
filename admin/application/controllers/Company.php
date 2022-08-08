<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Company_model');
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
        $rowcompany = $this->db->query("select * from company limit 1")->row();

        $data['rowcompany'] =$rowcompany;        
        $data['menu'] = 'company';
        $this->load->view('company/form', $data);        
    }   

    public function tambah()
    {       
        $data['namacompany'] = '';        
        $data['menu'] = 'company';  
        $this->load->view('company/form', $data);
    }

    public function edit($namacompany)
    {       
        $namacompany = $this->encrypt->decode($namacompany);

        if ($this->Company_model->get_by_id($namacompany)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('company');
            exit();
        };
        $data['namacompany'] =$namacompany;        
        $data['menu'] = 'company';
        $this->load->view('company/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Company_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->alamatcompany;
                $row[] = $rowdata->notelp;
                $row[] = $rowdata->nofax;
                $row[] = $rowdata->logo;
                $row[] = $rowdata->facebookcompany;
                $row[] = $rowdata->tweetercompany;
                $row[] = $rowdata->instagramcompany;
                $row[] = $rowdata->emailcompany;
                $row[] = '<a href="'.site_url( 'company/edit/'.$this->encrypt->encode($rowdata->namacompany) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('company/delete/'.$this->encrypt->encode($rowdata->namacompany) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Company_model->count_all(),
                        "recordsFiltered" => $this->Company_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($namacompany)
    {
        $namacompany = $this->encrypt->decode($namacompany);  
        $rsdata = $this->Company_model->get_by_id($namacompany);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('company');
            exit();
        };

        $hapus = $this->Company_model->hapus($namacompany);
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
        redirect('company');        

    }

    public function simpan()
    {       
        $namacompany             = $this->input->post('namacompany');
        $alamatcompany        = $this->input->post('alamatcompany');
        $notelp        = $this->input->post('notelp');
        $nofax        = $this->input->post('nofax');
        $facebookcompany        = $this->input->post('facebookcompany');
        $tweetercompany        = $this->input->post('tweetercompany');
        $instagramcompany        = $this->input->post('instagramcompany');
        $emailcompany        = $this->input->post('emailcompany');
        $matauang        = $this->input->post('matauang');
        $tglinsert          = date('Y-m-d H:i:s');

        $file_lama = $this->input->post('file_lama');
        $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

        $data = array(
                        'alamatcompany'   => $alamatcompany, 
                        'notelp'   => $notelp, 
                        'nofax'   => $nofax, 
                        'logo'   => $foto, 
                        'facebookcompany'   => $facebookcompany, 
                        'tweetercompany'   => $tweetercompany, 
                        'instagramcompany'   => $instagramcompany, 
                        'emailcompany'   => $emailcompany, 
                        'matauang'   => $matauang, 
                    );
        $simpan = $this->Company_model->simpan($data);      


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
        redirect('company');   
    }
    
    public function get_edit_data()
    {
        $namacompany = $this->input->post('namacompany');
        $RsData = $this->Company_model->get_by_id($namacompany)->row();

        $data = array( 
                            'namacompany'     =>  $RsData->namacompany,  
                            'alamatcompany'     =>  $RsData->alamatcompany,  
                            'notelp'     =>  $RsData->notelp,  
                            'nofax'     =>  $RsData->nofax,  
                            'logo'     =>  $RsData->logo,  
                            'facebookcompany'     =>  $RsData->facebookcompany,  
                            'tweetercompany'     =>  $RsData->tweetercompany,  
                            'instagramcompany'     =>  $RsData->instagramcompany,  
                            'emailcompany'     =>  $RsData->emailcompany,  
                        );

        echo(json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = '../uploads/company/';
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
            $config['upload_path']          = '../uploads/company/';
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

/* End of file Company.php */
/* Location: ./application/controllers/Company.php */