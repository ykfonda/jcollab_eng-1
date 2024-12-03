<div class="modal-header">
	<h4 class="modal-title">
		Motif Abandon
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Motif',['id' => 'MotifAbandonForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
	
		<?php echo $this->Form->hidden('order_code',['value'=>$order_code]); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Motif</label>
				<div class="col-md-3">
				<select name="data[Motif][motif]" class="select2 form-control" id="MotifMotif">
					<?php foreach ($motifsabandons as $motifsabandon): ?>
						<option value="<?php echo $motifsabandon; ?>"><?php echo $motifsabandon; ?></option>
					<?php endforeach; ?>
				</select>
				</div>
				
			</div>
			
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'MotifAbandonForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
