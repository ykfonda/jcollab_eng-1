<html>
    <head>
    	<title>VENTE N° : <?php echo $this->data['Salepoint']['reference']; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php echo $this->element('style-ticket', ['societe' => $societe]); ?>
    </head>
    <body>

    <style>
        .footer-ticket{
            font-size : 12px;
        }

        .text-center {
            text-align: center !important;
        }
    </style>



        <p class="paragraph" >
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
        <div id='printbox'>
            
            <?php echo $this->element('header-ticket', ['societe' => $societe, 'title' => 'VENTE']); ?>
            
            <div>
                TICKET N° : <?php echo $this->data['Salepoint']['reference']; ?>
            </div>

            <br/>
            
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
                </table><br/>

            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Montant : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'], 2, ',', ' '); ?>
            </p>
            <?php if ($this->data['Salepoint']['etat'] != 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            <?php if (strpos($modes, "Bon d'achat") !== false) {
    echo  $ref_bon_achat;
} elseif (strpos($modes, 'Chèque cadeau') !== false) {
    echo   $ref_cheque_cad;
} ?>
                
                
            </p>
            <?php else : ?>    
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Mode de paiement : <?php echo ''; ?>
            </p>
            <?php endif; ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Frais : <?php echo number_format($this->data['Salepoint']['fee'], 2, ',', ' '); ?>
            </p>
            <?php if ($this->data['Salepoint']['etat'] == 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Remise : <?php echo number_format(0, 2, ',', ' '); ?>
            </p>
            <?php else : ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            Remise : <?php echo number_format($this->data['Salepoint']['total_a_payer_ttc'] - $this->data['Salepoint']['total_paye'], 2, ',', ' '); ?>
            </p>
            <?php endif; ?>
            <?php if ($this->data['Salepoint']['etat'] == 3) :  ?>
            <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
            NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_apres_reduction'], 2, ',', ' '); ?>
            </p>
            <?php else : ?>
                <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                NET A PAYER : <?php echo number_format($this->data['Salepoint']['total_paye'] + $this->data['Salepoint']['fee'], 2, ',', ' '); ?>
            </p>
            <?php if (isset($this->data['Salepoint']['check_cad']) and !empty($this->data['Salepoint']['check_cad'])) :  ?>
                <p style="text-align: right;margin-top: 2px;padding-bottom: 2px;font-weight: bold;"> 
                    Cheque cadeau num : <?php echo $this->data['Chequecadeau']['reference']; ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="footer-ticket">
	<?php
    // recuperer les info caisse
        echo 'Caisse N° : '
        .$caisse_data['Caisse']['libelle']
        ;

    // recuperer les info user
        echo '<br />';
        echo 'Caissier(e) : '
        .$this->data['Creator']['nom']
        .' '
        .$this->data['Creator']['prenom']
        ;
        echo '<br />';

    // Afficher boucher
        echo 'Préparé par : ';
        echo $this->data['Salepoint']['boucher'];

    ?> 

<div id='printbox' class="printme">
        <table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" width="80px">Tva</th>
                        <th nowrap="">Mnt(HT)</th>
                        <th nowrap="">Taxe</th>
                        <th nowrap="">Mnt(TTC)</th>
                        
                    </tr>
                    <?php if (isset($is_salepoint)) : ?>
                    <?php foreach ($details_tva as $detail): ?>
                    <tr>
                        <td style="text-align: right;"><?php echo number_format($detail['Tmp']['tva'], 2, ',', ' '); ?></td>
                        <td style="text-align: right;"><?php echo number_format($detail[0]['ht'], 2, ',', ' '); ?></td>
                         
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['tax'], 2, ',', ' '); ?></td>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['ttc'], 2, ',', ' '); /* echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') */ ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>    
                    <?php foreach ($details_tva as $detail): ?>
                    <tr>
                        <td style="text-align: right;"><?php echo number_format($detail['Produit']['tva_vente'], 2, ',', ' '); ?></td>
                        <td style="text-align: right;"><?php echo number_format($detail[0]['mnt_ht'], 2, ',', ' '); ?></td>
                         
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['taxe'], 2, ',', ' '); ?></td>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['mnt_ttc'], 2, ',', ' '); /* echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') */ ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </table>
                <?php echo '<br>'.'Modes de paiement : '.'<br>'; ?>
				
				<table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" class="text-center">Mode</th>
                        <th nowrap="" class="text-center">Montant</th>
                        
                        
                    </tr>
                    <?php foreach ($avances as $detail): ?>
						<?php if ($detail['Avance']['montant'] != 0) : ?>
                    <tr>
                        <td class="text-center"><?php echo $this->App->getModePaiment($detail['Avance']['mode']); ?></td>
                        <td class="text-right"><?php echo number_format($detail['Avance']['montant'], 2, ',', ' '); ?></td>
                    </tr>
					<?php endif; ?>
                    <?php endforeach; ?>
                </table>
                </div>  
				</div>   
			<?php
                // Afficher la date et heure du ticket
        echo 'Date et heure : ';
        echo date('d/m/Y', strtotime($this->data['Salepoint']['date_u'])).' - '.date('H:i', strtotime($this->data['Salepoint']['date_u']));

        ?>


    <hr />

    <p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;"> Merci de votre visite<br/> **See You After**</p>

    <p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;">
    Par mesure d'hygiène et de sécurité nos produits ne sont pas échangeables une fois encaissés.
    <br />
    Merci de votre compréhension.
    </p>
</div>

    <div class="text-center">
        <?php
            echo $this->Html->image('POS/qr_ticket.png', [
                'alt' => 'QR Ticket',
                'class' => 'img-responsive',
                'width' => '150',
                'height' => '150'
            ]);
        ?>
        <p class="sous-footer text-center"> Votre Boucherie en Ligne au Maroc </p>
    </div>


        <p class="paragraph">
            <button onclick="window.print();" class="no-print">Imprimer ticket</button>
        </p>
    </body>
</html>
<script>
   window.print();
</script>