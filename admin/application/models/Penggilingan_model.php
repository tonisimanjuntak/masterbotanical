<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggilingan_model extends CI_Model {

	// ------------------------- >   Ubah Data Disini Aja

    public $tabelview        = 'v_penggilingan_listdata';
    public $tabel            = 'penggilingan';
    public $idpenggilingan = 'idpenggilingan';

    public $column_order  = array(null, 'idbahankeluar', 'totalberatbahan', 'idpenggilingan', 'pemilikremahan', 'namapenggiling', null);
    public $column_search = array('idbahankeluar', 'keterangan_keluar', 'idpenggilingan', 'keterangan', 'pemilikremahan', 'namapenggiling');
    public $order         = array('idbahankeluar' => 'desc'); // default order

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

    public function get_by_id($idpenggilingan)
    {
        $this->db->where('idpenggilingan', $idpenggilingan);
        return $this->db->get($this->tabelview);
    }

    public function get_by_id_bahankeluar($idbahankeluar)
    {
        $this->db->where('idbahankeluar', $idbahankeluar);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idbahankeluar, $idpenggilingan)
    {
        $this->db->trans_begin();

        $this->db->query('update bahankeluardetail set beratbahanhasil = null where idbahankeluar="' . $idbahankeluar . '"');
        $this->db->where('idpenggilingan', $idpenggilingan);
        $this->db->delete('penggilingan');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpan($arrayhead, $idpenggilingan, $idbahankeluar)
    {
        $this->db->trans_begin();

        $this->db->insert('penggilingan', $arrayhead);

        $rsdetail = $this->db->query("select * from bahankeluardetail where idbahankeluar='".$idbahankeluar."'");
        if ($rsdetail->num_rows()>0) {
            foreach ($rsdetail->result() as $row) {
                $beratbahanhasil = $this->input->post('beratbahanhasil'.untitik($row->idbahan));
                $this->db->query("update bahankeluardetail set beratbahanhasil=".$beratbahanhasil." where idbahankeluar='".$idbahankeluar."' and idbahan='".$row->idbahan."'");
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($arrayhead, $idpenggilingan, $idbahankeluar)
    {
        $this->db->trans_begin();
        $this->db->where('idpenggilingan', $idpenggilingan);
        $this->db->update('penggilingan', $arrayhead);

        $rsdetail = $this->db->query("select * from bahankeluardetail where idbahankeluar='".$idbahankeluar."'");
        if ($rsdetail->num_rows()>0) {
            foreach ($rsdetail->result() as $row) {
                $beratbahanhasil = $this->input->post('beratbahanhasil'.$row->idbahan);
                $this->db->query("update bahankeluardetail set beratbahanhasil=".$beratbahanhasil." where idbahankeluar='".$idbahankeluar."' and idbahan='".$row->idbahan."'");
            }
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Penggilingan_model.php */
/* Location: ./application/models/Penggilingan_model.php */