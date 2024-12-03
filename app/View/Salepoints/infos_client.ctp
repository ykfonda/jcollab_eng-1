<?php echo $this->Form->create('Client',['id' => 'ChooseClientForm','class' => 'form-horizontal']); ?>
	
		<?php echo $this->Form->input('id'); ?>
    
		<div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Nom</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('designation',['class'=>'form-control','type'=>'text','label'=>false,'id'=>'ClientId']); ?>
				</div>
                </div>
                <div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('adresse',['class'=>'form-control','type'=>'text','label'=>false,'id'=>'ClientId']); ?>
				</div>
                </div>
                <div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Ice</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('ice',['class'=>'form-control','type'=>'text','label'=>false,'id'=>'ClientId']); ?>
				</div>
                </div>
                
				
			
	</div>
										
	<?php echo $this->Form->end(); ?>

    <div class="modal-footer">
	
		
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ChooseClientForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	$(document).ready(function(){
    $('#ChooseClientForm').attr("target", "_blank");
});
</script>