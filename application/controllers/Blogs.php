<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		
		$rowcompany = $this->db->query("select * from company limit 1")->row();
		$data['rowcompany'] = $rowcompany;
		$this->load->view('blogs/index', $data);			

	}

	public function detail()
	{
		
		$rowcompany = $this->db->query("select * from company limit 1")->row();
		$rowblogs = $this->db->query("select * from v_blogs limit 1")->row();
		$data['rowcompany'] = $rowcompany;
		$data['rowblogs'] = $rowblogs;
		$this->load->view('blogs/detail', $data);			

	}

}

/* End of file Blogs.php */
/* Location: ./application/controllers/Blogs.php */