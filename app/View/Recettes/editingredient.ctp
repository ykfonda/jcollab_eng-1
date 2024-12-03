<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Produitingredient']['id']) ): ?>
			Modifier un ingrédient
		<?php else: ?>
			Nouveau ingrédient
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Produitingredient',['id' => 'ProduitIngredient','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Ingrédient</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('ingredient_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix d'achat</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_achat',['class' => 'form-control','label'=>false,'readonly' => true ,'min' =>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">Taux de perte</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('pourcentage_perte',['class' => 'form-control','label'=>false,'readonly' => true ,'min' =>0,'max'=>100]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('quantite',['class' => 'form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProduitIngredient','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
