<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Visite']['id']) ): ?>
			Modifier visite
		<?php else: ?>
			Nouvelle visite
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Visite',['id' => 'VisiteEditForm','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Vendeur</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('user_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Vendeur']); ?>
				</div>
				<label class="control-label col-md-1">Date</label>
				<div class="col-md-2">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'default'=>date('d-m-Y'),'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('client_id',['class' => 'select2 form-control','label'=>false,'empty'=>'--Client']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Motif</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('Motifvisite',['class' => 'select2 form-control','label'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Image</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('image',['class' => 'form-control','label'=>false,'type'=>'file','accept'=>"image/*"]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Commentaire</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'VisiteEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
