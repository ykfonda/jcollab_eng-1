<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['User']['id']) ): ?>
			Modifier un utilisateur
		<?php else: ?>
			Ajouter un nouvel utilisateur
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('User',['id' => 'UserEditForm','class' => 'form-horizontal','autocomplete'=>false]); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-3">Nom</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('nom',['class' => 'form-control','label'=>false,'required'=>true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3">Prénom</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('prenom',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3">Email</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3">Username</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('username',['class' => 'form-control','label'=>false,'type'=>'text','required'=>true]); ?>
				</div>
			</div>
			<?php if (!isset($this->data['User']['password'])): ?>
			<div class="form-group row">
				<label class="control-label col-md-3">Mot de passe</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('password',['class'=>'form-control','label'=>false,'type'=>'password','required'=>true]); ?>
				</div>
			</div>
			<?php endif ?>
			<div class="form-group row">
				<label class="control-label col-md-3">Role</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('role',['class'=>'form-control','label'=>false,'required'=>true,'options'=>$this->App->getRole(),'empty'=>'--Role']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-3">Téléphone</label>
				<div class="col-md-5">
					<?php echo $this->Form->input('tel',['class' => 'form-control','label'=>false,'type'=>'text']); ?>
				</div>
			</div>
			<?php echo $this->Form->input('avatar',['class' => 'form-control','label'=>false,'type'=>'hidden','value'=>'avatar.png']); ?>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'UserEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
