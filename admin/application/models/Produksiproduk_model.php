<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksiproduk_model extends CI_Model
{

    // ------------------------- >   Ubah Data Disini Aja

    public $tabelview  = 'v_produksi';
    public $tabel      = 'produksi';
    public $idproduksi = 'idproduksi';

    public $column_order  = array(null, 'tglproduksi', 'keterangan', 'namaproduk', 'beratbruto', 'beratnetto', 'namapengguna', null);
    public $column_search = array('tglproduksi', 'keterangan', 'namaproduk', 'namapengguna');
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

    public function get_by_id($idproduksi)
    {
        $this->db->where('idproduksi', $idproduksi);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idproduksi)
    {
        $this->db->trans_begin();

        $this->db->query('delete from produksibahan where idproduksi="' . $idproduksi . '"');
        $this->db->query('delete from produksikaryawan where idproduksi="' . $idproduksi . '"');
        $this->db->where('idproduksi', $idproduksi);
        $this->db->delete('produksi');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpan($arrayhead, $arraybahan, $arraykaryawan, $idproduksi)
    {
        $this->db->trans_begin();

        $this->db->insert('produksi', $arrayhead);
        $this->db->query('delete from produksibahan where idproduksi="' . $idproduksi . '"');
        $this->db->insert_batch('produksibahan', $arraybahan);

        $this->db->query('delete from produksikaryawan where idproduksi="' . $idproduksi . '"');
        $this->db->insert_batch('produksikaryawan', $arraykaryawan);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($arrayhead, $arraybahan, $arraykaryawan, $idproduksi)
    {
        $this->db->trans_begin();
        $this->db->where('idproduksi', $idproduksi);
        $this->db->update('produksi', $arrayhead);

        $this->db->query('delete from produksibahan where idproduksi="' . $idproduksi . '"');
        $this->db->insert_batch('produksibahan', $arraybahan);

        $this->db->query('delete from produksikaryawan where idproduksi="' . $idproduksi . '"');
        $this->db->insert_batch('produksikaryawan', $arraykaryawan);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Produksiproduk_model.php */
/* Location: ./application/models/Produksiproduk_model.php */
