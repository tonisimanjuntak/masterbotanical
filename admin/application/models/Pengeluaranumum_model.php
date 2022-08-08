<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaranumum_model extends CI_Model
{

    // ------------------------- >   Ubah Data Disini Aja

    public $tabelview         = 'v_pengeluaranumum';
    public $tabel             = 'pengeluaran';
    public $idpengeluaranumum = 'idpengeluaranumum';

    public $column_order  = array(null, 'tglpengeluaranumum', 'keterangan', 'totalpengeluaranumum', 'idpengguna');
    public $column_search = array('tglpengeluaranumum', 'keterangan', 'totalpengeluaranumum', 'idpengguna');
    public $order         = array('idpengeluaranumum' => 'desc'); // default order

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

    public function get_by_id($idpengeluaranumum)
    {
        $this->db->where('idpengeluaranumum', $idpengeluaranumum);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idpengeluaranumum)
    {
        $this->db->trans_begin();

        $this->db->query('delete from pengeluarandetail where idpengeluaranumum="' . $idpengeluaranumum . '"');
        $this->db->where('idpengeluaranumum', $idpengeluaranumum);
        $this->db->delete('pengeluaran');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpan($arrayhead, $arraydetail, $idpengeluaranumum)
    {
        $this->db->trans_begin();

        $this->db->insert('pengeluaran', $arrayhead);
        $this->db->query('delete from pengeluarandetail where idpengeluaranumum="' . $idpengeluaranumum . '"');
        $this->db->insert_batch('pengeluarandetail', $arraydetail);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($arrayhead, $arraydetail, $idpengeluaranumum)
    {
        $this->db->trans_begin();
        $this->db->where('idpengeluaranumum', $idpengeluaranumum);
        $this->db->update('pengeluaran', $arrayhead);

        $this->db->query('delete from pengeluarandetail where idpengeluaranumum="' . $idpengeluaranumum . '"');
        $this->db->insert_batch('pengeluarandetail', $arraydetail);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Pengeluaranumum_model.php */
/* Location: ./application/models/Pengeluaranumum_model.php */
