<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


	public function read($idpages)
	{
		$idpages = $this->encrypt->decode($idpages);

		$rowpages =  $this->db->query("select * from v_pages where idpages='$idpages'")->row();
		$rowcompany = $this->db->query("select * from company limit 1")->row();
		$data['rowcompany'] = $rowcompany;
		$data['rowpages'] = $rowpages;
		$this->load->view('page/read', $data);			
	}

}

/* End of file Page.php */
/* Location: ./application/controllers/Page.php */