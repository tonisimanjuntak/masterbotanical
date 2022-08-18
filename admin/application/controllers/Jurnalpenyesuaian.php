<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnalpenyesuaian extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Jurnalpenyesuaian_model');
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
        $data['menu'] = 'jurnalpenyesuaian';
        $this->load->view('jurnalpenyesuaian/listdata', $data);
    }   

    public function tambah()
    {       
        $data['idjurnal'] = "";     
        $data['menu'] = 'jurnalpenyesuaian';  
        $this->load->view('jurnalpenyesuaian/form', $data);
    }

    public function edit($idjurnal)
    {       
        $idjurnal = $this->encrypt->decode($idjurnal);

        if ($this->Jurnalpenyesuaian_model->get_by_id($idjurnal)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('jurnalpenyesuaian');
            exit();
        };
        $data['idjurnal'] = $idjurnal;      
        $data['menu'] = 'jurnalpenyesuaian';
        $this->load->view('jurnalpenyesuaian/form', $data);
    }

    public function datatablesource()
    {
        $RsData = $this->Jurnalpenyesuaian_model->get_datatables();
        $no = $_POST['start'];
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = tglindonesia($rowdata->tgljurnal).'<br>'.$rowdata->idjurnal;
                $row[] = $rowdata->deskripsi;
                $row[] = 'Rp. '.format_rupiah($rowdata->jumlah);
                $row[] = '<a href="' . site_url('jurnalpenyesuaian/edit/' . $this->encrypt->encode($rowdata->idjurnal)) . '" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> |
                        <a href="' . site_url('jurnalpenyesuaian/delete/' . $this->encrypt->encode($rowdata->idjurnal)) . '" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';

                $data[] = $row;
            }
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Jurnalpenyesuaian_model->count_all(),
                        "recordsFiltered" => $this->Jurnalpenyesuaian_model->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function datatablesourcedetail()
    {
        // query ini untuk item yang dimunculkan sesuai dengan kategori yang dipilih        

        $idjurnal = $this->input->post('idjurnal');
        $query = "select * from v_penerimaandetail
                        WHERE v_penerimaandetail.idjurnal='".$idjurnal."'";

        $RsData = $this->db->query($query);

        $no = 0;
        $data = array();

        if ($RsData->num_rows()>0) {
            foreach ($RsData->result() as $rowdata) {               
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $rowdata->kdakun4;
                $row[] = $rowdata->kdakun4.' '.$rowdata->namaakun4;
                $row[] = $rowdata->jumlahbarang;
                $row[] = format_rupiah($rowdata->hargabeli);
                $row[] = format_rupiah($rowdata->totalharga);
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

    public function delete($idjurnal)
    {
        $idjurnal = $this->encrypt->decode($idjurnal);  

        if ($this->Jurnalpenyesuaian_model->get_by_id($idjurnal)->num_rows()<1) {
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Ilegal!</strong> Data tidak ditemukan!
                        </div>
                    </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('jurnalpenyesuaian');
            exit();
        };

        $hapus = $this->Jurnalpenyesuaian_model->hapus($idjurnal);
        if ($hapus) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil dihapus!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan! <br>
                        </div>
                    </div>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('jurnalpenyesuaian');        

    }

    public function simpan()
    {       

        $idjurnal       = $this->input->post('idjurnal');
        $tgljurnal      = date('Y-m-d', strtotime($this->input->post('tgljurnal')));
        $tag            = '';
        $deskripsi      = $this->input->post('deskripsi');
        $kdakun4        = $this->input->post('kdakun4');
        $jumlah         = str_replace(',', '', $this->input->post('totaldebet') );
        $debet          = $this->input->post('debet');
        $kredit         = $this->input->post('kredit');
        $tglupdate      = date('Y-m-d H:i:s');
        $idpengguna     = $this->session->userdata('idpengguna');

        if ( $idjurnal=='' ) { // ini kondisi jika tambah data 

            $idjurnal = $this->db->query("SELECT create_idjurnal('".date('Y-m-d')."') as idjurnal")->row()->idjurnal;

            $data = array(
                            'idjurnal'      => $idjurnal, 
                            'tgljurnal'     => $tgljurnal, 
                            'deskripsi'     => $deskripsi,
                            'jumlah'        => $jumlah,
                            'tglinsert'     => $tglupdate,
                            'tglupdate'     => $tglupdate,
                            'idpengguna'    => $idpengguna,
                            'jenistransaksi'    => 'Jurnal Penyesuaian',
                        );

            $arrDetail = array();
            $urut = 1;
            foreach ($kdakun4 as $key => $value) {

                $arrDetail_temp = array(
                                    'idjurnal'      => $idjurnal, 
                                    'kdakun4' => $value, 
                                    'debet' => str_replace(',', '', $debet[$key] ), 
                                    'kredit' => str_replace(',', '', $kredit[$key] ),
                                    'nourut' => $urut++, 
                                );
                array_push($arrDetail, $arrDetail_temp);
            }

            $simpan = $this->Jurnalpenyesuaian_model->simpan($data, $arrDetail, $idjurnal);       

        }else{ 
            
            $file_lama2 = $this->input->post('file_lama2');

            $data = array(
                            'tgljurnal'     => $tgljurnal, 
                            'deskripsi'     => $deskripsi,
                            'jumlah'        => $jumlah,
                            'tglupdate'     => $tglupdate,
                            'idpengguna'    => $idpengguna,
                        );

            $arrDetail = array();
            $urut = 1;
            foreach ($kdakun4 as $key => $value) {

                $arrDetail_temp = array(
                                    'idjurnal'      => $idjurnal, 
                                    'kdakun4' => $value, 
                                    'debet' => str_replace(',', '', $debet[$key] ), 
                                    'kredit' => str_replace(',', '', $kredit[$key] ),
                                    'nourut' => $urut++, 
                                );
                array_push($arrDetail, $arrDetail_temp);
            }

            $simpan = $this->Jurnalpenyesuaian_model->update($data, $arrDetail, $idjurnal);   
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
        redirect('Jurnalpenyesuaian');      
    }
    
    public function get_edit_data()
    {
        $idjurnal = $this->input->post('idjurnal');
        $RsData = $this->Jurnalpenyesuaian_model->get_by_id($idjurnal)->row();

        $RsDataDetail = $this->Jurnalpenyesuaian_model->get_detail_by_id($idjurnal)->result_array();

        $data = array(
                    'idjurnal' =>  $RsData->idjurnal,
                    'tgljurnal' =>  date('d-m-Y', strtotime($RsData->tgljurnal)),
                    'tag' =>  $RsData->tag,
                    'deskripsi' =>  $RsData->deskripsi,
                    'filelampiran' =>  $RsData->filelampiran,
                    'RsDataDetail' => $RsDataDetail,
                    );

        echo(json_encode($data));
    }


    public function akun4_autocomplate()
    {
        $cari= $this->input->post('term');
        $query = "SELECT * FROM akun4 WHERE 
            ( kdakun4 like '%".$cari."%' or namaakun4 like '%".$cari."%' ) order by kdakun4 asc limit 10";
        $res = $this->db->query($query);
        $result = array();
        foreach ($res->result() as $row) {
            array_push($result, array(
                'kdakun4' => $row->kdakun4,
                'namaakun4' => $row->namaakun4,
            ));
        }
        echo json_encode($result);
    }

}

/* End of file Jurnalpenyesuaian.php */
/* Location: ./application/controllers/Jurnalpenyesuaian.php */