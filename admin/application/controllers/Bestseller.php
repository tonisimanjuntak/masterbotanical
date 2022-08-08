<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bestseller extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Bestseller_model');
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
    	$rsbestseller = $this->db->query("select * from v_utilbestseller order by idjenis, namaproduk");
        $data['menu'] = 'bestseller';
        $data['rsbestseller'] = $rsbestseller;
        $this->load->view('bestseller/form', $data);
    }

    public function simpan()
    {        
    	$this->db->query("delete from utilbestseller");
        foreach($_POST['isbestseller'] as $value){
	      // echo $value;
        	$this->db->query("insert into utilbestseller(idproduk) values('".$value."')");
	    }

        $pesan = '<div>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        <strong>Berhasil!</strong> Data berhasil disimpan!
                    </div>
                </div>';
                
        $this->session->set_flashdata('pesan', $pesan);
        redirect('bestseller');
    }

    public function get_edit_data()
    {
        $idslider = $this->input->post('idslider');
        $RsData   = $this->Bestseller_model->get_by_id($idslider)->row();

        $data = array(
            'idslider'     => $RsData->idslider,
            'judul'        => $RsData->judul,
            'catatan'      => $RsData->catatan,
            'gambarslider' => $RsData->gambarslider,
        );

        echo (json_encode($data));
    }

    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/slider/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = "";
            }

        } else {
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']   = '../uploads/slider/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['remove_space']  = true;
            $config['max_size']      = '2000KB';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext');
            } else {
                $foto = $file_lama;
            }
        } else {
            $foto = $file_lama;
        }

        return $foto;
    }

}

/* End of file Bestseller.php */
/* Location: ./application/controllers/Bestseller.php */