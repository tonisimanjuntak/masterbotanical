<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Myaccount_model extends CI_Model {

	public function updatepenjualan($data, $idpenjualan)
	{
		$this->db->where('idpenjualan', $idpenjualan);
		return $this->db->update('penjualan', $data);
	}


	public function updateaccount($data, $idkonsumen)
	{
		$this->db->where('idkonsumen', $idkonsumen);
		return $this->db->update('konsumen', $data);
	}

}

/* End of file Myaccount_model.php */
/* Location: ./application/models/Myaccount_model.php */