<style>
#totalStockSource {
	cursor: not-allowed;
    background-color: #eeeeee !important;
    font-size: 14px;
    font-weight: normal;
    color: #333333;
    background-color: white;
    border: 1px solid #e5e5e5;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	display: block;
    width: 100%;
    height: 2.714rem;
    padding: 0.438rem 1rem;
	line-height: 1.45;
    color: #6E6B7B;
	background-clip: padding-box;
}
</style>


<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Expédition
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->button('Enregistrer (Etape 1)',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'MouvementSortie','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
		<?php echo $this->Form->create('Mouvement',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
    	<?php echo $this->Form->end(); ?>
    	<?php echo $this->Form->create('Mouvement',['id' => 'MouvementSortie','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">

				<div class="form-group row row">
					
					<label class="control-label col-md-2">Date sortie</label>
					<div class="col-md-2">
						<?php echo $this->Form->input('date_sortie',['class' => 'date-picker form-control','label'=>false,'required' => true,'type'=>'text','data-default-date'=>date('d-m-Y') ]); ?>
					</div>
				</div>

				<div class="form-group row row">
					<label class="control-label col-md-2">Dépôt source</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'options'=>$depots_source,'required' => true,'id'=>'DepotID']); ?>
					</div>
					<label class="control-label col-md-2">Site destination</label>
					<div class="col-md-3">
						<?php echo $this->Form->input('depot_destination_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotDestination','empty'=>'--Site destination','options'=>$depots_dest]); ?>
					</div>
				</div>

				<div class="form-group row">
					<label class="control-label col-md-2">Motif</label>
					<div class="col-md-4">
					<?php echo $this->Form->input('description', ['class' => 'form-control', 'label' => false, 'required' => true]); ?>
					</div>


					<label class="control-label col-md-2">T. Quantité sortie:</label>
					<div class="col-md-1">
						<span id="totalStockSource"></span>
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
	  
	  $('#MouvementSortie').on('submit',function(e){
		var error_quatite = false;
		$(".stock_source").each(function( ) {
			if($(this).val() <= 0) {
				e.preventDefault();
				error_quatite = true; 
			toastr.error("la quantite doit etre supérieur a 0");
			}	
		});
		if(!error_quatite)	
  		$('.saveBtn').attr('disabled',true);
  	});

	function loadproduit(produit_id,depot_id,element) {
	    $.ajax({
		  dataType: "json",
		  url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id+"/"+depot_id,
		  success: function(dt){
		    element.find('.stock').val(0);
		    element.find('.stock_source').attr('max',0);
		   /*  if ( typeof dt.Produit != 'undefined' && typeof dt.Produit.id != 'undefined' ) { */
		      console.log(dt.Produit);
			  element.find('.stock').val(dt.stock);
		      element.find('.stock_source').attr('max',dt.stock);
		   /*  } */
		  },
		  error: function(dt){
		    element.find('.stock').val(0);
		    element.find('.stock_source').attr('max',0);
		    toastr.error("Il y a un problème");
		  }
		}); 
	};

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
	      url: $(this).attr('href')+'/'+count+'/'+null+'/'+depot_id,
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
	$('#ScanForm').on('submit',function(e){
  		e.preventDefault();
  		var code_barre = $('#code_barre').val();
  		scaning(code_barre);
  	});

	function scaning(code_barre) {
		if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }

        var count = $('tbody#Main .child').length;
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);

	    var url = "<?php echo $this->Html->url(['action' => 'newrow']) ?>/"+count;
		var depot_id = $('#DepotID').val();
		if(depot_id == "") {
			toastr.error("Veuillez selectionner un depot source");
			return;
		}
	    $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'scan']) ?>/"+code_barre +"/" +depot_id,
	      success: function(result){
	      	if ( result.error == true ) toastr.error(result.message);
	      	else{
	      		/* var quantite_sortie = result.data.quantite_sortie;
	      		var produit_id = result.data.produit_id;
	      		var stock = result.data.stock;

	      		var full_path = url+'/'+produit_id+'/'+stock+'/'+quantite_sortie;
	      	 */	var quantite_sortie = result.data.quantite_sortie;
	      		var stock = result.data.stock;
			    var produit_id = result.data.produit_id;
			    var depot_id = $('#DepotID').val();
			    var full_path = url+'/'+produit_id+'/'+depot_id+'/'+stock+'/'+quantite_sortie;
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

		var totalStockSource = 0;
		$('.stock_source').each(function() {
		var valueStockSource = parseFloat($(this).val());
		if (!isNaN(valueStockSource)) {
			totalStockSource += valueStockSource;
		}
		});
		$('#totalStockSource').text(totalStockSource.toFixed(3));


	}
});
</script>
<?php $this->end() ?>