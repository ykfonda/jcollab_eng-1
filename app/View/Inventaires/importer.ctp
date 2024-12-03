<div class="modal-header">
	<h4 class="modal-title">
		Importation des produits
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Inventairedetail',['id' => 'InventairedetailImportation','class' => 'form-horizontal','type'=>'file']); ?>
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
					<label class="control-label col-md-2">Qté réel</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.quantite_reel',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Vide','type'=>'select','id'=>'quantite_reel']); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Importer',array('div'=>false,'form'=>'InventairedetailImportation','class'=>'saveBtn btn btn-success','disabled'=>true)) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>