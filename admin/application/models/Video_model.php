<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

	public function simpan($data)
	{
		return $this->db->insert('utilvideo', $data);
	}

	public function get_by_id($idutilvideo)
	{
		$this->db->where('idutilvideo', $idutilvideo);
		return $this->db->get('utilvideo');
	}

	public function hapus($idutilvideo)
	{
		$this->db->where('idutilvideo', $idutilvideo);
		return $this->db->delete('utilvideo');
	}

}

/* End of file Video_model.php */
/* Location: ./application/models/Video_model.php */