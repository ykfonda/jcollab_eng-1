<div class="modal-header">
	<h4 class="modal-title">
		Importation des produits
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Produit',['id' => 'ProduitImportation','class' => 'form-horizontal','type'=>'file']); ?>
		<div class="row">
			<div class="col-md-12 mb-1">
				<div class="alert alert-info text-center p-1" id="Loading" style="display: none;">
					Importation des données en cours ... <i class="fa fa-spinner fa-2x faa-spin animated"></i> 
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group row" style="border-bottom:1px solid silver;padding-bottom: 5px;">
					<label class="control-label col-md-2">Fichier</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('file',['id'=>'files','class' => 'imported_file form-control','label'=>false,'type'=>'file','accept'=>".CSV,.csv",'required'=>true]); ?>
					</div>
				</div>
				<div class="form-group row" style="border-bottom:1px solid silver;padding-bottom: 5px;">
					<label class="control-label col-md-2"></label>
					<div class="col-md-3">
						<?php echo $this->Form->input('check',['class' => 'uniform form-control','label'=>'Videz la liste des produits','type'=>'checkbox']); ?>
					</div>
					<label class="control-label col-md-2">Délimiteur</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('delimiteur',['class' => 'form-control','label'=>false,'options'=>$this->App->getDelimiteur() ]); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Code à barre</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.code_barre',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Vide','type'=>'select','id'=>'code_barre']); ?>
					</div>
					<label class="control-label col-md-2">Libellé</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.libelle',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Vide','type'=>'select','id'=>'libelle']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Prix d'achat HT</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.prixachat',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Vide','type'=>'select','id'=>'prixachat']); ?>
					</div>
					<label class="control-label col-md-2">Prix de vente TTC</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.prix_vente',['class' => 'form-control','empty'=>'--Vide','type'=>'select','label'=>false,'id'=>'prix_vente']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Tva achat</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.tva_achat',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'tva_achat']); ?>
					</div>
					<label class="control-label col-md-2">Tva vente</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.tva_vente',['class' => 'form-control','empty'=>'--Vide','type'=>'select','label'=>false,'id'=>'tva_vente']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Unité</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.unite',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'unite']); ?>
					</div>
					<label class="control-label col-md-2">Catégorie</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.categorie',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'categorie']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Pesé</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.pese',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'pese']); ?>
					</div>
					<label class="control-label col-md-2">Compte achat</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.cpt_achat',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'cpt_achat']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Compte vente</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.cpt_vente',['class'=>'form-control','label'=>false,'empty'=>'--Vide','type'=>'select','id'=>'cpt_vente']); ?>
					</div>
					
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Importer',array('div'=>false,'form'=>'ProduitImportation','class'=>'saveBtn btn btn-success','disabled'=>true)) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>