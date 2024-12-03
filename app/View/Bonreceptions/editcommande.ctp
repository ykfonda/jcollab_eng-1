<div class="modal-header">
	<h4 class="modal-title">
		Réception d'un bon de commande
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Bonreception',['id' => 'BonreceptionEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<?php echo $this->Form->hidden('user_id',['value'=>$user_id]); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Référence</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('reference',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
				</div>
				<label class="control-label col-md-2">Date réception</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Bon de commande</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('boncommande_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Bon de commande']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">No BL Fournisseur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('no_Bl_fournisseur',['class'=>'select2 form-control','label'=>false,'required'=>false,'empty'=>'--Bon de commande']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonreceptionEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
