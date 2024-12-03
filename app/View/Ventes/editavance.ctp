<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Avance']['id']) ): ?>
			Modifier le paiement
		<?php else: ?>
			Effectuer un paiement
		<?php endif ?>
	</h4>
</div>

<div class="modal-body ">
<?php echo $this->Form->create('Avance',['id' => 'AvanceEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<?php if ( $total_a_payer <= 0 ): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center" role="alert">
				  <strong> Le reste à payer est 0 </strong>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-12">
				<div class="form-group row">
					<label class="control-label col-md-2">Date</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
					</div>
					<label class="control-label col-md-2">Mode paiment</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('mode',['class'=>'form-control','label'=>false,'required'=>true,'options'=>$this->App->getModePaiment() ]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Montant</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('montant',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'max'=>$total_a_payer]); ?>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'AvanceEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>