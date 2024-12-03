<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Depence']['id']) ): ?>
			Modifier le paiement
		<?php else: ?>
			Effectuer un paiement
		<?php endif ?>
	</h4>
</div>

<div class="modal-body">
<?php echo $this->Form->create('Depence',['id' => 'DepenceEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<?php if ( $reste_a_payer <= 0 ): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center" role="alert">
				  <strong> Le reste à payer est 0 </strong>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-12">
				<div class="alert alert-info text-center" role="alert">
				  <strong> Le reste à payer est <?php echo number_format($reste_a_payer, 2, ',', ' '); ?> </strong>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row">
					<label class="control-label col-md-2">Date de délivrance</label>
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
						<?php echo $this->Form->input('montant',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'max'=>$reste_a_payer]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2"></label>
					<div class="col-md-8">
						<h5><strong>Information complémentaire : </strong></h5>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Date échéance</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date_echeance',['class' => 'date-picker form-control','label'=>false,'readonly' => true,'type'=>'text']); ?>
					</div>
					<label class="control-label col-md-2">N° de pièce</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('numero_piece',['class'=>'form-control','label'=>false,'required'=>false]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Émetteur/Tél</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('emeteur',['class'=>'form-control','label'=>false,'required'=>false]); ?>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php if ( $reste_a_payer <= 0 ): ?>
		<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'DepenceEditForm','class' => 'saveBtn btn btn-success','disabled'=>true)) ?>
	<?php else: ?>
		<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'DepenceEditForm','class' => 'saveBtn btn btn-success')) ?>
	<?php endif ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>