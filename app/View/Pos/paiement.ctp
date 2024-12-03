
<style>
[type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}
.imgradio {
	margin-left: 2rem;
}
/* CHECKED STYLES */
[type=radio]:checked + img {
    outline: 3px solid #f00;
    padding: 4px;
}
.visa{background-image:url(http://i.imgur.com/lXzJ1eB.png);}
.mastercard{background-image:url(http://i.imgur.com/SJbRQF7.png);}


/* JCOLLAB 4 X */

label {
    color: #000000;
    font-weight: bold;
}

input#MontantTotal, input#Remise, input#MontantRemise {
    width: 150px;
    font-size: 20px;
    color: #991f1f !important;
    font-weight: 800;
}


</style>


<div class="modal-header">
	<h4 class="modal-title">
		Effectuez un paiement
	</h4>
</div>
<div class="modal-body ">
	<?php $readonly = false; ?>
	<?php $net_a_payer = (isset($this->data['Salepoint']['total_apres_reduction']) and !empty($this->data['Salepoint']['total_apres_reduction'])) ? $this->data['Salepoint']['total_apres_reduction'] + $this->data['Salepoint']['fee'] : 0; ?>
	<?php $payment_method = (isset($this->data['Ecommerce']['payment_method']) and !empty($this->data['Ecommerce']['payment_method'])) ? $this->data['Ecommerce']['payment_method'] : 'espece'; ?>
	<?php if ((isset($this->data['Commandeglovo']['payment_method']) and trim($this->data['Commandeglovo']['payment_method']) == 'CASH')) {
    $payment_method = 'cod';
} elseif ((isset($this->data['Commandeglovo']['payment_method']) and trim($this->data['Commandeglovo']['payment_method']) == 'DELAYED')) {
    $payment_method = 'delayed';
} ?>
	
	<?php $remise = (isset($this->data['Salepoint']['remise']) and !empty($this->data['Salepoint']['remise'])) ? $this->data['Salepoint']['remise'] : ''; ?>
	<?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?>
		<?php $readonly = true; ?>
		<?php if ($error): ?>		
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-danger p-1 text-center"><strong>Attention : il vous reste des commandes à livrer</strong></div>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php echo $this->Form->create('Salepoint', ['id' => 'SalepointPaiement', 'class' => 'form-horizontal', 'autocomplete' => 'off']); ?>
		<?php echo $this->Form->input('id'); ?>

	

<?php echo $this->Form->hidden('boucher', ['class' => 'form-control', 'label' => 'boucher', 'readonly' => true, 'id' => 'boucher', 'step' => 'any']); ?>


		<?php echo $this->Form->hidden('depot_id', ['value' => 1]); ?>
		<?php if (isset($this->data['Salepoint']['client_id']) and !empty($this->data['Salepoint']['client_id'])): ?>
			<?php echo $this->Form->hidden('client_id', ['value' => $this->data['Salepoint']['client_id']]); ?>
		<?php else: ?>
			<?php echo $this->Form->hidden('client_id', ['value' => 1]); ?>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row mb-1 pb-1 pt-1" style="border:1px solid #e5e5e5;">
					<label class="control-label col-md-1"></label>
				
					<div class="col-md-2">
						<?php echo $this->Form->input('total_apres_reduction', ['class' => 'form-control', 'value' => $total, 'label' => 'Net à payer', 'readonly' => true, 'min' => 0, 'id' => 'MontantTotal', 'step' => 'any', 'default' => 0]); ?>
					</div>
					
					<div class="col-md-2">
						<?php echo $this->Form->input('remise', ['class' => 'form-control', 'label' => 'Remise (%)', 'readonly' => true, 'min' => 0, 'id' => 'Remise', 'step' => 'any', 'default' => 0]); ?>
					</div>

					<div class="col-md-2">
						<?php echo $this->Form->input('montant_remise', ['class' => 'form-control', 'label' => 'Montant remise (DHs)', 'readonly' => true, 'min' => 0, 'max' => 100, 'id' => 'MontantRemise', 'step' => 'any', 'default' => 0]); ?>
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 pb-2 pt-2">
				<div class="card">
				  	<div class="card-header">
				      	<h4 class="card-title">Mode 1</h4>
				  	</div>
				  	<div class="card-content collapse show">
				      	<div class="card-body">
				          	<div class="row">
				              	<div class="col-sm-12">
									<div class="form-group row mb-1 pb-1 pt-1">
										<div class="col-md-6">
											<?php echo $this->Form->hidden('Avance.0.date', ['default' => date('d-m-Y')]); ?>
											<?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?>
												<?php echo $this->Form->hidden('Avance.0.mode', ['value' => $payment_method]); ?>
												
												<label>
													<input  type="radio" name="data[Salepoint][payment]" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'wallet') {
    echo 'disabled="disabled"';
} ?> id="RadioMode1" value="wallet" <?php  echo ($payment_method == 'wallet') ? 'checked' : ''; ?> >
													<?php echo $this->Html->image('wallet.jpeg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
													<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode1">wallet&nbsp</label>	
												</label>
												<br><br>
												<!-- COD -->
												<label>
														<input  type="radio" name="data[Salepoint][payment]"  id="RadioMode0" value="cod" <?php  echo ($payment_method == 'cod') ? 'checked' : ''; ?> >
														<?php echo $this->Html->image('cod.png', [
                                                        'alt' => 'COD',
                                                        'width' => 70,
                                                        'height' => 50,
                                                        'class' => 'imgradio payement-icon',
                                                        'fullBase' => true,
                                                        ]); ?>
														<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">COD</label>	
													</label>
													<br /><br />		
													
												<label>
												  <input class="form-check-input"  type="radio" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'cmi') {
                                                            echo 'disabled="disabled"';
                                                        } ?> name="data[Salepoint][payment]" id="RadioMode2" value="cmi" <?php echo ($payment_method == 'cmi') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('paiement_en_ligne.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode2">Cmi<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												  <label>
													<input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'tpe') {
                                                            echo 'disabled="disabled"';
                                                        } ?>  type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="tpe" <?php echo ($payment_method == 'tpe') ? 'checked' : ''; ?>>
													<img class="imgradio" style="width: 3rem;" src="http://i.imgur.com/lXzJ1eB.png">
													
													<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">terminal  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de paiement&nbsp</label>	
												</label>
												<br><br>
												<label>
												  <input class="form-check-input" disabled="disabled"  type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="cheque" <?php echo ($payment_method == 'cheque') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque.png', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">chèque<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												
												<label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'bon_achat') {
                                                            echo 'disabled="disabled"';
                                                        } ?>  type="radio" name="data[Salepoint][payment]" id="RadioMode4" value="bon_achat" <?php echo ($payment_method == 'bon_achat') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('bon_achat.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" disabled="disabled" style="display : inline;color: #B9B9C3;" for="RadioMode4">Bon &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspd'achat </label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'cheque_cadeau') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment]" id="RadioMode5" value="cheque_cadeau" <?php echo ($payment_method == 'cheque_cadeau') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque_cadeau.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode5">chèque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspcadeau</label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'offert') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment]" id="RadioMode6" value="offert" <?php echo ($payment_method == 'offert') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('offert.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode6">offert</label>
												  </label>
												  <br><br>
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'cod') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment]" id="RadioMode7" value="espece" <?php echo ($payment_method == 'espece') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('especes.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Especes</label>
												  </label>
												  <br><br>
												<!--<div class="form-check">
												  <input class="form-check-input" disabled="disabled" type="radio" name="data[Salepoint][payment]" id="RadioMode4" value="payement_en_ligne" <?php echo ($payment_method == 'payement_en_ligne') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="RadioMode4">Paiement en ligne</label>
												</div>-->
											<?php else: ?>
		<!--  Mode 1 : ESPECES  --->
		<label>
		<input class="form-check-input change"  type="radio" name="data[Salepoint][payment]" id="RadioMode7" value="espece" <?php echo ($payment_method == 'espece') ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('especes.jpg', [
        'alt' => 'cool image',
        'width' => 70,
        'height' => 50,
        'class' => 'imgradio',
        'fullBase' => true,
        ]); ?>


		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Espèce</label>
		</label>
		<br><br>


		<!--  Mode 1 : COD if mode ecommerce  --->
		<label>
			<input  class="form-check-input change"  type="radio" name="data[Salepoint][payment]"  id="RadioMode0" value="cod" <?php echo ($payment_method == 'cod') ? 'checked' : ''; ?> >
			<?php echo $this->Html->image('cod.png', [
            'alt' => 'COD',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio payement-icon',
            'fullBase' => true,
            ]); ?>
			<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">COD</label>	
		</label>
		<br /><br />			


		<label>
			<input  class="form-check-input change"  type="radio" name="data[Salepoint][payment]"  id="RadioMode0" value="delayed" <?php echo ($payment_method == 'delayed') ? 'checked' : ''; ?> >
			<?php echo $this->Html->image('credit.png', [
            'alt' => 'COD',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio payement-icon',
            'fullBase' => true,
            ]); ?>
			<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">Delayed</label>	
		</label>
		<br /><br />			

		<!--  Mode 1 : WALLET  --->
		<label>
			<input  class="wallet" type="radio" name="data[Salepoint][payment]"  id="RadioMode1" value="wallet" <?php  echo ($payment_method == 'wallet') ? 'checked' : ''; ?> >
			<?php echo $this->Html->image('wallet.jpeg', [
            'alt' => 'cool image',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio',
            'fullBase' => true,
            ]); ?>

			<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode1">Wallet</label>	
			</label>
		<br><br>


		<!--  Mode 1 : CARTE  --->
		<label>
		<input  class="form-check-input change"  type="radio"  name="data[Salepoint][payment]" id="RadioMode2" value="Carte" <?php echo ($payment_method == 'Carte') ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('paiement_en_ligne.jpg', [
        'alt' => 'cool image',
        'width' => 70,
        'height' => 50,
        'class' => 'imgradio',
        'fullBase' => true,
        ]); ?>

		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode2">Carte <i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>


		</label>
		<br><br>

		<!--  Mode 1 : CARTE  --->
		<label>
		<input class="form-check-input change" type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="cheque" <?php echo ($payment_method == 'cheque') ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('cheque.png', [
        'alt' => 'cool image',
        'width' => 70,
        'height' => 50,
        'class' => 'imgradio',
        'fullBase' => true,
        ]); ?>
		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">chèque<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
		</label>
		<br><br>
		
		<label>
			<input class="form-check-input change"   type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="tpe" <?php echo ($payment_method == 'tpe') ? 'checked' : ''; ?>>
			<img class="imgradio" style="width: 3rem;" src="http://i.imgur.com/lXzJ1eB.png">
			
			<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">terminal  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de paiement&nbsp</label>	
		</label>
		<br><br>
		
		<!--  Mode 1 : BON D'ACHAT  --->
		<label>
		<input class="form-check-input"  type="radio" name="data[Salepoint][payment]" id="RadioMode4" value="bon_achat" <?php echo ($payment_method == 'bon_achat' or $bon_achat == true) ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('bon_achat.jpg', [
        'alt' => 'cool image',
        'width' => 70,
        'height' => 50,
        'class' => 'imgradio',
        'fullBase' => true,
        ]); ?>
		<label class="form-check-label" disabled="disabled" style="display : inline;color: #B9B9C3;" for="RadioMode4">Bon d'achat </label>
		</label>
		<br><br>
					
		<!--  Mode 1 : CHEQUE CADEAU --->
		<label>
		<input  type="radio" name="data[Salepoint][payment]" id="RadioMode5" value="cheque_cadeau" <?php echo ($payment_method == 'cheque_cadeau' or $cheque_cad == true) ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('cheque_cadeau.jpg', [
        'alt' => 'cool image',
        'width' => 70,
        'height' => 50,
        'class' => 'imgradio',
        'fullBase' => true,
        ]); ?>
		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode5">chèque cadeau</label>
		</label>
		<br><br>


		<!--  Mode 1 : OFFERT --->									
		<label>
		<input class="form-check-input change" type="radio" name="data[Salepoint][payment]" id="RadioMode6" value="offert" <?php echo ($payment_method == 'offert' || $remise == '100.00' ) ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('offert.jpg', [
        'alt' => 'cool image',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio',
            'fullBase' => true,
            ]); ?>
		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode6">Offert</label>
		</label>
		<br><br>

		<!--  Mode 1 : VIREMENT --->
		<label>
		<input class="form-check-input change" type="radio" name="data[Salepoint][payment]" id="RadioMode7" value="virement" <?php echo ($payment_method == 'virement') ? 'checked' : ''; ?>>
		<?php echo $this->Html->image('virement.png', [
        'alt' => 'cool image',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio',
            'fullBase' => true,
            ]); ?>
		<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Virement</label>
		</label>
		<br><br>
												<!-- <div class="form-check" style="padding-left: 6.25rem;">
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="RadioMode4" value="cmi" <?php /* echo ( $payment_method == 'cmi' ) ? 'checked' : '' ; */ ?>>
												  <label class="form-check-label" for="RadioMode4">Paiement en ligne</label>
												</div> -->
											<?php endif; ?>
										</div>
										<div class="col-md-6" id="Mode1Container">
											<?php echo $this->Form->input('Avance.0.montant', ['class' => 'form-control', 'label' => 'Montant payé', 'required' => true, 'min' => 0, 'step' => 'any', 'id' => 'Montant1', 'type' => 'text', 'max' => $net_a_payer, 'default' => $net_a_payer, 'readonly' => $readonly]); ?>
											<?php if (empty($this->data['Salepoint']['ecommerce_id'])): ?>
						                        <!-- KeyPad -->
						                        <table style="width:100%;">
						                            <tr>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="7" >7</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="8" >8</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="9" >9</button></td>
						                            </tr>
						                            <tr>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="4" >4</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="5" >5</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="6" >6</button></td>
						                            </tr>
						                            <tr>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="1" >1</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="2" >2</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="3" >3</button></td>
						                            </tr>
						                            <tr>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="±">±</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="0">0</button></td>
						                                <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href=".">.</button></td>
						                            </tr>
						                            <tr>
						                                <td colspan="3"><button class="btn btn-primary btn-danger btn-block btn-sm easy_numpad_clear_mode1" type="button" href="Clear"><i class="fa fa-eraser"></i> Vider</button></td>
						                            </tr>
						                            <tr>
						                                <td colspan="3"><button class="btn btn-primary btn-warning btn-block btn-sm easy_numpad_del_mode1" type="button" href="Clear"><i class="fa fa-eraser"></i> Supprimer</button></td>
						                            </tr>
						                        </table>
						                        <!-- KeyPad -->
											<?php endif; ?>
										</div>
									</div>
				              	</div>
				          	</div>
				      	</div>
				  	</div>
				</div>
			</div>
			<div class="col-md-6 pb-2 pt-2">
				<div class="card">
				  	<div class="card-header">
				      	<h4 class="card-title">Mode 2</h4>
				  	</div>
				  	<div class="card-content collapse show">
				      	<div class="card-body">
				          	<div class="row">
				              	<div class="col-sm-12">
									<div class="form-group row mb-1 pb-1 pt-1">
										<div class="col-md-6">
											<?php echo $this->Form->hidden('Avance.1.date', ['default' => date('d-m-Y')]); ?>
											<?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?>
												<?php echo $this->Form->hidden('Avance.1.mode', ['value' => $payment_method]); ?>
												<label>
													<input  type="radio" name="data[Salepoint][payment2]" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'wallet') {
                echo 'disabled="disabled"';
            } ?> id="RadioMode1" value="wallet" <?php  echo ($payment_method == 'wallet') ? 'checked' : ''; ?> >
													<?php echo $this->Html->image('wallet.jpeg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
													<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode1">wallet&nbsp</label>	
												</label>
												<br><br>
													<!-- COD -->
													<label>
														<input  type="radio" name="data[Salepoint][payment2]"  id="RadioMode0" value="cod" <?php  echo ($payment_method == 'cod') ? 'checked' : ''; ?> >
														<?php echo $this->Html->image('cod.png', [
                                                        'alt' => 'COD',
                                                        'width' => 70,
                                                        'height' => 50,
                                                        'class' => 'imgradio payement-icon',
                                                        'fullBase' => true,
                                                        ]); ?>
														<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">COD</label>	
													</label>
													<br /><br />	
												<label>
												  <input class="form-check-input"  type="radio" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'cmi') {
                                                            echo 'disabled="disabled"';
                                                        } ?> name="data[Salepoint][payment2]" id="RadioMode2" value="cmi" <?php echo ($payment_method == 'cmi') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('paiement_en_ligne.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode2">Cmi<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												<label>
													<input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'tpe') {
                                                            echo 'disabled="disabled"';
                                                        } ?>  type="radio" name="data[Salepoint][payment2]" id="RadioMode3" value="tpe" <?php echo ($payment_method == 'tpe') ? 'checked' : ''; ?>>
													<img class="imgradio" style="width: 3rem;" src="http://i.imgur.com/lXzJ1eB.png">
													
													<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">terminal  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de paiement&nbsp</label>	
												</label>
												<br><br>
												<label>
												  <input class="form-check-input" disabled="disabled"  type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="cheque" <?php echo ($payment_method == 'cheque') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque.png', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">chèque<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												
												<label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'bon_achat') {
                                                            echo 'disabled="disabled"';
                                                        } ?>  type="radio" name="data[Salepoint][payment2]" id="RadioMode4" value="bon_achat" <?php echo ($payment_method == 'bon_achat') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('bon_achat.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" disabled="disabled" style="display : inline;color: #B9B9C3;" for="RadioMode4">Bon &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspd'achat </label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'cheque_cadeau') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment2]" id="RadioMode5" value="cheque_cadeau" <?php echo ($payment_method == 'cheque_cadeau') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque_cadeau.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode5">chèque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspcadeau</label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['payment_method'] != 'offert') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment2]" id="RadioMode6" value="offert" <?php echo ($payment_method == 'offert') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('offert.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode6">offert</label>
												  </label>
												  <br><br>
												  <label>
												  <input class="form-check-input" <?php if (isset($this->data['Ecommerce']['payment_method']) and $this->data['Ecommerce']['shipment'] != 'pickup' and $this->data['Ecommerce']['payment_method'] != 'cod') {
                                                            echo 'disabled="disabled"';
                                                        } ?> type="radio" name="data[Salepoint][payment2]" id="RadioMode7" value="espece" <?php echo ($payment_method == 'espece') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('especes.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Especes</label>
												  </label>
												  <br><br>
												<!-- <div class="form-check">
												  <input class="form-check-input" disabled="disabled" type="radio" name="data[Salepoint][payment]" id="RadioMode4" value="payement_en_ligne" <?php echo ($payment_method == 'payement_en_ligne') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="RadioMode4">Paiement en ligne</label>
												</div> -->
											<?php else: ?>
												<label>
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment2]" id="RadioMode7" value="espece" <?php echo ($payment_method == 'espece') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('especes.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Especes</label>
												  </label>
												  <br><br>

												  <!--  Mode 1 : COD if mode ecommerce  --->
		<label>
			<input  type="radio" name="data[Salepoint][payment2]"  id="RadioMode0" value="cod"  <?php  echo ($payment_method == 'cod') ? 'checked' : ''; ?>>
			<?php echo $this->Html->image('cod.png', [
            'alt' => 'COD',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio payement-icon',
            'fullBase' => true,
            ]); ?>
			<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">COD</label>	
		</label>
		<br /><br />	

		<label>
			<input  class="form-check-input change"  type="radio" name="data[Salepoint][payment2]"  id="RadioMode0" value="delayed" <?php echo ($payment_method == 'delayed') ? 'checked' : ''; ?> >
			<?php echo $this->Html->image('credit.png', [
            'alt' => 'COD',
            'width' => 70,
            'height' => 50,
            'class' => 'imgradio payement-icon',
            'fullBase' => true,
            ]); ?>
			<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode0">Delayed</label>	
		</label>
		<br /><br />		
												<label>
													<input  type="radio" name="data[Salepoint][payment2]"  id="RadioMode1" value="wallet" <?php  echo ($payment_method == 'wallet') ? 'checked' : ''; ?> >
													<?php echo $this->Html->image('wallet.jpeg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
													<label class="form-check-label" style="color: #B9B9C3;" for="RadioMode1">wallet&nbsp</label>	
												</label>
												<br><br>
												
												<label>
												  <input class="form-check-input"  type="radio"  name="data[Salepoint][payment2]" id="RadioMode2" value="Carte" <?php echo ($payment_method == 'Carte') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('paiement_en_ligne.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 40,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode2">Carte<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												
												<label>
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment2]" id="RadioMode3" value="cheque" <?php echo ($payment_method == 'cheque') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque.png', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">chèque<i style="font-size : 1.2rem;display : inline;color : #7c7cd1;" class="fab fa-cc-amazon-pay"></i> </label>
												  </label>
												  <br><br>
												  
												  <label>
													<input class="form-check-input"   type="radio" name="data[Salepoint][payment]" id="RadioMode3" value="tpe" <?php echo ($payment_method == 'tpe') ? 'checked' : ''; ?>>
													<img class="imgradio" style="width: 3rem;" src="http://i.imgur.com/lXzJ1eB.png">
													
													<label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode3">terminal  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de paiement&nbsp</label>	
												</label>
												<br><br>

												<label>
												  <input class="form-check-input"  type="radio" name="data[Salepoint][payment2]" id="RadioMode4" value="bon_achat" <?php echo ($payment_method == 'bon_achat') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('bon_achat.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" disabled="disabled" style="display : inline;color: #B9B9C3;" for="RadioMode4">Bon &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspd'achat </label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment2]" id="RadioMode5" value="cheque_cadeau" <?php echo ($payment_method == 'cheque_cadeau') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('cheque_cadeau.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode5">chèque &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspcadeau</label>
												  </label>
												  <br><br>
												
												  <label>
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment2]" id="RadioMode6" value="offert" <?php echo ($payment_method == 'offert') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('offert.jpg', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode6">offert</label>
												  </label>
												  <br><br>
												  <label>
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="RadioMode7" value="virement" <?php echo ($payment_method == 'virement') ? 'checked' : ''; ?>>
												  <?php echo $this->Html->image('virement.png', [
                                                    'alt' => 'cool image',
                                                        'width' => 60,
                                                        'height' => 35,
                                                        'class' => 'imgradio',
                                                        'fullBase' => true,
                                                        ]); ?>
													
												 
												  <label class="form-check-label" style="display : inline;color: #B9B9C3;" for="RadioMode7">Virement</label>
												  </label>
												  <br><br>
												<!-- <div class="form-check">
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="InputRadioMode1" value="cod" <?php echo ($payment_method == 'cod') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="InputRadioMode1">Paiement espèce</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="InputRadioMode2" value="tpe" <?php echo ($payment_method == 'tpe') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="InputRadioMode2">Terminal de paiement</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="InputRadioMode3" value="wallet" <?php echo ($payment_method == 'wallet') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="InputRadioMode3">Portefeuille client</label>
												</div>
												<div class="form-check">
												  <input class="form-check-input" type="radio" name="data[Salepoint][payment]" id="InputRadioMode4" value="cmi" <?php echo ($payment_method == 'cmi') ? 'checked' : ''; ?>>
												  <label class="form-check-label" for="InputRadioMode4">Paiement en ligne</label>
												</div> -->
											<?php endif; ?>
										</div>
										<div class="col-md-6" id="Mode2Container">
											<?php echo $this->Form->input('Avance.1.montant', ['class' => 'form-control', 'label' => 'Montant payé', 'required' => true, 'default' => 0, 'min' => 0, 'step' => 'any', 'id' => 'Montant2', 'type' => 'text', 'max' => $net_a_payer, 'readonly' => $readonly]); ?>
					                        <?php if (empty($this->data['Salepoint']['ecommerce_id'])): ?>
					                        <!-- KeyPad -->
					                        <table style="width:100%;">
					                            <tr>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="7" >7</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="8" >8</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="9" >9</button></td>
					                            </tr>
					                            <tr>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="4" >4</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="5" >5</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="6" >6</button></td>
					                            </tr>
					                            <tr>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="1" >1</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="2" >2</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="3" >3</button></td>
					                            </tr>
					                            <tr>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="±">±</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="0">0</button></td>
					                                <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href=".">.</button></td>
					                            </tr>
					                            <tr>
					                                <td colspan="3"><button class="btn btn-primary btn-danger btn-block btn-sm easy_numpad_clear_mode2" type="button" href="Clear"><i class="fa fa-eraser"></i> Vider</button></td>
					                            </tr>
					                            <tr>
					                                <td colspan="3"><button class="btn btn-primary btn-warning btn-block btn-sm easy_numpad_del_mode2" type="button" href="Clear"><i class="fa fa-eraser"></i> Supprimer</button></td>
					                            </tr>
					                        </table>
					                        <!-- KeyPad -->
					                    	<?php endif; ?>
										</div>
									</div>
				              	</div>
				          	</div>
				      	</div>
				  	</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<style>
