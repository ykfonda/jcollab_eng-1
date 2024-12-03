<div class="modal-header">
	
	<h4 class="modal-title">
		Importation des clients
	</h4>
</div>
<div class="modal-body ">
	<?php echo $this->Form->create('Client',['id' => 'ClientImportation','class' => 'form-horizontal','type'=>'file']); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info text-center" id="Loading" style="margin-bottom:0px;display: none;">
					Importation des données en cours ... <i class="fa fa-spinner faa-spin animated" style="font-size:25px !important;"></i> 
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Désignation</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.designation',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Vide','type'=>'select','id'=>'designation']); ?>
					</div>
					<label class="control-label col-md-2">ICE</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.ice',['class' => 'form-control','label'=>false,'required' => true,'empty'=>'--Vide','type'=>'select','id'=>'ice']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Tél</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.telmobile',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Vide','type'=>'select','id'=>'telmobile']); ?>
					</div>
					<label class="control-label col-md-2">FAX</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.fax',['class' => 'form-control','empty'=>'--Vide','type'=>'select','label'=>false,'id'=>'fax']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">E-mail</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.email',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Vide','type'=>'select','id'=>'email']); ?>
					</div>
					<label class="control-label col-md-2">Adresse</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('csv.adresse',['class'=>'form-control','label'=>false,'required'=>true,'empty'=>'--Vide','type'=>'select','id'=>'adresse']); ?>
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-md-2">Fichier</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('file',['id'=>'files','class' => 'imported_file form-control','label'=>false,'type'=>'file','accept'=>".CSV,.csv",'required'=>true]); ?>
					</div>
				</div>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Importer',array('div'=>false,'form'=>'ClientImportation','class'=>'saveBtn btn btn-success','disabled'=>true)) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>