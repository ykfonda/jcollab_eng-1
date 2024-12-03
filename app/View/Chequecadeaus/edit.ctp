<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Caisse']['id']) ): ?>
			Modifier une caisse
		<?php else: ?>
			Nouvelle saisie
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Chequecadeau',['id' => 'BonachatEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">

		<?php 
		// Initialisation des variable // OLD CODE
		
		//echo $this->Form->input('date_debut',['class' => 'form-control date-picker','label'=>false,'disabled' => true,'type'=>'text']); 
					echo $this->Form->input('date_debut',['label'=>false,'disabled' => true,'type'=>'hidden']); 
		

		 // echo $this->Form->input('date_fin',['class' => 'date-picker form-control','label'=>false,'disabled' => true,'type'=>'text']); 
		echo $this->Form->input('date_fin',['label'=>false,'disabled' => true,'type'=>'hidden']);
		

		 // echo $this->Form->input('date_encaissement',['class' => 'date-picker form-control','label'=>false,'disabled' => true,'type'=>'text']); 
		echo $this->Form->input('date_encaissement',['label'=>false,'disabled' => true,'type'=>'hidden']); 
		?>





			<div class="form-group row">
				<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant',['class' => 'form-control','label'=>false,'type' => "number"]); ?>
				</div>
				<label class="control-label col-md-2">Validité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('validite',['class' => 'form-control','label'=>false,'required' => true,'type' => 'number']); ?>
				</div>
			</div>



			<div class="form-group row">
			

				<label class="control-label col-md-2">Activer</label>

				<div class="col-md-3">
					<input type="hidden" name="data[Chequecadeau][active]" value="0" />
						<input class="form-check-input" name="data[Chequecadeau][active]" style="margin-left: 2rem; /* Double-sized Checkboxes */
						-ms-transform: scale(2); /* IE */
						-moz-transform: scale(2); /* FF */
						-webkit-transform: scale(2); /* Safari and Chrome */
						-o-transform: scale(2); /* Opera */
						transform: scale(2);
						padding: 10px;" id="flexCheck3" value="1" <?php if (isset($this->data["Chequecadeau"]["active"]) and  $this->data["Chequecadeau"]["active"] == 1) echo ' checked' ?> type="checkbox">	
				</div>

				<label class="control-label col-md-2">Numéro</label>
				<div class="col-md-3">
				<?php echo $this->Form->input('numero',['class' => 'form-control','label'=>false,'type' => 'number']); ?>
				</div>

			</div>



			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonachatEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
