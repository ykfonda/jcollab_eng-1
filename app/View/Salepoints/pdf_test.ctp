<?php $today = date("d-m-Y");
$ville = (isset( $this->data['Client']['Ville']['id'] ) AND !empty( $this->data['Client']['Ville']['id'] )) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '' ;
//$ice = (isset( $this->data['Client']['ice'] ) AND !empty( $this->data['Client']['ice'] )) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '' ;
$nom = (isset( $this->data['Client']['designation'] )) ? $this->data['Client']['designation'] : "";
$adresse = (isset( $this->data['Client']['adresse'] )) ? str_replace(array("\n", "\r"), '', $this->data['Client']['adresse']) : "";
$ice = (isset( $this->data['Client']['ice'] )) ? $this->data['Client']['ice'] : "";
?>
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
    bottom: 22rem;
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
    <title>VENTE N° : <?php echo $this->data['Salepoint']['reference'] ?></title>
     <?php echo $this->element('style') ?>
</head>
<body>
     <?php echo $this->element('header',['societe' => $societe,'title' => 'VENTE']) ?>
     <?php echo $this->element('footer',['societe' => $societe]) ?>
    <div>
    <table style="position : relative; bottom : 1rem;margin-top : 1.6rem;width : 15rem;" class="table details table-responsive tabledesc">
    <caption style="    font-weight: bold;
    position: relative;
    right: 5.3rem;">Facture</caption>
    <thead>
    <tr>
      
      <th scope="col">Date</th>
      <th scope="col">Ticket N°</th>
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <td scope="row"> <?php echo $this->data['Salepoint']['date'] ?></td>
      <td> <?php echo $this->data['Salepoint']['reference'] ?></td>
    </tr>
    </tbody>
   
    </table>
       
    <div class="rounded">
        <p style="font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">Client</p>
        <p style="font-size : 80%"> <?php echo $nom ?></p>
        <p style="font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">Adresse</p>
        <p style="margin-right : -1 rem;font-size : 80%"> <?php echo $adresse ?></p>
        
        <p style="font-weight : bold;display : inline;color : #282525;text-decoration : underline;font-size : 95%">ICE : </p>
        <p style="display : inline;margin-right : -1 rem;font-size : 80%"> <?php echo $ice ?></p>
        
        </div> 
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
            <tbody>
                <?php foreach ($details as $tache) : ?>
                    <tr>
                        <td nowrap> <?php echo $tache['Produit']['libelle'] ?></td>
                        <td nowrap style="text-align:right;"> <?php echo $tache['Salepointdetail']['qte'] ?></td>
                        <td nowrap style="text-align:right;"> <?php echo number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' ') ?></td>
                        <td nowrap style="text-align:right;"> <?php echo (int)$tache['Salepointdetail']['remise'] ?>%</td>
                        <td nowrap style="text-align:right;"> <?php echo number_format($tache['Salepointdetail']['total'], 2, ',', ' ') ?></td>
                    </tr>  
                    <?php endforeach; ?>
                </tbody>
                </table> </div>
                   
                <div style="position : relative; float : left; margin-left : 0.9rem">
                        <h3 style="width:50%;text-align:left;font-size : 90%;">
                            Arrêtée la présente de la vente à la somme de :
                        </h3>
                        <p style="width:50%;text-align:left">
                             <?php echo strtoupper( $this->Lettre->NumberToLetter( strval($this->data['Salepoint']['total_apres_reduction']) ) ) ?> DHS
                        </p>
                        </div>  
                <div style="margin-top : 1rem; margin-right : 1rem; text-align : right">
                <p style="display : inline;font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">TOTAL TVA ( <?php echo $societe['Societe']['tva'] ?>%) : </p>
                <p style="display : inline;font-size : 95%"> <?php echo number_format($this->data['Salepoint']['montant_tva'], 2, ',', ' ') ?></p> <br><br>
                <p style="display : inline;font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">TOTAL REMISE( <?php echo $this->data['Salepoint']['remise'] ?>%) : </p>
                <p style="display : inline;font-size : 95%"> <?php echo number_format($this->data['Salepoint']['montant_remise'], 2, ',', ' ') ?></p><br><br>
           
                <p style="display : inline;font-weight : bold;color : #282525;text-decoration : underline;font-size : 95%">TOTAL TTC : </p>
                <p style="display : inline;font-size : 95%"> <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' ') ?></p><br><br>
               
                </div>
                       
          
        
   
    <?php echo $this->element('footer',['societe' => $societe]) ?>
</body>
</html>