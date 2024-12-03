<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Mouvement']['id']) ): ?>
			Modifier 
		<?php else: ?>
			Nouvelle transfert
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Mouvement',['id' => 'MouvementEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Mouvement']['id']) ): ?>
					<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'-- Produit','disabled'=>true]); ?>
					<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'ProduitID','empty'=>'-- Produit']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row row" id="BlockProduit" style="display: none;">
				<label class="control-label col-md-2"></label>
				<div class="col-md-2">
					<img src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" style="width: 80px;" id="ProduitImage" />
				</div>
				<div class="col-md-6">
					<div id="ProduitInfo"></div>
				</div>
			</div>
			<div class="form-group row row" style="display: none;" id="BlockInformation">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<div class="alert alert-warning" style="padding: 8px;margin-bottom: 2px;"><strong>Information : </strong> La quantité présent dans le dépot est : <span id="Stock"></span> </div>
				</div>
			</div>
			<div class="form-group row row" style="display: none;" id="BlockError">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<div class="alert alert-danger" style="padding: 8px;margin-bottom: 2px;"><strong>Attention : </strong> Le stock dans ce dépôt est epuisé </div>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Dépôt source</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('depot_source_id',['class' => 'select2 form-control','label'=>false,'required' => true,'options'=>$depots,'id'=>'DepotSources']); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Dépôt destination</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('depot_destination_id',['class' => 'select2 form-control','label'=>false,'required' => true,'options'=>$depots]); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','default'=>date("d-m-Y")]); ?>
				</div>
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock_destination',['class' => 'stock_destination form-control','label'=>false,'required' => true,'min'=>0,'id'=>'Quantite','default'=>0]); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Description</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('description',['class'=>'form-control','label'=>false,'type'=>'textarea','rows'=>2]); ?>
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
