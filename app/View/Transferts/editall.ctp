<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Transfert en masse
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->button('Valider transfert',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'TransfertEnMasse','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
    	<?php echo $this->Form->create('Mouvement',['id' => 'TransfertEnMasse','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row row">
					<label class="control-label col-md-2">Dépot source</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_source_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotSource','options'=>$depots]); ?>
					</div>
					<label class="control-label col-md-2">Dépot destination</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_destination_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotDestination','empty'=>'-- Dépot destination','options'=>$depots]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<label class="control-label col-md-2">Date</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'default'=>date('d-m-Y'),'type'=>'text' ]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<div class="col-md-12">
						<div class="table-scrollable">
							<table id="dynamique_data" class="table table-striped table-bordered">
		                        <thead>
		                            <tr>
		                               	<th style="width: 50%;">Produit</th>
		                                <th style="width: 20%;">Stock actuel</th>
		                                <th style="width: 20%;">Quantité</th>
		                                <th class="actions">
		                                	<?php if ($globalPermission['Permission']['a']): ?>
											 	<button disabled="disabled" href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
											 		<i class="fa fa-plus"></i> Ajouter un produit
											 	</button>
								      		<?php endif ?>
		                                </th>                                    
		                            </tr>
		                        </thead>
		                        <tbody id="Main">
		                        	
		                        </tbody>
		                        <tbody>
		                            <tr>
		                                <th style="width: 50%;"></th>
		                                <th style="width: 20%;"></th>
		                                <th style="width: 20%;"></th>
		                                <th class="actions">
		                                	<?php if ($globalPermission['Permission']['a']): ?>
											 	<button disabled="disabled" href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm btn-block">
											 		<i class="fa fa-plus"></i> Ajouter un produit
											 	</button>
								      		<?php endif ?>
		                                </th>                                    
		                            </tr>
		                        </tbody>
		                    </table>
						</div>
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

  	$('#TransfertEnMasse').on('submit',function(e){
      	var depot_destination_id = $('#DepotDestination').val();
    	var depot_source_id = $('#DepotSource').val();

    	if ( depot_source_id == depot_destination_id ) {
    		e.preventDefault();
	      	toastr.error("Veuillez changer le dépôt destination svp !");
	      	return;
	    } else {
     		$('.saveBtn').attr("disabled", true);
	    }
  	});

  	$('#Main').on('change','.produit_id',function(e){
  		var depot_id = $('#DepotSource').val();
	    var produit_id = $(this).val();
	    var element =  $(this).closest('.child');
	    loadQuatite(depot_id,produit_id,element);
	    loadProduit(element);
  	});

  	function loadQuatite(depot_id,produit_id,element) {
	    $.ajax({
	      dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadquatite']) ?>/"+depot_id+"/"+produit_id,
	      success: function(dt){
	        if ( dt >= 0 ) {
	        	element.find('.stock_source').attr({ "max" : dt });
		        element.find('.stock').val( dt );
		        loadProduit(element);
	        }
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      }
	    }); 
	}

  	$('#DepotSource').on('change',function(e){
	    var depot_destination_id = $('#DepotDestination').val();
	    var depot_source_id = $('#DepotSource').val();

	    if( depot_source_id != '' && depot_destination_id != '' ) {
	    	$('.addRow').attr('disabled',false);
	    	$('.saveBtn').attr('disabled',false);
	    } else {
	    	$('.addRow').attr('disabled',true);
	    	$('.saveBtn').attr('disabled',true);
	    }
  	});

  	$('#DepotDestination').on('change',function(e){
	    var depot_destination_id = $('#DepotDestination').val();
	    var depot_source_id = $('#DepotSource').val();

	    if( depot_source_id != '' && depot_destination_id != '' ) {
	    	$('.addRow').attr('disabled',false);
	    	$('.saveBtn').attr('disabled',false);
	    } else {
	    	$('.addRow').attr('disabled',true);
	    	$('.saveBtn').attr('disabled',true);
	    }
  	});


  	$('.addRow').on('click',function(e){
	    e.preventDefault();
        var depot_source_id = $('#DepotSource').val();
        var count = $('tbody#Main .child').length;

        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    $('.addRow').attr('disabled',true);
	    $.ajax({
	      url: $(this).attr('href')+'/'+count+'/'+depot_source_id,
	      success: function(dt){
			$('tbody#Main').append(dt);
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
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

  	$('#Main').on('input','.stock_source',function(e){
  		var element = $(this);
  		calculeValeurStock(element);
    });

    function loadProduit(element) {
    	var produit_id = element.closest('.child').find('.produit_id').val();
    	$.ajax({
  		  dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id,
	      success: function(dt){

	      	if ( typeof dt.Produit.id != 'undefined' ) {
	      		var prix_vente = dt.Produit.prix_vente;
	      		element.closest('.child').find('.prix_vente').val(prix_vente);
	      	}else{
	      		element.closest('.child').find('.prix_vente').val(0);
	      		element.closest('.child').find('.valeur').val(0);
	      	}

	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	      	calculeValeurStock(element);
	      }
	    });
    }

    function calculeValeurStock(element) {
    	var quantite = parseInt(element.closest('.child').find('.stock_source').val());
		var prix_vente = parseInt(element.closest('.child').find('.prix_vente').val());
  		var valeur = parseInt(quantite*prix_vente);
  		element.closest('.child').find('.valeur').val(valeur);
    }

    function calcule(count) {
    	var quantite_total = 0;
  		for (var i = 0; i < count; i++) {
  			var quantite = $("input[name='data[MouvementDetail]["+i+"][stock_source]']").val();
  			quantite_total = parseInt(quantite_total) + parseInt(quantite);
  		}

  		var quantite = $('.quantite_generale').val();
  		if ( quantite_total > quantite ) {
  			toastr.error("Vous avez dépacez la quantite globale");
  			$('.saveBtn').attr('disabled',true);
  		}else{
  			$('.saveBtn').attr('disabled',false);
  		}
    }

});
</script>
<?php $this->end() ?>