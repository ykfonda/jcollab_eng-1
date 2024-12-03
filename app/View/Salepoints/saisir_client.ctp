<style>
	.btn-1 {
 
		clear: left;
    display: table;
  margin: auto;
}
</style>
<div class="modal-header">
	
	<h4 class="modal-title">
		
			Saisir informations Client
		
	</h4>
</div>

<div class="modal-body">
<div class="btn-1">
<button type="button" class="btn-nv btn btn-primary">Nouveau</button>
<?php if($client_id != "1") : ?>
<button type="button" style="margin-left: 2rem;"  class="btn-mod btn btn-primary">Modifier</button>
<?php endif ?>
</div>
<div class="modal-footer">
	
		
	
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	 $('.btn-nv').on('click',function(e){
    	e.preventDefault();
		$.ajax({
			url: "<?php echo $this->Html->url(['action' => 'infosClient',$id,$client_id]) ?>",
			success: function(dt){
				$('#edit .modal-body').html(dt);
				//$('#edit').modal('show');
				//$('#edit .modal-footer').prepend('<input form="ChooseClientForm" class="saveBtn btn btn-success" type="submit" value="Enregistrer">');
			},
			error: function(dt){
				toastr.error("Il y a un probleme");
			},
			complete: function(){
				Init();
			}
			});
  });
  	$('.btn-mod').on('click',function(e){
    	e.preventDefault();
		$.ajax({
			url: "<?php echo $this->Html->url(['action' => 'infosClientExist',$id,$client_id]) ?>",
			success: function(dt){
				$('#edit .modal-body').html(dt);
				//$('#edit').modal('show');
				//$('#edit .modal-footer').prepend('<input form="ChooseClientForm" class="saveBtn btn btn-success" type="submit" value="Enregistrer">');
			},
			error: function(dt){
				toastr.error("Il y a un probleme");
			},
			complete: function(){
				Init();
			}
			});
  });
</script>