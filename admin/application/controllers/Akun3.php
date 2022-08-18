<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun3 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun3_model');

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
        $data['menu'] = 'akun3';
        $this->load->view('akun3/listdata', $data);
    }   

    public function tambah()
    {       
        $data['kdakun3'] = '';        
        $data['menu'] = 'akun3';  
        $data['ltambah'] = "1";  
        $this->load->view('akun3/form', $data);
    }

    public function edit($kdakun3)
    {       
        $kdakun3 = $this->encrypt->decode($kdakun3);

        if ($this->Akun3_model->get_by_id($kdakun3)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('akun3');
            exit();
        };
        $data['kdakun3'] =$kdakun3;        
        $data['menu'] = 'akun3';
        $data['ltambah'] = "0";  
        $this->load->view('akun3/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Akun3_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->kdakun2;
                $row[] = $rowdata->kdakun3;
                $row[] = $rowdata->namaakun3;
                $row[] = '<a href="'.site_url( 'akun3/edit/'.$this->encrypt->encode($rowdata->kdakun3) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('akun3/delete/'.$this->encrypt->encode($rowdata->kdakun3) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Akun3_model->count_all(),
                        "recordsFiltered" => $this->Akun3_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($kdakun3)
    {
        $kdakun3 = $this->encrypt->decode($kdakun3);  
        $rsdata = $this->Akun3_model->get_by_id($kdakun3);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun3');
            exit();
        };

        $hapus = $this->Akun3_model->hapus($kdakun3);
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
        redirect('akun3');        

    }

    public function simpan()
    {       
        $kdakun2             = $this->input->post('kdakun2');
        $kdakun3             = $this->input->post('kdakun3');
        $namaakun3        	= $this->input->post('namaakun3');
        $ltambah        	= $this->input->post('ltambah');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $ltambah == '1' ) {
            $data = array(
                            'kdakun2'   => $kdakun2, 
                            'kdakun3'   => $kdakun3, 
                            'namaakun3'   => $namaakun3, 
                        );
            $simpan = $this->Akun3_model->simpan($data);      
        }else{ 
            $data = array(
                            'namaakun3'   => $namaakun3, 
                        );
            $simpan = $this->Akun3_model->update($data, $kdakun3);
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
        redirect('akun3');   
    }
    
    public function get_edit_data()
    {
        $kdakun3 = $this->input->post('kdakun3');
        $RsData = $this->Akun3_model->get_by_id($kdakun3)->row();

        $data = array( 
                            'kdakun2'     =>  $RsData->kdakun2,  
                            'kdakun3'     =>  $RsData->kdakun3,  
                            'namaakun3'     =>  $RsData->namaakun3,  
                        );

        echo(json_encode($data));
    }

}

/* End of file Akun3.php */
/* Location: ./application/controllers/Akun3.php */