.btn_style {
    width: 220px;
    height: 50px;
    font-size: 17px;
    font-weight: bold;
}
</style>

<div class="modal-footer">
	<?php if (isset($this->data['Salepoint']['ecommerce_id']) and !empty($this->data['Salepoint']['ecommerce_id'])): ?>
		<?php if ($error): ?>
			<?php echo $this->Form->submit('Valider & Terminer', ['div' => false, 'form' => 'SalepointPaiement', 'class' => 'saveBtn btn btn-success btn_style', 'disabled' => true]); ?>
		<?php else: ?>
			<?php echo $this->Form->submit('Valider & Terminer', ['div' => false, 'form' => 'SalepointPaiement', 'class' => 'saveBtn btn btn-success  btn_style', 'disabled' => false]); ?>
		<?php endif; ?>
	<?php else: ?>	
		<?php echo $this->Form->submit('Valider & Terminer', ['div' => false, 'form' => 'SalepointPaiement', 'class' => 'saveBtn btn btn-success btn_style', 'disabled' => false]); ?>
	<?php endif; ?>
	<button type="button" class="btn default btn_style" data-dismiss="modal">Fermer</button>
</div>

<script>

	$( ".change" ).click(function (e) {
		var total = parseFloat("<?php echo $this->data['Salepoint']['total_apres_reduction']; ?>"); 
		$("#Montant1").val(total);
		$("#Montant2").val(0);
	});
	$(".wallet").click(function (e) { 
		var salepoint_id = parseInt("<?php echo $this->data['Salepoint']['id']; ?>");
		url = "<?php echo $this->Html->url(['action' => 'loadWallet']); ?>/"+salepoint_id;
		$.ajax({
			type: "post",
			url: url,
			success: function (dt) {
			
				if(dt.wallet) {
					if(dt.mnt1 == 0) toastr.error("Le solde de la wallet est egale a 0 !");
					$("#Montant1").val(dt.mnt1);
					$("#Montant2").val(dt.mnt2);
				}
				else {
					toastr.error("Le client ne possede pas de wallet !");
				}
			}
		});
	});	
	var boucher = document.getElementById('boucher');
	boucher.value = bouchier.value

	var mt1 = document.querySelector("#Montant1");
	var mt2 = document.querySelector("#Montant2");
	var total = document.querySelector("#MontantTotal");

	mt1.addEventListener('keyup', () => {
		var montant1 = Number(mt1.value) || 0;
		mt2.value = (Number(total.value) - montant1).toFixed(2);
	});

	mt2.addEventListener('keyup', () => {
		var montant2 = Number(mt2.value) || 0;
		mt1.value = (Number(total.value) - montant2).toFixed(2);
	})
</script>