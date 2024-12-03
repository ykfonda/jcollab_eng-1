<div class="modal-header">
	
	<h4 class="modal-title">
		Envoi par mail
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Email',['id' => 'EmailEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="alert alert-info text-center" id="Loading" style="margin-bottom:0px;display: none;">
				Envoi de votre mail est en cours ... <i class="fa fa-spinner faa-spin animated" style="font-size:25px !important;"></i> 
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Objet</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('objet',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Email</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('email',['class' => 'form-control','label'=>false,'required' => true,'type'=>'email','default'=>$email]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Message</label>
				<div class="col-md-8">
					<?php $content = "Bonjour,\n\nVeuillez trouver ci-joint le document.\n\nCordialement\n"; ?>
					<?php echo $this->Form->input('content',['class' => 'form-control','label'=>false,'required' => false,'rows'=>6,'default'=>$content]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'EmailEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>