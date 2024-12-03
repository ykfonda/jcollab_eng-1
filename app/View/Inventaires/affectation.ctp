<div class="modal-header">
	<h4 class="modal-title">
		Affectation des produits
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Inventairedetail',['id' => 'InventaireAffectation','class' => 'form-horizontal']); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group row">
				<div class="col-md-12 text-center">
					<div class="alert alert-info" style="font-weight: bold;padding: 2px;margin-bottom: 2px;">Nombre de produits sélectionné est (<span id="count">0</span>) </div>
				</div>
            </div>
			<div class="form-group row">
				<div class="col-md-6">
					<a href="#" class="btn btn-success btn-sm select-all pull-left">Sélectionner tout</a>
				</div>
				<div class="col-md-6">
					<a href="#" class="btn btn-danger btn-sm deselect-all pull-right">Désélectionner tout</a>
				</div>
            </div>
			<div class="form-group row">
				<div class="col-md-12">
                  	<?php echo $this->Form->input('Produit',['class' => 'multi-selectl','multiple' => true,'id' => 'my_multi_select1','label'=>false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'InventaireAffectation','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
