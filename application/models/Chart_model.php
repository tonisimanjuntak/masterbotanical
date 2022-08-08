<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model {

	public function simpan($arrayhead, $arraydetail, $idpenjualan)
    {       
        $this->db->trans_begin();

        $this->db->insert('penjualan', $arrayhead);
        $this->db->query('delete from penjualandetail where idpenjualan="'.$idpenjualan.'"');
        $this->db->insert_batch('penjualandetail', $arraydetail);

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
        }else{
                $this->db->trans_commit();
                return true;
        }
    }

}

/* End of file Chart_model.php */
/* Location: ./application/models/Chart_model.php */