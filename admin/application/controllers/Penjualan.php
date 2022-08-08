<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Penjualan_model');
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
        $data['menu'] = 'penjualan';
        $this->load->view('penjualan/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idpenjualan'] = "";     
        $data['menu'] = 'penjualan';  
        $this->load->view('penjualan/form', $data);
    }

    public function edit($idpenjualan)
    {       
        $idpenjualan = $this->encrypt->decode($idpenjualan);
        $rspenjualan = $this->Penjualan_model->get_by_id($idpenjualan);

        if ($rspenjualan->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualan');
            exit();
        };

        if ($rspenjualan->row()->statuskonfirmasi=='Dikonfirmasi') {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upss!</strong> Penjualan ini sudah dikonfirmasi, tidak bisa diubah lagi! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualan');
            exit();
        }

        $data['idpenjualan'] = $idpenjualan;      
        $data['menu'] = 'penjualan';
        $this->load->view('penjualan/form', $data);
    }

    public function cetakinvoice($idpenjualan)
    {
        $idpenjualan = $this->encrypt->decode($idpenjualan);

        if ($this->Penjualan_model->get_by_id($idpenjualan)->num_rows() < 1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualan');
            exit();
        };

        error_reporting(0);
        $this->load->library('Pdf');
        
        $data['idpenjualan'] = $idpenjualan;
        $this->load->view('penjualan/cetakinvoice', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Penjualan_model->get_datatables();
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

                $row[] = '<a href="' . site_url('penjualan/cetakinvoice/' . $this->encrypt->encode($rowdata->idpenjualan)) . '" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-print"></i></a> | <a href="'.site_url( 'penjualan/edit/'.$this->encrypt->encode($rowdata->idpenjualan) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
                        <a href="'.site_url('penjualan/delete/'.$this->encrypt->encode($rowdata->idpenjualan) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Penjualan_model->count_all(),
                        "recordsFiltered" => $this->Penjualan_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih        

        $idpenjualan = $this->input->post('idpenjualan');
        $query = "select * from v_penjualandetail
                        WHERE v_penjualandetail.idpenjualan='".$idpenjualan."'";

        $RsData = $this->db->query($query);

        $no = 0;
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {               
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->idprodukharga;
                $row[] = $rowdata->idproduk;
                $row[] = $rowdata->namaproduk2;
                $row[] = $rowdata->beratproduk;
                $row[] = format_decimal($rowdata->hargaproduk,2);
                $row[] = $rowdata->qty;
                $row[] = format_decimal($rowdata->subtotal,2);
                $row[] = '<span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span>';
                $data[] = $row;
            }
        }

        $output = array(
                        "data" => $data,
                        );

        //output to json format
        echo json_encode($output);
    }

    public function delete($idpenjualan)
    {
        $idpenjualan = $this->encrypt->decode($idpenjualan);  

        $rspenjualan = $this->Penjualan_model->get_by_id($idpenjualan);

        if ($rspenjualan->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualan');
            exit();
        };


        if ($rspenjualan->row()->statuskonfirmasi=='Dikonfirmasi') {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Upss!</strong> Penjualan ini sudah dikonfirmasi, tidak bisa hapus lagi! 
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('penjualan');
            exit();
        }


        $hapus = $this->Penjualan_model->hapus($idpenjualan);
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
        redirect('penjualan');        

    }

    public function simpan()
    {
        $isidatatable       = $_REQUEST['isidatatable'];
        $idpenjualan           = $this->input->post('idpenjualan');
        $tglpenjualan           = $this->input->post('tglpenjualan');
        $idkonsumen           = $this->input->post('idkonsumen');
        $keterangan           = $this->input->post('keterangan');
        $metodepembayaran           = $this->input->post('metodepembayaran');
        $totalpenjualan           = untitik($this->input->post('totalpenjualan'));
        $negara           = $this->input->post('negara');
        $propinsi           = $this->input->post('propinsi');
        $kota           = $this->input->post('kota');
        $desa           = $this->input->post('desa');
        $alamatpengiriman           = $this->input->post('alamatpengiriman');
        $idjasapengiriman           = $this->input->post('idjasapengiriman');

        $tglinsert           = date('Y-m-d H:i:s');

        //jika session berakhir
        if (empty($this->session->userdata('idpengguna'))) { 
            echo json_encode(array('msg'=>"Session telah berakhir, Silahkan refresh halaman!"));
            exit();
        }               


        if ($idpenjualan=='') {
            
            $idpenjualan = $this->db->query("select create_idpenjualan('".date('Y-m-d')."') as idpenjualan ")->row()->idpenjualan;

            $arrayhead = array(
                                'idpenjualan' => $idpenjualan,
                                'tglpenjualan' => $tglpenjualan,
                                'idkonsumen' => $idkonsumen,
                                'keterangan' => $keterangan,
                                'metodepembayaran' => $metodepembayaran,
                                'totalpenjualan' => $totalpenjualan,
                                'negara' => $negara,
                                'propinsi' => $propinsi,
                                'kota' => $kota,
                                'desa' => $desa,
                                'alamatpengiriman' => $alamatpengiriman,
                                'idjasapengiriman' => $idjasapengiriman,
                                'tglinsert' => $tglinsert,
                                'tglupdate' => $tglinsert,
                                );

            //-------------------------------- >> simpan dari datatable 
            $i=0;
            $arraydetail=array();       
            foreach ($isidatatable as $item) {
                        $idprodukharga              = $item[1];
                        $idproduk                   = $item[2];
                        $beratproduk              = untitik($item[4]);
                        $hargaproduk              = untitik($item[5]);
                        $qty                        = untitik($item[6]);
                        $subtotal                        = untitik($item[7]);
                $i++;

                $detail = array(
                                'idpenjualan' => $idpenjualan,
                                'idproduk' => $idproduk,
                                'beratproduk' => $beratproduk,
                                'hargaproduk' => $hargaproduk,
                                'qty' => $qty,
                                'subtotal' => $subtotal,
                                );

                array_push($arraydetail, $detail);              
            }


            $simpan  = $this->Penjualan_model->simpan($arrayhead, $arraydetail, $idpenjualan);
        }else{


            
            $arrayhead = array(
                                'tglpenjualan' => $tglpenjualan,
                                'idkonsumen' => $idkonsumen,
                                'keterangan' => $keterangan,
                                'metodepembayaran' => $metodepembayaran,
                                'totalpenjualan' => $totalpenjualan,
                                'negara' => $negara,
                                'propinsi' => $propinsi,
                                'kota' => $kota,
                                'desa' => $desa,
                                'alamatpengiriman' => $alamatpengiriman,
                                'idjasapengiriman' => $idjasapengiriman,
                                'tglupdate' => $tglinsert,
                                );

            //-------------------------------- >> simpan dari datatable 
            $i=0;
            $arraydetail=array();       
            foreach ($isidatatable as $item) {
                        $idproduk                   = $item[2];
                        $beratproduk              = untitik($item[4]);
                        $hargaproduk              = untitik($item[5]);
                        $qty                        = untitik($item[6]);
                        $subtotal                        = untitik($item[7]);
                $i++;

                $detail = array(
                                'idpenjualan' => $idpenjualan,
                                'idproduk' => $idproduk,
                                'beratproduk' => $beratproduk,
                                'hargaproduk' => $hargaproduk,
                                'qty' => $qty,
                                'subtotal' => $subtotal,
                                );

                array_push($arraydetail, $detail);              
            }

            $simpan  = $this->Penjualan_model->update($arrayhead, $arraydetail, $idpenjualan);

        }


        if (!$simpan) { //jika gagal
            $eror = $this->db->error(); 
            echo json_encode(array('msg'=>'Kode Eror: '.$eror['code'].' '.$eror['message']));
            exit();
        }

        // jika berhasil akan sampai ke tahap ini       
        echo json_encode(array('success' => true, 'idpenjualan' => $idpenjualan));
    }
    
    public function get_edit_data()
    {
        $idpenjualan = $this->input->post('idpenjualan');
        $RsData = $this->Penjualan_model->get_by_id($idpenjualan)->row();

        $data = array(
                    'idpenjualan'     =>  $RsData->idpenjualan,
                    'tglpenjualan'     =>  $RsData->tglpenjualan,
                    'idkonsumen'     =>  $RsData->idkonsumen,
                    'keterangan'     =>  $RsData->keterangan,
                    'metodepembayaran'     =>  $RsData->metodepembayaran,
                    'totalpenjualan'     =>  $RsData->totalpenjualan,
                    'statuskonfirmasi'     =>  $RsData->statuskonfirmasi,
                    'statuspengiriman'     =>  $RsData->statuspengiriman,
                    'idjasapengiriman'     =>  $RsData->idjasapengiriman,
                    'negara'     =>  $RsData->negara,
                    'propinsi'     =>  $RsData->propinsi,
                    'kota'     =>  $RsData->kota,
                    'desa'     =>  $RsData->desa,
                    'alamatpengiriman'     =>  $RsData->alamatpengiriman,
                    );
        echo(json_encode($data));
    }

    public function get_produkharga()
    {
        $idproduk = $this->input->get('idproduk');
        $rsprodukharga = $this->db->query("select * from produkharga where idproduk='$idproduk'");
        $dataprodukharga = array();

        if ($rsprodukharga->num_rows()>0) {
            foreach ($rsprodukharga->result() as $rowpinjaman) {
                array_push($dataprodukharga, array(
                                                'idprodukharga' => $rowpinjaman->idprodukharga, 
                                                'harga' => $rowpinjaman->harga, 
                                                'berat' => number_format($rowpinjaman->berat), 
                                            ));        
            }
        }
        echo json_encode($dataprodukharga);
    }

    public function get_rinciharga()
    {
        $idprodukharga = $this->input->get('idprodukharga');
        $rsprodukharga = $this->db->query("select * from produkharga where idprodukharga='$idprodukharga'")->row();
        echo json_encode($rsprodukharga);
    }


    public function get_alamatpengiriman()
    {
        $idkonsumen = $this->input->get('idkonsumen');
        $rowkonsumen = $this->db->query("select * from konsumen where idkonsumen='$idkonsumen'")->row();
        echo json_encode($rowkonsumen);
    }

}

/* End of file Penjualan.php */
/* Location: ./application/controllers/Penjualan.php */