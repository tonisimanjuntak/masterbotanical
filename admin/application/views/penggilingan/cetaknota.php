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


$rowhead = $this->db->query("select * from v_penggilingan_listdata where idpenggilingan='".$idpenggilingan."'")->row();

$title = '
	<table border="0" cellpadding="5">
		</thead>
			<tr style="">
				<th width="50%" style="font-size:14px; font-weight:bold; text-align:center;">
					<img src="'.base_url("../images/logo-laporan.jpg").'" alt="">
				</th>
				<th width="20%" style="font-size:18px; font-weight:bold; text-align:right;">
					NOTA NO
				</th>
				<th width="5%" style="font-size:14px; font-weight:bold; text-align:left;">
					:
				</th>
				<th width="20%" style="font-size:18px; font-weight:bold; text-align:left;">
					'.$rowhead->idpenggilingan.'
				</th>
			</tr>
			<tr>
				<th width="50%" style="font-size:10px; text-align:center;">
					Jl. Adisucipto KM.15 Desa Limbung RT.009/RW.012
					Kecamatan Sungai Raya Kabupaten Kubu Raya 78391
					Pontianak Kalimantan Barat
					Mobile: +62 821 4818 6900
				</th>
				<th width="50%" style="font-size:14px; font-weight:bold; text-align:center;">


					<table border="0" cellpadding="0">
						</thead>
							<tr>
								<th width="40%" style="font-size:14px; text-align:left;">
									Tanggal 
								</th>
								<th width="10%" style="font-size:14px; text-align:left;">
									: 
								</th>
								<th width="50%" style="font-size:14px; text-align:left;">
									'.tglindonesia($rowhead->tglpenggilingan).'
								</th>
							</tr>
							<tr>
								<th width="40%" style="font-size:14px; text-align:left;">
									Hari
								</th>
								<th width="10%" style="font-size:14px; text-align:left;">
									: 
								</th>
								<th width="50%" style="font-size:14px; text-align:left;">
									'.hariini(date('Y-m-d', strtotime($rowhead->tglpenggilingan))).'
								</th>
							</tr>
							<tr>
								<th width="40%" style="font-size:14px; text-align:left;">
									Nama Penggiling
								</th>
								<th width="10%" style="font-size:14px; text-align:left;">
									: 
								</th>
								<th width="50%" style="font-size:14px; text-align:left;">
									'.$rowhead->namapenggiling.'
								</th>
							</tr>

							<tr>
								<th width="40%" style="font-size:14px; text-align:left;">
									Alamat Gudang
								</th>
								<th width="10%" style="font-size:14px; text-align:left;">
									: 
								</th>
								<th width="50%" style="font-size:14px; text-align:left;">
									'.$rowhead->alamatgudang.'
								</th>
							</tr>
							<tr>
								<th width="40%" style="font-size:14px; text-align:left;">
									Pemilik Remahan
								</th>
								<th width="10%" style="font-size:14px; text-align:left;">
									: 
								</th>
								<th width="50%" style="font-size:14px; text-align:left;">
									'.$rowhead->pemilikremahan.'
								</th>
							</tr>
						</thead>
					</table>


				</th>
			</tr>
		</thead>
	</table>
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
	<div style="text-align: center; font-size: 24px; background-color: #ACACAC;">
		<span style="padding-top: 10px;">NOTA GILING</span>
	</div>
';


$table  .= '<br><br><table border="1" cellpadding="5">';


$table .= ' 
			<thead>
				<tr style="font-size:14px; font-weight:bold;">
					<th width="5%" style="text-align:center;">NO</th>
					<th width="50%" style="text-align:center;">JENIS BARANG</th>
					<th width="15%" style="text-align:center;">JUMLAH BAHAN (KG)</th>
					<th width="15%" style="text-align:center;">BANYAK HASIL (KG)</th>					
					<th width="15%" style="text-align:center;">JUMLAH SELISIH (KG)</th>
				</tr>
			</thead>
			<tbody>';

$no = 1;
$subtotalberatbahan = 0;

$rsdetail = $this->db->query("select * from v_bahankeluardetail where idbahankeluar='".$rowhead->idbahankeluar."'");
if ($rsdetail->num_rows()>0) {
	
	foreach ($rsdetail->result() as $rowdetail) {
		
		$selisih = $rowdetail->beratbahankeluar - $rowdetail->beratbahanhasil;
		$table .= '<tr style="font-size:12px;">
						<td width="5%" style="text-align:center;">'.$no++.'</td>
						<td width="50%" style="text-align:left;">'.$rowdetail->namabahan.'</td>
						<td width="15%" style="text-align:center;">'.$rowdetail->beratbahankeluar.'</td>
						<td width="15%" style="text-align:center;">'.$rowdetail->beratbahanhasil.'</td>
						<td width="15%" style="text-align:center;">'.$selisih.'</td>
					</tr>
					';
		$subtotalberatbahan += $rowdetail->beratbahanhasil;
	}

	$table .= '<tr style="font-size:12px;">
						<td width="70%" style="text-align:center;" colspan="3">TOTAL SELURUH HASIL PRODUKSI</td>
						<td width="15%" style="text-align:center;">'.$subtotalberatbahan.'</td>
						<td width="15%" style="text-align:center;"></td>
					</tr>
					';

}else{
	$table .= '<tr style="font-size:12px;">
					<td width="100%" style="text-align:center;" colspan="5">Data tidak ditemukan...</td>
				</tr>
					';
}



$table .= ' </tbody>
			</table>';

$table .= '
	<div style="text-align: left; font-size: 14px;">
		<br><br>Keterangan : '.$rowhead->keterangan.'
	</div>
';


$table  .= '';


$table .= ' <br>
			<table border="0" cellpadding="5">
				<thead>
					<tr style="background-color:#ccc; font-size:14px;">
						<th width="33%" style="text-align:center;">Diserahkan Oleh:</th>
						<th width="33%" style="text-align:center;">Diterima Oleh:</th>
						<th width="34%" style="text-align:center;">Disetujui Oleh:</th>
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
						<th width="33%" style="text-align:center;">'.$rowhead->diserahkanoleh.'</th>
						<th width="33%" style="text-align:center;">'.$rowhead->diterimaoleh.'</th>
						<th width="34%" style="text-align:center;">'.$rowhead->disetujuioleh.'</th>
					</tr>
				</thead>
			<table>';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');


$tglcetak = date('d-m-Y');



$pdf->Output();
?>
