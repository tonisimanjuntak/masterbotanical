<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bestseller_model extends CI_Model {

	public function update($data)
    {
        return $this->db->update('utiltabinfo', $data);
    }

}

/* End of file Bestseller_model.php */
/* Location: ./application/models/Bestseller_model.php */