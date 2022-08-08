<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produkharga extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produkharga_model');
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
        $data['menu'] = 'Produkharga';
        $this->load->view('produkharga/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idprodukharga'] = '';        
        $data['menu'] = 'Produkharga';  
        $this->load->view('produkharga/form', $data);
    }

    public function edit($idprodukharga)
    {       
        $idprodukharga = $this->encrypt->decode($idprodukharga);

        if ($this->Produkharga_model->get_by_id($idprodukharga)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('Produkharga');
            exit();
        };
        $data['idprodukharga'] =$idprodukharga;        
        $data['menu'] = 'Produkharga';
        $this->load->view('produkharga/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Produkharga_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idproduk;
                $row[] = $rowdata->harga;
                $row[] = $rowdata->berat;
                $row[] = '<a href="'.site_url( 'Produkharga/edit/'.$this->encrypt->encode($rowdata->idprodukharga) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('Produkharga/delete/'.$this->encrypt->encode($rowdata->idprodukharga) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Produkharga_model->count_all(),
                        "recordsFiltered" => $this->Produkharga_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idprodukharga)
    {
        $idprodukharga = $this->encrypt->decode($idprodukharga);  
        $rsdata = $this->Produkharga_model->get_by_id($idprodukharga);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Produkharga');
            exit();
        };

        $hapus = $this->Produkharga_model->hapus($idprodukharga);
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
        redirect('Produkharga');        

    }

    public function simpan()
    {       
        $idprodukharga             = $this->input->post('idprodukharga');
        $idproduk        = $this->input->post('idproduk');
        $harga        = $this->input->post('harga');
        $berat        = $this->input->post('berat');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idprodukharga=='' ) {  
            $data = array(
                            'idproduk'   => $idproduk, 
                            'harga'   => $harga, 
                            'berat'   => $berat, 
                        );
            $simpan = $this->Produkharga_model->simpan($data);      
        }else{ 

            $data = array(
                            'idproduk'   => $idproduk, 
                            'harga'   => $harga, 
                            'berat'   => $berat,                      );
            $simpan = $this->Produkharga_model->update($data, $idprodukharga);
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
        redirect('Produkharga');   
    }
    
    public function get_edit_data()
    {
        $idprodukharga = $this->input->post('idprodukharga');
        $RsData = $this->Produkharga_model->get_by_id($idprodukharga)->row();

        $data = array( 
                            'idprodukharga'     =>  $RsData->idprodukharga,  
                            'idproduk'     =>  $RsData->idproduk,  
                            'harga'     =>  $RsData->harga,  
                            'berat'     =>  $RsData->berat,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Produkharga.php */
/* Location: ./application/controllers/Produkharga.php */