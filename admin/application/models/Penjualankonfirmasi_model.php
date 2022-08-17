<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualankonfirmasi_model extends CI_Model {

    // ------------------------- >   Ubah Data Disini Aja

    var $tabelview = 'v_penjualan';
    var $tabel     = 'penjualan';
    var $idpenjualan = 'idpenjualan';

    var $column_order = array(null,'idpenjualan','namakonsumen','keterangan','totalpenjualan','statuskonfirmasi','statuspengiriman', null );
    var $column_search = array('idpenjualan','namakonsumen','keterangan','totalpenjualan','statuskonfirmasi','statuspengiriman');
    var $order = array('idpenjualan' => 'desc'); // default order 

    // ----------------------------


    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        return $this->db->get();        
    }

    private function _get_datatables_query()
    {
        $this->db->where('isfrontend', 'Yes');
        $this->db->from($this->tabelview);
        $i = 0;
     
        foreach ($this->column_search as $item) 
        {
            if($_POST['search']['value']) 
            {
                if($i===0) {
                    $this->db->group_start(); // Untuk Menggabung beberapa kondisi "AND"
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); 
            }
            $i++;
        }
        
        // -------------------------> Proses Order by        
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }

    function count_filtered()
    {
        $this->db->select('count(*) as jlh');
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->row()->jlh;
    }
 
    public function count_all()
    {
        $this->db->select('count(*) as jlh');
        return $this->db->get($this->tabelview)->row()->jlh;
    }

    public function get_all()
    {
        return $this->db->get($this->tabelview);
    }

    public function get_by_id($idpenjualan)
    {
        $this->db->where('idpenjualan', $idpenjualan);
        return $this->db->get($this->tabelview);
    }

    public function simpan($idpenjualankonfirmasi, $idpenjualan, $statuskonfirmasi)
    {       
        $this->db->trans_begin();

        $tglpenjualankonfirmasi = date('Y-m-d H:i:s');
        $idpengguna = $this->session->userdata('idpengguna');

        $this->db->query("insert into penjualankonfirmasi(idpenjualankonfirmasi, idpenjualan, tglpenjualankonfirmasi, tglinsert, tglupdate, idpengguna) 
                            values('$idpenjualankonfirmasi', '$idpenjualan', '$tglpenjualankonfirmasi', '$tglpenjualankonfirmasi', '$tglpenjualankonfirmasi', '$idpengguna')
                                ON DUPLICATE KEY UPDATE tglpenjualankonfirmasi='$tglpenjualankonfirmasi', tglupdate='$tglpenjualankonfirmasi', idpengguna='$idpengguna'
                            ");

        $this->db->query("update penjualan set statuskonfirmasi='$statuskonfirmasi' where idpenjualan='$idpenjualan'");
        
        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
        }else{
                $this->db->trans_commit();
                return true;
        }
    }


}

/* End of file Penjualankonfirmasi_model.php */
/* Location: ./application/models/Penjualankonfirmasi_model.php */