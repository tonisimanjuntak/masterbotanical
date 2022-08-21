<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengadaanbahan_model extends CI_Model
{

    // ------------------------- >   Ubah Data Disini Aja

    public $tabelview        = 'v_pengadaanbahan';
    public $tabel            = 'pengadaanbahan';
    public $idpengadaanbahan = 'idpengadaanbahan';

    public $column_order  = array(null, 'tglpengadaanbahan', 'keterangan', 'totalpengadaan', 'idpengguna');
    public $column_search = array('tglpengadaanbahan', 'keterangan', 'totalpengadaan', 'idpengguna');
    public $order         = array('idpengadaanbahan' => 'desc'); // default order

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

    public function get_by_id($idpengadaanbahan)
    {
        $this->db->where('idpengadaanbahan', $idpengadaanbahan);
        return $this->db->get($this->tabelview);
    }

    public function hapus($idpengadaanbahan)
    {
        $this->db->trans_begin();

        $this->db->query('delete from jurnaldetail where idjurnal="' . $idpengadaanbahan . '"');
        $this->db->query('delete from jurnal where idjurnal="' . $idpengadaanbahan . '"');

        $this->db->query('delete from pengadaanbahandetail where idpengadaanbahan="' . $idpengadaanbahan . '"');
        $this->db->where('idpengadaanbahan', $idpengadaanbahan);
        $this->db->delete('pengadaanbahan');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpan($arrayhead, $arraydetail, $idpengadaanbahan)
    {
        $this->db->trans_begin();
        $this->db->query('delete from jurnaldetail where idjurnal="' . $idpengadaanbahan . '"');
        $this->db->query('delete from jurnal where idjurnal="' . $idpengadaanbahan . '"');
        $this->db->query('delete from pengadaanbahandetail where idpengadaanbahan="' . $idpengadaanbahan . '"');

        
        $this->db->insert('pengadaanbahan', $arrayhead);
        $this->db->insert_batch('pengadaanbahandetail', $arraydetail);

        //jurnal
        $datajurnal = array(
                        'idjurnal' => $arrayhead['idpengadaanbahan'],
                        'tgljurnal' => $arrayhead['tglpengadaanbahan'], 
                        'deskripsi' => $arrayhead['keterangan'], 
                        'jumlah' => $arrayhead['totalpengadaan'], 
                        'jenistransaksi' => 'Pengadaan Bahan'
                    );
        $this->db->insert('jurnal', $datajurnal);

        // jurnal detail
        $kdakunkaspengadaanbahan = $this->db->query("select kdakunkaspengadaanbahan from pengaturan")->row()->kdakunkaspengadaanbahan;
        $kdakunpengadaanbahan = $this->db->query("select kdakunpengadaanbahan from pengaturan")->row()->kdakunpengadaanbahan;
        $datadebet = array();        
        $datakredit = array();        
        array_push($datadebet, array(
                'idjurnal' => $arrayhead['idpengadaanbahan'], 
                'kdakun4' => $kdakunpengadaanbahan, 
                'debet' => $arrayhead['totalpengadaan'],  
                'kredit' => 0, 
                'nourut' => 1
             ));

        array_push($datakredit, array(
                    'idjurnal' => $arrayhead['idpengadaanbahan'], 
                    'kdakun4' => $kdakunkaspengadaanbahan, 
                    'debet' => 0, 
                    'kredit' => $arrayhead['totalpengadaan'], 
                    'nourut' => 2
                 ));

        $this->db->insert_batch('jurnaldetail', $datadebet);
        $this->db->insert_batch('jurnaldetail', $datakredit);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($arrayhead, $arraydetail, $idpengadaanbahan)
    {
        $this->db->trans_begin();

        $this->db->query('delete from jurnaldetail where idjurnal="' . $idpengadaanbahan . '"');
        $this->db->query('delete from jurnal where idjurnal="' . $idpengadaanbahan . '"');
        $this->db->query('delete from pengadaanbahandetail where idpengadaanbahan="' . $idpengadaanbahan . '"');

        $this->db->where('idpengadaanbahan', $idpengadaanbahan);
        $this->db->update('pengadaanbahan', $arrayhead);
        $this->db->insert_batch('pengadaanbahandetail', $arraydetail);


        //jurnal
        $datajurnal = array(
                        'idjurnal' => $arrayhead['idpengadaanbahan'],
                        'tgljurnal' => $arrayhead['tglpengadaanbahan'], 
                        'deskripsi' => $arrayhead['keterangan'], 
                        'jumlah' => $arrayhead['totalpengadaan'], 
                        'jenistransaksi' => 'Pengadaan Bahan'
                    );
        $this->db->insert('jurnal', $datajurnal);

        // jurnal detail
        $kdakunkaspengadaanbahan = $this->db->query("select kdakunkaspengadaanbahan from pengaturan")->row()->kdakunkaspengadaanbahan;
        $kdakunpengadaanbahan = $this->db->query("select kdakunpengadaanbahan from pengaturan")->row()->kdakunpengadaanbahan;
        $datadebet = array();        
        $datakredit = array();        
        array_push($datadebet, array(
                'idjurnal' => $arrayhead['idpengadaanbahan'], 
                'kdakun4' => $kdakunpengadaanbahan, 
                'debet' => $arrayhead['totalpengadaan'],  
                'kredit' => 0, 
                'nourut' => 1
             ));

        array_push($datakredit, array(
                    'idjurnal' => $arrayhead['idpengadaanbahan'], 
                    'kdakun4' => $kdakunkaspengadaanbahan, 
                    'debet' => 0, 
                    'kredit' => $arrayhead['totalpengadaan'], 
                    'nourut' => 2
                 ));

        $this->db->insert_batch('jurnaldetail', $datadebet);
        $this->db->insert_batch('jurnaldetail', $datakredit);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

/* End of file Pengadaanbahan_model.php */
/* Location: ./application/models/Pengadaanbahan_model.php */
