<?php
require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');
$today = date("d-m-Y");
if($this->data['Mouvementprincipal']['type'] == "Expedition" and ($this->data['DepotSource']['Societe']['designation'] != $this->data['DepotDestination']['Societe']['designation'])) 
  $type =  "Bonlivraison";
else if($this->data['Mouvementprincipal']['type'] == "Expedition" and ($this->data['DepotSource']['Societe']['designation'] == $this->data['DepotDestination']['Societe']['designation'])) 
  $type =  "Bontransfert";
else {
  $type = "Facture";
} 
if($this->data['Mouvementprincipal']['type'] == "Expedition" and ($this->data['DepotSource']['Societe']['designation'] != $this->data['DepotDestination']['Societe']['designation'])) 
  $sous_type = "Bl";
else if($this->data['Mouvementprincipal']['type'] == "Expedition" and ($this->data['DepotSource']['Societe']['designation'] == $this->data['DepotDestination']['Societe']['designation'])) 
  $sous_type = "Bt";
else {
  $sous_type  = "sortie";
} 
 

  // Traitement de titre du document
  $type_doc = $this->data['Mouvementprincipal']['type'];
  if ($type_doc == 'Sortie en masse') {
    $titre = "Sortie en masse";
    $class_titre = "titre1";
  }
  if ($type_doc == 'Expedition') {
    $titre = "Expedition";
    $class_titre = "titre2";
  }



// $titre = ($this->data['Mouvementprincipal']['type'] == "Expedition") ? "titre1" : "titre2";




$html = '
<style>
.titre1 {
  position: relative;
    left: -6.8rem;
}
.titre2 {
  position: relative;
  left: -8.0rem;
}
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
  padding-bottom : 0.8rem;
  padding-top : 1rem;
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
    <title>SORTIE N° : '.$this->data['Mouvementprincipal']['reference'].'</title>
    '.$this->element('style').'
</head>
<body>
    '.$this->element('header',['societe' => $societe,'title' => 'VENTE']).'
    '.$this->element('footer',['societe' => $societe]).'
    <div>
    
    <table style="position : relative; top : -1.5rem;margin-top : 1.6rem;width : 15rem;" class="table details table-responsive tabledesc">
    <caption class="'.$class_titre.'" style="font-weight: bold;
    font-size : 110%"> Type : '.$titre.'</caption>
    
    <thead>
    <tr>
      <th scope="col" style="width : 6rem">Date</th>
      <th scope="col" style="width : 7rem"> Référence N°</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td scope="row">'.date("d-m-Y",strtotime($this->data['Mouvementprincipal']['date'])).'</td>
      <td>'.$this->data['Mouvementprincipal']['reference'].'</td>
    </tr>
    </tbody>
    <div class="rounded">
        <p style=";display : inline;font-weight : bold;color : #282525;font-size : 95%">Dépot source : &nbsp&nbsp</p>
        <p style="margin-bottom : 3rem;display : inline;margin-right : -1 rem;font-size : 80%">'.$this->data['DepotSource']['Societe']['designation'] . " / " . $this->data['DepotSource']['libelle'].'</p>
        <p style="height : 1px"></p>
        <p style="font-weight : bold;display : inline;color : #282525;font-size : 95%">Dépot destination : &nbsp&nbsp</p>
        <p style="display : inline;margin-right : -1 rem;font-size : 80%">'.$this->data['DepotDestination']['Societe']['designation'] . " / " .$this->data['DepotDestination']['libelle'].'</p>
        
        </div> 
    </table>
       
       
        <table style="margin-top : 2rem" class="details" width="100%">
            <thead>
                <tr>
                    <th nowrap="">Désignation </th>
                    <th nowrap="">Quantité </th>
                    <th nowrap="">Prix</th>
                    <th nowrap="">Montant total</th>
                </tr>
            </thead>
            <tbody>';
                $total = 0;
                foreach ($details as $tache){
                    $html.='<tr>
                        <td nowrap>'.$tache['Produit']['libelle'].'</td>
                        <td nowrap style="text-align:right;">'.number_format($tache['Sortiedetail']['stock_source'], 3, ',', ' ').'</td>
                        <td nowrap style="text-align:right;">'.number_format($tache['Produit']['prixachat'], 2, ',', ' ').'</td>
                        <td nowrap style="text-align:right;">'.number_format($tache['Produit']['prixachat'] * $tache['Sortiedetail']['stock_source'], 2, ',', ' ').'</td>
                    </tr>  ';
                    $total += ($tache['Produit']['prixachat'] * $tache['Sortiedetail']['stock_source']);
                }

                $html .= '</tbody>
                </table> </div>
                   
                <div style="position : relative; float : left; margin-left : 0.9rem">
                        <h3 style="width:50%;text-align:left;font-size : 90%;">
                            Arrêtée la présente de la vente à la somme de :
                        </h3>
                        <p style="width:50%;text-align:left">
                            '.strtoupper( $this->Lettre->NumberToLetter( strval($total) ) ).'
                        </p>
                        </div>  
                <div style="margin-top : 1rem; margin-right : 1rem; text-align : right">
               
                <p style="display : inline;font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">TOTAL HT : </p>
                <p style="display : inline;font-size : 95%">'.number_format($total, 2, ',', ' ').'</p><br><br>
               
                </div>
                       
          
        
   
    '.$this->element('footer',['societe' => $societe]).'
</body>
</html>';
//echo $html;die;
$pdfName = 'Salepoint.'.$this->data['Mouvementprincipal']['date'].'.pdf';
$dompdf = new DOMPDF();
$dompdf->load_html($html);

$dompdf->render();
$canvas = $dompdf->get_canvas(); 
$font = Font_Metrics::get_font("helvetica", "bold"); 
$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
$dompdf->stream($pdfName,array('Attachment'=>0));
exit;
?>