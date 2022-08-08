<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualandetail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penjualandetail_model');
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
        $data['menu'] = 'Penjualandetail';
        $this->load->view('penjualandetail/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idpenjualandetail'] = '';        
        $data['menu'] = 'Penjualandetail';  
        $this->load->view('penjualandetail/form', $data);
    }

    public function edit($idpenjualandetail)
    {       
        $idpenjualandetail = $this->encrypt->decode($idpenjualandetail);

        if ($this->Penjualandetail_model->get_by_id($idpenjualandetail)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('Penjualandetail');
            exit();
        };
        $data['idpenjualandetail'] =$idpenjualandetail;        
        $data['menu'] = 'Penjualandetail';
        $this->load->view('penjualandetail/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penjualandetail_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idpenjualan;
                $row[] = $rowdata->idproduk;
                $row[] = $rowdata->beratproduk;
                $row[] = $rowdata->hargaproduk;
                $row[] = '<a href="'.site_url( 'Penjualandetail/edit/'.$this->encrypt->encode($rowdata->idpenjualandetail) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('Penjualandetail/delete/'.$this->encrypt->encode($rowdata->idpenjualandetail) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Penjualandetail_model->count_all(),
                        "recordsFiltered" => $this->Penjualandetail_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idpenjualandetail)
    {
        $idpenjualandetail = $this->encrypt->decode($idpenjualandetail);  
        $rsdata = $this->Penjualandetail_model->get_by_id($idpenjualandetail);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Penjualandetail');
            exit();
        };

        $hapus = $this->Penjualandetail_model->hapus($idpenjualandetail);
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
        redirect('Penjualandetail');        

    }

    public function simpan()
    {       
        $idpenjualandetail             = $this->input->post('idpenjualandetail');
        $idpenjualan        = $this->input->post('idpenjualan');
        $idproduk        = $this->input->post('idproduk');
        $beratproduk        = $this->input->post('beratproduk');
        $hargaproduk        = $this->input->post('hargaproduk');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idpenjualandetail=='' ) {  
            $data = array(
                            'idpenjualan'   => $idpenjualan, 
                            'idproduk'   => $idproduk, 
                            'beratproduk'   => $beratproduk, 
                            'hargaproduk'   => $hargaproduk, 
                        );
            $simpan = $this->Penjualandetail_model->simpan($data);      
        }else{ 

            $data = array(
                            'idpenjualan'   => $idpenjualan, 
                            'idproduk'   => $idproduk, 
                            'beratproduk'   => $beratproduk, 
                            'hargaproduk'   => $hargaproduk,                      );
            $simpan = $this->Penjualandetail_model->update($data, $idpenjualandetail);
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
        redirect('Penjualandetail');   
    }
    
    public function get_edit_data()
    {
        $idpenjualandetail = $this->input->post('idpenjualandetail');
        $RsData = $this->Penjualandetail_model->get_by_id($idpenjualandetail)->row();

        $data = array( 
                            'idpenjualandetail'     =>  $RsData->idpenjualandetail,  
                            'idpenjualan'     =>  $RsData->idpenjualan,  
                            'idproduk'     =>  $RsData->idproduk,  
                            'beratproduk'     =>  $RsData->beratproduk,  
                            'hargaproduk'     =>  $RsData->hargaproduk,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Penjualandetail.php */
/* Location: ./application/controllers/Penjualandetail.php */