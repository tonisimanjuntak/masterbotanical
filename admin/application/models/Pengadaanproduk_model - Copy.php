<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaanproduk_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

    public $tabelview        = 'v_pengadaanproduk';
    public $tabel            = 'pengadaanproduk';
    public $idpengadaanproduk = 'idpengadaanproduk';

    public $column_order  = array(null, 'idpengadaanproduk', 'keterangan', 'totalpengadaan', 'namapengguna');
    public $column_search = array('idpengadaanproduk', 'keterangan', 'totalpengadaan', 'namapengguna');
    public $order         = array('idpengadaanproduk' => 'desc'); // default order

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

    public function get_by_id($idpengadaanproduk)
    {
        $this->db->where('idpengadaanproduk', $idpengadaanproduk);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idpengadaanproduk)
    {
        $this->db->trans_begin();

        $this->db->query('delete from pengadaanprodukdetail where idpengadaanproduk="' . $idpengadaanproduk . '"');
        $this->db->where('idpengadaanproduk', $idpengadaanproduk);
        $this->db->delete('pengadaanproduk');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpan($arrayhead, $arraydetail, $idpengadaanproduk)
    {
        $this->db->trans_begin();

        $this->db->insert('pengadaanproduk', $arrayhead);
        $this->db->query('delete from pengadaanprodukdetail where idpengadaanproduk="' . $idpengadaanproduk . '"');
        $this->db->insert_batch('pengadaanprodukdetail', $arraydetail);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($arrayhead, $arraydetail, $idpengadaanproduk)
    {
        $this->db->trans_begin();
        $this->db->where('idpengadaanproduk', $idpengadaanproduk);
        $this->db->update('pengadaanproduk', $arrayhead);

        $this->db->query('delete from pengadaanprodukdetail where idpengadaanproduk="' . $idpengadaanproduk . '"');
        $this->db->insert_batch('pengadaanprodukdetail', $arraydetail);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Pengadaanproduk_model.php */
/* Location: ./application/models/Pengadaanproduk_model.php */