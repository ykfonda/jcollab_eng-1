
<?php echo $this->Form->create('Promotion', ['id' => 'PromotionEditForm', 'class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('client_id', ['class' => 'form-control select2', 'label' => false, 'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('produit_id', ['class' => 'select2 form-control', 'label' => false, 'required' => true, 'empty' => '--Produit']); ?>
				</div>
			</div>
			<div class="form-group row">
			
			<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant', ['class' => 'form-control', 'label' => false, 'type' => 'float', 'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Date limite</label>
				<div class="col-md-3">
				<?php echo $this->Form->input('date_limite', ['class' => 'date-picker form-control', 'label' => false, 'type' => 'text', 'required' => true]); ?>
				</div>
			</div>
			
			
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'PromotionEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
