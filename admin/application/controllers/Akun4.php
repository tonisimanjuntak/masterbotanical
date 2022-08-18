<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun4 extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Akun4_model');

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
        $data['menu'] = 'akun4';
        $this->load->view('akun4/listdata', $data);
    }   

    public function tambah()
    {       
        $data['kdakun4'] = '';        
        $data['menu'] = 'akun4';  
        $data['ltambah'] = "1";  
        $this->load->view('akun4/form', $data);
    }

    public function edit($kdakun4)
    {       
        $kdakun4 = $this->encrypt->decode($kdakun4);

        if ($this->Akun4_model->get_by_id($kdakun4)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('akun4');
            exit();
        };
        $data['kdakun4'] =$kdakun4;        
        $data['menu'] = 'akun4';
        $data['ltambah'] = "0";  
        $this->load->view('akun4/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Akun4_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->kdakun3;
                $row[] = $rowdata->kdakun4;
                $row[] = $rowdata->namaakun4;
                $row[] = '<a href="'.site_url( 'akun4/edit/'.$this->encrypt->encode($rowdata->kdakun4) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('akun4/delete/'.$this->encrypt->encode($rowdata->kdakun4) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Akun4_model->count_all(),
                        "recordsFiltered" => $this->Akun4_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($kdakun4)
    {
        $kdakun4 = $this->encrypt->decode($kdakun4);  
        $rsdata = $this->Akun4_model->get_by_id($kdakun4);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('akun4');
            exit();
        };

        $hapus = $this->Akun4_model->hapus($kdakun4);
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
        redirect('akun4');        

    }

    public function simpan()
    {       
        $kdakun3             = $this->input->post('kdakun3');
        $kdakun4             = $this->input->post('kdakun4');
        $namaakun4        	= $this->input->post('namaakun4');
        $ltambah        	= $this->input->post('ltambah');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $ltambah == '1' ) {
            $data = array(
                            'kdakun3'   => $kdakun3, 
                            'kdakun4'   => $kdakun4, 
                            'namaakun4'   => $namaakun4, 
                        );
            $simpan = $this->Akun4_model->simpan($data);      
        }else{ 
            $data = array(
                            'namaakun4'   => $namaakun4, 
                        );
            $simpan = $this->Akun4_model->update($data, $kdakun4);
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
        redirect('akun4');   
    }
    
    public function get_edit_data()
    {
        $kdakun4 = $this->input->post('kdakun4');
        $RsData = $this->Akun4_model->get_by_id($kdakun4)->row();

        $data = array( 
                            'kdakun3'     =>  $RsData->kdakun3,  
                            'kdakun4'     =>  $RsData->kdakun4,  
                            'namaakun4'     =>  $RsData->namaakun4,  
                        );

        echo(json_encode($data));
    }

}

/* End of file Akun4.php */
/* Location: ./application/controllers/Akun4.php */