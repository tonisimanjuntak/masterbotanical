<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$namafile);

$table = '
      <h1>MASTER BOTANICAL</h1>
      <h3>BUKU BESAR</h3>
<br>';

$table .= '
                  <div>Tanggal Periode : '.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</div><br>
                  <div>Nama Akun : '.$kdakun.' - '.$namaakun.'</div>
                  ';




$table .= '<br><br><table border="0" cellpadding="5">';
$table .= '
      <thead>
        <tr style="font-size:12px; font-weight:bold;">
          <th width="5%" style="text-align:center;" class="add-border-top add-border-bottom">NO</th>
          <th width="15%" style="text-align:center;" class="add-border-top add-border-bottom">TANGGAL</th>
          <th width="35%" style="text-align:left;" class="add-border-top add-border-bottom">KETERANGAN</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">DEBET</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">KREDIT</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">SALDO</th>
        </tr>
      </thead>
      <tbody>';



$saldonormal = get_saldo_normal($kdakun);
$subtotaldebet = 0;
$subtotalkredit = 0;
$saldo = 0;


if ($saldonormal=='D') {
      $saldo += $rowjurnal_lalu->debet - $rowjurnal_lalu->kredit;
    }else{
      $saldo += $rowjurnal_lalu->kredit - $rowjurnal_lalu->debet;
    }
$subtotaldebet = $rowjurnal_lalu->debet;
$subtotalkredit = $rowjurnal_lalu->kredit;

$table .= '
          <tr style="font-size:12px;">
            <td width="5%" style="text-align:center;" class="add-border-top"></td>
            <td width="15%" style="text-align:center;" class="add-border-top"></td>
            <td width="35%" style="text-align:left;" class="add-border-top">Saldo Awal Tgl '.tglindonesia($tglawal).'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowjurnal_lalu->debet).'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowjurnal_lalu->kredit).'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($saldo).'</td>
          </tr>
    ';


$no = 1;

if ($rsjurnal->num_rows()>0) {
  foreach ($rsjurnal->result() as $rowjurnal) {
    

    if ($saldonormal=='D') {
      $saldo += $rowjurnal->debet - $rowjurnal->kredit;
    }else{
      $saldo += $rowjurnal->kredit - $rowjurnal->debet;
    }

    $table .= '
          <tr style="font-size:12px;">
            <td width="5%" style="text-align:center;" class="add-border-top">'.$no++.'</td>
            <td width="15%" style="text-align:center;" class="add-border-top">'.tglindonesia($rowjurnal->tgljurnal).'</td>
            <td width="35%" style="text-align:left;" class="add-border-top">'.$rowjurnal->deskripsi.'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowjurnal->debet).'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowjurnal->kredit).'</td>
            <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($saldo).'</td>
          </tr>
    ';

    $subtotaldebet += $rowjurnal->debet;
    $subtotalkredit += $rowjurnal->kredit;

  }
}else{
    $table .= '
            <tr style="font-size:12px;">
              <td width="100%" style="text-align:center;" class="add-border-top add-border-bottom" colspan="6">Data tidak ditemukan..</td>
            </tr>
      ';
}


if ($subtotaldebet>0 || $subtotalkredit>0) {
          
    $table .= '
      <tr style="font-size:12px; font-weight: bold;">
        <td width="55%" style="text-align:right;" class="add-border-top add-border-bottom" colspan="3">TOTAL</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotaldebet).'</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotalkredit).'</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($saldo).'</td>
      </tr>
    ';
}

$table .= ' </tbody>
      </table>';

echo $table;
