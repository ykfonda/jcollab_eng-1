<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Caisse']['id']) ): ?>
			Modifier une caisse
		<?php else: ?>
			Nouvelle saisie
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Fidelite',['id' => 'BonachatEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant',['class' => 'form-control','label'=>false,'required' => true,'type' => 'number']); ?>
				</div>
				<label class="control-label col-md-2">Points</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('points',['class' => 'form-control','label'=>false,'type' => 'number']); ?>
				</div>
			</div>
			<div class="form-group row">

				<label class="control-label col-md-2">Montant cheque_cad</label>
				<div class="col-md-8">
				
					<?php echo $this->Form->input('montant_cheque_cad',['class' => 'form-control','label'=>false,'type' => "number"]); ?>
			
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonachatEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
