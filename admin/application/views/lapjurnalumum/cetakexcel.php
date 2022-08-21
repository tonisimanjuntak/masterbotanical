<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$namafile);

$table = '
      <h1>MASTER BOTANICAL</h1>
      <h3>JURNAL UMUM</h3>
<br>';

$table .= '
                  <div>Tanggal Periode : '.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</div><br>';



$table .= '<table border="0" cellpadding="5">
              <thead>
                <tr style="font-size:12px; font-weight:bold;">
                  <th width="15%">Tanggal Periode</th>
                  <th width="5%">:</th>
                  <th width="80%">'.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</th>
                </tr> ';

$table .= '
              </thead>
            </table>
';


$table .= '<br><table border="0" cellpadding="5">';
$table .= '
      <thead>
        <tr style="font-size:12px; font-weight:bold;">
          <th width="15%" style="text-align:center;" class="add-border-top add-border-bottom">TANGGAL</th>
          <th width="15%" style="text-align:center;" class="add-border-top add-border-bottom">NO BUKTI</th>
          <th width="30%" style="text-align:left;" class="add-border-top add-border-bottom">URAIAN</th>
          <th width="10%" style="text-align:left;" class="add-border-top add-border-bottom">REF</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">DEBET</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">KREDIT</th>
        </tr>
      </thead>
      <tbody>';

$no = 1;
$total = 0;
$idjurnal_old = '';
$subtotaldebet = 0;
$subtotalkredit = 0;
if ($rsjurnal->num_rows()>0) {
  foreach ($rsjurnal->result() as $rowjurnal) {
    
    $debet = '';
    $kredit = '';
    if ($rowjurnal->debet!=0) {
      $debet = $rowjurnal->debet;
    }

    if ($rowjurnal->kredit!=0) {
      $kredit = $rowjurnal->kredit;
    }

    if ($idjurnal_old != $rowjurnal->idjurnal) {
      

      $table .= '
            <tr style="font-size:12px;">
              <td width="15%" style="text-align:center;" class="add-border-top">'.tglindonesia($rowjurnal->tgljurnal).'</td>
              <td width="15%" style="text-align:center;" class="add-border-top">'.$rowjurnal->idjurnal.'</td>
              <td width="30%" style="text-align:left;" class="add-border-top">'.$rowjurnal->deskripsi.'</td>
              <td width="10%" style="text-align:right;" class="add-border-top"></td>
              <td width="15%" style="text-align:right;" class="add-border-top"></td>
              <td width="15%" style="text-align:right;" class="add-border-top"></td>
            </tr>
      ';

     
      $table .= '
            <tr style="font-size:12px;">
              <td width="15%" style="text-align:center;" class="add-border-top"></td>
              <td width="15%" style="text-align:center;" class="add-border-top"></td>
              <td width="30%" style="text-align:left;" class="add-border-top">'.$rowjurnal->namaakun4.'</td>
              <td width="10%" style="text-align:left;" class="add-border-top"></td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($debet).'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($kredit).'</td>
            </tr>
      ';

    }else{

      $table .= '
            <tr style="font-size:12px;">
              <td width="15%" style="text-align:center;" class="add-border-top"></td>
              <td width="15%" style="text-align:center;" class="add-border-top"></td>
              <td width="30%" style="text-align:left;" class="add-border-top">'.$rowjurnal->namaakun4.'</td>
              <td width="10%" style="text-align:left;" class="add-border-top"></td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($debet).'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowjurnal->kredit).'</td>
            </tr>
      ';

    }

    $subtotaldebet += $rowjurnal->debet;
    $subtotalkredit += $rowjurnal->kredit;
    $idjurnal_old = $rowjurnal->idjurnal;
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
        <td width="70%" style="text-align:right;" class="add-border-top add-border-bottom" colspan="4">TOTAL</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotaldebet).'</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotalkredit).'</td>
      </tr>
    ';
}

$table .= ' </tbody>
      </table>';


echo $table;
