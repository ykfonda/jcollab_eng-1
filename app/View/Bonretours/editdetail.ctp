<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Bonretourdetail']['id']) ): ?>
			Modifier un article
		<?php else: ?>
			Ajouter un article
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Commandedetail',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
    	<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('Bonretourdetail',['id' => 'BonretourdetailEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id',['id'=>'DetailID']); ?>
		<div class="col-md-12">
			<?php echo $this->Form->input('depot_id',['type' => 'hidden','value'=>1,'id'=>'DepotID']); ?>
			
			<div class="form-group row">
				<label class="control-label col-md-2">Article</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Bonretourdetail']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'empty'=>'-- Votre choix','disabled'=>true]); ?>
						<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden','id'=>'ArticleID']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix','id'=>'ArticleID']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row row">
					<label class="control-label col-md-2"></label>
					<div class="col-md-8">
						<?php echo $this->Form->input('code_barre',['class' => 'form-control','label'=>false,'required' => false,'id'=>'code_barre','placeholder'=>'Scanner code à barre ...','form'=>'ScanForm','maxlength'=>13,'minlength'=>13]); ?>
					</div>
				</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'id'=>'QteChange','step'=>'any']); ?>
				</div>
			</div>
			<?php echo $this->Form->hidden('paquet',['class'=>'form-control','label'=>false,'readonly'=>true,'id'=>'PaquetChange','default'=>1,'step'=>'any']); ?>
			<?php echo $this->Form->hidden('total_unitaire',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'TotalUnitaire','step'=>'any']); ?>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix </label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente',['class'=>'form-control','label'=>false,'required'=>true,'id'=>'PrixVente','step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">Total TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ttc',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'Total','step'=>'any']); ?>
					<?php echo $this->Form->input('tva',['type'=>'hidden','id'=>'TVA']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonretourdetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>