<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produkimage extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produkimage_model');
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
        $data['menu'] = 'Produkimage';
        $this->load->view('produkimage/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idprodukimage'] = '';        
        $data['menu'] = 'Produkimage';  
        $this->load->view('produkimage/form', $data);
    }

    public function edit($idprodukimage)
    {       
        $idprodukimage = $this->encrypt->decode($idprodukimage);

        if ($this->Produkimage_model->get_by_id($idprodukimage)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('Produkimage');
            exit();
        };
        $data['idprodukimage'] =$idprodukimage;        
        $data['menu'] = 'Produkimage';
        $this->load->view('produkimage/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Produkimage_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idproduk;
                $row[] = $rowdata->gambarproduk;
                $row[] = $rowdata->deskripsiprodukimage;
                $row[] = '<a href="'.site_url( 'Produkimage/edit/'.$this->encrypt->encode($rowdata->idprodukimage) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('Produkimage/delete/'.$this->encrypt->encode($rowdata->idprodukimage) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Produkimage_model->count_all(),
                        "recordsFiltered" => $this->Produkimage_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idprodukimage)
    {
        $idprodukimage = $this->encrypt->decode($idprodukimage);  
        $rsdata = $this->Produkimage_model->get_by_id($idprodukimage);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Produkimage');
            exit();
        };

        $hapus = $this->Produkimage_model->hapus($idprodukimage);
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
        redirect('Produkimage');        

    }

    public function simpan()
    {       
        $idprodukimage             = $this->input->post('idprodukimage');
        $idproduk        = $this->input->post('idproduk');
        $gambarproduk        = $this->input->post('gambarproduk');
        $deskripsiprodukimage        = $this->input->post('deskripsiprodukimage');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idprodukimage=='' ) {  
            $data = array(
                            'idproduk'   => $idproduk, 
                            'gambarproduk'   => $gambarproduk, 
                            'deskripsiprodukimage'   => $deskripsiprodukimage, 
                        );
            $simpan = $this->Produkimage_model->simpan($data);      
        }else{ 

            $data = array(
                            'idproduk'   => $idproduk, 
                            'gambarproduk'   => $gambarproduk, 
                            'deskripsiprodukimage'   => $deskripsiprodukimage,                      );
            $simpan = $this->Produkimage_model->update($data, $idprodukimage);
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
        redirect('Produkimage');   
    }
    
    public function get_edit_data()
    {
        $idprodukimage = $this->input->post('idprodukimage');
        $RsData = $this->Produkimage_model->get_by_id($idprodukimage)->row();

        $data = array( 
                            'idprodukimage'     =>  $RsData->idprodukimage,  
                            'idproduk'     =>  $RsData->idproduk,  
                            'gambarproduk'     =>  $RsData->gambarproduk,  
                            'deskripsiprodukimage'     =>  $RsData->deskripsiprodukimage,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Produkimage.php */
/* Location: ./application/controllers/Produkimage.php */