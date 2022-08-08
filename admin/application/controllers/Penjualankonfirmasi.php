<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualankonfirmasi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Penjualankonfirmasi_model');
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
        $data['menu'] = 'penjualankonfirmasi';
        $this->load->view('penjualankonfirmasi/listdata', $data);
    }   


    public function lihat($idpenjualan)
    {       
        $idpenjualan = $this->encrypt->decode($idpenjualan);
        $rspenjualan = $this->Penjualankonfirmasi_model->get_by_id($idpenjualan);

        if ($rspenjualan->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualankonfirmasi');
            exit();
        };

        $data['idpenjualan'] = $idpenjualan;      
        $data['rowpenjualan'] = $rspenjualan->row();      
        $data['menu'] = 'penjualankonfirmasi';
        $this->load->view('penjualankonfirmasi/lihat', $data);
    }

    public function konfirmasi($idpenjualan)
    {       
        $idpenjualan = $this->encrypt->decode($idpenjualan);
        $rspenjualan = $this->Penjualankonfirmasi_model->get_by_id($idpenjualan);

        if ($rspenjualan->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualankonfirmasi');
            exit();
        };

        if ($rspenjualan->row()->statuspengiriman=='Sudah Dikirim') {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upss!</strong> Penjualan ini sudah dilakukan pengiriman, tidak bisa diubah lagi! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualankonfirmasi');
            exit();
        }

        $data['idpenjualan'] = $idpenjualan;      
        $data['rowpenjualan'] = $rspenjualan->row();      
        $data['menu'] = 'penjualankonfirmasi';
        $this->load->view('penjualankonfirmasi/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penjualankonfirmasi_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idpenjualan.'<br>'.tglindonesia($rowdata->tglpenjualan);
                $row[] = $rowdata->namakonsumen;
                $row[] = $rowdata->keterangan;
                $row[] = format_rupiah($rowdata->totalpenjualan);
                switch ($rowdata->statuskonfirmasi) {
                    case 'Dikonfirmasi':
                        $statuskonfirmasi = '<span class="badge badge-success">'.$rowdata->statuskonfirmasi.'</span>';
                        break;
                    case 'Ditolak':
                        $statuskonfirmasi = '<span class="badge badge-danger">'.$rowdata->statuskonfirmasi.'</span>';
                        break;
                    
                    default:
                        $statuskonfirmasi = $rowdata->statuskonfirmasi;
                        break;
                }
                $row[] = $statuskonfirmasi;

                switch ($rowdata->statuspengiriman) {
                    case 'Sudah Dikirim':
                        $statuspengiriman = '<span class="badge badge-success">'.$rowdata->statuspengiriman.'</span>';
                        break;
                    default:
                        $statuspengiriman = $rowdata->statuspengiriman;
                        break;
                }
                $row[] = $statuspengiriman;

                $row[] = '<a href="'.site_url( 'penjualankonfirmasi/lihat/'.$this->encrypt->encode($rowdata->idpenjualan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-search"></i></a> | <a href="'.site_url( 'penjualankonfirmasi/konfirmasi/'.$this->encrypt->encode($rowdata->idpenjualan) ).'" class="btn btn-sm btn-primary btn-circle"><i class="fa fa-check"></i> Konfirmasi</a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Penjualankonfirmasi_model->count_all(),
                        "recordsFiltered" => $this->Penjualankonfirmasi_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }



    public function simpan()
    {
        $idpenjualan           = $this->input->post('idpenjualan');
        $statuskonfirmasi           = $this->input->post('statuskonfirmasi');
        $idpengguna = $this->session->userdata('idpengguna');
        $tglinsert           = date('Y-m-d H:i:s');

        //jika session berakhir
        if (empty($this->session->userdata('idpengguna'))) { 
            echo json_encode(array('msg'=>"Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }               

        $idpenjualankonfirmasi = $this->db->query("select create_idpenjualankonfirmasi('".date('Y-m-d')."') as idpenjualankonfirmasi ")->row()->idpenjualankonfirmasi;
        $simpan  = $this->Penjualankonfirmasi_model->simpan($idpenjualankonfirmasi, $idpenjualan, $statuskonfirmasi);

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
        redirect('penjualankonfirmasi');   
    }
    


}

/* End of file Penjualankonfirmasi.php */
/* Location: ./application/controllers/Penjualankonfirmasi.php */