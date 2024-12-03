<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Tva']['id']) ): ?>
			Modifier une tva
		<?php else: ?>
			Ajouter une tva
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Tva',['id' => 'TvaEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Valeur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('valeur',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">TVA sur Achat</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('achat',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">TVA sur Vente</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('vente',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'TvaEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
