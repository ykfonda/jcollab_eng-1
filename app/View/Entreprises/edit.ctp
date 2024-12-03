<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Societe']['id']) ): ?>
			Modifier une société
		<?php else: ?>
			Nouvelle société
		<?php endif ?>
	</h4>
</div>
<div class="modal-body">
<?php echo $this->Form->create('Societe',['id' => 'SocieteEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<span style="font-weight: bold;font-size: 20px;">Information</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Designation</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('designation',['label' => false,'class' => 'form-control','required'=>true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['label' => false,'type' => 'text','class' => 'date-picker form-control','default'=>date('d-m-Y')]); ?>
				</div>
				<label class="control-label col-md-2">ICE</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('ice',['label' => false,'class' => 'form-control','required'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Identifiant fiscal</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('idfiscale',['label' => false,'class' => 'form-control']); ?>
				</div>
				<label class="control-label col-md-2">Registre de commerce</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('registrecommerce',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Patente</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('patent',['label' => false,'class' => 'form-control']); ?>
				</div>
				<label class="control-label col-md-2">CNSS</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('cnss',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Directeur général</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('dg',['label' => false,'class' => 'form-control']); ?>
				</div>
				<label class="control-label col-md-2">Modèle</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('pdfmodele_id',['label' => false,'class' => 'select2 form-control','empty'=>'--Modèle','required'=>true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Nature de l'activité</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nature',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Client</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('client_id',['label' => false,'class' => 'select2 form-control','options' => $clients,'empty'=>'-- Client','required'=>false]); ?>
				</div>
				<label class="control-label col-md-2">Fournisseur</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('fournisseur_id',['label' => false,'class' => 'select2 form-control','options' => $fournisseurs,'empty'=>'-- Fournisseur','required'=>false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-8">
					<span style="font-weight: bold;font-size: 20px;">Adresse</span>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Contact</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('contact',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Téléphone fixe</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('telfixe',['label' => false,'class' => 'form-control']); ?>
				</div>
				<label class="control-label col-md-2">Téléphone mobile</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('telmobile',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Fax</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('fax',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Website Url</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('website',['label' => false,'class' => 'form-control']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'SocieteEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	$(".select2").select2();
</script>