<div class="modal-header">
	
	<h4 class="modal-title">
		Dupliquer le rôle
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Role',['id' => 'RoleEditForm']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
		<?php echo $this->Form->input('libelle',['label'=>'Libellé','class' => 'form-control']); ?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'RoleEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
