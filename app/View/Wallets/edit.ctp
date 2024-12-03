<div class="modal-header">
	<h4 class="modal-title">
		<?php if (isset($this->data['Caisse']['id'])): ?>
			Modifier une caisse
		<?php else: ?>
			Nouvelle saisie
		<?php endif; ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Wallet', ['id' => 'WalletEditForm', 'class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('client_id', ['class' => 'form-control select2', 'label' => false, 'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant', ['class' => 'form-control', 'label' => false, 'type' => 'float']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Mode</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('mode', ['class' => 'form-control', 'label' => false, 'required' => true, 'type' => 'text']); ?>
				</div>
				<label class="control-label col-md-2">Num cheque</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('num_cheque', ['class' => 'form-control', 'label' => false, 'type' => 'number']); ?>
				</div>
			</div>
			
			
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'WalletEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
