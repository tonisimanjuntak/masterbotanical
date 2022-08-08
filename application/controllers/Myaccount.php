<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('Myaccount_model');
        $this->load->library('image_lib');
        //Do your magic here
    }

    public function is_login()
    {
        $idkonsumen = $this->session->userdata('idkonsumen');
        if (empty($idkonsumen)) {
            $pesan = '<script>swal("Login First!", "You have to login first to continue!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login'); 
            exit();
        }
    } 

    public function index()
    {
    	$idkonsumen = $this->session->userdata('idkonsumen');
        $rowkonsumen = $this->db->query("select * from konsumen where idkonsumen='$idkonsumen'")->row();

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowkonsumen']       = $rowkonsumen;
        $data['menu']           = 'myaccount';
        $this->load->view('myaccount/index', $data);

    }

    public function saveinformation()
    {

        $idkonsumen = $this->session->userdata('idkonsumen');
        $namakonsumen = $this->input->post('namakonsumen');
        $jk = $this->input->post('gender');
        $alamatpengiriman = $this->input->post('alamatpengiriman');
        $negara = $this->input->post('negara');
        $propinsi = $this->input->post('propinsi');
        $kota = $this->input->post('kota');
        $desa = $this->input->post('desa');
        $notelp = $this->input->post('notelp');
        $nowa = $this->input->post('nowa');

        if (empty($idkonsumen)) {
            $pesan = '<script>swal("Upps!", "Please login again, because your session end for our security !", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('login');
        }


        $data = array(
                            'namakonsumen'   => $namakonsumen, 
                            'jk'   => $jk, 
                            'alamatpengiriman'   => $alamatpengiriman, 
                            'negara'   => $negara, 
                            'propinsi'   => $propinsi, 
                            'kota'   => $kota, 
                            'desa'   => $desa, 
                            'notelp'   => $notelp, 
                            'nowa'   => $nowa, 
                        );

        $simpan = $this->Myaccount_model->updateaccount($data, $idkonsumen);

        if ($simpan) {
            $pesan = '<script>swal("Success!", "Your account information has been change successfully !", "success")</script>';
        }else{
            $pesan = '<script>swal("Upps!", "Your account information failed to change !", "warning")</script>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('myaccount');
    }


    public function orderhistory()
    {
    	$idkonsumen = $this->session->userdata('idkonsumen');
        $rowkonsumen = $this->db->query("select * from konsumen where idkonsumen='$idkonsumen'")->row();
        $rspenjualan = $this->db->query("select * from v_penjualan where idkonsumen='$idkonsumen' order by tglcheckout desc, tglpenjualan desc");

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowkonsumen']       = $rowkonsumen;
        $data['rspenjualan']       = $rspenjualan;
        $data['menu']           = 'myaccount';
        $this->load->view('myaccount/orderhistory', $data);

    }

    public function uploadpayment($idpenjualan)
    {
    	$idpenjualan = $this->encrypt->decode($idpenjualan);
    	$rspenjualan = $this->db->query("select * from v_penjualan where idpenjualan='$idpenjualan'");
    	if ($rspenjualan->num_rows()==0) {
    		$pesan = '<script>swal("Upps!", "Your order cannot be found !", "warning")</script>';
	        $this->session->set_flashdata('pesan', $pesan);
	        redirect('myaccount/orderhistory/');
    	}

        $rowkonsumen = $this->db->query("select * from konsumen where idkonsumen='".$rspenjualan->row()->idkonsumen."'")->row();
        $rspenjualandetail = $this->db->query("select * from v_penjualandetail where idpenjualan='$idpenjualan' order by namaproduk");
    	$rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowkonsumen']       = $rowkonsumen;
        $data['rowpenjualan']       = $rspenjualan->row();
        $data['rspenjualandetail']       = $rspenjualandetail;
        $data['menu']           = 'myaccount';
        $this->load->view('myaccount/uploadpayment', $data);


    }

    public function uploadsubmit()
    {
        $idpenjualan = $this->input->post('idpenjualan');
        $file_lama = $this->input->post('file_lama');
        $foto = $this->update_upload_foto($_FILES, "file", $file_lama);

        $data = array(
                            'uploadbukti'   => $foto, 
                        );
        $simpan = $this->Myaccount_model->updatepenjualan($data, $idpenjualan);

        if ($simpan) {
            $pesan = '<script>swal("Success!", "Your proof of Payment has been successfully upload !", "success")</script>';
        }else{
            $pesan = '<script>swal("Upps!", "Your upload failed !", "warning")</script>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('myaccount/orderhistory/');

    }


    public function changepassword()
    {
        $idkonsumen = $this->session->userdata('idkonsumen');
        $rowkonsumen = $this->db->query("select * from konsumen where idkonsumen='$idkonsumen'")->row();

        $rowcompany             = $this->db->query("select * from company limit 1")->row();
        $rowsosialmedia         = $this->db->query("select * from utilsosialmedia")->row();
        $data['rowcompany']     = $rowcompany;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rowkonsumen']       = $rowkonsumen;
        $data['menu']           = 'myaccount';
        $this->load->view('myaccount/changepassword', $data);
    }

    public function savechangepassword()
    {
        $idkonsumen = $this->session->userdata('idkonsumen');
        $oldpassword = $this->input->post('oldpassword');
        $newpassword = $this->input->post('newpassword');
        $newpassword2 = $this->input->post('newpassword2');

        
        $cekpassword = $this->db->query("select * from konsumen where idkonsumen='$idkonsumen' and password='".md5($oldpassword)."'");
        if ($cekpassword->num_rows()==0) {
            $pesan = '<script>swal("Upps!", "Your old password not match !", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('myaccount/changepassword');
        }

        if ($newpassword!=$newpassword2) {
            $pesan = '<script>swal("Upps!", "Your new password not match !", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('myaccount/changepassword');
        }

        $data = array(
                            'password'   => md5($newpassword), 
                        );

        $simpan = $this->Myaccount_model->updateaccount($data, $idkonsumen);

        if ($simpan) {
            $pesan = '<script>swal("Success!", "Your password has been change successfully !", "success")</script>';
        }else{
            $pesan = '<script>swal("Upps!", "Your password failed to change !", "warning")</script>';
        }

        $this->session->set_flashdata('pesan', $pesan);
        redirect('myaccount');
    }


    public function upload_foto($file, $nama)
    {

        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = 'uploads/penjualan/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']             = '2000KB';

            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
             }else{
                 $foto = "";
             }

        }else{
            $foto = "";
        }
        return $foto;
    }

    public function update_upload_foto($file, $nama, $file_lama)
    {
        if (!empty($file[$nama]['name'])) {
            $config['upload_path']          = 'uploads/penjualan/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['remove_space']         = TRUE;
            $config['max_size']            = '2000KB';
            

            $this->load->library('upload', $config);           
            if ($this->upload->do_upload($nama)) {
                $foto = $this->upload->data('file_name');
                $size = $this->upload->data('file_size');
                $ext  = $this->upload->data('file_ext'); 
            }else{
                $foto = $file_lama;
            }          
        }else{          
            $foto = $file_lama;
        }

        return $foto;
    }



}

/* End of file Myaccount.php */
/* Location: ./application/controllers/Myaccount.php */