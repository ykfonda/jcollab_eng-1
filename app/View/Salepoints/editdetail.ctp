<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Bonlivraisondetail']['id']) ): ?>
			Modifier un produit
		<?php else: ?>
			Ajouter un produit
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Bonlivraisondetail',['id' => 'BonlivraisondetailEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id',['id'=>'DetailID']); ?>
		<div class="col-md-12">
			<div class="alert alert-info text-center" id="Loading" style="margin-bottom:5px;display: none;">
				Traitement est en cours ... <i class="fa fa-spinner faa-spin animated" style="font-size:25px !important;"></i> 
			</div>
			<?php echo $this->Form->input('depot_id',['type' => 'hidden','value'=>1,'id'=>'DepotID']); ?>
			<?php echo $this->Form->hidden('paquet',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>1,'id'=>'PaquetChange','default'=>1,'step'=>'any']); ?>
			<?php echo $this->Form->hidden('total_unitaire',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'TotalUnitaire','step'=>'any']); ?>
			<div class="form-group row">
				<label class="control-label col-md-2">Catégorie</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Bonlivraisondetail']['id']) ): ?>
						<?php echo $this->Form->input('categorieproduit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
						<?php echo $this->Form->input('categorieproduit_id',['label'=>false,'type'=>'hidden','id'=>'CategorieproduitID']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('categorieproduit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'CategorieproduitID','default'=>1]); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Bonlivraisondetail']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
						<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden','id'=>'ArticleID']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'ArticleID']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row" id="MessageContainer" style="display: none;">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<div class="alert alert-warning" style="margin-bottom: 5px;padding: 5px;text-align: center;" id="MessageContent"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>1,'id'=>'QteChange','step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">Prix TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente',['class'=>'form-control','label'=>false,'required'=>true,'min'=>1,'id'=>'PrixVente','step'=>'any']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Remise (%)</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('remise',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'max'=>100,'id'=>'Remise','step'=>'any','default'=>0]); ?>
				</div>
				<label class="control-label col-md-2">Montant remise</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant_remise',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'MontantRemise','step'=>'any','default'=>0]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-3"></div>
				<label class="control-label col-md-2">Total TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('total',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total','step'=>'any']); ?>
					<?php echo $this->Form->input('tva',['type'=>'hidden','id'=>'TVA']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonlivraisondetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>