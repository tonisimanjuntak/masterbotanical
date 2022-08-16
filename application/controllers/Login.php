<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    public function keluar()
    {
        //$this->session->sess_destroy();
        $this->session->unset_userdata('idkonsumen');
        redirect( site_url() );
    }

    public function index()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (!empty($idpengguna)) {
            redirect(site_url());
        } else {
            $this->load->view('login/index');
        }

    }

    public function cek_login()
    {
        $email    = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));

        if (empty($email) and empty($password)) {
            $pesan = '<script>swal("Upps!", "Email or Password can not be empty!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login');
        } else {
            $kirim = $this->Login_model->cek_login($email, md5($password));
            if ($kirim->num_rows() > 0) {
                $result = $kirim->row();

                if (!empty($result->foto)) {
                    $foto = base_url('uploads/konsumen/' . $result->foto);
                } else {
                    $foto = base_url('images/users1.png');
                }

                $data = array(
                    'idkonsumen'   => $result->idkonsumen,
                    'namakonsumen' => $result->namakonsumen,
                    'email'        => $result->email,
                    'foto'         => $foto,
                );

                $this->session->set_userdata($data);
                redirect(site_url());
            } else {
                $pesan = '<script>swal("Upps!", "Email or Password not match!", "warning")</script>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('Login');
            }

        }
    }

    public function createaccount()
    {
        $this->load->view('login/createaccount');
    }

    public function simpanaccountbaru()
    {
        $email        = trim($this->input->post('email'));
        $namakonsumen = trim($this->input->post('namakonsumen'));
        $password     = trim($this->input->post('password'));
        $password2    = trim($this->input->post('password2'));

        if ($password != $password2) {
            $pesan = '<script>swal("Upps!", "Repeat password not match!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login/createaccount');
        }

        if ($this->Login_model->emailbelumada($email) ) {
            
            $idkonsumen = $this->db->query("select create_idkonsumen('" . $namakonsumen . "') as idkonsumen ")->row()->idkonsumen;
        	$data = array(
                            'idkonsumen' => $idkonsumen, 
                            'namakonsumen' => $namakonsumen, 
                            'email' => $email, 
                            'password' => md5($password), 
                        );

            $simpan = $this->Login_model->simpanaccountbaru($data);
            if ($simpan) {
                $pesan = '<script>swal("Success!", "Account created successfully!", "success")</script>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('Login');    
            }else{
                
                $pesan = '<script>swal("Upps!", "Cannot create acount, please contact our CS!", "warning")</script>';
                $this->session->set_flashdata('pesan', $pesan);
                redirect('Login/createaccount');    
            }

        }else{

        	$pesan = '<script>swal("Upps!", "This email has already been registered!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login/createaccount');	
        }

        
    }

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
