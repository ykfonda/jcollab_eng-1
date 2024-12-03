<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Transformation']['id']) ): ?>
			Modifier une transformation
		<?php else: ?>
			Nouvelle transformation
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Transformation',['id' => 'TransformationEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Objet</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Responsable</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('user_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Responsable']); ?>
				</div>
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Dépot']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-3">
					<?php if ( isset($this->data['Transformation']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'empty'=>'--Produit']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Produit']); ?>
					<?php endif ?>
				</div>
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php if ( isset($this->data['Transformation']['id']) ): ?>
						<?php echo $this->Form->input('quantite',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'min'=>0,'step'=>'any']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('quantite',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'TransformationEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
