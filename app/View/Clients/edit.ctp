<style>
	.radio-inline {
	margin-top: 0.8rem;
	}
	</style>
<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if (isset($this->data['Client']['id'])): ?>
			Modifier un client
		<?php else: ?>
			Ajouter un nouveau client
		<?php endif; ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Client', ['id' => 'ClientEditForm', 'class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<?php echo $this->Form->input('designation', ['class' => 'form-control', 'label' => 'Désignation/Nom complet', 'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date naissance</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date_naissance', ['class' => 'date-picker form-control', 'label' => false, 'required' => false, 'type' => 'text']); ?>
				</div>
				<label class="control-label col-md-2">Sexe</label>
				<div class="col-md-5">
				<label class="radio-inline">
					<input type="radio" name="data[Client][sexe]" value="0" <?php if (isset($this->data['Client']['sexe']) and $this->data['Client']['sexe'] == 0) {
    echo 'checked';
} ?>>Masculin
					</label>
					
					
					<label class="radio-inline">
					<input type="radio" name="data[Client][sexe]" value="1" <?php if (isset($this->data['Client']['sexe']) and $this->data['Client']['sexe'] == 1) {
    echo 'checked';
} ?>>Feminin
					</label>
					
				</div>
				
				
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Organisme</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('organisme', ['class' => 'form-control', 'label' => false, 'required' => false, 'options' => $this->App->getOrganisme()]); ?>
				</div>
				<label class="control-label col-md-2">ICE</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ice', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Type</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('categorieclient_id', ['class' => 'form-control', 'label' => false, 'empty' => '-- --', 'required' => false]); ?>
				</div>
				
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Tél</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('telmobile', ['class' => 'form-control', 'label' => false, 'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">FAX</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('fax', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Ville</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ville_id', ['class' => 'select2 form-control', 'label' => false, 'empty' => '-- --', 'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Rating</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('rating', ['class' => 'form-control', 'label' => false, 'required' => true, 'options' => $this->App->getImportance()]); ?>
				</div>
			</div>
			<div class="form-group row">
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email', ['class' => 'form-control', 'label' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse', ['class' => 'form-control', 'label' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Note</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('note', ['class' => 'form-control', 'label' => false]); ?>
				</div>
				
			</div>
			<div class="form-group row">
			<label class="control-label col-md-2">Compte comptable</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('compte_comptable', ['class' => 'form-control', 'label' => false]); ?>
				</div>
				</div>
				<div class="form-group row">
			<label class="control-label col-md-2">Code client</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('code_client', ['class' => 'form-control', 'label' => false]); ?>
				</div>
				</div>

				<div class="form-group row">
			<label class="control-label col-md-2">Points fidelite</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('points_fidelite', ['class' => 'form-control', 'label' => false]); ?>
				</div>
				</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'ClientEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
