<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualanpengiriman extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Penjualanpengiriman_model');
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
        $data['menu'] = 'penjualanpengiriman';
        $this->load->view('penjualanpengiriman/listdata', $data);
    }   

    public function kirim($idpenjualan)
    {       
        $idpenjualan = $this->encrypt->decode($idpenjualan);
        $rspenjualan = $this->Penjualanpengiriman_model->get_by_id($idpenjualan);

        if ($rspenjualan->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualanpengiriman');
            exit();
        };

        $rspengiriman = $this->db->query("select * from penjualanpengiriman where idpenjualan='$idpenjualan' limit 1");
        if ($rspengiriman->num_rows()>0) {
            $tglpengiriman = date('Y-m-d', strtotime($rspengiriman->row()->tglpenjualanpengiriman));
            $idjasapengiriman = $rspengiriman->row()->idjasapengiriman;
            $estimasiharipengiriman = $rspengiriman->row()->estimasiharipengiriman;
            $keteranganpenjualanpengiriman = $rspengiriman->row()->keteranganpenjualanpengiriman;
            $noresipengiriman = $rspengiriman->row()->noresipengiriman;
        }else{
            $tglpengiriman = date('Y-m-d');
            $idjasapengiriman = '';
            $estimasiharipengiriman = '3';
            $keteranganpenjualanpengiriman = '';
            $noresipengiriman = '';
        }

        $data['idpenjualan'] = $idpenjualan;      
        $data['rowpenjualan'] = $rspenjualan->row();      
        $data['tglpengiriman'] = $tglpengiriman;      
        $data['idjasapengiriman'] = $idjasapengiriman;      
        $data['estimasiharipengiriman'] = $estimasiharipengiriman;      
        $data['keteranganpenjualanpengiriman'] = $keteranganpenjualanpengiriman;      
        $data['noresipengiriman'] = $noresipengiriman;      
        $data['statuspengiriman'] = $rspenjualan->row()->statuspengiriman;      
        $data['menu'] = 'penjualanpengiriman';
        $this->load->view('penjualanpengiriman/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penjualanpengiriman_model->get_datatables();
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

                $row[] = '<a href="'.site_url( 'penjualanpengiriman/kirim/'.$this->encrypt->encode($rowdata->idpenjualan) ).'" class="btn btn-sm btn-primary btn-circle"><i class="fa fa-paper-plane"></i> Pengiriman</a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Penjualanpengiriman_model->count_all(),
                        "recordsFiltered" => $this->Penjualanpengiriman_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }



    public function simpan()
    {
        $idpenjualan           = $this->input->post('idpenjualan');
        $statuspengiriman           = $this->input->post('statuspengiriman');
        $tglpengiriman           = $this->input->post('tglpengiriman');
        $noresipengiriman           = $this->input->post('noresipengiriman');
        $idjasapengiriman           = $this->input->post('idjasapengiriman');
        $estimasiharipengiriman           = $this->input->post('estimasiharipengiriman');
        $keteranganpenjualanpengiriman           = $this->input->post('keteranganpenjualanpengiriman');
        $idpengguna = $this->session->userdata('idpengguna');
        $tglinsert           = date('Y-m-d H:i:s');

        //jika session berakhir
        if (empty($this->session->userdata('idpengguna'))) { 
            echo json_encode(array('msg'=>"Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }               

        $idpenjualanpengiriman = $this->db->query("select create_idpenjualanpengiriman('".date('Y-m-d')."') as idpenjualanpengiriman ")->row()->idpenjualanpengiriman;
        $simpan  = $this->Penjualanpengiriman_model->simpan($idpenjualanpengiriman, $idpenjualan, $statuspengiriman, $tglpengiriman, $idjasapengiriman, $estimasiharipengiriman, $keteranganpenjualanpengiriman, $idpengguna, $tglinsert, $noresipengiriman);

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
        redirect('penjualanpengiriman');   
    }

}

/* End of file Penjualanpengiriman.php */
/* Location: ./application/controllers/Penjualanpengiriman.php */