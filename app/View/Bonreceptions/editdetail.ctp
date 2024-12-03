<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Bonreceptiondetail']['id']) ): ?>
			Modifier un produit
		<?php else: ?>
			Ajouter un produit
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Commandedetail',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
    	<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('Bonreceptiondetail',['id' => 'BonreceptiondetailEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id',['id'=>'DetailID']); ?>
		<div class="col-md-12">
			<div class="alert alert-info text-center" id="Loading" style="padding:5px;display: none;">
				Traitement en cours ... <i class="fa fa-spinner faa-spin fa-2x animated"></i> 
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Bonreceptiondetail']['id']) ): ?>
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
					<?php if ( isset($this->data['Bonreceptiondetail']['id']) ): ?>
						<?php if ( !empty($this->data['Bonreceptiondetail']['boncommandedetail_id']) ): ?>
							<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'default'=>0,'id'=>'QteChange','step'=>'any','max'=>$this->data['Bonreceptiondetail']['qte_cmd'] ]); ?>
						<?php else: ?>
							<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'default'=>0,'id'=>'QteChange','step'=>'any']); ?>
						<?php endif ?>
					<?php else: ?>
						<?php echo $this->Form->input('qte',['class'=>'form-control','label'=>false,'required'=>true,'min'=>0,'default'=>0,'id'=>'QteChange','step'=>'any']); ?>
					<?php endif ?>
				</div>
				<label class="control-label col-md-2">N° de lot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('num_lot',['class'=>'form-control','label'=>false,'required'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix d'achat</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente',['class'=>'form-control','label'=>false,'required'=>true,'min'=>1,'id'=>'PrixVente','step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">Total</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ttc',['class'=>'form-control','label'=>false,'readonly'=>true,'min'=>0,'id'=>'TotalTTC','step'=>'any']); ?>
					<?php echo $this->Form->hidden('total',['id'=>'TotalHT','default'=>0]); ?>
					<?php echo $this->Form->hidden('montant_tva',['id'=>'MontantTVA','default'=>0]); ?>
					<?php echo $this->Form->hidden('tva',['id'=>'TVA','default'=>20]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>

<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonreceptiondetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>