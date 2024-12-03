<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Typeconditionnement']['id']) ): ?>
			Modifier Type Conditionnement
		<?php else: ?>
			Ajouter Type Conditionnement
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Typeconditionnement', ['id' => 'TypeEditForm']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle', ['class' => 'form-control','label'=>false, 'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Code Conditionnement</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('code_type',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
		</div>
		<!-- <div class="col-md-4">
		<?php echo $this->Form->input('active', ['class' => 'form-control', 'options' => $this->App->OuiNon()]); ?> 
		</div> -->

	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', array('div' => false,'form' => 'TypeEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
