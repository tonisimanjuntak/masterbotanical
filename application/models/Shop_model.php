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

	public function get_all_filter($limit, $start, $idjenis)
	{
		if (!empty($idjenis) && $idjenis!= 'all') {
			return $this->db->query("select * from v_produk where idjenis='$idjenis' order by idproduk limit ".$start.", ".$limit."");		
		}else{
			return $this->db->query("select * from v_produk order by idproduk limit ".$start.", ".$limit."");		
		}
	}

	public function count_all_filter($idjenis)
	{
		if (!empty($idjenis) && $idjenis!= 'all') {
			return $this->db->query("select count(*) as jlhrow from v_produk where idjenis='$idjenis'")->row()->jlhrow;		
		}else{
			return $this->db->query("select count(*) as jlhrow from v_produk")->row()->jlhrow;		
		}
	}

}

/* End of file Shop_model.php */
/* Location: ./application/models/Shop_model.php */