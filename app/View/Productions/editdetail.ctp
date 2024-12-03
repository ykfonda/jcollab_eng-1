<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Productiondetail']['id']) ): ?>
			Modification une production
		<?php else: ?>
			Nouvelle production
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Productiondetail',['id' => 'ProductiondetailEditForm','class' => 'form-horizontal']); ?>
		<div class="row">
			<?php echo $this->Form->input('id'); ?>
			<div class="col-md-12">
				<div class="form-group row">
					<label class="control-label col-md-2">Produit</label>
					<div class="col-md-4">
						<?php if ( isset($this->data['Productiondetail']['id']) ): ?>
							<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'empty'=>'--Produit']); ?>
						<?php else: ?>
							<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Produit']); ?>
						<?php endif ?>
					</div>
					<label class="control-label col-md-1">Quantité</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('quantite_reel',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any','max'=>$this->data['Productiondetail']['quantite_theo'] ]); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProductiondetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
