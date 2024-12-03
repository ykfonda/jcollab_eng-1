
<div class="modal-header">
	
	<h4 class="modal-title">
		
			Choisir un Client
		
	</h4>
</div>

<div class="modal-body">
<?php echo $this->Form->create('Client',['id' => 'ChooseClientForm','class' => 'form-horizontal']); ?>
	
		<?php echo $this->Form->input('id',["value" => $id]); ?>
    
		<div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Client</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('client_id',['class'=>'select2 form-control',"default" => $client_id,'options'=> $clients,'label'=>false,'required'=>true,'empty'=>'--Client','id'=>'ClientId']); ?>
				</div>
				
			
	</div>
										
	<?php echo $this->Form->end(); ?>


<div class="modal-footer">
	
		<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ChooseClientForm','class' => 'saveBtn btn btn-success')) ?>
	
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>