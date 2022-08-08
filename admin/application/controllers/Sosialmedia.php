<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sosialmedia extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Sosialmedia_model');
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
    	$rowsosialmedia = $this->db->query("select * from utilsosialmedia")->row();
        $data['menu'] = 'sosialmedia';
        $data['rowsosialmedia'] = $rowsosialmedia;
        $this->load->view('sosialmedia/form', $data);
    }

    public function simpan()
    {        
    	$urlfacebook 	= $this->input->post('urlfacebook');
    	$urltwitter 	= $this->input->post('urltwitter');
    	$urlinstagram 	= $this->input->post('urlinstagram');
        $urlyoutube     = $this->input->post('urlyoutube');
        $urllinkedin     = $this->input->post('urllinkedin');
        $urltiktok     = $this->input->post('urltiktok');
        $notelp2     = $this->input->post('notelp2');
        $notelp3     = $this->input->post('notelp3');
    	$notelp 	= $this->input->post('notelp');
    	$email 	= $this->input->post('email');

    	$data  = array(
    					'urlfacebook' => $urlfacebook, 
    					'urltwitter' => $urltwitter, 
    					'urlinstagram' => $urlinstagram, 
                        'urlyoutube' => $urlyoutube, 
                        'urllinkedin' => $urllinkedin, 
                        'urltiktok' => $urltiktok, 
                        'notelp2' => $notelp2, 
    					'notelp3' => $notelp3, 
    					'notelp' => $notelp, 
    					'email' => $email, 
    				);

    	$simpan = $this->Sosialmedia_model->update($data);

        if ($simpan) {
            $pesan = '<div>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Berhasil!</strong> Data berhasil disimpan!
                        </div>
                    </div>';
        } else {
            $eror  = $this->db->error();
            $pesan = '<div>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <strong>Gagal!</strong> Data gagal disimpan! <br>
                            Pesan Error : ' . $eror['code'] . ' ' . $eror['message'] . '
                        </div>
                    </div>';
        }
                
        $this->session->set_flashdata('pesan', $pesan);
        redirect('sosialmedia');
    }


}

/* End of file Sosialmedia.php */
/* Location: ./application/controllers/Sosialmedia.php */