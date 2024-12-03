<div class="modal-header">
	<h4 class="modal-title">
		<?php if ( isset($this->data['Depot']['id']) ): ?>
			Modifier un dépot
		<?php else: ?>
			Nouveau dépot
		<?php endif ?>
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Depot',['id' => 'DepotEditForm','class' => 'form-horizontal']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Nom</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('libelle', ['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Société</label>
				<div class="col-md-3">
					<?php echo $this->Form->hidden('societe_id', ['class' => 'societe_id']); ?>
					<?php echo $this->Form->input('societe_id', ['class' => 'societe_id form-control','label'=>false,'disabled' => true,'empty'=>'--', 'id'=>'societeId']); ?>
				</div>
				<label class="control-label col-md-2">Site</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('store_id', ['class' => 'select2 form-control','label'=>false, 'required' => true,'empty'=>'--']); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Adresse</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('adresse', ['class' => 'form-control', 'label'=>false, 'required' => false]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2"></label>
				<div class="col-md-3">
					<?php echo $this->Form->input('principal', ['class' => 'uniform form-control','label'=>'Principale','type'=>'checkbox']); ?>
				</div>
				<label class="control-label col-md-2"></label>
				<div class="col-md-3">
					<?php echo $this->Form->input('vente', ['class' => 'uniform form-control','label'=>'Vente','type'=>'checkbox']); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'DepotEditForm','class' => 'saveBtn btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>
<script>
$('#edit').on('change','#DepotStoreId',function(e){
    e.preventDefault();
    var store_id = $(this).val();
    societe(store_id);
  });

  function societe(store_id) {
    $.ajax({
      type: 'GET',
      dataType: "json",
      url: "<?php echo $this->html->url(['action' => 'societe']) ?>/"+store_id,
      success : function(dt){
        $('.societe_id').val(dt.societe_id);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
    });
  }
  </script>