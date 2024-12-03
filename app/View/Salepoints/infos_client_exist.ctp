<?php echo $this->Form->create('Client',['id' => 'ChooseClientForm','class' => 'form-horizontal']); ?>
	
		<?php echo $this->Form->input('id'); ?>
    
		<div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Nom</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('client_id',['class'=>'select2 form-control','label'=>false,'id'=>'ClientId',"value" => $client_id]); ?>
				</div>
                </div>
                <div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('adresse',['class'=>'form-control','type'=>'text','label'=>false,'id'=>'Adresse']); ?>
				</div>
                </div>
                <div class="form-group row">
				<label style="    color: #69738b;font-weight: 600;" class="control-label col-md-2">Ice</label>
				<div class="col-md-8">
                <?php echo $this->Form->input('ice',['class'=>'form-control','type'=>'text','label'=>false,'id'=>'Ice']); ?>
				</div>
                </div>
                
				
			
	</div>
										
	<?php echo $this->Form->end(); ?>

    <div class="modal-footer">
	
		
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ChooseClientForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
<script>
    $(function(){
    $('.select2').select2();
  
    $('#ChooseClientForm').attr("target", "_blank");

    client_id = $(".select2 option:selected").val();
    
 
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadClient' ]) ?>/"+client_id,
      success: function(dt){

        $("#Adresse").val(dt.adresse);
        $("#Ice").val(dt.ice);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
    $('#edit').on('change','#ClientId',function(e){
    client_id = $(this).val();
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadClient' ]) ?>/"+client_id,
      success: function(dt){

        $("#Adresse").val(dt.adresse);
        $("#Ice").val(dt.ice);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  });
    });
</script>