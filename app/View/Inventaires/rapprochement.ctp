<div class="modal-header">
	
	<h4 class="modal-title">
		
			Nouveau rapprochement
	
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Inventaire',['id' => 'InventaireEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Inventaire 1</label>
				<div class="col-md-4">
					<?php echo $this->Form->input('inventaire', ['class' => 'select2 form-control','label'=>false,'required' => true]); ?>
				</div>
				
			</div>
			<div class="form-group row">
            <label class="control-label col-md-2">Inventaire 2</label>
				<div class="col-md-4">
					<?php echo $this->Form->input('inventaire_id', ['class' => 'select2 form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'InventaireEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

