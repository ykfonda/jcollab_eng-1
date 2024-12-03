<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Expédition
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->button('Valider & Terminer',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'ExpeditionSortie','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
    	<?php echo $this->Form->create('Expedition',['id' => 'ExpeditionSortie','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">

				<div class="form-group row row">
					
					<label class="control-label col-md-2">Date sortie</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','data-default-date'=>date('d-m-Y') ]); ?>
					</div>
				</div>

				<div class="form-group row row">
					<label class="control-label col-md-2">Dépot</label>
					<div class="col-md-3">
					<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotID']); ?>
					</div>
					<label class="control-label col-md-2">Store</label>
					<div class="col-md-3">
					    <?php echo $this->Form->input('store_id',['class' => 'form-control','label'=>false,'required' => true,'options'=>$stores]); ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-2">Description</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('description',['class' => 'form-control','label'=>false,'required' => false]); ?>
					</div>
				</div>

				<div class="form-group row row">
					<div class="col-md-12">
						<table id="dynamique_data" class="table table-striped table-bordered text-center">
	                        <thead>
	                            <tr>
	                                <th style="width: 40%;" nowrap="">Produit</th>
	                                <th style="width: 20%;" nowrap="">Qté en stock</th>
	                                <th style="width: 20%;" nowrap="">Qté sortie</th>
	                                <th style="width: 20%;" nowrap="">N° de lot</th>
	                                <th style="width: 20%;" nowrap="" class="actions">
	                                	<?php if ($globalPermission['Permission']['a']): ?>
										 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
										 		<i class="fa fa-plus"></i> Ajouter un produit
										 	</button>
							      		<?php endif ?>
	                                </th>                                    
	                            </tr>
	                        </thead>
	                        <tbody id="Main">
	                        	
	                        </tbody>
	                        <thead>
	                            <tr style="border-top: 1px solid silver;">
	                                <th style="width: 40%;" nowrap=""></th>
	                                <th style="width: 20%;" nowrap=""></th>
	                                <th style="width: 20%;" nowrap=""></th>
	                                <th style="width: 20%;" nowrap=""></th>
	                                <th style="width: 20%;" nowrap="" class="actions">
	                                	<?php if ($globalPermission['Permission']['a']): ?>
										 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
										 		<i class="fa fa-plus"></i> Ajouter un produit
										 	</button>
							      		<?php endif ?>
	                                </th>                                    
	                            </tr>
	                        </thead>
	                    </table>
					</div>
				</div>

			</div>
		</div>
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){
  
  	var Init = function(){
  		$('.select2').select2();
	    $('.date-picker').flatpickr({
	      altFormat: "DD-MM-YYYY",
	      dateFormat: "d-m-Y",
	      allowInput: true,
	      locale: "fr",
	    });
  	}

  	Init();

	async function loadproduit(produit_id,depot_id,element) {
		await $.ajax({
		  dataType: "json",
		  url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id+"/"+depot_id,
		  success: function(dt){
		    element.find('.stock').val(0);
		    element.find('.stock_source').attr('max',0);
		    if ( typeof dt.Produit != 'undefined' && typeof dt.Produit.id != 'undefined' ) {
		      element.find('.stock').val(dt.Produit.stock);
		      element.find('.stock_source').attr('max',dt.Produit.stock);
		    }
		  },
		  error: function(dt){
		    element.find('.stock').val(0);
		    element.find('.stock_source').attr('max',0);
		    toastr.error("Il y a un problème");
		  }
		}); 
	}

    $('#Main').on('change','.produit_id',function(e){
    	var element = $(this).closest('.child');
	    var depot_id = $('#DepotID').val();
	    var produit_id = element.find('.produit_id').val();
	    loadproduit( produit_id , depot_id , element);
	});

  	$('.addRow').on('click',function(e){
	    e.preventDefault();
        var count = $('tbody#Main .child').length;
        var depot_id = $('#DepotID').val();
        $('.addRow').attr('disabled',true);
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    $.ajax({
	      url: $(this).attr('href')+'/'+count+'/'+depot_id,
	      success: function(dt){
			$('tbody#Main').append(dt);
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème Produit");
	      },
	      complete: function(){
	      	$('.addRow').attr('disabled',false);
	        Init();
	      }
	    });
  	});

  	$('#Main').on('click','.deleteRow',function(e){
        e.preventDefault();
        var element = $(this);
        element.closest('.child').remove();
        var count = $('tbody#Main .child').length;
        if( count == 0 ) $('.saveBtn').attr('disabled',true);
	    else $('.saveBtn').attr('disabled',false);
    });

});
</script>
<?php $this->end() ?>