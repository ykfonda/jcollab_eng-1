<style>
    .img-responsive{
        text-align: center;
    }

    .footer-ticket{
        font-size : 12px;
    }

    .text-center {
        text-align: center !important;
    }

</style>

<div class="footer-ticket">
    <br />
	<?php  
	// recuperer les info caisse 
		echo 'Caisse N° : '
		. $caisse_data['Caisse']['libelle'] 
		;

	// recuperer les info user 
        if (isset($users_data) AND !empty($users_data) ) {
            $caissier_nom = $users_data['User']['nom'];
            $caissier_prenom = $users_data['User']['prenom'];
        }else{
            $caissier_nom = $this->Session->read('Auth.User.nom');
            $caissier_prenom = $this->Session->read('Auth.User.prenom');
        }
       
		echo "<br />";
		echo 'Caissier(e) : '
		. $caissier_nom
		. " "
		. $caissier_prenom
		;
		echo "<br />";

	// Afficher boucher
    if (isset($salepoints_data) AND !empty($salepoints_data) ) {
        $boucher = $salepoints_data['Salepoint']['boucher'];
    }else{
        $boucher = $this->data['Salepoint']['boucher'];
    }
		echo "Préparé par : ";
		echo $boucher;
	?> 

<div id='printbox' class="printme">
                
                <?php echo "<br>".'Ventilation TVA : ' . "<br>" ?>
                <table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" width="80px">TVA</th>
                        <th nowrap="">MNT(HT)</th>
                        <th nowrap="">TAXE</th>
                        <th nowrap="">MNT(TTC)</th>
                        
                    </tr>
                    <?php foreach ($details_tva as $detail): ?>
                    <tr>
                         <td style="text-align: right;"><?php echo number_format($detail['Tmps']['tva'], 2, ',', ' '); ?></td>
                        <td style="text-align: right;"><?php echo number_format($detail[0]['ht'], 2, ',', ' '); ?></td>
                         
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['tax'], 2, ',', ' '); ?></td>
                        <td nowrap="" style="text-align: right;"><?php echo number_format($detail[0]['ttc'], 2, ',', ' '); /* echo number_format($tache['Salepointdetail']['ttc'], 2, ',', ' ') */ ?></td>
                    </tr>
                    <?php endforeach ?>
                </table>
				
				<?php echo "<br>".'Modes de paiement : ' . "<br>" ?>
				
				<table id="products" cellspacing="0" cellpadding="0">
                    <tr>
                        <th nowrap="" class="text-center">Mode</th>
                        <th nowrap="" class="text-center">Montant</th>
                        
                        
                    </tr>
                    <?php foreach ($avances as $detail): ?>
						<?php if ($detail["Avance"]["montant"] != 0 ) : ?>
                    <tr>
                        <td class="text-center"><?php echo $this->App->getModePaiment($detail["Avance"]['mode']) ?></td>
                        <td class="text-right"><?php echo number_format($detail["Avance"]['montant'], 2, ',', ' ') ?></td>
                    </tr>
					<?php endif ?>
                    <?php endforeach ?>
                </table>
				
                </div>  
				</div>   
			<?php 
				// Afficher la date et heure du ticket
		echo "Date et heure : ";
		echo date('d/m/Y').' - '.date('H:i');
		
		?>

<hr />
<p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;"> Merci de votre visite<br/> **See You After**</p>

<p style="text-align: center;margin-top: 5px;padding-bottom: 2px;font-weight: bold;">
Par mesure d'hygiène et de sécurité nos produits ne sont pas échangeables une fois encaissés.
<br />
Merci de votre compréhension.
</p>

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
