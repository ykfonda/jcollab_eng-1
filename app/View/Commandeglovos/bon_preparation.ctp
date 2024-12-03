<?php

require_once APP.'Vendor'.DS.'dompdf'.DS.'dompdf_config.inc.php';
$pickup = isset($commande['Commandeglovo']['pick_up_code']) ? $commande['Commandeglovo']['pick_up_code'] : '';
$order_code = isset($commande['Commandeglovo']['order_code']) ? $commande['Commandeglovo']['order_code'] : '';
$client = isset($commande['Client']['designation']) ? $commande['Client']['designation'] : '';
$html = '<style>
   .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th, .table:not(.table-dark):not(.table-light) tfoot:not(.thead-dark) th {
    background-color: #ffffff;
    }
    .table thead th {
  border-bottom: 0.2rem solid #645353;
  
}
</style>

<html>
<head>
	<title>Bon preparation</title>
    
</head>
<body>

   <h1 style="margin-top: 3rem !important;display: inline-block;font-size: 164%;
    margin-left: 30%;margin-right : 35%;padding: 0.2rem 0rem;color : white;text-align: center;border-style: none;background-color: #453f3f;">Bon de preparation</h1>
    <br> <br>
    <div style="margin-left: 6%;    margin-right: 10%;">

        <div style="display : inline-block">
                        <p class="container" style="text-shadow: 0.5px 0 currentColor;
                        letter-spacing: -0.5px;font-weight : bold;display:inline;font-size:130%;">Pickup : '.$pickup.'</p><br>

                        <p class="container" style="text-shadow: 0.5px 0 currentColor;
                        letter-spacing: -0.5px;font-weight : bold;display:inline;font-size:130%;">Commande : '.$order_code.'</p><br>
                   
                        <p class="container" style="text-shadow: 0.5px 0 currentColor;
                        letter-spacing: -0.5px;font-weight : bold;display:inline;font-size:130%;">Client : '.$client.'</p><br><br>
                   
                        </div>
                        <br> <br>
                        <hr style="border: 0.2rem solid #f1ecec;
    border-radius: 5px;
    background-color: #f1ecec;">
                    
    <br>
    

    <h3 style="font-size : 130%">Produits</h3>
        <table class="table" style="border-collapse: collapse;" width="100%">
            <thead>
                <tr>
                    <th nowrap="">Code barre </th>
                    <th nowrap="">Nom produit </th>
                    <th nowrap="">Condt </th>
                    <th nowrap="">Qte commandée</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($commande['Commandeglovodetail'] as $tache) {
                $html .=
              '<tr>
                        <td nowrap style="text-align : left">'.$tache['product_barcode'].'</td>
                        <td nowrap style="text-align : left">'.$tache['Produit']['libelle'].'</td>
                        <td nowrap style="padding-right : 2.5rem;text-align:right;">'.number_format($tache['Produit']['conditionnement'], 3, ',', ' ').'</td>
                        <td nowrap style="padding-right : 2.5rem;text-align:right;">'.number_format($tache['quantity'], 3, ',', ' ').'</td>
                    </tr>
                    ';
            }
                $html .= '   
            </tbody>
        </table>

        </div>

    </div>

  
</body>
</html>';
//echo $html;die;
$pdfName = 'Commandeglovos.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);

$dompdf->render();
$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font('helvetica', 'bold');
$canvas->page_text(512, 820, 'Page : {PAGE_NUM}/{PAGE_COUNT}', $font, 8, [0, 0, 0]);
$dompdf->stream($pdfName, ['Attachment' => 0]);
exit;
