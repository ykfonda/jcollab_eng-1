<div class="modal-header">
	
	<h4 class="modal-title">
		<?php if ( isset($this->data['Expense']['id']) ): ?>
			Modifier un dépense
		<?php else: ?>
			Ajouter un dépense
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Expense',['id' => 'ExpenseEditForm','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Libelle</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle',['class' => 'form-control','label'=>false,'required'=>true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'type'=>'text','default'=>date('d-m-Y')]); ?>
				</div>
				<label class="control-label col-md-2">Montant</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('montant',['class'=>'form-control','label'=>false,'required'=>true,'min'=>1,'step'=>'any']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ExpenseEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
