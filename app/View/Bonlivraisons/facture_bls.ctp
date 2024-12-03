<div class="modal-header">	
	<h4 class="modal-title">
		Facture a partir de plusieurs Bls
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Bonlivraison',['id' => 'BonlivraisonEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
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
		
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonlivraisonEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
