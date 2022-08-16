<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardmanagement_model extends CI_Model {

	public function getchartbulanini($bulan='', $tahun='')
	{
		if (empty($bulan)) {
			$bulan = date('m');
		}
		if (empty($tahun)) {
			$tahun = date('Y');
		}

        $query = "
        		SELECT SUM(totalpenjualan) AS totalpenjualan,
			            DATE_FORMAT(tglpenjualankonfirmasi,'%d-%m-%Y') AS tanggal 
			            FROM v_penjualan_dikonfirmasi
			            WHERE MONTH(tglpenjualankonfirmasi)= '".$bulan."'
			            AND YEAR(tglpenjualankonfirmasi)='".$tahun."'
			            GROUP BY DATE(tglpenjualankonfirmasi)
        	";
       return $this->db->query($query);
	}


	public function getcharttahunini($tahun='')
	{
		if (empty($tahun)) {
			$tahun = date('Y');
		}

        $query = "
        		SELECT SUM(totalpenjualan) AS totalpenjualan,
			            MONTH(tglpenjualankonfirmasi) AS bulan
			            FROM v_penjualan_dikonfirmasi
			            WHERE YEAR(tglpenjualankonfirmasi)='".$tahun."'
			            GROUP BY MONTH(tglpenjualankonfirmasi)
        	";
       return $this->db->query($query);
	}

}

/* End of file Dashboardmanagement_model.php */
/* Location: ./application/models/Dashboardmanagement_model.php */