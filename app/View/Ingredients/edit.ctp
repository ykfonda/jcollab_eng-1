<style>
.select2-selection {
	height : 3.2em;
}
</style>

<div id="id1">
<div class="modal-header">
	<h4 class="modal-title">
		<?php if (isset($this->data['Produit']['id'])): ?>
			Modifier un produit
		<?php else: ?>
			Nouveau produit
		<?php endif; ?>
	</h4>
</div>
<div class="modal-body " id="mod">
<?php echo $this->Form->create('Produit', ['id' => 'ProduitEditForm', 'class' => 'form-horizontal', 'type' => 'file', 'autocomplete' => 'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
		<div class="form-group row">

			<div class="col-md-4">
				<label class="control-label">Référence</label>
				<?php echo $this->Form->input('reference', [
				'class' => 'form-control', 
				'label' => false, 
				'readonly' => true
				]); ?>
			</div>

			<div class="col-md-4">
				<label class="control-label">EAN13</label>
				<?php echo $this->Form->input('ean13', [
				'class' => 'form-control', 
				'label' => false, 
				'readonly' => false // Modifié pour rendre éditable
				]); ?>
			</div>

			<div class="col-md-4">
				<label class="control-label">Date création</label>
				<?php echo $this->Form->input('date', [
				'class' => 'form-control', 
				'label' => false, 
				'readonly' => true, 
				'type' => 'text', 
				'default' => date('d-m-Y')
				]); ?>
			</div>
			</div>


			<div class="form-group row">
				<label class="control-label col-md-2">Libellé</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle', ['class' => 'form-control', 'label' => false, 'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix d'achat HT</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prixachat', ['class' => 'prixachat form-control', 'label' => false, 'required' => true, 'min' => 0, 'step' => 'any']); ?>
				</div>
				<label class="control-label col-md-2">Prix de vente TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente', ['class' => 'prix_vente form-control', 'label' => false, 'required' => true, 'min' => 0, 'step' => 'any']); ?>
				</div>
			</div>
	        <div class="form-group row">
	          <label class="control-label col-md-2">TVA achat</label>
	          <div class="col-md-3">
	            <?php echo $this->Form->input('tva_achat', ['class' => 'form-control', 'label' => false, 'empty' => '--TVA achat', 'options' => $tvas, 'required' => true]); ?>
	          </div>
	          <label class="control-label col-md-2">TVA vente</label>
	          <div class="col-md-3">
	            <?php echo $this->Form->input('tva_vente', ['class' => 'form-control', 'label' => false, 'empty' => '--TVA vente', 'options' => $tvas, 'required' => true]); ?>
	          </div>
	        </div>
			<div class="form-group row">
				<label class="control-label col-md-2">Pourcentage du perte</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('pourcentage_perte', ['class' => 'form-control', 'label' => false, 'default' => 0, 'min' => 0, 'max' => 100]); ?>
				</div>
				<label class="control-label col-md-2">Actif</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('active', ['class' => 'form-control', 'label' => false, 'required' => true, 'options' => $this->App->OuiNon()]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Image</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('image', ['class' => 'form-control', 'label' => false, 'type' => 'file', 'accept' => 'image/*']); ?>
				</div>
			</div>
			<div class="form-group row">
	          <label class="control-label col-md-2">Etat</label>
	          <div class="col-md-3">
	            <?php echo $this->Form->input('etat', ['class' => 'form-control', 'label' => false, 'empty' => '--Etat', 'options' => $this->App->getEtatProduit()]); ?>
	          </div>
	          <label class="control-label col-md-2">Afficher sur</label>
	          <div class="col-md-3">
	            <?php echo $this->Form->input('display_on', ['class' => 'form-control', 'label' => false, 'required' => true, 'empty' => '--Afficher sur', 'options' => $this->App->getNatureProduit(), 'default' => $this->Session->read('Auth.User.StoreSession.type')]); ?>
	          </div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Catégorie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('categorieproduit_id', ['class' => 'form-control', 'label' => false, 'required' => true, 'empty' => '--Catégorie']); ?>
				</div>
				<label class="control-label col-md-2">Sous Catégorie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('souscategorieproduit_id', ['class' => 'form-control', 'label' => false, 'empty' => '--Sous Catégorie']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Unité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('unite_id', ['class' => 'form-control', 'label' => false, 'empty' => '--Unité']); ?>
				</div>
				<label class="control-label col-md-2">Description</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('description', ['class' => 'form-control', 'label' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Code à barre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('code_barre', ['class' => 'form-control', 'required' => true, 'label' => false, 'maxlength' => 13]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Compte Achat</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('cpt_achat', ['class' => 'form-control', 'label' => false, 'maxlength' => 8]); ?>
				</div>
				<label class="control-label col-md-2">Compte Vente</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('cpt_vente', ['class' => 'form-control', 'label' => false, 'maxlength' => 8]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Compte Stock</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('cpt_stock', ['class' => 'form-control', 'label' => false, 'maxlength' => 8]); ?>
				</div>
				<label class="control-label col-md-2"></label>
				<div class="col-md-3">
					<?php echo $this->Form->input('pese', ['class' => 'uniform form-control', 'label' => 'Pesé', 'type' => 'checkbox']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Type OF</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('type_of', ['class' => 'form-control', 'label' => false, 'required' => true, 'options' => ['auto' => 'Automatique', 'man' => 'Manuelle']]); ?>
				</div>
				
			</div>
			
			
			<div class="form-group row">
				<label class="control-label col-md-2">Poids</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('poids', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>

				
				</div>
				<label class="control-label col-md-2">Volume</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('volume', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
				</div>
				<div class="form-group row">
				<label class="control-label col-md-2">Cdt en US</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('conditionnement', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div></div>
				<div class="form-group row">
				<label class="control-label col-md-2">DLC Jours</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dlc_jours', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">DLC Années</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dlc_annees', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
			</div>
				<div class="form-group row">
				<label class="control-label col-md-2">DLC Mois</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dlc_mois', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
				<label class="control-label col-md-2">DLC Heures</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dlc_heures', ['class' => 'form-control', 'label' => false, 'required' => false]); ?>
				</div>
			</div>

			<div class="form-group row">
        <label class="control-label col-md-2"></label>
          <div class="col-md-3 Num_lot">
            <?php echo $this->Form->input('num_lot', ['class' => 'uniform form-control', 'label' => 'Geré Par Lot', 'type' => 'checkbox']); ?>
          </div>
		</div>

        <div class="form-group row">
          <label class="control-label col-md-2">Type Conditionnement</label>
          <div class="col-md-8">
             <select name="data[Produit][type_conditionnement][]" class="select2 form-control" multiple="multiple" id="ProduitTypeConditionnement">
             <?php foreach ($condtionnements as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php if (in_array($value, $typeconditionnementslibelles)) { ?>
                selected <?php } ?>><?php echo $value; ?></option>   
              <?php } ?>
            </select>
          </div>
        </div>
		
			<div class="form-group row">
				<label class="control-label col-md-2">Option</label>
				<div class="col-md-8 ">
				<select name="data[Produit][options1][]" class="select2 form-control" multiple="multiple"  id="ProduitOptions">
             <?php foreach ($options as $key => $value) { ?>
                <option value="<?php echo $key; ?>" <?php if (in_array($value, $optionlibelles)) { ?>
                selected <?php } ?>><?php echo $value; ?></option>   
              <?php } ?>
            </select>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer', ['div' => false, 'form' => 'ProduitEditForm', 'class' => 'saveBtn btn btn-success']); ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
</div>

<script>
$(".produit[multiple] option").prop("selected", "selected");

  </script>
