<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabinfo_model extends CI_Model {

	
    public function update($data)
    {
        return $this->db->update('utiltabinfo', $data);
    }

}

/* End of file Tabinfo_model.php */
/* Location: ./application/models/Tabinfo_model.php */