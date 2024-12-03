<div class="modal-header">
	<h4 class="modal-title">
		Paiement
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Salepoint',['id' => 'SalepointPaiement','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<?php echo $this->Form->input('id'); ?>
			<div class="col-md-12">
				<div class="alert alert-danger p-2"><strong>Remarque : </strong> en cours de développement ...</div>
				<!-- <div class="form-group row">
					<label class="control-label col-md-2">Client</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('client_id',['class'=>'form-control','label'=>false,'required'=>false]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Date</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
					</div>
					<label class="control-label col-md-2">Mode paiment</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('mode',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Mode paiment','options'=>$this->App->getModePaiment() ]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Montant</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('montant',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'max'=>$total]); ?>
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
				</div> -->
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php //echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'SalepointEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
