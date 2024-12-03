<div class="modal-header">	
	<h4 class="modal-title">
		Sortie de stock
	</h4>
</div>
<div class="modal-body ">
<?php echo $this->Form->create('Sortiedetail',['id' => 'MouvementEditForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
	<div class="row">
		<?php echo $this->Form->input('id'); ?>
		<div class="col-md-12">
			<div class="form-group row">
				<label class="control-label col-md-2">Produit</label>
				<div class="col-md-8">
					<?php if ( isset($this->data['Sortiedetail']['id']) ): ?>
						<?php echo $this->Form->input('produit_id',['class' => 'form-control','label'=>false,'disabled' => true,'empty'=>'-- Votre choix --']); ?>
						<?php echo $this->Form->input('produit_id',['label'=>false,'type'=>'hidden']); ?>
					<?php else: ?>
						<?php echo $this->Form->input('produit_id',['class' => 'select2 produit_id form-control','label'=>false,'required' => true,'empty'=>'-- Votre choix --']); ?>
					<?php endif ?>
				</div>
			</div>
			<?php /* if(isset($produit["Produit"]["stockactuel"])) : */ ?>
			<!-- <div class="form-group row">
				<label class="control-label col-md-2">Dépot</label>
				<div class="col-md-8">	
					<?php /*echo $this->Form->input('depot_source_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotID','options'=>$depots,'empty'=>'-- Votre choix --']);*/ ?>	
				</div>
			</div> -->
			<?php /*  endif  */?>
			<div class="form-group row" id="BlockProduit" style="display: none;border: 1px solid silver;padding: 15px;">
				<label class="control-label col-md-2"></label>
				<div class="col-md-2">
					<img src="<?php echo $this->Html->url('/img/no-avatar.jpg') ?>" style="width: 80px;" id="ProduitImage" />
				</div>
				<div class="col-md-6">
					<div id="ProduitInfo"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Date sortie</label>
				<div class="col-md-3">
				<?php if ( isset($this->data['Sortiedetail']['id']) ): ?>
					<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false, 'required' => true,'type'=>'text']); ?>
				<?php else: ?>	
					<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false, 'required' => true,'type'=>'text','value'=>date("d-m-Y")]); ?>
				<?php endif ?>
				</div>
				<label class="control-label col-md-2">Numéro de lot</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('num_lot',['class' => 'form-control','label'=>false,'required' => true]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Qté en stock</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock',['class' => 'stock form-control','label'=>false,'value' => isset($produit["Produit"]["stockactuel"]) ? $produit["Produit"]["stockactuel"] : "", 'disabled' => true]); ?>
				</div>
				<label class="control-label col-md-2">Qté sortie</label>
				<div class="col-md-3">
					<?php echo $this->Form->input('stock_source',['class' => 'stock_source form-control','label'=>false,'required' => true/* ,'min'=>1,'max'=>0,'step'=>1 */]); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="control-label col-md-2">Description</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('description',['class' => 'form-control','label'=>false,'required' => false]); ?>
				</div>
			</div>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
</div>
<div class="modal-footer">
	<?php echo $this->Form->submit('Enregistrer',array('div' => false,'form' => 'MouvementEditForm','class' => 'saveBtn_sortie btn btn-success')) ?>
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	$( ".produit_id" ).change(function() {
		var produit_id = $(this).val();
		$.ajax({
		dataType: "json",
		url: "<?php echo $this->Html->url(['action' => 'loadquantite']) ?>/"+produit_id,
		success: function(dt){
			$(".stock").val(dt); 
		},
		error: function(dt){
		toastr.error("Il y a un problème");
		}
		});
	});
	
	
/* 	$('.date-picker-modify').flatpickr({
		altFormat: "DD-MM-YYYY",
		dateFormat: "d-m-Y",
		allowInput: true,
		locale: "fr",
	}); */


</script>
