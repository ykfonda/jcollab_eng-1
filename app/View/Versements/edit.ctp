<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Versement']['id']) ): ?>
			Modifier un versement
		<?php else: ?>
			Ajouter un versement
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Versement',['id' => 'VersementEditForm','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Référence</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('reference',['class' => 'form-control','label'=>false,'readonly'=>true]); ?>
				</div>
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php if ( isset($this->data['Versement']['id']) ): ?>
						<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'disabled' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
					<?php else: ?>
						<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Vendeur</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Versement']['id']) ): ?>
						<?php echo $this->Form->input('user_id',['class'=>'form-control','label'=>false,'disabled'=>true,'empty'=>'--Vendeur']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('user_id',['class'=>'select2 form-control','label'=>false,'required'=>true,'empty'=>'--Vendeur','id'=>'user_id']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Versement']['id']) ): ?>
						<?php echo $this->Form->input('client_id',['class'=>'form-control','label'=>false,'disabled'=>true,'empty'=>'--Client']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('client_id',['class'=>'select2 form-control','label'=>false,'required'=>false,'empty'=>'--Client','id'=>'client_id']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Vente</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Versement']['id']) ): ?>
						<?php echo $this->Form->input('Vente',['class'=>'select2 form-control','label'=>false,'disabled'=>true,'title'=>'Vente']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('Vente',['class'=>'select2 form-control','label'=>false,'required'=>true,'title'=>'Vente','id'=>'ventes']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Mode paiment</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('mode_paiement',['class'=>'form-control','label'=>false,'required'=>true,'options'=>$this->App->getModePaiment()]); ?>
				</div>
				<label class="control-label col-md-2">Agence</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('agence_id',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Agence']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Image</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('image',['class' => 'form-control','label'=>false,'type'=>'file','accept'=>"image/*"]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'VersementEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
