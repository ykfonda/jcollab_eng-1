<?php $form = ( isset( $form ) ) ? '#'.$form : 'form' ; ?>
<?php $depot_id = ( isset( $depot_id ) ) ? $depot_id : 1 ; ?>
<?php $client_id = ( isset( $client_id ) ) ? $client_id : 0 ; ?>
<script type="text/javascript">

	var depot_id = parseInt("<?php echo $depot_id ?>");
	//add
	var client_id = parseInt("<?php echo $client_id ?>");
	
  	$('<?php echo $form ?>').on('submit',function(e){
	    $('.saveBtn').attr("disabled", true);
  	});

  	$('.action').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).prop('href');
	    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
	      if( result ){
	      	window.location = url;
	      }
	    });
  	});

  	$('.edit').on('click',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
	        $('#edit .modal-content').html(dt);
	        $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un probleme");
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	});

  	$('#edit').on('input','#QteChange,#PrixVente,#Remise',function(e){
    	calculeTotal();
  	});

  	$('#edit').on('change','#TVA',function(e){
    	calculeTotal();
  	});

  	$('#edit').on('submit','form',function(e){
      $('.saveBtn').attr("disabled", true);
  	});

  	function calculeTotal() {
	    var tva = $('#TVA').val();
	    var remise = $('#Remise').val();
	    var quantite = $('#QteChange').val();
	    var prix_vente_ttc = $('#PrixVente').val();

	    if( tva == '' ) tva = 20;
	    if( remise == '' ) remise = 0; 
	    if( quantite == '' ) quantite = 0; 
	    if( prix_vente_ttc == '' ) prix_vente_ttc = 0; 

	    var division_tva = (1+tva/100);
	    var total_a_payer_ttc = quantite * prix_vente_ttc;
	    // Remise
	    var discounted_price = (total_a_payer_ttc.toFixed(2) * remise / 100);
	    $('#MontantRemise').val(discounted_price.toFixed(2));
	    var montant_remise = $('#MontantRemise').val();
	    var total_a_payer_ht = total_a_payer_ttc/division_tva;
	   
	    // TTC
	    $('#TotalTTC').val( total_a_payer_ttc.toFixed(2) );
	    // HT
	    var final_result = total_a_payer_ht.toFixed(2)-montant_remise;
	    $('#TotalHT').val( final_result.toFixed(2) );
	    // TVA
	    var montant_tva = total_a_payer_ttc-total_a_payer_ht;
	    $('#MontantTVA').val( montant_tva.toFixed(2) );
  	}

  	$('#edit').on('change','#ArticleID',function(e){
	    var produit_id = $('#ArticleID').val();
	    if ( produit_id == '' ) {
	      $('#TVA').val(0);
	      $('#TotalHT').val(0);
	      $('#TotalTTC').val(0);
	      $('#PrixVente').val(0);
	      $('#MontantTVA').val(0);
	      //$('#QteChange').removeAttr('max');
	    } else {
	      getproduit(produit_id);
	    }
  	});

  	function getproduit(produit_id) {
		var url = "";
		if(client_id != 0) url = "<?php echo $this->Html->url(['action' => 'getproduit']) ?>/"+produit_id+'/'+depot_id +'/'+client_id;
	    else url = "<?php echo $this->Html->url(['action' => 'getproduit']) ?>/"+produit_id+'/'+depot_id;
		$.ajax({
	      	dataType:'JSON',
	      	url: url,
	      	success: function(dt){
		        if (produit_id != ''){
		          	var quantite = parseFloat(dt.quantite);
		          	var prix_vente = parseFloat(dt.prix_vente);
		          	var tva = parseFloat(dt.tva);
					  if (typeof dt.remise !== 'undefined') {
						var remise = parseFloat(dt.remise);
						$('#Remise').val(remise);
					}
					
		         	$('#TotalTTC').val(0);
		          	$('#TotalHT').val(0);
		          	$('#PrixVente').val(prix_vente);
		          	$('#TVA').val(tva);
		          	calculeTotal();
		        }
	      	},
	      	error: function(dt){
	      		$('#QteChange').removeAttr('max');
	      		$('#MontantTVA').val(0);
		        $('#PrixVente').val(0);
				$('#TotalTTC').val(0);
				$('#TotalHT').val(0);
				$('#TVA').val(0);
		        toastr.error("Il y a un probléme");
	      	},
	      	complete: function(){
	      	}
	    });
  	}
	  

</script>