<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Role']['id']) ): ?>
			Modifier admin
		<?php else: ?>
			Nouveau admin systéme
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Role',['id' => 'RoleEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Role</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('role_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Role']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'RoleEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
