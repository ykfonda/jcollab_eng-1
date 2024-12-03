<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Transformationdetail']['id']) ): ?>
			Modification une transformation
		<?php else: ?>
			Nouvelle transformation
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Transformationdetail',['id' => 'TransformationdetailEditForm','class' => 'form-horizontal']); ?>
		<div class="row">
			<?php echo $this->Form->input('id'); ?>
			<div class="col-md-12">
				<div class="form-group row">
					<label class="control-label col-md-2">Produit à transformer</label>
					<div class="col-md-4">
						<?php if ( isset($this->data['Transformationdetail']['id']) ): ?>
							<?php echo $this->Form->input('produit_a_transformer_id',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'empty'=>'--Produit à transformer','options'=>$produits]); ?>
						<?php else: ?>
							<?php echo $this->Form->input('produit_a_transformer_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Produit à transformer','options'=>$produits]); ?>
						<?php endif ?>
					</div>
					<label class="control-label col-md-1">Quantité</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('quantite_a_transformer',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any' ]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Produit transformé</label>
					<div class="col-md-4">
						<?php if ( isset($this->data['Transformationdetail']['id']) ): ?>
							<?php echo $this->Form->input('produit_transforme_id',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'empty'=>'--Produit transformé','options'=>$produits]); ?>
						<?php else: ?>
							<?php echo $this->Form->input('produit_transforme_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Produit transformé','options'=>$produits]); ?>
						<?php endif ?>
					</div>
					<label class="control-label col-md-1">Quantité</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('quantite_transforme',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any' ]); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'TransformationdetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
