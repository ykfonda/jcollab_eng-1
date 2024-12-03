<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Inventaire']['id']) ): ?>
			Modifier un inventaire
		<?php else: ?>
			Nouvel inventaire
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Inventaire',['id' => 'InventaireEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Objet</label>
				<div class="col-md-4">
					<?php echo $this->Form->input('libelle', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-1">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date', ['class' => 'date-picker form-control','label'=>false,'readonly' => false,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Inventaire']['id']) ): ?>
						<?php echo $this->Form->input('depot_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'--Dépot']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Dépot']); ?>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'InventaireEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
