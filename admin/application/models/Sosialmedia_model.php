<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sosialmedia_model extends CI_Model {

	public function update($data)
    {
        return $this->db->update('utilsosialmedia', $data);
    }

}

/* End of file Sosialmedia_model.php */
/* Location: ./application/models/Sosialmedia_model.php */