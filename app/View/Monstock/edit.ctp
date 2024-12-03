<div class="modal-header">
	
	<h4 class="modal-title">
		Adaptation du stock
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Depotproduit',['id' => 'DepotproduitEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'disabled' => true]); ?>
					<?php echo $this->Form->hidden('produit_id'); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('depot_id',['class' => 'form-control','label'=>false,'disabled' => true]); ?>
					<?php echo $this->Form->hidden('depot_id'); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('quantite',['class' => 'quantite form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'DepotproduitEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
</div>
