<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	public function simpanconsultation($data)
	{
		return $this->db->insert('consultation', $data);
	}

}

/* End of file Home_model.php */
/* Location: ./application/models/Home_model.php */