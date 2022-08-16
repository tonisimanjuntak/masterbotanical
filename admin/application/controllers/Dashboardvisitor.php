<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardvisitor extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->is_login();
        $this->load->model('VisitorModel');
        //Do your magic here
    }

    public function is_login()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        if (empty($idpengguna)) {
            $pesan = '<div class="alert alert-danger">Session telah berakhir. Silahkan login kembali . . . </div>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect('Login');
            exit();
        }
    }

    public function index()
    {
        $data["menu"] = "dashboardvisitor";
        $this->load->view("dashboardvisitor", $data);
    }

    public function getinfobox()
    {
        $hitcounterlastweek = $this->VisitorModel->get_site_data_for_last_week();
        $hitcountertoday = $this->VisitorModel->get_site_data_for_today();
        $newvisitorthismonth = $this->VisitorModel->get_new_visitor_last_month();
        $onlinevisitor = $this->VisitorModel->get_online_visitor();

        $data = array(
        				'hitcountertoday' => $hitcountertoday, 
        				'hitcounterlastweek' => $hitcounterlastweek, 
        				'newvisitorthismonth' => $newvisitorthismonth, 
        				'onlinevisitor' => $onlinevisitor, 
        			);
        echo json_encode($data);
    }

    public function getgrafikhit()
    {
    	$rshit = $this->VisitorModel->get_chart_data_for_month_year();
    	$datatanggal = array();
    	$datahit = array();
    	$dataaverage = array();
		$jumlah = 0;
    	if ($rshit->num_rows()>0) {
    		$i = 1;
	    	foreach ($rshit->result() as $rowhit) {
	    		$datatanggal[] = 'Tgl-'.date('d', strtotime($rowhit->day));
	    		$datahit[] = $rowhit->visits;
	    		$dataaverage[] = ($jumlah+$rowhit->visits)/2;

	    		$jumlah += $rowhit->visits;
	    		$i++;
	    	}    		
    	}

    	$data = array(
    					'datatanggal' => $datatanggal, 
    					'datahit' => $datahit, 
    					'dataaverage' => $dataaverage, 
    					'totalhit' => $jumlah, 
    				);
    	echo json_encode( $data );
    }


    public function getgraviknewvisitor()
    {
    	$rsvisitor = $this->VisitorModel->get_chart_data_for_month_year_new_visitor();
    	$datatanggal = array();
    	$datavisitor = array();
    	$totalnewvisitor = 0;
    	if ($rsvisitor->num_rows()>0) {
	    	foreach ($rsvisitor->result() as $rowvisitor) {
	    		$datatanggal[] = 'Tgl-'.date('d', strtotime($rowvisitor->day));
	    		$datavisitor[] = $rowvisitor->visitor;
	    		$totalnewvisitor += $rowvisitor->visitor;
	    	}    		
    	}
    	$data = array(
    					'datatanggal' => $datatanggal, 
    					'datavisitor' => $datavisitor, 
    					'totalnewvisitor' => $totalnewvisitor, 
    				);
    	echo json_encode($data);
    }



}

/* End of file Dashboardvisitor.php */
/* Location: ./application/controllers/Dashboardvisitor.php */