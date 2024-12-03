<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Kitchensystem']['id']) ): ?>
			Modifier une kds
		<?php else: ?>
			Nouvelle kds
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Kitchensystem',['id' => 'KitchensystemEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
				<label class="control-label col-md-2">Adresse IP</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ip_adresse',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Store</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('store_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Store','id'=>'StoreId']); ?>
				</div>
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('societe_id',['class' => 'societe_id form-control','label'=>false,'disabled' => true,'empty'=>'--Société']); ?>
					<?php echo $this->Form->hidden('societe_id',['class' => 'societe_id']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8 text-center">
					<?php if ( isset($this->data['Kitchensystem']['id']) AND isset($this->data['Produit']) ): ?>
						<div class="alert alert-danger p-1" style="font-weight: bold;">Nombre de produits sélectionné est (<span id="count"><?php echo count($this->data['Produit']) ?></span>) </div>
					<?php else: ?>
						<div class="alert alert-danger p-1" style="font-weight: bold;">Nombre de produits sélectionné est (<span id="count">0</span>) </div>
					<?php endif ?>
				</div>
	        </div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-4">
					<a href="#" class="btn btn-success btn-sm select-all pull-left">Sélectionner tout</a>
				</div>
				<div class="col-md-4">
					<a href="#" class="btn btn-danger btn-sm deselect-all pull-right">Désélectionner tout</a>
				</div>
	        </div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
	              	<?php echo $this->Form->input('Produit',['class' => 'multi-selectl','multiple' => true,'id' => 'my_multi_select1','label'=>false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'KitchensystemEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
