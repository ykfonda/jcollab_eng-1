<div class="modal-header">
	<h4 class="modal-title">
		Liste attente
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('User',['id' => 'UserEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="alert alert-danger p-2"><strong>Remarque : </strong> en cours de développement ...</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php //echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'UserEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
