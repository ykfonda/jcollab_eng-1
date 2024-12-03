<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Objectifclient']['id']) ): ?>
			Modifier un objectif
		<?php else: ?>
			Ajouter un nouveau objectif
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Objectifclient',['id' => 'ObjectifclientEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Année</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('annee',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => true,'options'=>$this->App->getAnnees() ]); ?>
				</div>
				<label class="control-label col-md-2">Objectif</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('objectif',['class' => 'form-control','label'=>false,'required' => true ]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ObjectifclientEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
