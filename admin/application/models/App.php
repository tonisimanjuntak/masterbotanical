<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Model {

	public function ambilJenis()
	{
		return $this->db->query("select * from jenis order by namajenis asc");
	}	

}

/* End of file App.php */
/* Location: ./application/models/App.php */