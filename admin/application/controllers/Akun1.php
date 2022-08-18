<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun1 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun1_model');

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
        $data['menu'] = 'akun1';
        $this->load->view('akun1/listdata', $data);
    }   

    public function tambah()
    {       
        $data['kdakun1'] = '';        
        $data['menu'] = 'akun1';  
        $data['ltambah'] = "1";  
        $this->load->view('akun1/form', $data);
    }

    public function edit($kdakun1)
    {       
        $kdakun1 = $this->encrypt->decode($kdakun1);

        if ($this->Akun1_model->get_by_id($kdakun1)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('akun1');
            exit();
        };
        $data['kdakun1'] =$kdakun1;        
        $data['menu'] = 'akun1';
        $data['ltambah'] = "0";  
        $this->load->view('akun1/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Akun1_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->kdakun1;
                $row[] = $rowdata->namaakun1;
                $row[] = '<a href="'.site_url( 'akun1/edit/'.$this->encrypt->encode($rowdata->kdakun1) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('akun1/delete/'.$this->encrypt->encode($rowdata->kdakun1) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Akun1_model->count_all(),
                        "recordsFiltered" => $this->Akun1_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($kdakun1)
    {
        $kdakun1 = $this->encrypt->decode($kdakun1);  
        $rsdata = $this->Akun1_model->get_by_id($kdakun1);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun1');
            exit();
        };

        $hapus = $this->Akun1_model->hapus($kdakun1);
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
        redirect('akun1');        

    }

    public function simpan()
    {       
        $kdakun1             = $this->input->post('kdakun1');
        $namaakun1        = $this->input->post('namaakun1');
        $ltambah        = $this->input->post('ltambah');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $ltambah == '1' ) {
            $data = array(
                            'kdakun1'   => $kdakun1, 
                            'namaakun1'   => $namaakun1, 
                        );
            $simpan = $this->Akun1_model->simpan($data);      
        }else{ 
            $data = array(
                            'namaakun1'   => $namaakun1, 
                        );
            $simpan = $this->Akun1_model->update($data, $kdakun1);
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
        redirect('akun1');   
    }
    
    public function get_edit_data()
    {
        $kdakun1 = $this->input->post('kdakun1');
        $RsData = $this->Akun1_model->get_by_id($kdakun1)->row();

        $data = array( 
                            'kdakun1'     =>  $RsData->kdakun1,  
                            'namaakun1'     =>  $RsData->namaakun1,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Akun1.php */
/* Location: ./application/controllers/Akun1.php */