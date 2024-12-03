<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Produitprice']['id']) ): ?>
			Modifier un prix
		<?php else: ?>
			Ajouter un nouvau prix
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Produitprice',['id' => 'ProduitpriceFournisseur','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Fournisseur</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('fournisseur_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix d'achat HT</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_achat',['class' => 'form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">TVA(%)</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('tva',['class' => 'form-control','label'=>false,'empty'=>"--TVA",'options'=>$tvas,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<?php echo $this->Form->input('default_frs',['type' => 'checkbox', 'class' => 'uniform', 'label' => 'Fournisseur par défaut']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProduitpriceFournisseur','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
