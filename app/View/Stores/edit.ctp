<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Store']['id']) ): ?>
			Modifier un site
		<?php else: ?>
			Ajouter un site
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Store',['id' => 'StoreEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Nom</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('societe_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Société']); ?>
				</div>
				<label class="control-label col-md-2">Type</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('type',['label' => false,'class' => 'form-control','required'=>true,'empty'=>'--Type','options'=>$this->App->getNature() ]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-4">
					<?php echo $this->Form->input('adresse', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Ville</label>
				<div class="col-md-2">
					<?php echo $this->Form->input('ville', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Pays</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('pays', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Télephone</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('tel', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Patente</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('numero_tp', ['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Code Journale</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('code_journal', ['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Frais de livraison</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('frais_livraison', ['class' => 'form-control','label'=>false,'options'=>$frais_livraison,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">ID Ecommerce</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('id_ecommerce', ['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
			<label class="control-label col-md-2">Code CSB</label>
				<div class="col-md-3">
					<?php echo $this->Form->text('code_csb', ['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">Adresse IP</label>
				<div class="col-md-3">
					<?php echo $this->Form->text('adresses_ip', ['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'StoreEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
