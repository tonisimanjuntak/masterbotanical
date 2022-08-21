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
            <td width="90%" style="text-align: left; font-weight: bold; font-size: 18px;">BUKU KAS UMUM</td>
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

$table .= '
              </thead>
            </table>
';


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

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

$tglcetak = date('d-m-Y');

$pdf->Output();
