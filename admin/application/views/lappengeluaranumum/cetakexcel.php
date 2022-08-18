<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$namafile);

$table = '
      <h1>MASTER BOTANICAL</h1>
      <h3>LAPORAN PENGELUARAN UMUM</h3>
<br>';

$table .= '
                  <div>Tanggal Periode : '.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</div><br>';


if (!empty($kdakun4) && $kdakun4 != '-') {
  $namaakun4 = $this->db->query("select * from akun4 where kdakun4='".$kdakun4."'")->row()->namaakun4;
  $table .= '
                  <div>Nama Akun : '.strtoupper($namaakun4).'</div><br>';
}



$table .= '<br><br><table border="0" cellpadding="5">';
$table .= '
      <thead>
        <tr style="font-size:12px; font-weight:bold;">
          <th width="5%" style="text-align:center;" class="add-border-top add-border-bottom">NO</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">KODE</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">TANGGAL</th>
          <th width="55%" style="text-align:left;" class="add-border-top add-border-bottom">URAIAN</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">JUMLAH</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">SUBTOTAL</th>
        </tr>
      </thead>
      <tbody>';

$no = 1;
$total = 0;
$idpengeluaranumum_old = '';
$subtotal = 0;

if ($rspengeluaranumum->num_rows()>0) {
  foreach ($rspengeluaranumum->result() as $rowpengeluaranumum) {
    
    if ($idpengeluaranumum_old != $rowpengeluaranumum->idpengeluaranumum) {
      
      if ($subtotal>0) {
          
          $table .= '
            <tr style="font-size:12px; font-weight: bold;">
              <td width="5%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="55%" style="text-align:right;">Subtotal</td>
              <td width="10%" style="text-align:right;"></td>
              <td width="10%" style="text-align:right;">'.format_dollar($subtotal).'</td>
            </tr>
          ';
          $subtotal =0;
      }

      $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;" class="add-border-top">'.$no++.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.$rowpengeluaranumum->idpengeluaranumum.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.tglindonesia($rowpengeluaranumum->tglpengeluaranumum).'</td>
              <td width="55%" style="text-align:left;" class="add-border-top">'.$rowpengeluaranumum->keterangan.'</td>
              <td width="10%" style="text-align:right;" class="add-border-top"></td>
              <td width="10%" style="text-align:right;" class="add-border-top"></td>
            </tr>
      ';

      $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="55%" style="text-align:left;">> '.$rowpengeluaranumum->kdakun4.' - '.$rowpengeluaranumum->namaakun4.'</td>
              <td width="10%" style="text-align:right;">'.format_dollar($rowpengeluaranumum->jumlahpengeluaran).'</td>
              <td width="10%" style="text-align:right;"></td>
            </tr>
      ';

    }else{

        $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="10%" style="text-align:center;"></td>
              <td width="55%" style="text-align:left;">> '.$rowpengeluaranumum->kdakun4.' - '.$rowpengeluaranumum->namaakun4.'</td>
              <td width="10%" style="text-align:right;">'.format_dollar($rowpengeluaranumum->jumlahpengeluaran).'</td>
              <td width="10%" style="text-align:right;"></td>
            </tr>
      ';

    }

    $subtotal += $rowpengeluaranumum->jumlahpengeluaran;
    $total += $rowpengeluaranumum->jumlahpengeluaran;    
    $idpengeluaranumum_old = $rowpengeluaranumum->idpengeluaranumum;
  }
}else{
    $table .= '
            <tr style="font-size:12px;">
              <td width="100%" style="text-align:center;" class="add-border-top add-border-bottom" colspan="9">Data tidak ditemukan..</td>
            </tr>
      ';
}


if ($subtotal>0) {
          
    $table .= '
      <tr style="font-size:12px; font-weight: bold;">
        <td width="5%" style="text-align:center;"></td>
        <td width="10%" style="text-align:center;"></td>
        <td width="10%" style="text-align:center;"></td>
        <td width="55%" style="text-align:right;">Subtotal</td>
        <td width="10%" style="text-align:right;"></td>
        <td width="10%" style="text-align:right;">'.format_dollar($subtotal).'</td>
      </tr>
    ';
    $subtotal =0;
}

if ($no>1) {
  $table .= '
            <tr style="font-size:12px; font-weight: bold;">
              <td width="90%" style="text-align:right;" class="add-border-top add-border-bottom" colspan="5">T O T A L</td>
              <td width="10%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_decimal($total,2).'</td>
            </tr>
      ';
}
$table .= ' </tbody>
      </table>';


echo $table;
