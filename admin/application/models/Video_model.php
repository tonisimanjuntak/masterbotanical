<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

	public function simpan($data)
	{
		return $this->db->insert('utilvideo', $data);
	}

}

/* End of file Video_model.php */
/* Location: ./application/models/Video_model.php */