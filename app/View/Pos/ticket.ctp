<html>
    <head>
    	<title>VENTE N° : <?php echo $this->data['Salepoint']['reference']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket', ['societe' => $societe]); ?>
    </head>
    <body>


<!---   TICKET VENTE DIRECT ------>


<style>
body, .DivIdToPrint {
    margin: 0;
    padding: 0;
    font-size: 13px;
    font-weight: bold;
    background-color: #fff;
    font-family: Calibri Light !important;
    border:none !important;
}

.print-ticket, .print-ticket-impr{
	background: #4ccf3d;
    font-weight: 600;
    color: white;
}

</style>







<script>
	
    $('#edit').on('click','.print-ticket-impr',function(e){
			e.preventDefault();
			var url = $(this).attr('href');
		    $.ajax({
		      url: url,
		      success: function(dt){
		      	$('#edit').modal('hide');
                var divToPrint=document.getElementById('DivIdToPrint');

                // Appliquer des styles spécifiques à l'élément "DivIdToPrint" lors de l'impression
                divToPrint.style.border = 'none'; // Supprimer la bordure
                divToPrint.style.padding = '0'; // Supprimer le padding

                var newWin=window.open('','Print-Window');
                newWin.document.open();
                newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                newWin.document.close();
                setTimeout(function(){newWin.close();},10);
              }
		    });
		
	});
</script>

    <div class="paragraph">

    	<br />
    		<center>
       			 <input type='button' class='btn btn-default btn-lg print-ticket-impr' id='btn' value='Imprimer ticket' href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'printed', $this->data['Salepoint']['id']]); ?>">
    	    </center>
    	<br />
    </div>




<div id='DivIdToPrint'>
        <?php echo $this->element('pos-ticket-style', ['societe' => $societe]); ?>
        <div class="col-md-12">
            <div id='printbox' class="printme">
                
                <?php echo $this->element('header-ticket', ['societe' => $societe, 'title' => 'TICKET']); ?>

                <div>
                    TICKET N° : 
                	<?php
                     echo $this->data['Salepoint']['reference']; ?> 
                </div>
                
                <div>
                    CLIENT : <?php echo $this->data['Client']['designation']; ?><br/>
                    <?php if (isset($this->data['Client']['adresse']) and !empty($this->data['Client']['adresse'])): ?>
                    <?php echo $this->data['Client']['adresse']; ?><br/>    
                    <?php endif; ?>
                     <?php if (isset($this->data['Client']['telmobile']) and !empty($this->data['Client']['telmobile'])): ?>
                    TEL : <?php echo $this->data['Client']['telmobile']; ?>
                    <?php endif; ?>

                </div>
                <br/>
                <table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" width="80px">Désignation</th>
                        <th nowrap="">Qte</th>
                        <th nowrap="">Prix</th>
                        <th nowrap="">R(%)</th>
                        <th nowrap="">Total</th>
                    </tr>
                    <?php foreach ($details as $tache): ?>
                    <tr>
                    <td style="text-align: left;"><?php echo $tache['Produit']['libelle']; ?></td>
                        <td nowrap=""><?php echo $tache['Salepointdetail']['qte']; ?></td>
                        <?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['unit_price'], 2, ',', ' '); ?></td>
                        <?php else : ?>
                            <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' '); ?></td>
                        <?php endif; ?>    
                        <td nowrap="" style="text-align: right;"><?php echo (int) $tache['Salepointdetail']['remise']; ?>%</td>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' '); /* echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') */ ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php if (isset($this->data['Salepoint']['glovo_id'])) : ?>
                <div class="list_valeurs_ticket"> 
                    Commande glovo : <?php echo $this->data['Commandeglovo']['order_code'] ?>
                </div>
                <?php endif ?>
            
                <div class="list_valeurs_ticket"> 
                    Montant : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' '); ?>
                </div>

                <?php if ($this->data['Salepoint']['etat'] == 3) :  ?>
                <div class="list_valeurs_ticket"> 
                    Mode de paiement : <?php echo ''; ?>
                </div>
                <?php else : ?>
                <div class="list_valeurs_ticket"> 
                    <!--Mode de paiement : --> <?php /* echo $modes */   ?> <?php if (strpos($modes, "Bon d'achat") !== false) {
                         echo  $ref_bon_achat;
                     } elseif (strpos($modes, 'Chèque cadeau') !== false) {
                         echo   $ref_cheque_cad;
                     } ?>
                </div>
                <?php endif; ?>
                
                <div class="list_valeurs_ticket"> 
                    Frais : <?php echo number_format($this->data['Salepoint']['fee'], 2, ',', ' '); ?>
                </div>

                <?php if ($this->data['Salepoint']['etat'] == 3) :  ?>
                <div class="list_valeurs_ticket"> 
                    Remise : <?php echo number_format(0, 2, ',', ' '); ?>
                </div>
                <?php else : ?>
                <div class="list_valeurs_ticket"> 
                    Remise : <?php /* if($this->data['Salepoint']['check_cad'] == 1 or $this->data['Salepoint']['check_mode'] == 1)  echo "0.00"; else */ echo number_format($this->data['Salepoint']['total_a_payer_ttc'] - $this->data['Salepoint']['total_paye'], 2, ',', ' '); ?>
                </div>
                <?php endif; ?>

                <?php if ($this->data['Salepoint']['etat'] == 3) :  ?>
                <div class="list_valeurs_ticket"> 
                    NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_apres_reduction'], 2, ',', ' '); ?>
                </div>
                <?php else : ?>
                <div class="list_valeurs_ticket"> 
                    NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_paye'] + $this->data['Salepoint']['fee'], 2, ',', ' '); ?>
                </div>

                <?php if (isset($this->data['Salepoint']['check_cad']) and !empty($this->data['Salepoint']['check_cad'])) :  ?>
                <div class="list_valeurs_ticket"> 
                    Veuillez recuperer votre Cheque cadeau de <?php echo $this->data['Chequecadeau']['montant']; ?> Dhs num : <?php echo $this->data['Chequecadeau']['reference']; ?>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php if (isset($this->data['Salepoint']['client_id']) and $this->data['Salepoint']['client_id'] != 1) : ?>
                    <div class="list_valeurs_ticket"> 
                    Points  fidélité : <?php echo $this->data['Client']['points_fidelite']; ?>
                </div>
                <?php endif; ?>
                    <?php echo $this->element('footer-ticket', ['details_tva' => $details_tva, 'societe' => $societe, 'avances' => $avances]); ?>
            </div>
        </div>
           
 </div>


<div class="modal-footer no-printme">
    <button type="button" class="btn btn-default btn-lg print-ticket" href="<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'printed', $this->data['Salepoint']['id']]); ?>">Terminer & Fermer</button>
</div>


    </body>
</html>