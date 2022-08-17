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
            <td width="90%" style="text-align: left; font-weight: bold; font-size: 18px;">LAPORAN PENJUALAN</td>
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


if (!empty($statuskonfirmasi) && $statuskonfirmasi != '-') {
  $table .= '
            <tr style="font-size:12px; font-weight:bold;">
                <th width="15%">Status Konfirmasi</th>
                <th width="2%">:</th>
                <th width="83%">'.strtoupper($statuskonfirmasi).'</th>
              </tr>
  ';
}

if (!empty($idproduk) && $idproduk != '-') {
  $namaproduk = $this->db->query("select * from produk where idproduk='".$idproduk."'")->row()->namaproduk;
  $table .= '
            <tr style="font-size:12px; font-weight:bold;">
                <th width="15%">Nama Produk</th>
                <th width="2%">:</th>
                <th width="83%">'.strtoupper($namaproduk).'</th>
              </tr>
  '; 
}

if (!empty($idprodukbatchnumber) && $idprodukbatchnumber != '-') {
  $nomorbatch = $this->db->query("select * from produkbatchnumber where idprodukbatchnumber='".$idprodukbatchnumber."'")->row()->nomorbatch;
  $table .= '
            <tr style="font-size:12px; font-weight:bold;">
                <th width="15%">Nomor Batch</th>
                <th width="2%">:</th>
                <th width="83%">'.strtoupper($nomorbatch).'</th>
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

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

$tglcetak = date('d-m-Y');

$pdf->Output();
