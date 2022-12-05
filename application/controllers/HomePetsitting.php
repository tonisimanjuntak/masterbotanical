<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomePetsitting extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
        $this->loadInfoCompany();
        //Do your magic here
    }

    public function index()
    {
        $rowtabinfo     = $this->db->query("select * from v_utiltabinfo")->row();
        $rowwhychooseus = $this->db->query("select * from utilwhychooseus")->row();
        $rsfaq          = $this->db->query("select * from utilfaq");
        $rshappyclient  = $this->db->query("select * from utilhappyclient");
        $rowsosialmedia = $this->db->query("select * from utilsosialmedia")->row();
        $rsbestseller   = $this->db->query("select * from v_utilbestseller where idprodukbestseller is not null");
        $rsspesialoffer   = $this->db->query("
                                select * from v_spesialoffer limit 3
                                ");
        $rowcompany     = $this->db->query("select * from company limit 1")->row();
        $rowcounter     = $this->db->query("select * from utilcounter limit 1")->row();
        $rowsetting     = $this->db->query("select * from setting limit 1")->row();

        $jlhproduk = $this->db->query("select count(*) as jlhproduk from produk ")->row()->jlhproduk;
        $jlhcostumer = $this->db->query("select count(*) as jlhcostumer from konsumen ")->row()->jlhcostumer;
        $jlhtotalsale = $this->db->query("select sum(beratproduk*qty) as jlhtotalsale  from v_penjualandetail")->row()->jlhtotalsale;

        $jlhcostumer += $rowcounter->costumer;
        $jlhtotalsale += $rowcounter->totalsale;
        
        $bghappyclient = base_url('images/happy-smileys.jpg');
        if (!empty($rowsetting->bghappyclient)) {
            $bghappyclient = base_url('uploads/pengaturan/'.$rowsetting->bghappyclient);            
        }

        $logofreeconsultation = 'images/produk1.jpg';
        if (!empty($rowsetting->logofreeconsultation)) {
            $logofreeconsultation = 'uploads/pengaturan/'.$rowsetting->logofreeconsultation;            
        }

        $data['jlhcostumer']     = $jlhcostumer;
        $data['jlhtotalsale']     = $jlhtotalsale;
        $data['jlhproduk']     = $jlhproduk;
        $data['rowcompany']     = $rowcompany;
        $data['rowtabinfo']     = $rowtabinfo;
        $data['rowwhychooseus'] = $rowwhychooseus;
        $data['rowsetting'] = $rowsetting;
        $data['bghappyclient'] = $bghappyclient;
        $data['logofreeconsultation'] = $logofreeconsultation;
        $data['rshappyclient']  = $rshappyclient;
        $data['rowsosialmedia'] = $rowsosialmedia;
        $data['rsbestseller']   = $rsbestseller;
        $data['rsspesialoffer']   = $rsspesialoffer;
        $data['rsfaq']          = $rsfaq;
        $data['menu']           = 'homepetsitting';
        $this->load->view('homepetsitting', $data);
    }

    public function simpanconsultation()
    {
        $consulservice = htmlspecialchars($this->input->post('consulservice'));
        $consulname = htmlspecialchars($this->input->post('consulname'));
        $consulemail = $this->input->post('consulemail');
        $consulmessage = htmlspecialchars($this->input->post('consulmessage'));

        $data = array(
                        'consulservice' => $consulservice, 
                        'consulname' => $consulname, 
                        'consulemail' => $consulemail, 
                        'consulmessage' => $consulmessage,
                        'tglinsert' => date('Y-m-d H:i:s')
                    );
        $simpan = $this->Home_model->simpanconsultation($data);
        if ($simpan) {
            $pesan = '<script>swal("Success!", "Your consultation has been send! Thanks", "success")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect( site_url() );            
        }else{
            $pesan = '<script>swal("Upps!", "Your consultation cant submit!", "warning")</script>';
            $this->session->set_flashdata('pesan', $pesan);
            redirect( site_url() );            
        }
        

    }

}

/* End of file HomePetsitting.php */
/* Location: ./application/controllers/HomePetsitting.php */
