<div class="modal-header">
	
	<h4 class="modal-title">
		Maitre une réduction
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Facture',['id' => 'FactureEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Total à payer</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('total_a_payer_ht',['class' => 'form-control','label'=>false,'disabled' => true,'id'=>'TotalBefore']); ?>
				</div>
				<label class="control-label col-md-2">Réduction</label>
				<div class="col-md-3">
					<?php $reste_a_payer = (isset( $this->data['Facture']['reste_a_payer'] )) ? $this->data['Facture']['reste_a_payer'] : '' ; ?>
					<?php $total_a_payer_ht = (isset( $this->data['Facture']['total_a_payer_ht'] )) ? $this->data['Facture']['total_a_payer_ht'] : '' ; ?>
					<?php echo $this->Form->input('reduction',['class' => 'form-control','label'=>false,'required' => true,'min'=>0,'max'=>$total_a_payer_ht,'step'=>'any','id'=>'Reduction']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Net à payer</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('total_a_payer_ht',['class'=>'form-control','label'=>false,'disabled'=>true,'min'=>0,'step'=>'any','id'=>'TotalAfter','default'=>$total_a_payer_ht,'readonly' => true]); ?>
				</div>
				<!-- <label class="control-label col-md-2">Le reste à payer</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('reste_a_payer',['data-reste'=>$reste_a_payer,'class'=>'form-control','label'=>false,'disabled'=>true,'min'=>0,'step'=>'any','id'=>'RestePayer','readonly' => true]); ?>
				</div> -->
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'FactureEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
