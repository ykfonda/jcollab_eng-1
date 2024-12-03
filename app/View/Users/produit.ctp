<div class="modal-header">
	
	<h4 class="modal-title">
		Information produit
	</h4>
</div>
<div class="modal-body form-horizontal">
	<?php echo $this->Form->create('Produit',['id' => 'ProduitSearch','class' => 'form-horizontal','autocomplete'=>false]); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Recherche</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('codebarre',['type'=>'text','class' => 'form-control','label'=>false,'required'=>true,'id'=>'codebarre','autofocus'=>true,'placeholder'=>'Scanner Ou Tappez Le Code à barre / Désignation / Référence ... ']); ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div id="produitinfo"></div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
