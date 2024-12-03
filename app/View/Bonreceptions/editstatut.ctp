<div class="modal-header">
	
	<h4 class="modal-title">
		Changement de statut
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Bonreception',['id' => 'ChangeStatutForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Statut</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('paye',['class'=>'form-control','label'=>false,'required'=>true,'options'=>$this->App->getStatutPayment() ]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ChangeStatutForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
