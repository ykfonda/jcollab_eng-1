<div class="modal-header">	
	<h4 class="modal-title">
		Bon retour a partir de plusieurs tickets T09
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Salepoint',['id' => 'Brt09Form','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Date Debut</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date_debut',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
				</div>
				<label class="control-label col-md-1">Date fin</label>
				<div class="col-md-4">
                <?php echo $this->Form->input('date_fin',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
				
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Fournisseur</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('fournisseur_id',['class' => 'select2 form-control','label'=>false,'required' => true]); ?>
				</div>
				
			</div>
		
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'Brt09Form','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
