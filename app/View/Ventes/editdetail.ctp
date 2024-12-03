<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Ventedetail']['id']) ): ?>
			Modifier un article
		<?php else: ?>
			Ajouter un article
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Ventedetail',['id' => 'VentedetailEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<?php echo $this->Form->input('depot_id',['type' => 'hidden','value'=>$depot_id,'id'=>'DepotID']); ?>
			<div class="form-group row">
				<label class="control-label col-md-2">Catégorie</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Ventedetail']['id']) ): ?>
					<?php echo $this->Form->input('categorieproduit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
					<?php echo $this->Form->input('categorieproduit_id',['label'=>false,'type'=>'hidden','id'=>'CategorieproduitID']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('categorieproduit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'CategorieproduitID','default'=>1]); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Article</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Ventedetail']['id']) ): ?>
					<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
					<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden','id'=>'ArticleID']); ?>
					<?php else: ?>
					<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'ArticleID']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'id'=>'QteChange']); ?>
				</div>
				<label class="control-label col-md-2">Prix HT</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prixachat',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'PrixAchat']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Total HT</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('total',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total']); ?>
					<?php echo $this->Form->input('tva',['type'=>'hidden','id'=>'TVA']); ?>
				</div>
				<label class="control-label col-md-2">Total TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ttc',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'TotalTVA']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'VentedetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>