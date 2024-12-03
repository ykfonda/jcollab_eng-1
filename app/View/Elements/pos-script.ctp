<style>
@media (min-width: 576px) {
.modal-size {
    max-width: 80% !important;
    margin: 1.75rem auto;
}
}
</style>
<div id="myModal1" class="modal fade" role="dialog">
<div class="modal-dialog modal-size modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       
      </div>
      <div class="modal-body">
        <p style="text-align: center;font-weight: bold;">Lequel de ces elements voulez vous mettre a jour :</p>
		<div class="table-responsive" style="overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">PRODUIT</th>
								<th nowrap="">QTÉ LIVRÉE</th>
								<th nowrap="">QTÉ CDÉE</th>
								<th nowrap="">PRIX UNITAIRE</th>
								<th nowrap="">Conditionnements</th>
								<th nowrap="">options</th>
								<th nowrap="">TOTAL</th>
								<th class="actions">Action</th>
							</tr>
						</thead>
						<tbody id="details">
							

								
						
						</tbody>
					</table>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="return Closemodal();" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

		//Init();
		
		var salepoint_id = parseInt("<?php echo $salepoint_id; ?>");
		var commande_id = parseInt("<?php echo $commande_id; ?>");
		var ecommerce_id = parseInt("<?php echo $ecommerce_id; ?>");
		var glovo_id = parseInt("<?php echo $glovo_id; ?>");

	//	function disableButtons() {
	//  	var count = $('#tbodyParent').children('.rowParent').length;
	// 	if ( count > 0 ) $('.btn-disabled').attr('disabled',true);
	//  	else $('.btn-disabled').attr('disabled',false);
	//	}

		function disableButtons() {
			var count = $('#tbodyParent').children('.rowParent').length;
			if (count > 0) {
				$('.btn-disabled').attr('disabled', true);
				$('.btn-enabled').attr('disabled', false);
			} else {
				$('.btn-disabled').attr('disabled', false);
				$('.btn-enabled').attr('disabled', true);
			}
		}

	  setInterval(function(){ disableButtons() }, 500);

	  //setInterval(function(){ $('#code_barre').focus() }, 2000);
	    function Closemodal() {
			$("#details").html("");
			$('#myModal1').modal('hide');
			
		}
		async function scaning(code_barre,salepoint_id) {
			if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }

			$('.btn-reset').attr('disabled',true);
			$('.btn-scan').attr('disabled',true);
			$('.scan-loading').show();

			var url = "<?php echo $this->Html->url(['action' => 'scan']); ?>/"+code_barre+'/'+salepoint_id;
			if( commande_id != '' && commande_id > 0 ) url = "<?php echo $this->Html->url(['action' => 'updateline']); ?>/"+code_barre+'/'+salepoint_id;
			else if( ecommerce_id != '' && ecommerce_id > 0 ) url = "<?php echo $this->Html->url(['action' => 'updateline']); ?>/"+code_barre+'/'+salepoint_id;
			else if( glovo_id != '' && glovo_id > 0 ) url = "<?php echo $this->Html->url(['action' => 'updateline'/* 'scanGlovo' */]); ?>/"+code_barre+'/'+salepoint_id;
		    
			await $.ajax({
		      url: url,
		      success: function(dt){
		      	if ( dt.error == true ) toastr.error(dt.message);
				else if(dt.duplicate) {
					
					$('#myModal1').modal('show');
					for(var i=0; i < dt.details.length;i++) {
						$("#details").append("<tr>");
						for(var j=1; j < dt.details[i].length;j++) {
							
							$("#details").append("<td>"+dt.details[i][j]+"</td>");
							
						}
						var salepointdetail = dt.details[i][0];
						$("#details").append('<td><a onclick='+'"'+"return updatelineD("+salepoint_id+","+salepointdetail+","+dt.code_barre +')"'+" class='btn btn-primary btn-xs btn-circle'>Confirmer</a></td>");
							
						$("#details").append("</tr>");
					}
					
				}
				/* else if(dt.notice) {
					toastr.error("Le Net a payer dépasse le total commandé");
				}    */
		      	else details(salepoint_id);
		      },
		      error: function(dt){
		        toastr.error("Il y a un problème");
		      },
		      complete: function(dt){
						$('.btn-reset').attr('disabled',false);
						$('.btn-scan').attr('disabled',false);
						$('.scan-loading').hide();
						$('#code_barre').val('');
						
		      }
		    });
		}
		async function updatelineD(salepoint_id,salepointdetail,code_barre) {
		
			if( ecommerce_id != '' && ecommerce_id > 0 ) var url = "<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'updatelineDE']); ?>/"+salepoint_id+'/'+salepointdetail+'/'+code_barre;
			if( commande_id != '' && commande_id > 0 ) var url = "<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'updatelineCommande']); ?>/"+salepoint_id+'/'+salepointdetail+'/'+code_barre;
			if( glovo_id != '' && glovo_id > 0 ) var url = "<?php echo $this->Html->url(['controller' => 'pos', 'action' => 'updatelineCommande']); ?>/"+salepoint_id+'/'+salepointdetail+'/'+code_barre;
 			await $.ajax({
		      url: url,
		      success: function(dt){
				$("#details").html("");
				$('#myModal1').modal('hide');
				$('.modal-backdrop').hide();
		      	if ( dt.error == true ) toastr.error(dt.message);
				else if(dt.notice) {
					toastr.error("Le Net a payer dépasse le total commandé");
				}  
		      	else details(salepoint_id);
				
		      },
		      error: function(dt){
		        toastr.error("Il y a un problème");
		      },
		      complete: function(dt){
						$('.btn-reset').attr('disabled',false);
						$('.btn-scan').attr('disabled',false);
						$('.scan-loading').hide();
						$('#code_barre').val('');
						
		      }
		    });
		}
		async function details(salepoint_id) {
			$('.scan-loading').show();
		    await $.ajax({
		      url: "<?php echo $this->Html->url(['action' => 'details']); ?>/"+salepoint_id,
		      success: function(dt){
		      	$('#BlockDetails').html(dt)
		      },
		      error: function(dt){
		        toastr.error("Il y a un problème");
		      },
		      complete: function(dt){
		      	$('.scan-loading').hide();
		      }
		    });
		}

		async function action(url,element,force_display) {
			var count = $('#tbodyParent').children('.rowParent').length;
			if ( count <= 0 && force_display == true ) {
				toastr.error("Opération impossible : Liste des articles est vide !");
				return;
			} else {
				await  bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
		      if( result ) {
						$('.scan-loading').show();
							element.attr('disabled',true);
							window.location = url;
			      }
		    });
			}
		}

		async function actionAjax(url,element,force_display) {
			var count = $('#tbodyParent').children('.rowParent').length;
			if ( count <= 0 && force_display == true ) {
				toastr.error("Opération impossible : Liste des articles est vide !");
				return;
			} else {
				await  bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
			    if( result ) {
						$('.scan-loading').show();
						element.attr('disabled',true);
				    $.ajax({
				      url: url,
				      success: function(dt){
				        toastr.success("L'action a été effectué avec succès."); details(salepoint_id);
				      },
				      error: function(dt){
						toastr.error(dt.responseText);
				        toastr.error("Il y a un problème")
				      },
				      complete: function(dt){
								element.attr('disabled',false);
								$('.scan-loading').hide();
								$('#commande_id').val('');
				      }
				    });
			    }
			  });
			}
		}

		$('#edit').on('click','.print-ticket',function(e){
			e.preventDefault();
			var url = $(this).attr('href');
		    $.ajax({
		      url: url,
		      success: function(dt){
		      	$('#edit').modal('hide');
		      }
		    });
		});
		$( document ).ready(function() {
		$(document).on("click", '.print-ticket-session', function(e) { 
			e.preventDefault();
			var url = $(this).attr('href');
		    $.ajax({
		      url: url,
		      success: function(dt){
				window.location = "<?php echo $this->Html->url(['controller' => 'salepoints', 'action' => 'index']); ?>";
		      }
		    });
});
});
		
		async function loadModal(url,force_display) {
			var count = $('#tbodyParent').children('.rowParent').length;
			var code_bouchier = $("#bouchier").val();
			
			if(url.includes("paiement")) {
				if( code_bouchier == "") {
					toastr.error("Opération impossible : Code Boucher est vide !");
					return;
				}
				else {
					var err = false;
					$.ajax({
					async: false, 
					url: "<?php echo $this->Html->url(['action' => 'loadBouchiers']); ?>/" +code_bouchier,
					success: function(dt){
						if(dt.error) {
							toastr.error("le code Boucher n'existe pas");
							err = true;	
						}
					},
					error: function(dt){
						toastr.error("Il y a un probleme");
					},
					});
					
					$.ajax({
					async: false, 
					url: "<?php echo $this->Html->url(['action' => 'verifpaiement']); ?>/" +salepoint_id,
					success: function(dt){
						if(dt.error) {
							
							toastr.error("le net a payer depasse le total commandé");
							err = true;	
						}
					},
					error: function(dt){
						toastr.error("Il y a un probleme");
					},
					});
					if(err) return;
				}
			}
			
			if ( count <= 0 && force_display == true  ) {
				toastr.error("Opération impossible : Liste des articles est vide !");
				return;
			}
			
			 else {		
			    await $.ajax({
			      url: url,
			      success: function(dt){
			        $('#edit .modal-content').html(dt);
			        $('#edit').modal('show');
			      },
			      error: function(dt){
			        toastr.error("Il y a un probleme");
			      },
			      complete: function(){
			        //Init();
			      }
			    });
			}
		}

		$('.btn-reset').on('click',function(e){
			e.preventDefault();
			$('#code_barre').val('');
		});

		$('#scan-product').on('submit',function (e) {
		e.preventDefault();
		var code_barre = $('#code_barre').val();
		scaning(code_barre,salepoint_id);
		});

		/////////////action

		$('.btn-show-modal').on('click',function(e){
	    e.preventDefault();
		var url = $(this).attr('href');
	/* 	var active = 0;
		if($(this).attr('id') == "btn_paiement") {
			$.ajax({
			async: false, 
			url: "<?php echo $this->Html->url(['action' => 'verifChequecad']); ?>/" + salepoint_id,
			success: function(dt){
				var resp = JSON.parse(dt);
				if(resp.active == 1) {
					active = 1;
					toastr.success("un cheque cadeau a été activé"); 
				}
			},
			error: function(dt){
				toastr.error("Il y a un problème")
			}
			});
			
			if(active == 1) return;
		} */
		var perm = <?php echo json_encode($perm); ?>;
		if( $(this).attr('id') == "btn_remise" && perm["Remise ticket"] == false) {
			
			
		
				$('#myModal2').modal('show');
				$('#module').val("btn_remise");
				$('#url').val(url);
			
   
        	
    
		}
		else {
	    if($(this).text().trim() == "Paiement") {
			var urlP = url;
			checkQuantity(salepoint_id,urlP);

			return 0;
		}
			
	    loadModal(url,true);
		}
		});
		
		async function checkQuantity(salepoint_id,urlP) {
			var url = "<?php echo $this->Html->url(['action' => 'checkQuantity']); ?>/" + salepoint_id;   
			var result = 0;
			$.ajax({
			url: url,
			success: function(dt){
				if(dt.error == true) {
			bootbox.confirm({
				message: "Une ou plusieurs lignes contiennent 0 dans la colonne QTÉ LIVRÉE, voulez-vous continuer ?",
				buttons: {
					confirm: {
						label: 'Oui',
						className: 'btn-success'
					},
					cancel: {
						label: 'Non',
						className: 'btn-danger'
					}
				},
				callback: function (result) {
					if(result==true){
						loadModal(urlP,true);
					}
				}
			});
					}
					else loadModal(urlP,true);
			},
			error: function(dt){
				toastr.error("Il y a un problème")
			}
	    });
		}

		$('.action').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
		var perm = <?php echo json_encode($perm); ?>;
		if( $(this).attr('id') == "cancel" && perm["Annuler ticket"] == false) {
			
			
			
				$('#myModal2').modal('show');
				$('#module').val("cancel");
				$('#url').val(url);
			
   
        	
    
		}
		else {
	    var element = $(this);
	    action(url,element,true);
		}
		});

		$('.btn-quit').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
		var perm = <?php echo json_encode($perm); ?>;
		if( $(this).attr('id') == "closeSession" && perm["Cloture caisse"] == false) {
			
			
				$('#myModal2').modal('show');
				$('#module').val("closeSession");
				$('#url').val(url);
			
   
        	
    
		}
		else {
	    var count = $('#tbodyParent').children('.rowParent').length;
		bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
	      if( result ) {
		    if ( count <= 0 ) window.location = url;
		    else toastr.error("Opération impossible : il vous reste des produits en caisse !")
	      }
	    });
		}
		});

		$('.actionAjax').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
		if( $(this).attr('id') == "btn_offer") {
			
			var perm = <?php echo json_encode($perm); ?>;
			if(perm["Offert"] == false) {
				$('#myModal2').modal('show');
				$('#module').val("btn_offert");
				$('#url').val(url);
			}
			else {		
				var element = $(this);
				actionAjax(url,element,true);
				
			}
        	
    
		}
		else {		
			var element = $(this);
			actionAjax(url,element,true);	
			}
	
		});

		$('.subremise').on('click',function(e){
            e.preventDefault();
			var module = $('#module').val();
			var urlP = $('#url').val();
			var pass = $('#passw').val();
			var url = "<?php echo $this->Html->url(['action' => 'Auth']); ?>/" + module +"/" + pass;   
			$.ajax({
			url: url,
			success: function(dt){
				if(dt.success == true) {
					$('#myModal2').modal('hide');
					if(module == "btn_remise")
					loadModal(urlP,true);
					else if(module == "btn_offert") {
						var element = $(".actionAjax");
						document.getElementById("passw").value = "";
	    				actionAjax(urlP,element,true);
					}
					else if(module == "cancel") {
						var element = $("#cancel");
						action(urlP,element,true);
					}
					else if(module == "closeSession") {
						var count = $('#tbodyParent').children('.rowParent').length;
						bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
						if( result ) {
							if ( count <= 0 ) window.location = urlP;
							else toastr.error("Opération impossible : il vous reste des produits en caisse !")
						}
						});
					}
					
				}
				else toastr.error("Mot de passe incorrect");   
			},
			error: function(dt){
				toastr.error("Il y a un problème")
			}
	    });
		});
		

		$('.btn-show-modal-eco').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    loadModal(url,false);
		});
		$('.btn-show-modal-reimp').on('click',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    
		$.ajax({
			      url: url,
			      success: function(dt){
			        $('#edit .modal-content').html(dt);
			        $('#edit').modal('show');
			      },
			      error: function(dt){
			        toastr.error("Il y a un probleme");
			      },
			      complete: function(){
			        //Init();
			      }
			    });

			});
		

		$('.btn-show-hold-list').on('click',function(e){
		
	    e.preventDefault();
	    var url = $(this).attr('href');
	    var count = parseInt($(this).attr('data-holdList'));
		if ( count <= 0 ) {
			toastr.error("Opération impossible : Liste des articles est vide !");
			return;
		} else loadModal(url,false);
		});

		$('#edit').on('click','.holdoff,.traitercommande,.modifierticket',function(e){
		e.preventDefault();
	    /* var url = $(this).attr('attrUrl')+'/'+salepoint_id;
		var traiterecommerce = true;
		$.ajax({
	      url: url,
	      success: function(dt){
	      	if(dt.error == true) {
				traiterecommerce = false;
				toastr.error("la commande est deja prise");
			  }
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème")
	      }
	    });
		if(traiterecommerce == false) return false; */
		var url = $(this).attr('href')+'/'+salepoint_id;
	    var element = $(this);
	    action(url,element,false);
		});
		/* $('#edit').on('click','.annulercommande_j',function(e){
			var url = $(this).attr('href')+'/'+salepoint_id;
			
		}); */
		$('#edit').on('click','.getdetail,.getdetailticket',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    $.ajax({
	      url: url,
	      success: function(dt){
	      	$('#showdetail').html(dt);
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème")
	      }
	    });
		});

		$('#BlockDetails').on('click','.btn-delete',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    var element = $(this);
	    actionAjax(url,element,false);
		});

		$('#BlockDetails').on('click','.btn-edit-remise',function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    loadModal(url,false);
		});

		$('#edit').on('change','#RemiseArticle',function(e){
	    e.preventDefault();
	    calculeRemiseArticle();
		});

		function calculeRemiseArticle() {
	    var remise = $('#RemiseArticle').val();
	    if( remise == '' ) remise = 0; 
	    var quantite = $('#Quantite').val();
	    if( quantite == '' ) quantite = 0; 
	    var prix_vente = $('#PrixVente').val();
	    if( prix_vente == '' ) prix_vente = 0; 
	    
	    var total_ttc = parseFloat(quantite*prix_vente);
	    var discounted_price = (total_ttc * remise / 100);
	    $('#MontantRemise').val(discounted_price.toFixed(2));
	    var montant_remise = $('#MontantRemise').val();
	    var final_result = total_ttc-montant_remise;
	    $('#Total').val( final_result.toFixed(2) );
		}

		$('#edit').on('submit','#SalepointRemise,#SalepointRemiseTotal',function(e){
	    e.preventDefault();
	    var formData = new FormData( this );
	    var form = $(this);
	    $('.saveBtn').attr("disabled", true);
	    $.ajax({
	      cache: false,
	      contentType: false,
	      processData: false,
	      type: 'POST',
	      url: form.attr('action'),
	      data:formData,
	      success : function(dt){
	      	details(salepoint_id);
	      	toastr.success("L'action a été effectué avec succès."); 
	        	$('#edit').modal('hide');
	      },
	      error: function(dt){
	        	toastr.error("Il y a un problème");
	      },
	      complete : function(){
	        	$('.saveBtn').attr("disabled", false);
	      },
	    });
		});
