<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun2 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun2_model');

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
        $data['menu'] = 'akun2';
        $this->load->view('akun2/listdata', $data);
    }   

    public function tambah()
    {       
        $data['kdakun2'] = '';        
        $data['menu'] = 'akun2';  
        $data['ltambah'] = "1";  
        $this->load->view('akun2/form', $data);
    }

    public function edit($kdakun2)
    {       
        $kdakun2 = $this->encrypt->decode($kdakun2);

        if ($this->Akun2_model->get_by_id($kdakun2)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('akun2');
            exit();
        };
        $data['kdakun2'] =$kdakun2;        
        $data['menu'] = 'akun2';
        $data['ltambah'] = "0";  
        $this->load->view('akun2/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Akun2_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->kdakun1;
                $row[] = $rowdata->kdakun2;
                $row[] = $rowdata->namaakun2;
                $row[] = '<a href="'.site_url( 'akun2/edit/'.$this->encrypt->encode($rowdata->kdakun2) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('akun2/delete/'.$this->encrypt->encode($rowdata->kdakun2) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Akun2_model->count_all(),
                        "recordsFiltered" => $this->Akun2_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($kdakun2)
    {
        $kdakun2 = $this->encrypt->decode($kdakun2);  
        $rsdata = $this->Akun2_model->get_by_id($kdakun2);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun2');
            exit();
        };

        $hapus = $this->Akun2_model->hapus($kdakun2);
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
        redirect('akun2');        

    }

    public function simpan()
    {       
        $kdakun1             = $this->input->post('kdakun1');
        $kdakun2             = $this->input->post('kdakun2');
        $namaakun2        	= $this->input->post('namaakun2');
        $ltambah        	= $this->input->post('ltambah');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $ltambah == '1' ) {
            $data = array(
                            'kdakun1'   => $kdakun1, 
                            'kdakun2'   => $kdakun2, 
                            'namaakun2'   => $namaakun2, 
                        );
            $simpan = $this->Akun2_model->simpan($data);      
        }else{ 
            $data = array(
                            'namaakun2'   => $namaakun2, 
                        );
            $simpan = $this->Akun2_model->update($data, $kdakun2);
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
        redirect('akun2');   
    }
    
    public function get_edit_data()
    {
        $kdakun2 = $this->input->post('kdakun2');
        $RsData = $this->Akun2_model->get_by_id($kdakun2)->row();

        $data = array( 
                            'kdakun1'     =>  $RsData->kdakun1,  
                            'kdakun2'     =>  $RsData->kdakun2,  
                            'namaakun2'     =>  $RsData->namaakun2,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Akun2.php */
/* Location: ./application/controllers/Akun2.php */