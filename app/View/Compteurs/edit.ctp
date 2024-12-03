<div class="modal-header">
	<h4 class="modal-title">
		<?php if (isset($this->data['Compteur']['id'])): ?>
			Modifier un compteur
			<?php else : ?>
				Nouveau compteur
			
				<?php endif; ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Compteur', ['id' => 'CompteurEditForm', 'class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
			<label class="control-label col-md-2">Store</label>
				<div class="col-md-3">
				<?php if (isset($this->data['Compteur']['id'])): ?>
					<?php echo $this->Form->input('store_id', ['class' => 'form-control select2', 'label' => false, 'required' => true, 'disabled' => true, 'empty' => '--Store']); ?>
					<?php else : ?>
						<?php echo $this->Form->input('store_id', ['class' => 'form-control select2', 'label' => false, 'required' => true, 'empty' => '--Store']); ?>
					<?php endif; ?>
				</div>	
			<label class="control-label col-md-2">Module</label>
				<div class="col-md-3">
				<?php if (isset($this->data['Compteur']['id'])): ?>
					<?php echo $this->Form->input('module', ['class' => 'form-control select2', 'label' => false, 'required' => true, 'disabled' => true, 'empty' => '--Module']); ?>
			
					<?php else : ?>
						<?php echo $this->Form->input('module', ['class' => 'form-control select2', 'label' => false, 'required' => true, 'empty' => '--Module']); ?>
			<?php endif; ?>
				
				</div>
				
			</div>
			<div class="form-group row">
                <label class="control-label col-md-2">Préfix</label>
				<div class="col-md-3">
				
					<?php echo $this->Form->input('prefix', ['class' => 'form-control', 'label' => false, 'required' => true, 'id' => 'Prefix']); ?>
					
				</div>
				<label class="control-label col-md-2">Numero</label>
				<div class="col-md-3">
				<?php if (isset($this->data['Compteur']['id'])) : ?>	
					<?php echo $this->Form->input('numero', ['class' => 'form-control', 'type' => 'number', 'label' => false, 'required' => true]); ?>
				<?php else : ?>
					<?php echo $this->Form->input('numero', ['class' => 'form-control', 'type' => 'number', 'label' => false, 'required' => true]); ?>
				<?php endif; ?>
					
					
				</div>
			</div>
		
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'CompteurEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
