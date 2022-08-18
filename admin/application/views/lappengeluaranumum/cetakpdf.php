<?php

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {

        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $this->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        //$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default header data
        $cop = '
		<div></div>
			<table border="0">
			    <tr>

			    	<td width="100%">
						<div style="text-align:left; font-size:20px; font-weight:bold; padding-top:10px;">' . $namaskpd . '</div>

						<i style="text-align:left; font-weight:bold; font-size:14px;">Cabang Pontianak </i>
			        </td>

			    </tr>
			</table>
			<hr>
			';

        // $this->writeHTML($cop, true, false, false, false, '');
        // // set margins
        // $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        // set default header data

    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->AddPage();

$title .= '<table cellpadding="5">
			<tbody>
				<tr>
					<td width="10%" style="text-align: right;" rowspan="2"><img src="' . base_url('../images/logo.jpg') . '" alt="" width="70px;"></td>
          <td width="90%" style="text-align: left; font-weight: bold; font-size: 28px;">MASTER BOTANICAL</td>
        </tr>
        <tr>
            <td width="90%" style="text-align: left; font-weight: bold; font-size: 18px;">LAPORAN PENGELUARAN UMUM</td>
        </tr>
			</tbody>
			</table>';
$pdf->SetFont('times', '', 16);
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->SetTopMargin(15);



$table = '

<style>
  .no-border-bottom {
    border-bottom: 1px solid #eee;
  }
  .no-border-top {
    border-top: 1px solid #eee;
  }
  .add-border-top {
    border-top: 1px solid black; 
  }
  .add-border-bottom {
    border-bottom: 1px solid black; 
  }
</style>
';


$table .= '<table border="0" cellpadding="5">
              <thead>
                <tr style="font-size:12px; font-weight:bold;">
                  <th width="15%">Tanggal Periode</th>
                  <th width="2%">:</th>
                  <th width="83%">'.strtoupper(tglindonesia($tglawal)).' S/D '.strtoupper(tglindonesia($tglakhir)).'</th>
                </tr> ';


if (!empty($kdakun4) && $kdakun4 != '-') {
  $namaakun4 = $this->db->query("select * from akun4 where kdakun4='".$kdakun4."'")->row()->namaakun4;
  $table .= '
            <tr style="font-size:12px; font-weight:bold;">
                <th width="15%">Nama Akun</th>
                <th width="2%">:</th>
                <th width="83%">'.strtoupper($namaakun4).'</th>
              </tr>
  '; 
}

$table .= '
              </thead>
            </table>
';


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

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

$tglcetak = date('d-m-Y');

$pdf->Output();
