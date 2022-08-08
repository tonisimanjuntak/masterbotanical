<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function cek_login($email, $password)
    {
        $query = "select * from konsumen where email='" . $email . "' and password='" . $password . "' ";
        return $this->db->query($query);
    }

    public function emailbelumada($email)
    {
        $cek = $this->db->query("select * from konsumen where email='" . $email . "'");
        if ($cek->num_rows() <= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function simpanaccountbaru($data)
    {
    	return $this->db->insert('konsumen', $data);
    }

}

/* End of file Login_model.php */
/* Location: ./application/models/Login_model.php */
