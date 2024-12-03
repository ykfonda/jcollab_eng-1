<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Bontransfertdetail']['id']) ): ?>
			Modifier produit
		<?php else: ?>
			Ajouter un nouveau produit
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Bontransfertdetail',['id' => 'BontransfertdetailEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id',['id'=>'RecordID']); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-5">
					<?php if ( isset($this->data['Bontransfertdetail']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Produit']); ?>
						<?php echo $this->Form->hidden('produit_id',['class' => 'produit_id']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 form-control produit_id','label'=>false,'required' => true,'empty'=>'-- Produit']); ?>
					<?php endif ?>
				</div>
				<label class="control-label col-md-1">Date</label>
				<div class="col-md-2">
					<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date("d-m-Y")]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Dépot source</label>
				<div class="col-md-3">
					<?php if ( isset($this->data['Bontransfertdetail']['id']) ): ?>
						<?php echo $this->Form->input('depot_source_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Dépot source','options'=>$depots]); ?>
						<?php echo $this->Form->hidden('depot_source_id',['id'=>'DepotSource']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('depot_source_id',['class' => 'form-control','label'=>false,'required' => true,'disabled' => true,'empty'=>'-- Dépot source','options'=>$depots,'id'=>'DepotSource']); ?>
					<?php endif ?>
				</div>
				<label class="control-label col-md-2">Dépot destination</label>
				<div class="col-md-3">
					<?php if ( isset($this->data['Bontransfertdetail']['id']) ): ?>
						<?php echo $this->Form->input('depot_destination_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Dépot destination','options'=>$depots]); ?>
						<?php echo $this->Form->hidden('depot_destination_id'); ?>
					<?php else: ?>
						<?php echo $this->Form->input('depot_destination_id',['class' => 'form-control','disabled' => true,'label'=>false,'required' => true,'empty'=>'-- Dépot destination','options'=>$depots]); ?>
					<?php endif ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Stock</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock',['class' => 'stock form-control','label'=>false,'disabled' => true,'default'=>0,'min'=>0,'step'=>1]); ?>
				</div>
				<label class="control-label col-md-2">Quantité</label>
				<?php if($this->data['Bontransfert']['type'] == "Expedition") : ?>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock_destination',['class' => 'stock_source form-control','label'=>false,'required' => true,'default'=>0]); ?>
				</div>
				<?php else: ?>
					<?php echo $this->Form->input('stock_source',['class' => 'stock_source form-control','label'=>false,'required' => true,'default'=>0]); ?>
					<?php endif ?>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'BontransfertdetailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
