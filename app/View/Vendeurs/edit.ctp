<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['User']['id']) ): ?>
			Modifier un vendeur
		<?php else: ?>
			Nouveau vendeur
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('User',['id' => 'UserEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Nom</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('nom',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Prénom</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prenom',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false,'required' => true,'type'=>"email"]); ?>
				</div>
				<label class="control-label col-md-2">Sexe</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('sexe',['class' => 'form-control','label'=>false,'options' => $this->App->getSexe()]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse',['class' => 'form-control','label'=>false,'rows'=>2]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Pseudo</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('username',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Mot de passe</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('password',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date naissance</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date_naissance',['class' => 'date-picker form-control','label'=>false,'type'=>'text']); ?>
				</div>
				<label class="control-label col-md-2">Role</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('role_id',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'UserEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
