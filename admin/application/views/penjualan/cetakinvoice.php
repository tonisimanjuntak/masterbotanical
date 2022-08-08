<?php

class MYPDF extends TCPDF {
 
	//Page header
	public function Header() {
	
		$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


		// set margins
		//$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set default header data
		// $cop = '
		// <div></div>
		// 	<table border="0">
		// 	    <tr>
			       
		// 	    	<td width="100%">
		// 				<div style="text-align:center; font-size:20px; font-weight:bold; padding-top:10px;">KALIMANTAN BARAT</div>

		// 				<i style="text-align:center; font-weight:bold; font-size:14px;">'.$nmkabupaten.'</i>
		// 				<br>
		// 				<i style="text-align:center; font-size:14px;">JL. H. BUJANG ATIM</i>						
		// 	        </td>
			        
		// 	    </tr>
		// 	</table>
		// 	<hr>
		// 	';

		// $this->writeHTML($cop, true, false, false, false, '');
		// // set margins
		// $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// $this->SetHeaderMargin(PDF_MARGIN_HEADER);

		// set default header data

					
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}


// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

$pdf->AddPage();


$rowhead = $this->db->query("select * from v_penjualan where idpenjualan='".$idpenjualan."'")->row();

$title = '
	<h1 style="color: #05860B; text-align: center;">INVOICE</h1>
	<table border="0" cellpadding="5">
		</thead>
			<tr>
				<th width="50%" style="font-size:12px; text-align:left;">
					<h3 style="color: #05860B;">PT. TRASINDO ANTARIKSA BORNEO</h3>
					Jl. Adisucipto KM.15 Desa Limbung RT.009/RW.012
					<br>Kecamatan Sungai Raya Kabupaten Kubu Raya 78391
					<br>Pontianak Kalimantan Barat
					<br>Email: masterbotanicals.office@gmail.com
					<br>Mobile: +62 821 4818 6900
				</th>
				<th width="50%" style="font-size:14px; font-weight:bold; text-align:center;">
					<img src="'.base_url("../images/logo-laporan.jpg").'" alt="">
				</th>				
			</tr>
		</thead>
	</table><hr><br>
';
$pdf->SetFont('times', '', 16);
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->SetTopMargin(15);




$table = '
	<style>
		.jarak-padding {
			padding-top = 100px;
		}
	</style>
';


$table .= '
	
	<table border="0" cellpadding="5">
		</thead>
			<tr>
				<th width="25%" style="font-size:12px; font-weight:bold; text-align:left;">
					<h3 style="color: #05860B;">Bill To</h3>
					'.$rowhead->namakonsumen.'
					<br>'.$rowhead->notelp.'
					<br>'.$rowhead->email.'
				</th>
				<th width="25%" style="font-size:12px; font-weight:bold; text-align:left;">
					<h3 style="color: #05860B;">Shipping Address</h3>
					'.$rowhead->alamatpengiriman.'
					<br>'.$rowhead->desa.', '.$rowhead->kota.', '.$rowhead->propinsi.', '.$rowhead->negara.'
					
				</th>	
				<th width="25%" style="font-size:16px; font-weight:bold; text-align:right;">
					Invoice No :
					<br>Invoice Date :
				</th>
				<th width="25%" style="font-size:16px; font-weight:bold; text-align:right;">
					'.$rowhead->idpenjualan.'
					<br>'.$rowhead->tglpenjualan.'
				</th>				
			</tr>
		</thead>
	</table><br><hr>
';

$table  .= '<br><br><br><br><table border="1" cellpadding="5">';


$table .= ' 
			<thead>
				<tr style="font-size:14px; font-weight:bold; background-color: #05860B; color: #FFFFFF;">
					<th width="5%" style="text-align:center;">SI</th>
					<th width="50%" style="text-align:center;">Description</th>
					<th width="15%" style="text-align:center;">Qty</th>
					<th width="15%" style="text-align:center;">Rate</th>					
					<th width="15%" style="text-align:center;">Amount</th>
				</tr>
			</thead>
			<tbody>';

$no = 1;
$subtotal = 0;
$totalquantity = 0;

$rsdetail = $this->db->query("select * from v_penjualandetail where idpenjualan='".$idpenjualan."'");
if ($rsdetail->num_rows()>0) {
	
	foreach ($rsdetail->result() as $rowdetail) {
		
		$table .= '<tr style="font-size:12px;">
						<td width="5%" style="text-align:center;">'.$no++.'</td>
						<td width="50%" style="text-align:left;">'.$rowdetail->namaproduk2.'</td>
						<td width="15%" style="text-align:center;">'.$rowdetail->beratproduk.'</td>					
						<td width="15%" style="text-align:center;">'.$rowdetail->hargaproduk.'</td>
						<td width="15%" style="text-align:center;">'.$rowdetail->subtotal.'</td>
					</tr>
					';
		$subtotal += $rowdetail->subtotal;
		$totalquantity += $rowdetail->beratproduk;

	}

	$table .= '<tr style="font-size:12px; font-weight: bold;">
						<td width="70%" style="text-align:left;" colspan="3">Total Quantity: '.$totalquantity.'</td>
						<td width="30%" style="text-align:right;" colspan="2"> Subtotal : USD '.$subtotal.'</td>
					</tr>
					';

}else{
	$table .= '<tr style="font-size:12px;">
					<td width="100%" style="text-align:center;" colspan="6">No data found...</td>
				</tr>
					';
}



$table .= ' </tbody>
			</table>';

$table .= '
	<div style="text-align: left; font-size: 14px;">
		<br><br>Note : '.$rowhead->keterangan.'
	</div>
';


$table  .= '';


$ttd = ' <br>
			<table border="0" cellpadding="5">
				<thead>
					<tr style="background-color:#ccc; font-size:14px;">
						<th width="33%" style="text-align:center;">Dikirim Oleh:</th>
						<th width="33%" style="text-align:center;">Diperiksa Oleh:</th>
						<th width="34%" style="text-align:center;">Diterima Oleh:</th>
					</tr>
					<tr style="background-color:#ccc; font-size:14px;">
						<th width="33%" style="text-align:center;">&nbsp;</th>
						<th width="33%" style="text-align:center;"></th>
						<th width="34%" style="text-align:center;"></th>
					</tr>
					<tr style="background-color:#ccc; font-size:14px;">
						<th width="33%" style="text-align:center;">&nbsp;</th>
						<th width="33%" style="text-align:center;"></th>
						<th width="34%" style="text-align:center;"></th>
					</tr>
					<tr style="background-color:#ccc; font-size:14px; font-weight: bold;">
						<th width="33%" style="text-align:center;"></th>
						<th width="33%" style="text-align:center;"></th>
						<th width="34%" style="text-align:center;"></th>
					</tr>
				</thead>
			<table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');


$tglcetak = date('d-m-Y');



$pdf->Output();
?>
