<?php

header("Content-type: application/vnd-ms-excel");

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=".$namafile);

$table = '
      <h1>MASTER BOTANICAL</h1>
      <h3>BUKU KAS UMUM</h3>
<br>';

$table .= '
                  <div>Tanggal Periode : '.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</div><br>';




$table .= '<br><br><table border="0" cellpadding="5">';
$table .= '
      <thead>
        <tr style="font-size:12px; font-weight:bold;">
          <th width="5%" style="text-align:center;" class="add-border-top add-border-bottom">NO</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">TANGGAL</th>
          <th width="10%" style="text-align:center;" class="add-border-top add-border-bottom">KODE</th>
          <th width="45%" style="text-align:left;" class="add-border-top add-border-bottom">URAIAN</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">PENERIMAAN</th>
          <th width="15%" style="text-align:right;" class="add-border-top add-border-bottom">PENGELUARAN</th>
        </tr>
      </thead>
      <tbody>';

$no = 1;
$total = 0;
$id_old = '';
$subtotalpenerimaan = 0;
$subtotalpengeluaran = 0;

if ($rsbukukas->num_rows()>0) {
  foreach ($rsbukukas->result() as $rowbukukas) {
    
    if ($id_old != $rowbukukas->id) {
      

      $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;" class="add-border-top">'.$no++.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.tglindonesia($rowbukukas->tgl).'</td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.$rowbukukas->id.'</td>
              <td width="45%" style="text-align:left;" class="add-border-top">'.$rowbukukas->keterangan.'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowbukukas->penerimaan).'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowbukukas->pengeluaran).'</td>
            </tr>
      ';

     

    }else{

      $table .= '
            <tr style="font-size:12px;">
              <td width="5%" style="text-align:center;" class="add-border-top">'.$no++.'</td>
              <td width="10%" style="text-align:center;" class="add-border-top"></td>
              <td width="10%" style="text-align:center;" class="add-border-top">'.$rowbukukas->id.'</td>
              <td width="45%" style="text-align:left;" class="add-border-top">'.$rowbukukas->keterangan.'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowbukukas->penerimaan).'</td>
              <td width="15%" style="text-align:right;" class="add-border-top">'.format_dollar($rowbukukas->pengeluaran).'</td>
            </tr>
      ';

    }

    $subtotalpenerimaan += $rowbukukas->penerimaan;
    $subtotalpengeluaran += $rowbukukas->pengeluaran;
    $id_old = $rowbukukas->id;
  }
}else{
    $table .= '
            <tr style="font-size:12px;">
              <td width="100%" style="text-align:center;" class="add-border-top add-border-bottom" colspan="6">Data tidak ditemukan..</td>
            </tr>
      ';
}


if ($subtotalpenerimaan>0 || $subtotalpengeluaran>0) {
          
    $table .= '
      <tr style="font-size:12px; font-weight: bold;">
        <td width="70%" style="text-align:right;" class="add-border-top add-border-bottom" colspan="4">TOTAL</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotalpenerimaan).'</td>
        <td width="15%" style="text-align:right;" class="add-border-top add-border-bottom">'.format_dollar($subtotalpengeluaran).'</td>
      </tr>
    ';
}

$table .= ' </tbody>
      </table>';


echo $table;
