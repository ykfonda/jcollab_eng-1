<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Objectif']['id']) ): ?>
			Modifier un objectif
		<?php else: ?>
			Ajouter un objectif
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Objectif',['id' => 'ObjectifEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Vendeur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('user_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'--Vendeur']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date début</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dated',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
				</div>
				<label class="control-label col-md-2">Date fin</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('datef',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Total jrs travail</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('total_jrs_travail',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">C.A mensuel</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('c_a_mensuel',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Visite mensuel</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('visite_mensuel',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">Nbr livraison</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('nbr_livraision',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Taux (Liv/Visit)</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('taux',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">C.A moyen par liv</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('c_a_moyen',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'step'=>'any']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ObjectifEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
