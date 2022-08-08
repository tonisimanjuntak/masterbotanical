<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurnalpenyesuaian extends CI_Controller {

	public $menuaktif = 'Jurnal';

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
		$this->load->model('Jurnalpenyesuaian_model', 'Model');
		$this->load->library('image_lib');

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

		if ($this->Model->get_by_id($idjurnal)->num_rows()<1) {
			// echo($idjurnal);
			// exit();
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Jurnalpenyesuaian');
			exit();
		};

		$data['idjurnal'] = $idjurnal;		
		$data['menu'] = 'jurnalpenyesuaian';
		$this->load->view('jurnalpenyesuaian/form', $data);
	}

	public function datatablesource()
	{
		$RsData = $this->Model->get_datatables();
		$no = $_POST['start'];
		$data = array();

		if ($RsData->num_rows()>0) {
			foreach ($RsData->result() as $rowdata) {
				$lihatgambar='';
				if ($rowdata->filelampiran!='') {
					$lihatgambar = '<a href="'.base_url('uploads/'.$rowdata->filelampiran).'" class="btn btn-sm btn-info btn-circle" target="_blank"><i class="fa fa-image"></i></a> | ';
				}
				$no++;
				$row = array();
				$row[] = $no;
	            $row[] = $rowdata->idjurnal;
	            $row[] = date('d-m-Y', strtotime($rowdata->tgljurnal));
	            $row[] = $rowdata->deskripsi;	 
	            $row[] = number_format($rowdata->jumlah);	 
	            $row[] = $lihatgambar.'<a href="'.site_url( 'Jurnalpenyesuaian/edit/'.$this->encrypt->encode($rowdata->idjurnal) ).'" class="btn btn-sm btn-warning btn-circle"><i class="fa fa-edit"></i></a> | 
	            		<a href="'.site_url('Jurnalpenyesuaian/delete/'.$this->encrypt->encode($rowdata->idjurnal) ).'" class="btn btn-sm btn-danger btn-circle" id="hapus"><i class="fa fa-trash"></i></a>';
	            $data[] = $row;
			}
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Model->count_all(),
                        "recordsFiltered" => $this->Model->count_filtered(),
                        "data" => $data,
                );

        //output to json format
        echo json_encode($output);
	}

	public function delete($id)
	{
		$id = $this->encrypt->decode($id);	
		$rsjurnal = $this->Model->get_by_id($id);
		if ($rsjurnal->num_rows()<1) {
			$pesan = '<div>
						<div class="alert alert-danger alert-dismissable">
			                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
			                <strong>Ilegal!</strong> Data tidak ditemukan! 
					    </div>
					</div>';
			$this->session->set_flashdata('pesan', $pesan);
			redirect('Jurnalpenyesuaian');
			exit();
		};

		$filelampiran= $rsjurnal->row()->filelampiran;

		$hapus = $this->Model->hapus($id);
		if ($hapus) {

			if ($filelampiran!='' && $filelampiran != null) {
				if (file_exists('./uploads/'.$filelampiran)) { unlink('./uploads/'.$filelampiran); };
			}

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
			                <strong>Gagal!</strong> Data gagal dihapus karena sudah digunakan di jurnal! <br>
					    </div>
					</div>';
		}

		$this->session->set_flashdata('pesan', $pesan);
		redirect('Jurnalpenyesuaian');		

	}

	public function simpan()
	{		

		$idjurnal 		= $this->input->post('idjurnal');
		$tgljurnal		= date('Y-m-d', strtotime($this->input->post('tgljurnal')));
		$tag			= '';
		$deskripsi		= $this->input->post('deskripsi');
		$kdakun4		= $this->input->post('kdakun4');
		$jumlah			= str_replace(',', '', $this->input->post('totaldebet') );
		$debet			= $this->input->post('debet');
		$kredit			= $this->input->post('kredit');
		$tglupdate		= date('Y-m-d H:i:s');
		$idpengguna 	= $this->session->userdata('idpengguna');

		if ( $idjurnal=='' ) { // ini kondisi jika tambah data 

			$idjurnal = $this->db->query("SELECT create_idjurnal('".date('Y-m-d')."') as idjurnal")->row()->idjurnal;

			$data = array(
							'idjurnal' 		=> $idjurnal, 
							'tgljurnal' 	=> $tgljurnal, 
							'deskripsi' 	=> $deskripsi,
							'jumlah' 		=> $jumlah,
							'tglinsert' 	=> $tglupdate,
							'tglupdate' 	=> $tglupdate,
							'idpengguna' 	=> $idpengguna,
							'jenistransaksi' 	=> 'JP',
							'tahunperiode' 	=> $this->session->userdata('tahunperiode'),
						);

			$arrDetail = array();
			$urut = 1;
			foreach ($kdakun4 as $key => $value) {

				$arrDetail_temp = array(
									'idjurnal' 		=> $idjurnal, 
									'kdakun4' => $value, 
									'debet' => str_replace(',', '', $debet[$key] ), 
									'kredit' => str_replace(',', '', $kredit[$key] ),
									'nourut' => $urut++, 
								);
				array_push($arrDetail, $arrDetail_temp);
			}

			$simpan = $this->Model->simpan($data, $arrDetail, $idjurnal);		

		}else{ 
			
			$file_lama2 = $this->input->post('file_lama2');

			$data = array(
							'tgljurnal' 	=> $tgljurnal, 
							'deskripsi' 	=> $deskripsi,
							'jumlah' 		=> $jumlah,
							'tglupdate' 	=> $tglupdate,
							'idpengguna' 	=> $idpengguna,
							'tahunperiode' 	=> $this->session->userdata('tahunperiode'),
						);

			$arrDetail = array();
			$urut = 1;
			foreach ($kdakun4 as $key => $value) {

				$arrDetail_temp = array(
									'idjurnal' 		=> $idjurnal, 
									'kdakun4' => $value, 
									'debet' => str_replace(',', '', $debet[$key] ), 
									'kredit' => str_replace(',', '', $kredit[$key] ),
									'nourut' => $urut++, 
								);
				array_push($arrDetail, $arrDetail_temp);
			}

			$simpan = $this->Model->update($data, $arrDetail, $idjurnal);	
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
		$RsData = $this->Model->get_by_id($idjurnal)->row();

		$RsDataDetail = $this->Model->get_detail_by_id($idjurnal)->result_array();

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


	public function upload_foto($file, $nama)
	{

		if (!empty($file[$nama]['name'])) {
			$config['upload_path']          = './uploads/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	        $config['remove_space']         = TRUE;
            $config['max_size']            	= '10000KB';

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);

		    if ($this->upload->do_upload($nama)) {
                $gambar = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
             }else{
                 $gambar = "";
             }

		}else{
			$gambar = "";
		}


		return $gambar;
	}

	public function update_upload_foto($file, $nama, $file_lama)
	{
		if (!empty($file[$nama]['name'])) {

			
			if ($file_lama!='' && $file_lama != null) {
				if (file_exists('./uploads/'.$file_lama)) { unlink('./uploads/'.$file_lama); };
			}

			$config['upload_path']          = './uploads/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']            = '20000KB';
	        

	        $this->load->library('upload', $config);	    
	        $this->upload->initialize($config);   
            if ($this->upload->do_upload($nama)) {
                $gambar = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); //extension .pdf

                $this->resize_foto($this->upload->data());
            }else{
                $gambar = $file_lama;
            }	       
		}else{			
			$gambar = $file_lama;
		}

		return $gambar;
	}

	public function akun4_autocomplate()
	{
		$cari= $this->input->post('term');
    	$query = "SELECT * FROM v_akun4 WHERE 
    		( kdakun4 like '%".$cari."%' or namaakun4 like '%".$cari."%' ) order by kdakun4 asc limit 10";
		$res = $this->db->query($query);
		$result = array();
		foreach ($res->result() as $row) {
			array_push($result, array(
				'kdakun4' => $row->kdakun4,
				'namaakun4' => $row->namaakun4,
				'kdakun3' => $row->kdakun3,
				'namaakun3' => $row->namaakun3
			));
		}
		echo json_encode($result);
	}

}

/* End of file Jurnalpenyesuaian.php */
/* Location: ./application/controllers/Jurnalpenyesuaian.php */