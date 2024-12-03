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
<button type="button" class="btn-nv btn btn-primary">Promotion Produit</button>
<button type="button" style="margin-left: 2rem;"  class="btn-mod btn btn-primary">Promotion Categorie</button>

</div>
<div class="modal-footer">
	
		
	
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	 $('.btn-nv').on('click',function(e){
    	e.preventDefault();
		$.ajax({
			url: "<?php echo $this->Html->url(['action' => 'editGeneraleProduit']); ?>",
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
			url: "<?php echo $this->Html->url(['action' => 'editGeneraleCategorie']); ?>",
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
