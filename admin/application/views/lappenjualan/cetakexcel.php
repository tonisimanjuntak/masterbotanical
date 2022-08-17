<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$namafile);

$table = '
      <h1>MASTER BOTANICAL</h1>
      <h3>LAPORAN PENJUALAN</h3>
<br>';

$table .= '
                  <div>Tanggal Periode : '.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</div><br>';



if (!empty($statuskonfirmasi) && $statuskonfirmasi != '-') {
  $table .= '
                  <div>Status Konfirmasi : '.strtoupper($statuskonfirmasi).'</div><br>';
}

if (!empty($idproduk) && $idproduk != '-') {
  $namaproduk = $this->db->query("select * from produk where idproduk='".$idproduk."'")->row()->namaproduk;
  $table .= '
                  <div>Nama Produk : '.strtoupper($namaproduk).'</div><br>';
}

if (!empty($idprodukbatchnumber) && $idprodukbatchnumber != '-') {
  $nomorbatch = $this->db->query("select * from produkbatchnumber where idprodukbatchnumber='".$idprodukbatchnumber."'")->row()->nomorbatch;
  $table .= '
                  <div>Nomor Batch: '.strtoupper($nomorbatch).'</div><br>'; 
}


$table .= '<br><br><table border="1" cellpadding="5">';
$table .= '
            <thead>
                <tr style="font-size:12px; font-weight:bold;">
          <th width="5%" style="text-align:center;" class="add-border-top add-border-bottom">NO</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">KODE</th>
                    <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">TANGGAL</th>
          <th width="15%" style="text-align:left;" class="add-border-top add-border-bottom">NAMA KONSUMEN</th>
          <th width="20%" style="text-align:left;" class="add-border-top add-border-bottom">URAIAN</th>
                    <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">BATCH NUMBER</th>
                    <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">BERAT <br>(KG)</th>
                    <th width="10%" style="text-align:right;" class="add-border-top add-border-bottom">HARGA SATUAN ($)</th>
                    <th width="10%" style="text-align:right;" class="add-border-top add-border-bottom">JUMLAH ($)</th>
                </tr>
            </thead>
      <tbody>';

$no = 1;
$total = 0;
$idpenjualan_old = '';

if ($rspenjualan->num_rows()>0) {
  foreach ($rspenjualan->result() as $rowpenjualan) {
    
    if ($rowpenjualan->isfrontend) {
      $keterangan = 'Penjualan dari web';
    }else{
      $keterangan = 'Penjualan langsung';
    }

    if ($idpenjualan_old != $rowpenjualan->idpenjualan) {
      
      $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;" class="add-border-top">'.$no++.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.$rowpenjualan->idpenjualan.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.tglindonesia($rowpenjualan->tglpenjualan).'</td>
              <td width="15%" style="text-align:left;" class="add-border-top">'.$rowpenjualan->namakonsumen.'</td>
              <td width="20%" style="text-align:left;" class="add-border-top">'.$rowpenjualan->namaproduk.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.$rowpenjualan->nomorbatch.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.format_decimal($rowpenjualan->beratproduk,2).'</td>
              <td width="10%" style="text-align:right;" class="add-border-top">'.format_decimal($rowpenjualan->hargaproduk,2).'</td>
              <td width="10%" style="text-align:right;" class="add-border-top">'.format_decimal($rowpenjualan->subtotal,2).'</td>
            </tr>
      ';

    }else{

        $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="15%" style="text-align:left;"></td>
              <td width="20%" style="text-align:left;">'.$rowpenjualan->namaproduk.'</td>
              <td width="10%" style="text-align:center;">'.$rowpenjualan->nomorbatch.'</td>
              <td width="10%" style="text-align:center;">'.format_decimal($rowpenjualan->beratproduk,2).'</td>
              <td width="10%" style="text-align:right;">'.format_decimal($rowpenjualan->hargaproduk,2).'</td>
              <td width="10%" style="text-align:right;">'.format_decimal($rowpenjualan->subtotal,2).'</td>
            </tr>
      ';

    }

    $total += $rowpenjualan->subtotal;    
  }
}else{
    $table .= '
            <tr style="font-size:12px;">
              <td width="100%" style="text-align:center;" class="add-border-top add-border-bottom" colspan="9">Data tidak ditemukan..</td>
            </tr>
      ';
}


if ($no>1) {
  $table .= '
            <tr style="font-size:12px; font-weight: bold;">
              <td width="90%" style="text-align:right;" class="add-border-top add-border-bottom" colspan="8">T O T A L</td>
              <td width="10%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_decimal($total,2).'</td>
            </tr>
      ';
}
$table .= ' </tbody>
            </table>';

echo $table;
