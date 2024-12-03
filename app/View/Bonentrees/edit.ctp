<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Bonentreedetail']['id']) ): ?>
			Modifier produit
		<?php else: ?>
			Ajouter un nouveau produit
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Bonentreedetail',['id' => 'BonentreedetailEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Bonentreedetail']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Produit']); ?>
						<?php echo $this->Form->hidden('produit_id'); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Produit']); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-8">
					<?php if ( !empty($depot_source_id) ): ?>
						<?php echo $this->Form->input('depot_source_id',['class' => 'form-control','label'=>false,'disabled' => true,'options'=>$depots]); ?>
						<?php echo $this->Form->hidden('depot_source_id',['value'=>$depot_source_id]); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Date entrée</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date("d-m-Y")]); ?>
				</div>
				<label class="control-label col-md-2">Date sortie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false,'type'=>'text']); ?>
				</div>
			</div>
			<div class="form-group row row">
				<label class="control-label col-md-2">Quantité</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock_source',['class' => 'stock_source form-control','label'=>false,'required' => true,'default'=>0,'min'=>0,'step'=>1]); ?>
				</div>
				<label class="control-label col-md-2">Numéro de lot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('num_lot',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BonentreedetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
