<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Decharchement']['id']) ): ?>
			Modifier un retour
		<?php else: ?>
			Saisir un retour
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Decharchement',['id' => 'DecharchementEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Référence</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('reference',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
				</div>
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Vendeur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('user_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Vendeur']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('client_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Client']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'DecharchementEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
