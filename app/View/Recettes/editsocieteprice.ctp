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
<?php echo $this->Form->create('Produitprice',['id' => 'ProduitpriceSociete','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('societe_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix de vente</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente',['class' => 'form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">TVA(%)</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('tva',['class' => 'form-control','label'=>false,'empty'=>"--TVA",'options'=>$this->App->getTVA(),'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProduitpriceSociete','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
