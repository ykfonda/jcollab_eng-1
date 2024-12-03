<style>
.select2-selection {
	height : 3.2em;
}
</style>

<div id="id1">
<div class="modal-header">
	<h4 class="modal-title">
		Impression produit
	</h4>
</div>
<div class="modal-body " id="mod">
<?php echo $this->Form->create('Bonlivraisondetail', ['id' => 'ScanForm', 'class' => 'form-horizontal', 'autocomplete' => 'off']); ?>
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('Produit', ['id' => 'ProduitEditForm', 'class' => 'form-horizontal', 'type' => 'file', 'autocomplete' => 'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
           	<label class="control-label col-md-2"></label>
				<div class="col-md-8">
                <?php echo $this->Form->input('code_barre', ['class' => 'form-control', 'label' => false, 'required' => false, 'id' => 'code_barre', 'placeholder' => 'Scanner code à barre ...', 'form' => 'ScanForm', 'maxlength' => 13, 'minlength' => 7]); ?>
				<?php echo $this->Form->hidden('code_barre_val', ['class' => 'form-control code_barre', 'label' => false, 'required' => false, 'id' => 'code_barre']); ?>
			
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('produit', ['class' => 'form-control', 'label' => false, 'Id' => 'Produit', 'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">DLC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dlc', ['class' => 'dlc form-control', 'label' => false, 'required' => true, 'min' => 0, 'step' => 'any']); ?>
				</div>
				<label class="control-label col-md-2">Quantite</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('quantite', ['class' => 'quantite form-control', 'label' => false, 'required' => true, 'min' => 0, 'step' => 'any']); ?>
				</div>
			</div>
	        <div class="form-group row">
	          <label class="control-label col-md-2">Numero de lot</label>
	          <div class="col-md-3">
	            <?php echo $this->Form->input('lot', ['class' => 'lot form-control', 'label' => false, 'required' => true]); ?>
	          </div>
	         
	        </div>
			
			
			
			
			
			
			

		
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Imprimer', ['div' => false, 'form' => 'ProduitEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
</div>

