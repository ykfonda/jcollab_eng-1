<div class="modal-header">
	<h4 class="modal-title">
		<?php if (isset($this->data['Remiseclient']['id'])): ?>
			Modifier une remise
		<?php else: ?>
			Ajouter une nouvelle remise
		<?php endif; ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Remiseclient', ['id' => 'RemiseClientArticle', 'class' => 'form-horizontal', 'type' => 'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('produit_id', ['class' => 'select2 form-control', 'label' => false, 'required' => true, 'empty' => '-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Nombre de kilogrammes</label>
				<div class="col-md-4">
					<?php echo $this->Form->input('nb_kilos', ['class' => 'form-control', 'label' => false, 'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Pourcentage</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant', ['class' => 'form-control', 'label' => false, 'required' => true, 'min' => 0, 'step' => 'any']); ?>
				</div>
				
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'RemiseClientArticle', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	var Init = function(){
    $('.select2').select2();
    $('.uniform').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }
	
</script>