/////////////actionajax
		

	

		$('#edit').on('change','#Remise',function(e){
	    e.preventDefault();
	    calculeRemiseTotal();
		});

		function calculeRemiseTotal() {
	    var remise = $('#Remise').val();
	    if( remise == '' ) remise = 0; 
	    var total_ttc_hidden = $('#TotalTTCHidden').val();
	    if( total_ttc_hidden == '' ) total_ttc_hidden = 0; 
	    
	    var discounted_price = (total_ttc_hidden * remise / 100);
	    $('#MontantRemise').val(discounted_price.toFixed(2));
	    var montant_remise = $('#MontantRemise').val();
	    var final_result = total_ttc_hidden-montant_remise;
	    $('#Total').val( final_result.toFixed(2) );
		}

		// $('#edit').on('change','#Montant1',function(e){
	 //    e.preventDefault();
	 //    var Montant1 = parseFloat( $('#Montant1').val() );
	 //    if ( Montant1 == '' ) Montant1 = 0;
	 //    var Montant2 = parseFloat( $('#Montant2').val() );
	 //    if ( Montant2 == '' ) Montant2 = 0;
	 //    var MontantTotal = parseFloat( $('#MontantTotal').val() );
	 //    if ( MontantTotal == '' ) MontantTotal = 0;

	 //    var TotalDesMontant = parseFloat(Montant1)+parseFloat(Montant2);

	 //    if ( TotalDesMontant > MontantTotal ) {
	 //    	$('.saveBtn').attr('disabled',true);
	 //    	toastr.error("Opération impossible : vous avez dépasser le montant total !");
	 //    } else {
	 //    	$('.saveBtn').attr('disabled',false);
	 //    	var difference = parseFloat(MontantTotal-TotalDesMontant);
	 //    	if ( difference > 0 ) {
	 //    		if( Montant2 <= 0 ) $('#Montant2').val(difference.toFixed(2));
	 //    		else if( Montant1 <= 0 ) $('#Montant1').val(difference.toFixed(2));

	 //    		var Montant1 = parseFloat( $('#Montant1').val() );
		// 		var Montant2 = parseFloat( $('#Montant2').val() );
		// 		var TotalDesMontant = parseFloat(Montant1)+parseFloat(Montant2);

		// 			if ( MontantTotal > TotalDesMontant ) {
	 //    			$('.saveBtn').attr('disabled',true);
	 //    			toastr.error("Attention : vous avez un montant insuffisant !")
		// 			} else $('.saveBtn').attr('disabled',false);
	 //    	} else {
	 //    		$('.saveBtn').attr('disabled',false);
	 //    	}
	 //    }
		// });

		// $('#edit').on('change','#Montant2',function(e){
	 //    e.preventDefault();
	 //    var Montant1 = parseFloat( $('#Montant1').val() );
	 //    if ( Montant1 == '' ) Montant1 = 0;
	 //    var Montant2 = parseFloat( $('#Montant2').val() );
	 //    if ( Montant2 == '' ) Montant2 = 0;
	 //    var MontantTotal = parseFloat( $('#MontantTotal').val() );
	 //    if ( MontantTotal == '' ) MontantTotal = 0;

	 //    var TotalDesMontant = parseFloat(Montant1)+parseFloat(Montant2);

	 //    if ( TotalDesMontant > MontantTotal ) {
	 //    	$('.saveBtn').attr('disabled',true);
	 //    	toastr.error("Opération impossible : vous avez dépasser le montant total !");
	 //    } else {
	 //    	$('.saveBtn').attr('disabled',false);
	 //    	var difference = parseFloat(MontantTotal-TotalDesMontant);
	 //    	if ( difference > 0 ) {
	 //    		if( Montant1 <= 0 ) $('#Montant1').val( difference.toFixed(2) );
	 //    		else if( Montant2 <= 0 ) $('#Montant2').val( difference.toFixed(2) );

	 //    		var Montant1 = parseFloat( $('#Montant1').val() );
		// 		var Montant2 = parseFloat( $('#Montant2').val() );
		// 		var TotalDesMontant = parseFloat(Montant1)+parseFloat(Montant2);

		// 		if ( MontantTotal > TotalDesMontant ) {
	 //    			$('.saveBtn').attr('disabled',true);
	 //    			toastr.error("Attention : vous avez un montant insuffisant !")
		// 		} else $('.saveBtn').attr('disabled',false);

	 //    	} else {
	 //    		$('.saveBtn').attr('disabled',false);
	 //    	}
	 //    }
		// });














































	</script>