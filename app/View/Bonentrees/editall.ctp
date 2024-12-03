<style>
#countDisplay, #totalDisplay, #totalPrixVente  {
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
			Nouveau bon d'entrée
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php echo $this->Form->button('Enregistrer & Terminer',['class'=>'btn btn-success saveBtn','type'=>'submit','form' => 'BonentreeMultiEntree','disabled'=>true]) ?>
		</div>
	</div>
	<div class="portlet-body">
    	<?php echo $this->Form->create('Bonentree',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
    	<?php echo $this->Form->end(); ?>
    	<?php echo $this->Form->create('Bonentree',['id' => 'BonentreeMultiEntree','class' => 'form-horizontal','autocomplete'=>'off']); ?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group row row">
					<label class="control-label col-md-2">Dépot</label>
					<div class="col-md-8">
						<?php echo $this->Form->input('depot_id',['class' => 'select2 form-control','label'=>false,'required' => true,'id'=>'DepotID','form'=>'BonentreeMultiEntree' ]); ?>
					</div>
				</div>
				<div class="form-group row row">
					<label class="control-label col-md-2">Date entrée</label>
					<div class="col-md-2">
						<?php echo $this->Form->input('date',['class' => 'form-control','label'=>false,'readonly' => true,'default'=>date('d-m-Y'),'type'=>'text','form'=>'BonentreeMultiEntree' ]); ?>
					</div>

					<label class="control-label col-md-1">T. Produit:</label>
					<div class="col-md-2">
						<div id="countDisplay"></div>
					</div>

					<label class="control-label col-md-1">T. Prix:</label>
					<div class="col-md-2">
						<span id="totalPrixVente"></span>
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
	                                <th style="width: 30%;">Produit</th>
	                                <th nowrap="">Quantité</th>
	                                <th nowrap="">Prix de vente</th>
	                                <th nowrap="">Valeur du stock</th>
	                                <th nowrap="">N° lot</th>
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
	                                <th style="width: 30%;"></th>
	                                <th nowrap=""></th>
	                                <th nowrap=""></th>
	                                <th nowrap=""></th>
	                                <th nowrap=""></th>
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
		<?php echo $this->Form->end(); ?>
    </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){
  
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  	var Init = function(){
  		$('.select2').select2();
  	}

  	Init();

  	$('#BonentreeMultiEntree').on('submit',function(e){
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

	    $.ajax({
	      url: "<?php echo $this->Html->url(['action' => 'scan']) ?>/"+code_barre,
	      success: function(result){
	      	if ( result.error == true ) toastr.error(result.message);
	      	else{
	      		var stock_source = result.data.stock_source;
	      		var produit_id = result.data.produit_id;
	      		var prix_vente = result.data.prix_vente;
	      		var valeur = result.data.valeur;

	      		var full_path = url+'/'+produit_id+'/'+stock_source+'/'+prix_vente+'/'+valeur;
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
			  console.log(dt);
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

		// Cumul du total des valeurs des champs d'entrée
		var total = 0;
		$('.stock_source').each(function() {
		var value = parseFloat($(this).val());
		if (!isNaN(value)) {
			total += value;
		}
		});
		$('#totalDisplay').text(total);

		// Comptage des éléments <tr class="child">
		var count = document.querySelectorAll('tr.child').length;
  		document.getElementById('countDisplay').textContent = count;

		// Cumul du total des valeurs des champs d'entrée "prix_vente"
		var totalPrixVente = 0;
		$('.prix_vente').each(function() {
		var valuePrixVente = parseFloat($(this).val());
		if (!isNaN(valuePrixVente)) {
			totalPrixVente += valuePrixVente;
		}
		});
		    $('#totalPrixVente').text(totalPrixVente.toFixed(3));	


		// Sélectionnez tous les éléments ayant la classe "prix_achat"
		var elementsPrix = document.getElementsByClassName("valeur");

		// Initialisez la variable pour stocker la somme cumulée
		var sommeCumulee = 0;

		// Parcourez tous les éléments et ajoutez leur valeur à la somme cumulée
		for (var i = 0; i < elementsPrix.length; i++) {
			var prix = parseFloat(elementsPrix[i].value);
			sommeCumulee += prix;
		}

		// Affichez la somme cumulée
		console.log("La somme cumulée des prix d'achat est : " + sommeCumulee);

		$('#totalPrixVente').text(sommeCumulee.toFixed(3));



	}

  	$('.addRow').on('click',function(e){
	    e.preventDefault();
        var count = $('tbody#Main .child').length;
        if( count >= 0 ) $('.saveBtn').attr('disabled',false);
	    else $('.saveBtn').attr('disabled',true);
	    $('.addRow').attr('disabled',true);
	    var url = $(this).attr('href')+'/'+count;
	    addrow(url);
  	});

  	$('#Main').on('click','.deleteRow',function(e){
        e.preventDefault();
        var element = $(this);
        element.closest('.child').remove();
        var count = $('tbody#Main .child').length;
        if( count == 0 ) $('.saveBtn').attr('disabled',true);
	    else $('.saveBtn').attr('disabled',false);
    });

  	$('#Main').on('input','.stock_source,.prix_vente',function(e){
  		var element = $(this);
  		calcule(element);
    });

  	$('#Main').on('change','.produit_id',function(e){
  		var produit_id = $(this).val();
  		var element = $(this);
  		$.ajax({
  		  dataType: "json",
	      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id,
	      success: function(dt){

	      	if ( typeof dt.Produit.id != 'undefined' ) {
	      		var prixvente = dt.Produit.prixvente;
	      		element.closest('.child').find('.prix_vente').val(prixvente);
	      	}else{
	      		element.closest('.child').find('.prix_vente').val(0);
	      		element.closest('.child').find('.valeur').val(0);
	      	}

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
    	var quantite = parseFloat(element.closest('.child').find('.stock_source').val());
		var prix_vente = parseFloat(element.closest('.child').find('.prix_vente').val());
  		var valeur = parseFloat(quantite*prix_vente);
  		element.closest('.child').find('.valeur').val(valeur);
    }

});
</script>
<?php $this->end() ?>