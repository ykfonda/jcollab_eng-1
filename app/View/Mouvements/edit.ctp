<div class="modal-header">	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Mouvement']['id']) ): ?>
			Modifier une entrée
		<?php else: ?>
			Nouvelle entrée
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Mouvement',['id' => 'MouvementEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Mouvement']['id']) ): ?>
					<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Produit']); ?>
					<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Produit','id'=>'ProduitId']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row" id="BlockProduit" style="display: none;border: 1px solid silver;padding: 15px;">
				<label class="control-label col-md-2"></label>
				<div class="col-md-2">
					<img src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" style="width: 80px;" id="ProduitImage" />
				</div>
				<div class="col-md-6">
					<div id="ProduitInfo"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Fournisseur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('fournisseur_id',['class' => 'select2 form-control','label'=>false,'required' => false,'empty'=>'-- Fournisseur']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('depot_source_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotID','options'=>$depots]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date entrée</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date("d-m-Y")]); ?>
				</div>
				<label class="control-label col-md-2">Date sortie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false,'required' => false,'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock_source',['class' => 'stock_source form-control','label'=>false,'required' => true,'min'=>1,'step'=>1]); ?>
				</div>
				<label class="control-label col-md-2">Numéro de lot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('num_lot',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Description</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('description',['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'MouvementEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
