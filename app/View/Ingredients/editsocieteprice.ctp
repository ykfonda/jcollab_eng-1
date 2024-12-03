<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Produitprice']['id']) ): ?>
			Modifier un prix
		<?php else: ?>
			Ajouter un nouvau prix
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Produitprice',['id' => 'ProduitpriceSociete','class' => 'form-horizontal','type'=>'file']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('societe_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Store</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('store_id',['class' => 'select2 form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Prix de vente TTC</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('prix_vente',['class' => 'form-control','label'=>false,'required' => true ,'min' =>0,'step'=>'any']); ?>
				</div>
				<label class="control-label col-md-2">TVA(%)</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('tva',['class' => 'form-control','label'=>false,'empty'=>"--TVA",'options'=>$tvas,'required' => true]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'ProduitpriceSociete','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	$('#edit').on('change','#ProduitpriceSocieteId',function(e){
      
	var societe_id = $(this).val();
      if(societe_id != "")
	    loadStores(societe_id);
  	});

  	function loadStores(societe_id) {
	    $.ajax({
	      dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadStores']) ?>/"+societe_id,
	      success: function(dt){
	        $('#ProduitpriceStoreId').empty();
	        $('#ProduitpriceStoreId').append($('<option>').text('--Store').attr('value', ''));
	        $.each(dt, function(i, obj){
	          $('#ProduitpriceStoreId').append($('<option>').text(obj).attr('value', i));
	        });
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      }
	    }); 
	}
</script>