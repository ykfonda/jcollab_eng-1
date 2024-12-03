<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Fournisseur']['id']) ): ?>
			Modifier un fournisseur
		<?php else: ?>
			Ajouter un nouveau fournisseur
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Fournisseur',['id' => 'FournisseurEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Désignation</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('designation',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">RC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('registrecommerce',['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Tél</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('telmobile',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">FAX</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('fax',['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">ICE</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ice',['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Ville</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ville_id',['class' => 'select2 form-control','label'=>false,'empty'=>'--Ville']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
			
			<div class="form-group row">
			<label class="control-label col-md-2">Compte comptable</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('compte_comptable',['class' => 'form-control','label'=>false]); ?>
				</div>
				</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'FournisseurEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
