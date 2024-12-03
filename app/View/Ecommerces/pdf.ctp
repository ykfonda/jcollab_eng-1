<?php
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
$today = date("d-m-Y");
$ville = (isset( $this->data['Client']['Ville']['id'] )) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '' ;
$ice = (isset( $this->data['Client']['id'] ) AND !empty($this->data['Client']['ice'])) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '' ;
$adresse = (isset( $this->data['Client']['id'] ) AND !empty($this->data['Client']['adresse'])) ? strtoupper($this->data['Client']['adresse']).'<br/>' : '' ;
$html = '
<html>
<head>
	<title>COMMANDE - '.$this->data['Ecommerce']['barcode'].'</title>
    '.$this->element('style').'
</head>
<body>

    '.$this->element('header',['societe' => $societe,'title' => 'COMMANDE']).'

    '.$this->element('footer',['societe' => $societe]).'

    <div>

        <table class="info" width="100%">
            <tbody>
                <tr>
                    <td style="width:50%;text-align:center;">
                        <h4 class="container" style="width:100%;">COMMANDE N° : '.$this->data['Ecommerce']['barcode'].'</h4>
                    </td>
                    <td style="width:50%;text-align:center;">
                        <h4 class="container" style="width:100%;">DATE : '.$this->data['Ecommerce']['date'].'</h4>
                    </td>
                </tr>
                <tr>
                    <td style="width:70%;text-align:center;"></td>
                    <td style="width:30%;text-align:left;">
                        <h4 class="container">
                            '.strtoupper($this->data['Client']['designation']).'<br/>
                            '.$adresse.'
                            '.$ville.'
                            '.$ice.'
                        </h4>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="details" width="100%">
            <thead>
                <tr>
                    <th nowrap="">Désignation </th>
                    <th nowrap="">Quantité </th>
                    <th nowrap="">Prix</th>
                    <th nowrap="">Montant total</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($details as $tache){
                    $html.='<tr>
                        <td nowrap>'.$tache['Produit']['libelle'].'</td>
                        <td nowrap style="text-align:right;">'.$tache['Ecommercedetail']['qte'].'</td>
                        <td nowrap style="text-align:right;">'.number_format($tache['Ecommercedetail']['prix_vente'], 2, ',', ' ').'</td>
                        <td nowrap style="text-align:right;">'.number_format($tache['Ecommercedetail']['total'], 2, ',', ' ').'</td>
                    </tr>';
                }
                $html .= '
                    <tr >
                        <td style="border:none;"></td>
                        <td style="border:none;"></td>
                        <td class="total">NET A PAYER</td>
                        <td class="total">'.number_format($this->data['Ecommerce']['total_apres_reduction'], 2, ',', ' ').'</td>
                    </tr>
            </tbody>
        </table>

        <table width="100%">
            <tbody>
                <tr>
                    <td style="width:50%;text-align:left;font-weight:bold;">
                        <u>Arrêtée la présente de commande à la somme de :</u>
                    </td>
                    <td style="width:50%;text-align:left;font-weight:bold;">
                        '.strtoupper( $this->Lettre->NumberToLetter( strval( $this->data['Ecommerce']['total_apres_reduction'] ) ) ).' DHS
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    '.$this->element('footer',['societe' => $societe]).'

</body>
</html>';
//echo $html;die;
$pdfName = 'Ecommerces.'.$this->data['Ecommerce']['date'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$canvas = $dompdf->get_canvas(); 
$font = Font_Metrics::get_font("helvetica", "bold"); 
$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
$dompdf->stream($pdfName,array('Attachment'=>0));
exit;
?>