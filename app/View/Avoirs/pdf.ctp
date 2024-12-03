<?php
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
$today = date("d-m-Y");
$html = '
<html>
<head>
	<title>Avoir</title>
</head>
<style>
    .container{
        padding: 10px;
    }
    .info, .data{
        margin-top: 40px;
    }
    .data{
        margin: auto;
        border: 1px solid #166ab3;
        border-spacing: 0;
        border-collapse: collapse;
    }
    .data th{
        background-color: #166ab3;
        padding: 5px 10px;
        color:#fff;
    }
    .data td{
        border: 1px solid #166ab3;
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    }
    .data .hidden{
        visibility: hidden;
    }

    .details div{
        padding: 8px 0;
    }
    .details .ps{
    	font-size: 12px;
    	text-align:left;
    }
    .rols{
        position: relative;
        text-align: center;
        font-size: 13px;
    }

    .signature{
        text-align: center;
        margin: auto;
        overflow: auto;
    }
    .signature div{
        text-align: left;
    }
    .signature .signature-left{
        width: 48%;
        float: left;
        margin-right: 10px;
        border:1px solid #166ab3;
        min-height: 120px;
    }
    .signature .signature-right{
        width: 50%;
        float: right;
        border:1px solid #166ab3;
        min-height: 120px;
    }
    .signature h3{
        background-color: #166ab3;
        color: #fff;
        padding: 3px 0;
        text-transform: uppercase;
        text-align: center;
        margin-top: 0;
    }
    .signature-left div, .signature-right div{
        padding-left: 20px;
    }
    .ps{
        text-align: center;
        margin-top: 10px;
    }
    .ps p{
        margin: 0;
        color: red;
        font-weight: bold;
    }
    div .ps {
        margin-top: 8px;
        font-size: 11px;
    }
</style>
<body>
    <div class="container">
        '.$this->element('header',['societe' => $societe,'title' => 'AVOIR']).'

        <table class="info" width="100%">
            <tbody>
                <tr>
                    <td width="50%">AVOIR N° : '.$this->data['Avoir']['reference'].'</td>
                    <td width="50%">Date : '.$this->data['Avoir']['date'].'</td>
                </tr>
            </tbody>
        </table>

        <table class="info" width="100%">
            <tbody>
                <tr>
                    <td width="50%">Nom:  '.$this->data['Client']['designation'].' </td>
                    <td width="50%">Téléphone: '.$this->data['Client']['telmobile'].'</td>
                </tr>
                <tr>
                    <td colspan="2">Adress: '.$this->data['Client']['adresse'].'</td>
                </tr>
            </tbody>
        </table><br/>

        <table class="info data" width="100%">
            <thead>
                <tr>
                    <th width="50%">Désignation </th>
                    <th width="16%">Quantité </th>
                    <th width="16%">Prix Unitaire HT </th>
                    <th width="16%">Montant Total HT</th>
                </tr>
            </thead>
            <tbody>';
                $total = 0;$total_ttc = 0;
                foreach ($details as $tache){
                    $total = $total + $tache['Avoirdetail']['total'];
                    $total_ttc = $total_ttc + $tache['Avoirdetail']['ttc'];
                    $html.='<tr>
                        <td width="50%">'.$tache['Produit']['libelle'].'</td>
                        <td width="16%">'.$tache['Avoirdetail']['qte'].'</td>
                        <td width="16%" style="text-align:right;">'.number_format($tache['Avoirdetail']['prixachat'], 2, ',', ' ').'</td>
                        <td width="16%" style="text-align:right;">'.number_format($tache['Avoirdetail']['total'], 2, ',', ' ').'</td>
                    </tr>';
                }
                $html .= '
                    <tr>
                        <td width="50%" style="border:none;"></td>
                        <td width="16%" style="border:none;"></td>
                        <td width="16%">Total HT</td>
                        <td width="16%" style="text-align:right;">'.number_format($total, 2, ',', ' ').'</td>
                    </tr>
                    <tr >
                        <td width="50%" style="border:none;"></td>
                        <td width="16%" style="border:none;"></td>
                        <td width="16%">TVA</td>
                        <td width="16%" style="text-align:right;">20%</td>
                    </tr>
                    <tr >
                        <td width="50%" style="border:none;"></td>
                        <td width="16%" style="border:none;"></td>
                        <td width="16%">Total TTC</td>
                        <td width="16%" style="text-align:right;">'.number_format($total_ttc, 2, ',', ' ').'</td>
                    </tr>
            </tbody>
        </table>
    </div>
    <div style="text-align: center; position: fixed;left: 0;bottom: 4;width: 100%;padding: 2px;">
        <strong> ICE : </strong>'.$societe['Societe']['ice'].'
        <strong>  - RC : </strong>'.$societe['Societe']['registrecommerce'].'
        <strong> - Patente : </strong>'.$societe['Societe']['patent'].'
        <strong> - IF : </strong>'.$societe['Societe']['idfiscale'].'
    </div>
</body>
</html>';
//echo $html;die;
$pdfName = 'Avoir.'.$this->data['Avoir']['date'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$canvas = $dompdf->get_canvas(); 
$font = Font_Metrics::get_font("helvetica", "bold"); 
$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
$dompdf->stream($pdfName,array('Attachment'=>0));
exit;
?>