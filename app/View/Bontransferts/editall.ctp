<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Nouveau bon de transfert
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->button('Enregistrer & Terminer',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'BontransfertMultiEntree2','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
		<?php echo $this->Form->create('Bontransfert',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
    	<?php echo $this->Form->end(); ?>
    	<?php echo $this->Form->create('Bontransfert',['id' => 'BontransfertMultiEntree2','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row row">
					<label class="control-label col-md-2">Date de transfert</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'default'=>date('d-m-Y'),'type'=>'text' ]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<label class="control-label col-md-2">Dépot source</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_source_id',['class' => 'select2 depot_source form-control','label'=>false,'required' => true,'id'=>'DepotSource','empty'=>'--Dépot source','options'=>$depots]); ?>
					</div>
					<label class="control-label col-md-2">Dépot destination</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_destination_id',['class' => 'select2 depot_destination form-control','label'=>false,'required' => true,'id'=>'DepotDestination','empty'=>'--Dépot destination','options'=>$depots]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<label class="control-label col-md-2"></label>
					<div class="col-md-8">
						<?php echo $this->Form->input('code_barre',['class' => 'form-control','label'=>false,'required' => false,'id'=>'code_barre','placeholder'=>'Scanner code à barre ...','form'=>'ScanForm','maxlength'=>13,'minlength'=>13]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<div class="col-md-12">
						<div class="table-scrollable">
							<table id="dynamique_data" class="table table-striped table-bordered text-center">
		                        <thead>
		                            <tr>
		                                <th nowrap="" style="width: 30%;">Produit</th>
		                                <th nowrap="" style="width: 14%;">Stock</th>
		                                <th nowrap="" style="width: 14%;">Quantité</th>
		                                <th nowrap="" style="width: 14%;">Prix d'achat</th>
		                                <th nowrap="" style="width: 14%;">Valeur du stock</th>
		                                <th nowrap="" class="actions">
		                                	<?php if ($globalPermission['Permission']['a']): ?>
											 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm pull-right">
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
		                                <th nowrap="" style="width: 30%;"></th>
		                                <th nowrap="" style="width: 14%;"></th>
		                                <th nowrap="" style="width: 14%;"></th>
		                                <th nowrap="" style="width: 14%;"></th>
		                                <th nowrap="" style="width: 14%;"></th>
		                                <th nowrap="" class="actions">
		                                	<?php if ($globalPermission['Permission']['a']): ?>
											 	<button href="<?php echo $this->Html->url(['action' => 'newrow']) ?>" class="addRow btn btn-primary btn-sm pull-right">
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

  /* 	$('#Main').on('change','.produit_id',function(e){
  		var depot_id = $('#DepotSource').val();
	    var produit_id = $(this).val();
	    var element =  $(this).closest('.child');
	    loadQuatite(depot_id,produit_id,element);
  	}); */

	  $('#BontransfertMultiEntree2').submit(function (evt) {
		var depot_destination = $( ".depot_destination option:selected" ).text();
		var depot_source = $( ".depot_source option:selected" ).text();
		if(depot_source == depot_destination)  {
			toastr.error("Le dépot source ne peut pas être le même que le dépot destination");
			evt.preventDefault();
			$('.saveBtn').attr('disabled',false);
		}
		  
		var error_quatite = false;
		$(".stock_source").each(function( ) {
			if($(this).val() <= 0) {
				evt.preventDefault();
				error_quatite = true; 
			toastr.error("la quantite doit etre supérieur a 0");
			}	
		});
		if(!error_quatite)	
  		$('.saveBtn').attr('disabled',true);
    	
    	
		
	});
	$('.depot_destination').on('change',function(e){
  		var depot_destination = $( ".depot_destination option:selected" ).text();
		var depot_source = $( ".depot_source option:selected" ).text();
		if(depot_source == depot_destination)  {
			toastr.error("Le dépot source ne peut pas être le même que le dépot destination");
		}	  
	});
	$('.depot_source').on('change',function(e){
  		var depot_destination = $( ".depot_destination option:selected" ).text();
		var depot_source = $( ".depot_source option:selected" ).text();
		if(depot_source == depot_destination)  {
			toastr.error("Le dépot source ne peut pas être le même que dépot destination");
		}	  
	});  
	  $('#ScanForm').on('submit',function(e){
  		e.preventDefault();
  		var code_barre = $('#code_barre').val();
  		scaning(code_barre);
  	});

	function scaning(code_barre) {
		if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }
		var depot_id = $('#DepotSource').val();
        var count = $('tbody#Main .child').length;
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    var url = "<?php echo $this->Html->url(['action' => 'newrow']) ?>/"+count;
		if(depot_id == "") {
			toastr.error("Veuillez selectionner un depot source");
			return;
		}
	
	    $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'scan']) ?>/"+code_barre+"/"+depot_id,
	      success: function(result){
	      	if ( result.error == true ) toastr.error(result.message);
	      	else{
	      		var stock_source = result.data.stock_source;
	      		var produit_id = result.data.produit_id;
	      		var prix_achat = result.data.prix_achat;
				var stock = result.data.stock;
	      		var valeur = result.data.valeur;

	      		var full_path = url+'/'+produit_id+'/'+stock_source+'/'+prix_achat+'/'+stock+'/'+valeur +'/'+depot_id;
	      		console.log('full_path : ',full_path)
	      		addrow(full_path);
	      	} 
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(dt){
			$('#code_barre').val('');
	      }
	    });
	}
  
	async function addrow(url) {
	    await $.ajax({
	      url: url,
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
	}

  	function loadQuatite(depot_id,produit_id,element) {
	    $.ajax({
	      dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadquatite']) ?>/"+depot_id+"/"+produit_id,
	      success: function(dt){
	        if ( dt >= 0 ) {
	        	element.find('.stock_source').attr({ "max" : dt });
		        element.find('.stock').val( dt );
	        }
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      }
	    }); 
	}

  	/* $('#BontransfertMultiEntree2').on('submit',function(e){
		//$('.saveBtn').attr('disabled',true);
  	});
	$('.saveBtn').on('click',function(e){
		$("#BontransfertMultiEntree2").submit();
	}); */
  	var depot_id = $('#DepotSource').val();
	if( depot_id == '' ) $('.addRow').attr('disabled',true);
	else $('.addRow').attr('disabled',false);

  	$('#DepotSource').on('change',function(e){
  		var depot_id = $('#DepotSource').val();
  		if( depot_id == '' ) $('.addRow').attr('disabled',true);
  		else $('.addRow').attr('disabled',false);
  	});

  	$('.addRow').on('click',function(e){
	    e.preventDefault();
        var count = $('tbody#Main .child').length;
        var depot_id = $('#DepotSource').val();
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    $('.addRow').attr('disabled',true);
	    $.ajax({
	      url: $(this).attr('href')+'/'+count+'/'+ 0+'/'+0+'/'+0+'/'+0+'/'+0+'/'+depot_id,
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

  	$('#Main').on('input','.stock_source,.prix_achat',function(e){
  		var element = $(this);
  		calcule(element);
    });

  	$('#Main').on('change','.produit_id',function(e){
  		var produit_id = $(this).val();
  		var element = $(this);
		var depot_id = $('#DepotSource').val();
  		$.ajax({
  		  dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id+"/"+depot_id,
	      success: function(dt){
			
	      
	      		var prixachat = dt.prixachat;
				var stock = dt.stock;
	      		element.closest('.child').find('.prix_achat').val(prixachat);
			    element.parent().parent().next().find('.stock').val(stock);
	      	/* 
	      		element.closest('.child').find('.prix_achat').val(0);
	      		element.closest('.child').find('.valeur').val(0); */
	      	

	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	      	calcule(element);
	      }
	    });
    });

    function calcule(element) {
    	var quantite = element.closest('.child').find('.stock_source').val();
		var prix_achat = element.closest('.child').find('.prix_achat').val();
  		var valeur = quantite*prix_achat;
		
  		element.closest('.child').find('.valeur').val(valeur);
    }

});

/* $('.saveBtn').attr('disabled',false); */
</script>
<?php $this->end() ?>