<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whychooseus_model extends CI_Model {

	public function update($data)
    {
        return $this->db->update('utilwhychooseus', $data);
    }

    public function get_by_id($idpage)
    {
        $this->db->where('idpage', $idpage);
        return $this->db->get($this->tabelview);
    }
    

}

/* End of file Whychooseus_model.php */
/* Location: ./application/models/Whychooseus_model.php */