<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Client']['id']) ): ?>
			Modifier un prospect
		<?php else: ?>
			Ajouter un nouveau prospect
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Client',['id' => 'ClientEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Désignation</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('designation',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">ICE</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ice',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Type</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('categorieclient_id',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Responsable</label>
				<div class="col-md-3">
					<?php if ( $role_id == 1 ): ?>
					<?php echo $this->Form->input('user_id',['class' => 'form-control','label'=>false,'empty'=>'-- --']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('user_id',['class' => 'form-control','label'=>false,'empty'=>'-- --','disabled'=>true,'value'=>$user_id]); ?>
					<?php echo $this->Form->input('user_id',['type'=>'hidden','value'=>$user_id]); ?>
					<?php endif ?>
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
				<label class="control-label col-md-2">Ville</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ville_id',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Rating</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('rating',['class' => 'form-control','label'=>false,'empty'=>'-- Rating','required' => true,'options'=>$this->App->getImportance() ]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Catégorie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('clienttype_id',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Classification</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('classification',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => false,'options'=>$this->App->getClassification() ]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Note</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('note',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse',['class' => 'form-control','label'=>false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ClientEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
