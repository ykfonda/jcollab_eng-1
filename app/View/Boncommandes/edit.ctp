<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Boncommande']['id']) ): ?>
			Modifier un bon de commande
		<?php else: ?>
			Nouveau bon de commande
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Boncommande',['id' => 'BoncommandeEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<?php echo $this->Form->hidden('user_id',['value'=>$user_id]); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Référence</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('reference',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
				</div>
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Fournisseur</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('fournisseur_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Fournisseur']); ?>
				</div>
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('depot_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Dépot']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BoncommandeEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
