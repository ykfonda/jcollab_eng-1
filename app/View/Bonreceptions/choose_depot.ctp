<div class="modal-header">
	<h4 class="modal-title">
		Choisir Dépot
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Validerexp',['id' => 'Validerexp','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
    
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Depots</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('depots',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'Validerexp','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

