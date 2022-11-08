<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_login();
        $this->loadInfoCompany();
	}

	public function index()
	{
		$data['menu'] = 'maintenance';
		$this->load->view('maintenance', $data);
	}

}

/* End of file Maintenance.php */
/* Location: ./application/controllers/Maintenance.php */