<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produkbahan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Produkbahan_model');
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
        $data['menu'] = 'produkbahan';
        $this->load->view('produkbahan/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idprodukbahan'] = '';        
        $data['menu'] = 'produkbahan';  
        $this->load->view('produkbahan/form', $data);
    }

    public function edit($idprodukbahan)
    {       
        $idprodukbahan = $this->encrypt->decode($idprodukbahan);

        if ($this->Produkbahan_model->get_by_id($idprodukbahan)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', );
            redirect('produkbahan');
            exit();
        };
        $data['idprodukbahan'] =$idprodukbahan;        
        $data['menu'] = 'produkbahan';
        $this->load->view('produkbahan/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Produkbahan_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idproduk;
                $row[] = $rowdata->namaproduk;
                $row[] = $rowdata->namajenis;
                $row[] = '';
                $row[] = '<a href="'.site_url( 'produkbahan/edit/'.$this->encrypt->encode($rowdata->idproduk) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Produkbahan_model->count_all(),
                        "recordsFiltered" => $this->Produkbahan_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function delete($idprodukbahan)
    {
        $idprodukbahan = $this->encrypt->decode($idprodukbahan);  
        $rsdata = $this->Produkbahan_model->get_by_id($idprodukbahan);
        if ($rsdata->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('produkbahan');
            exit();
        };

        $hapus = $this->Produkbahan_model->hapus($idprodukbahan);
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
        redirect('produkbahan');        

    }

    public function simpan()
    {       
        $idprodukbahan             = $this->input->post('idprodukbahan');
        $idproduk        = $this->input->post('idproduk');
        $idbahan        = $this->input->post('idbahan');
        $beratpenggunaan        = $this->input->post('beratpenggunaan');
        $tglinsert          = date('Y-m-d H:i:s');

        if ( $idprodukbahan=='' ) {  
            $data = array(
                            'idproduk'   => $idproduk, 
                            'idbahan'   => $idbahan, 
                            'beratpenggunaan'   => $beratpenggunaan, 
                        );
            $simpan = $this->Produkbahan_model->simpan($data);      
        }else{ 

            $data = array(
                            'idproduk'   => $idproduk, 
                            'idbahan'   => $idbahan, 
                            'beratpenggunaan'   => $beratpenggunaan,                      );
            $simpan = $this->Produkbahan_model->update($data, $idprodukbahan);
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
        redirect('produkbahan');   
    }
    
    public function get_edit_data()
    {
        $idprodukbahan = $this->input->post('idprodukbahan');
        $RsData = $this->Produkbahan_model->get_by_id($idprodukbahan)->row();

        $data = array( 
                            'idprodukbahan'     =>  $RsData->idprodukbahan,  
                            'idproduk'     =>  $RsData->idproduk,  
                            'idbahan'     =>  $RsData->idbahan,  
                            'beratpenggunaan'     =>  $RsData->beratpenggunaan,  
                        );

        echo(json_encode($data));
    }


}

/* End of file Produkbahan.php */
/* Location: ./application/controllers/Produkbahan.php */