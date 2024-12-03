<?php require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php'); ?>
<?php
$today = date("d-m-Y");
$html = '
<html>
<head>
	<title>Fiche recette</title>
</head>
<style>
body
{
	font-family: sans-serif;
	font-size: 12px;
}
table,div
{
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
.table 
{
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
<body>
<div class="global">
<table class="table table-bordered tableHeadInformation tableHead120">
	<tr>
		<td class="tableHead">Référence</td><td>'.$this->data['Produit']['reference'].'</td>
		<td class="tableHead">Libellé</td><td>'.$this->data['Produit']['libelle'].'</td>
	</tr>
	<tr>
		<td class="tableHead">Prix d\'achat</td><td>'.$this->data['Produit']['prixachat'].'</td>
		<td class="tableHead">Date création</td><td>'.$this->data['Produit']['date'].'</td>
	</tr>
	<tr>
		<td class="tableHead">Description</td><td colspan="3">'.$this->data['Produit']['description'].'</td>
	</tr>
</table><br/>';
if ( isset( $this->data['Emvtstock'] ) AND !empty($this->data['Emvtstock']) ) {
$html .= '<table class="table table-bordered tableHeadInformation tableHead120">
	<tr>
	  <th nowrap="">Date</th>
      <th nowrap="">Opération</th>
      <th nowrap="">Prix d\achat</th>
      <th nowrap="">Stock avant</th>
      <th nowrap="">Quantité</th>
      <th nowrap="">Stock aprés</th>
      <th nowrap="">Description</th>
	</tr>';
	foreach ($this->data['Emvtstock'] as $tache){
		$html .= '
		<tr>
			 <td>'.$tache['date'].'</td>
              <td>'.$this->Article->getOperation($tache['type']).'</td>
              <td>'.$tache['prixachat'].'</td>
              <td>'.$tache['stock_avant'].'</td>
              <td>'.$tache['qte'].'</td>
              <td>'.$tache['stock_apres'].'</td>
              <td>'.$tache['description'].'</td>
        </tr>
		';
	}
$html .= '</table>';
}
$html .= '</div>
</body>
</html>';
//echo $html;die;
$pdfName = 'fichearticle.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$canvas = $dompdf->get_canvas(); 
$font = Font_Metrics::get_font("helvetica", "bold"); 
$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
$dompdf->stream($pdfName,array('Attachment'=>1));
exit();
?>



