<?php require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php'); ?>
<?php 
$html = '
<html>
<head>
<title>Fiche société</title>
<style type="text/css">
	body{
		font-family: sans-serif;
		font-size: 12px;
	}
	table,div{
		page-break-inside: avoid;
	}	
	.bold
	{
		font-weight:bold;
	}

	.justify
	{
		text-align:justify;
	}

	.header_container
	{
		padding: 5px;
		border-top: 1px solid #ddd;
		background-color:#ddd;
		border-bottom:0px solid #000;  
	}
	.signature
	{
		text-align:right;
		margin:20px 100px 0 0;
	}
	.table {
    	margin: 0 !important;
	}
	.tableHeadInformation {
	    font-size: 12px;
	}
	.table-bordered {
	    border: 1px solid #ddd;
	}
	.table {
	    width: 100%;
	    max-width: 100%;
	    margin-bottom: 20px;
	}

	table {
	    background-color: transparent;
	}
	table {
	    border-spacing: 0;
	    border-collapse: collapse;
	}

	.tableHead {
	    font-weight: bold;
	    background-color: #f9f9f9 !important;
	}
	.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
	    border: 1px solid #ddd;
	}
	td {
	    border-left-width: 0;
	    border-bottom-width: 0;
	}
	.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
	    padding: 8px;
	    line-height: 1.42857143;
	    vertical-align: top;
	    border-top: 1px solid #ddd;
	}
	.container{
		width:100%;
		padding: 15px;
		border-top: 1px solid #ddd;
	}
	.header_site{
		padding:6px;
		background-color:#fff;
		text-align:center;
		border:1px solid #ddd;
		border-bottom:none;
	}
	.global {
	  margin-left: auto;
	  margin-right: auto;
	  width: 100%;
	}
	.tableinfos{
		width: 100%;
		margin-left: auto;
	  	margin-right: auto;
		border:0px;
	}
	.tableinfos2{
		width: 100%;
		margin-left: auto;
	  	margin-right: auto;
		border:1px;
		text-align:left;
	}
	.tableinfos2 tr th{
		border:1px solid black;
	}
	.tableinfos tr th{
		text-align:left;
	}
	.tableinfos tr td{
		text-align:left;
		border:0px;
		margin:10px;
		padding:10px;
	}
	caption{
		text-align:left;
		font-weight:bold;
		margin:5px;
		padding:5px;
		font-size: 15px;
	}
</style>
</head>
<body>';
$link = str_replace('\\', '/', WWW_ROOT.'uploads\\avatar\\user\\'.$this->data['Societe']['avatar']);
$link2 = str_replace('\\', '/', WWW_ROOT.$this->data['Societe']['avatar']);
if ( isset($this->data['Societe']['avatar']) AND file_exists($link2)) {
	$html .= '
	<table class="table table-bordered tableHeadInformation tableHead120" style="width:100%;border:none;">
		<tr>
			<td><img src="'.$link2.'" width="100px"/></td>
			<td style="text-align:center;width:80%;font-size: 20px;"><h1>Fiche société</h1></td>
			<td style="text-align:right;"><img src="'.$link2.'" width="100px"/></td>
		</tr>
	</table><br/>';
}
$html .= '
	<table class="table table-bordered tableHeadInformation tableHead120">
		<tbody>
			<tr>
				<td class="tableHead">Designation</td>
				<td>'.$this->request->data['Societe']['designation'].'</td>
				<td class="tableHead">Date</td>
				<td>'.$this->request->data['Societe']['date'].'</td>
				<td class="tableHead">Capital</td>
				<td>'.$this->request->data['Societe']['capital'].'</td>
			</tr>
			<tr>
				<td class="tableHead">Identifiant fiscal</td>
				<td>'.$this->request->data['Societe']['idfiscale'].'</td>
				<td class="tableHead">CNSS</td>
				<td>'.$this->request->data['Societe']['cnss'].'</td>
				<td class="tableHead">Tel</td>
				<td>'.$this->request->data['Societe']['telfixe'].'</td>
			</tr>
			<tr>
				<td class="tableHead">Registre de commerce</td>
				<td>'.$this->request->data['Societe']['registrecommerce'].'</td>
				<td class="tableHead">Patente</td>
				<td>'.$this->request->data['Societe']['patent'].'</td>
				<td class="tableHead">ICE</td>
				<td>'.$this->request->data['Societe']['ice'].'</td>
			</tr>
			<tr>
				<td class="tableHead">Directeur général</td>
				<td>'.$this->request->data['Societe']['dg'].'</td>
				<td class="tableHead">Contact service technique</td>
				<td>'.$this->request->data['Societe']['contact_service'].'</td>
				<td class="tableHead">Contact Assistance</td>
				<td>'.$this->request->data['Societe']['contact_assistance'].'</td>
			</tr>
			<tr>
				<td class="tableHead">Nature de l\'activité</td>
				<td colspan="5">'.$this->request->data['Societe']['nature'].'</td>
			</tr>
		</tbody>
	</table>
	</body>
</html>';
$pdfName = 'fiche.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$canvas = $dompdf->get_canvas(); 
$font = Font_Metrics::get_font("helvetica", "bold"); 
$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
$dompdf->stream($pdfName,array('Attachment'=>1));
exit();
 ?>