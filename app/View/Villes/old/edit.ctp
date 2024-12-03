<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Ville']['id']) ): ?>
			Modifier Ville
		<?php else: ?>
			Ajouter 
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Ville',['id' => 'VilleEditForm']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
		<?php echo $this->Form->input('libelle',['class' => 'form-control']); ?>
		</div>
		<div class="col-md-12">
		<?php echo $this->Form->input('pay_id',['class' => 'form-control']); ?>
		</div>
		<!-- <div class="col-md-4">
		<?php echo $this->Form->input('active',['class' => 'form-control','options' => $this->App->OuiNon()]); ?> 
		</div> -->

	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'VilleEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
