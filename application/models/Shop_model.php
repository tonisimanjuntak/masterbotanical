<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {

	public function get_all($limit, $start)
	{
		return $this->db->query("select * from v_produk order by idproduk limit ".$start.", ".$limit."");		
	}

	public function count_all()
	{
		return $this->db->query("select count(*) as jlhrow from v_produk")->row()->jlhrow;		
	}

}

/* End of file Shop_model.php */
/* Location: ./application/models/Shop_model.php */