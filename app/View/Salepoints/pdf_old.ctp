<?php

require_once APP.'Vendor'.DS.'dompdf'.DS.'dompdf_config.inc.php';
$today = date('d-m-Y');
$ville = (isset($this->data['Client']['Ville']['id']) and !empty($this->data['Client']['Ville']['id'])) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '';
//$ice = (isset( $this->data['Client']['ice'] ) AND !empty( $this->data['Client']['ice'] )) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '' ;
$nom = (isset($this->data['Client']['designation'])) ? $this->data['Client']['designation'] : '';
$adresse = (isset($this->data['Client']['adresse'])) ? str_replace(["\n", "\r"], '', $this->data['Client']['adresse']) : '';
$ice = (isset($this->data['Client']['ice'])) ? $this->data['Client']['ice'] : '';
$MT_TTC=$this->data['Salepoint']['total_apres_reduction'] - $this->data['Salepoint']['montant_remise'] + $this->data['Salepoint']['fee'];
$MT_TVA=$this->data['Salepoint']['montant_tva']+$this->data['Salepoint']['fee']/1.2;
$MT_HT=$MT_TTC-$MT_TVA;
$FRAIS_LIV=$this->data['Salepoint']['fee'];
$html = '
<style>
.tabledesc {
    margin-bottom : -2rem;
}
.tabledesc tr th:first-child,
.tabledesc tr td:first-child {
  border-left: 1px solid #bbb;
}
.tabledesc tr th {
  background: #eee;
  border-top: 1px solid #bbb;
  text-align: left;
}
table tr th {
    background: #eee;
    
  }
/* top-left border-radius */
.tabledesc tr:first-child th:first-child {
  border-top-left-radius: 6px;
}
/* top-right border-radius */
.tabledesc tr:first-child th:last-child {
  border-top-right-radius: 6px;
}
/* bottom-left border-radius */
.tabledesc tr:last-child td:first-child {
  border-bottom-left-radius: 6px;
}
/* bottom-right border-radius */
.tabledesc tr:last-child td:last-child {
  border-bottom-right-radius: 6px;
}
.rounded {
    word-wrap: break-word;
border: 1.5px solid #232222;
  border-radius: 10px;
  position: absolute;
  bottom: 45.6rem;
  right: 1rem;
  margin-right : 0.5rem;
  float : right;
  width : 40%;
  padding : 0 1rem;
  padding-bottom : 0.8rem
}
.rounded p {
    padding-bottom : -0.5rem;
    
}
.tabledesc th , tr {
  font-size : 80% !important;
}
</style>
<html>
<head>
    <title>VENTE N° : '.$this->data['Salepoint']['reference'].'</title>
    '.$this->element('style').'
</head>
<body>
    '.$this->element('header', ['societe' => $societe, 'title' => 'VENTE']).'
    '.$this->element('footer', ['societe' => $societe]).'
    <div>
    
    <table style="position : relative; top : -1.5rem;margin-top : 1.6rem;width : 15rem;" class="table details table-responsive tabledesc">
    <caption style="    font-weight: bold;
    position: relative;
    left: -10rem;font-size : 110%">Facture</caption>
    <thead>
    <tr>
      
      <th scope="col" style="width : 6rem">Date</th>
      <th scope="col" style="width : 7rem">Facture/ticket N°</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td scope="row">'.date('d-m-Y', strtotime($this->data['Salepoint']['date'])).'</td>
      <td>'.$this->data['Salepoint']['reference'].'</td>
    </tr>
    </tbody>
    <div class="rounded">
            <p style="font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">Client: </p>
        <p style="font-size : 80%">'.$nom.'</p>
        <p style="font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">Adresse: </p>
        <p style="margin-right : -1 rem;font-size : 80%">'.$adresse.'</p>
        
        <p style="font-weight : bold;display : inline;color : #282525;text-decoration : underline;font-size : 95%">ICE : </p>
        <p style="display : inline;margin-right : -1 rem;font-size : 80%">'.$ice.'</p>
        
        </div> 
    </table>
       
       
        <table style="margin-top : 2rem" class="details" width="100%">
            <thead>
                <tr>
                    <th nowrap="">Désignation </th>
                    <th nowrap="">Quantité </th>
                    <th nowrap="">Prix</th>
                    <th nowrap="">Remise(%)</th>
                    <th nowrap="">Montant total</th>
                </tr>
            </thead>
            <tbody>';
                foreach ($details as $tache) {
                    $html .= '<tr> 
                        <td nowrap style="width:70%;border:0px">'.$tache['Produit']['libelle'].'</td>
                        <td nowrap style="text-align:right;border:0px">'.number_format($tache['Salepointdetail']['qte'], 2, ',', ' ').'</td>
                        <td nowrap style="text-align:right;border:0px">'.number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' ').'</td>
                        <td nowrap style="text-align:right;border:0px">'.(int) $tache['Salepointdetail']['remise'].'%</td>
                        
                        <td nowrap style="text-align:right;border:0px">'.number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ').'</td>
                    </tr>  ';
                }
                $html .= '</tbody>
                </table> </div>
                   
                <div style="position : relative; float : left; margin-left : 0.9rem">
                        <h3 style="width:50%;text-align:left;font-size : 90%;">
                            Arrêtée la présente facture à la somme de :
                        </h3>
                        <p style="width:50%;text-align:left">
                            '.strtoupper($this->Lettre->NumberToLetter(strval($MT_TTC))).'
                        </p>
                        </div>  
                <div style="margin-top : 1rem; margin-right : 1rem; text-align : right">
                 <p style="display : inline;font-weight : bold;color : #282525;font-size : 95%;margin-right : 5.4rem;">Frais de livraison: </p>
                <p style="display : inline;font-size : 95%">'.number_format($FRAIS_LIV, 2, ',', ' ').'</p>
                <br><br>

                <p style="display : inline;font-weight : bold;color : #282525;font-size : 95%;margin-right : 6.8rem;">TOTAL  HT: </p>
                <p style="display : inline;font-size : 95%">'.number_format($MT_HT, 2, ',', ' ').'</p><br><br>


                <p style="display : inline;font-weight : bold;color : #282525;font-size : 95%;margin-right : 4rem;">TOTAL TVA ('.$societe['Societe']['tva'].'%) : </p>
                <p style="display : inline;font-size : 95%">'.number_format($MT_TVA, 2, ',', ' ').'</p> <br><br>
           
           
                <p style="display : inline;font-weight : bold;color : #282525;font-size : 95%;margin-right : 6rem;">TOTAL TTC : </p>
                <p style="display : inline;font-size : 95%">'.number_format($MT_TTC, 2, ',', ' ').'</p>
               
                </div>
                       
          
        
   
    '.$this->element('footer', ['societe' => $societe]).'
</body>
</html>';
//echo $html;die;
$pdfName = 'Salepoint.'.$this->data['Salepoint']['date'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$canvas = $dompdf->get_canvas();
$font = Font_Metrics::get_font('helvetica', 'bold');
$canvas->page_text(512, 820, 'Page : {PAGE_NUM}/{PAGE_COUNT}', $font, 8, [0, 0, 0]);
$dompdf->stream($pdfName, ['Attachment' => 0]);
exit;
