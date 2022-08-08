<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

	public function update($data)
	{
		return $this->db->update('utilvideo', $data);
	}

}

/* End of file Video_model.php */
/* Location: ./application/models/Video_model.php */