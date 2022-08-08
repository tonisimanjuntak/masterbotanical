<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$rowcompany = $this->db->query("select * from company limit 1")->row();
		$data['rowcompany'] = $rowcompany;
		$this->load->view('home', $data);			
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */