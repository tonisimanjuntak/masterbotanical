<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaanlab_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

    public $tabelview        = 'v_laboratorium';
    public $tabel            = 'laboratorium';
    public $idlaboratorium = 'idlaboratorium';

    public $column_order  = array(null, 'idproduksi', 'namaproduk', 'beratbruto', 'idlaboratorium', 'statuspemeriksaan', null);
    public $column_search = array('idproduksi', 'namaproduk', 'beratbruto', 'idlaboratorium', 'statuspemeriksaan');
    public $order         = array('idproduksi' => 'desc'); // default order

    // ----------------------------

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        return $this->db->get();
    }

    private function _get_datatables_query()
    {
        $this->db->from($this->tabelview);
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start(); // Untuk Menggabung beberapa kondisi "AND"
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) //last loop
                {
                    $this->db->group_end();
                }

            }
            $i++;
        }

        // -------------------------> Proses Order by
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }

    public function count_filtered()
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

    public function get_by_id($idlaboratorium)
    {
        $this->db->where('idlaboratorium', $idlaboratorium);
        return $this->db->get($this->tabelview);
    }

    public function get_id_produksi($idproduksi)
    {
        $this->db->where('idproduksi', $idproduksi);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idlaboratorium)
    {
        $this->db->where('idlaboratorium', $idlaboratorium);
        return $this->db->delete('laboratorium');
    }

    public function simpan($arrayhead, $idlaboratorium)
    {
        return $this->db->insert('laboratorium', $arrayhead);
    }

    public function update($arrayhead, $idlaboratorium)
    {
        $this->db->where('idlaboratorium', $idlaboratorium);
        return $this->db->update('laboratorium', $arrayhead);
    }

}

/* End of file Pemeriksaanlab_model.php */
/* Location: ./application/models/Pemeriksaanlab_model.php */