<?php $this->start('modal'); ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end(); ?>
<style type="text/css">
	#map_canvas {
        height: 350px;
        border:1px solid silver;
    }
</style>
<div class="hr"></div>
<?php if (isset($this->data['Client']['id']) and !empty($this->data['Client']['designation'])): ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Information client - <?php echo $this->data['Client']['reference']; ?>
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'edit', $this->data['Client']['id']]); ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier </a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">

	      		<div class="table-scrollable">
		          <table class="table table-bordered tableHeadInformation">
		            <tbody>
		              <tr>
		                <td class="tableHead" nowrap="">Désignation</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['designation']; ?> 
		                </td>
		                <td class="tableHead" nowrap="">ICE</td>
		                <td nowrap="" colspan="3"> 
		                  <?php echo $this->data['Client']['ice']; ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Type</td>
		                <td nowrap="">
		                  <?php echo $this->data['Categorieclient']['libelle']; ?>
		                </td>
						<td class="tableHead" nowrap="">Tél</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['telmobile']; ?>
		                </td>
		              </tr>
		              <tr>
		                
		                <td class="tableHead" nowrap="">FAX</td>
		                <td nowrap=""> 
		                  <?php echo $this->data['Client']['fax']; ?>
		                </td>
						<td class="tableHead" nowrap="">Email</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['email']; ?>
		                </td>
		              </tr>
		              <tr>
		                
		                <td class="tableHead" nowrap="">Rating</td>
		                <td nowrap="">
		                  <?php echo (!empty($this->data['Client']['rating'])) ? $this->App->getImportance($this->data['Client']['rating']) : ''; ?>
		                </td>
						
		              </tr>
		              <tr>
					  <td class="tableHead" nowrap="">Adresse</td>
		                <td nowrap="" colspan="3">
		                  <?php echo $this->data['Client']['adresse']; ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Note</td>
		                <td>
		                  <?php echo $this->data['Client']['note']; ?>
		                </td>
		                <td class="tableHead" nowrap="">Année d'objectif</td>
		                <td>
		                  <?php echo $this->Form->input('annee', ['class' => 'form-control', 'label' => false, 'empty' => '-- --', 'required' => true, 'options' => $this->App->getAnnees(), 'value' => $annee, 'id' => 'ObjYear']); ?>
		                </td>
		              </tr>
					  <tr>
		                <td class="tableHead" nowrap="">Compte comptable</td>
		                <td>
		                  <?php echo $this->data['Client']['compte_comptable']; ?>
		                </td>
		                <td class="tableHead" nowrap="">Date de naissance</td>
		                <td>
						<?php  echo $this->data['Client']['date_naissance']; ?>

		                </td>
						<tr>
		                <td class="tableHead" nowrap="">Sexe</td>
		                <td>
						<?php  if ($this->data['Client']['sexe'] == 0) {
    echo 'Masculin';
} else {
    echo 'Feminin';
} ?>

		                </td>
		                <td class="tableHead" nowrap="">Code</td>
		                <td>
						<?php  echo $this->data['Client']['code_client']; ?>

						</td>
		              </tr>
					  <tr>
		                <td class="tableHead" nowrap="">Points fidelité</td>
		                <td>
						<?php  echo $this->data['Client']['points_fidelite']; ?>


		                </td>
						<td class="tableHead" nowrap=""></td>
		                <td>
						</td>
					  </tr>
		            </tbody>
		          </table>
		        </div>

	      	</div>
	  	</div>

	  	<div class="row" style="margin-bottom: 10px;">
	  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		    	<div class="dashboard-stat dashboard-stat-v2 blue">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $total_paye_valide; ?>"><?php echo number_format($total_paye_valide, 2, ',', ' '); ?> Dhs</span>
		                </div>
		                <div class="desc"> Chiffre d'affaire reçu (<?php echo $annee; ?>) </div>
		            </div>
		        </div>
		    </div>
		    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		        <div class="dashboard-stat dashboard-stat-v2 red">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $ca_avoirs; ?>"><?php echo number_format($ca_avoirs, 2, ',', ' '); ?> Dhs</span>
		                </div>
		                <div class="desc"> Chiffre d'affaire avoir (<?php echo $annee; ?>) </div>
		            </div>
		        </div>
		    </div>
		    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		        <div class="dashboard-stat dashboard-stat-v2 green">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $ca_total; ?>"><?php echo number_format($ca_total, 2, ',', ' '); ?> Dhs</span>
		                </div>
		                <div class="desc"> Chiffre d'affaire net (<?php echo $annee; ?>) </div>
		            </div>
		        </div>
		    </div>
		    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		        <div class="dashboard-stat dashboard-stat-v2 yellow">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $taux; ?>"><?php echo $taux; ?> %</span>
		                </div>
		                <div class="desc"> Taux de réalisation % (<?php echo $annee; ?>) </div>
		            </div>
		        </div>
		    </div>
	  	</div>
	  	<div class="row">
	  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		        <div class="dashboard-stat dashboard-stat-v2 yellow">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $credit_restant; ?>"><?php echo number_format($credit_restant, 2, ',', ' '); ?> Dhs</span>
		                </div>
		                <div class="desc"> Crédit restant (<?php echo $annee; ?>) </div>
		            </div>
		        </div>
		    </div>
	  	</div>

  	</div>
</div>


<div class="card">
  <div class="card-header" style="border-bottom: 1px solid #eee;">
      <h4 class="card-title" style="color: #666">
		  Remises Client
	  </h4>
	  
  </div>
  
  <div class="card-body">
      <ul class="nav nav-tabs nav-justified" id="myTab2" role="tablist">
          <li class="nav-item">
              <a class="nav-link active" id="home-tab-justified" data-toggle="tab" href="#article-just" role="tab" aria-controls="article-just" aria-selected="false">Remise par acticle</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="profile-tab-justified" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just" aria-selected="false">Remise par catégorie</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="messages-tab-justified" data-toggle="tab" href="#messages-just" role="tab" aria-controls="messages-just" aria-selected="false">Remise globale</a>
		</li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content pt-1">

        <div class="tab-pane active" id="article-just" role="tabpanel" aria-labelledby="home-tab-justified">

		<div id="remiseArticle"></div>

        </div>

        <div class="tab-pane" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-justified">

		<div id="remiseCategorie"></div>

        </div>

        <div class="tab-pane" id="messages-just" role="tabpanel" aria-labelledby="messages-tab-justified">

		<div id="remiseGlobale"></div>

        </div>

       

        <div class="tab-pane" id="fournisseur-just" role="tabpanel" aria-labelledby="fournisseur-tab-justified">
          <div id="fournisseurprices"></div>
        </div>

        <div class="tab-pane" id="settings-just" role="tabpanel" aria-labelledby="settings-tab-justified">
          <div id="recettes"></div>
        </div>

    </div>
    <!-- Tab panes -->
  </div>
</div>


<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des objectifs
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a'] and isset($this->data['Client']['id'])): ?>
				<a href="<?php echo $this->Html->url(['action' => 'editobjectif', 0, $this->data['Client']['id']]); ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter objectif </a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12" style="min-height: 250px; max-height: 250px; overflow-y: scroll;">
	      		<?php if (empty($objectifclients)): ?>
	      			<div class="alert alert-warning">
	      				<strong> Attention : </strong> Le taux de réalisation est lié avec objectif annuelle 
	      			</div>
	      		<?php endif; ?>
	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Anneé</th>
								<th nowrap="">Objectif</th>
								<th class="actions" nowrap="">
							</tr>
						</thead>
						<tbody>
							<?php foreach ($objectifclients as $dossier): ?>
								<tr>
									<td nowrap=""><?php echo h($dossier['Objectifclient']['reference']); ?></td>
									<td nowrap=""><?php echo h($dossier['Objectifclient']['annee']); ?></td>
									<td nowrap="" class="text-right"><?php echo h($dossier['Objectifclient']['objectif']); ?></td>
									<td nowrap="" class="actions">
										<?php if ($globalPermission['Permission']['m1']): ?>
											<a href="<?php echo $this->Html->url(['action' => 'editobjectif', $dossier['Objectifclient']['id'], $dossier['Objectifclient']['client_id']]); ?>" class="edit"><i class="fa fa-edit"></i></a>
										<?php endif; ?>
										<?php if ($globalPermission['Permission']['s']): ?>
											<a href="<?php echo $this->Html->url(['action' => 'deleteobjectif', $dossier['Objectifclient']['id']]); ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
      		</div>
  		</div>
	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des produits les plus vendus (<?php echo $annee; ?>)
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12" style="min-height: 250px;max-height: 250px; overflow-y: scroll;">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Produit</th>
								<th nowrap="">Nombre</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($produits as $dossier): ?>
								<tr>
									<td nowrap=""><?php echo h($dossier['Produit']['libelle']); ?></td>
									<td nowrap="" class="text-right"><?php echo (isset($dossier[0]['NbrProduits'])) ? $dossier[0]['NbrProduits'] : 0; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

	      	</div>
      	</div>
  	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Historique des bon de livraisons (<?php echo $annee; ?>)
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12" style="min-height: 250px;max-height: 250px; overflow-y: scroll;">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Etat</th>
								<th nowrap="">Total payé</th>
								<th nowrap="">Reste à payer</th>
								<th nowrap="">Total à payer HT</th>
								<th nowrap="">Net à payer</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($bonlivraisons as $dossier): ?>
								<tr>
									<td nowrap="">
										<a target="_blank" href="<?php echo $this->Html->url(['controller' => 'bonlivraisons', 'action' => 'view', $dossier['Bonlivraison']['id']]); ?>"><?php echo h($dossier['Bonlivraison']['reference']); ?></a>
									</td>
									<td nowrap=""><?php echo h($dossier['Bonlivraison']['date']); ?></td>
									<td nowrap="">
										<?php if (!empty($dossier['Bonlivraison']['etat'])): ?>
											<span class="badge badge-default" style="width: 100%;background-color: <?php echo $this->App->getEtatFicheColor($dossier['Bonlivraison']['etat']); ?>">
												<?php echo $this->App->getEtatFiche($dossier['Bonlivraison']['etat']); ?>
											</span>
										<?php endif; ?>
									</td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['total_paye'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['reste_a_payer'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['total_a_payer_ht'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonlivraison']['total_apres_reduction'], 2, ',', ' '); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

      		</div>
  		</div>
	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Historique des factures (<?php echo $annee; ?>)
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12" style="min-height: 250px;max-height: 250px; overflow-y: scroll;">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Total à payer HT</th>
								<th nowrap="">Net à payer</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($factures as $dossier): ?>
								<tr>
									<td nowrap="">
										<a target="_blank" href="<?php echo $this->Html->url(['controller' => 'factures', 'action' => 'view', $dossier['Facture']['id']]); ?>"><?php echo h($dossier['Facture']['reference']); ?></a>
									</td>
									<td nowrap=""><?php echo h($dossier['Facture']['date']); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Facture']['total_a_payer_ht'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Facture']['total_apres_reduction'], 2, ',', ' '); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

      		</div>
  		</div>
	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Historique des avoirs (<?php echo $annee; ?>)
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12" style="min-height: 250px;max-height: 250px; overflow-y: scroll;">

	      		<div class="table-scrollable">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Total à payer HT</th>
								<th nowrap="">Net à payer</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($avoirs as $dossier): ?>
								<tr>
									<td nowrap="">
										<a target="_blank" href="<?php echo $this->Html->url(['controller' => 'bonavoirs', 'action' => 'view', $dossier['Bonavoir']['id']]); ?>"><?php echo h($dossier['Bonavoir']['reference']); ?></a>
									</td>
									<td nowrap=""><?php echo h($dossier['Bonavoir']['date']); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonavoir']['total_a_payer_ht'], 2, ',', ' '); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Bonavoir']['total_apres_reduction'], 2, ',', ' '); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

	      	</div>
      	</div>
  	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Localisation
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'changelocation', $this->data['Client']['id']]); ?>" class="changeLocation btn btn-primary btn-sm"><i class="fa fa-map-marker"></i> Actualisé la position client </a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">
	      		<div id="map_canvas"></div>
      		</div>
  		</div>
	</div>
</div>

<?php endif; ?>

<?php $this->start('js'); ?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDc0PN-ZA2y6wjP1dZagSZ1cnlSJYhUsck&sensor=false" type="text/javascript"></script>
<?php echo $this->Html->script('geolocation-marker.js'); ?>
<script>
  var map;

  var latitude = "<?php echo (!empty($this->data['Client']['latitude'])) ? $this->data['Client']['latitude'] : '0'; ?>";
  var longitude = "<?php echo (!empty($this->data['Client']['longitude'])) ? $this->data['Client']['longitude'] : '0'; ?>";
  var zoom = parseInt("<?php echo (empty($this->data['Client']['latitude'])) ? 1 : 15; ?>");

  function initialize() {
  	var location = new google.maps.LatLng(latitude, longitude);
    var mapOptions = {
      zoom: zoom,
      center: location,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

    var designation = "<?php echo (!empty($this->data['Client']['designation'])) ? $this->data['Client']['designation'] : ''; ?>";
    var adresse = "<?php echo (!empty($this->data['Client']['adresse'])) ? $this->data['Client']['adresse'] : ''; ?>";
    var link ='https://www.google.com/maps/search/?api=1&query='+latitude+','+longitude;
    var href = '<a target="_blank" href='+link+'>Voir sur google maps </a>';
    var label = '<strong>' + designation+'</strong><br/>'+adresse+'<br/>'+href;

    <?php if (isset($this->data['Client']['latitude']) and !empty($this->data['Client']['latitude'])): ?>
    	
	    var marker = new google.maps.Marker({
	        position: location,
	        map: map,
	    });

	    var iw = new google.maps.InfoWindow({
		    content: label
		});

	    google.maps.event.addListener(marker, "click", function(e) {
		    iw.open(map, this);
		});

    <?php endif; ?>


  }

  google.maps.event.addDomListener(window, 'load', initialize);

  if(!navigator.geolocation) {
    alert("La géolocalisation n'est pas prise en charge par cette appareil.");
  }
</script>
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

		$('#edit').on('submit','form',function(e){
    		$('.saveBtn').attr("disabled", true);
    	});

		$('#ObjYear').on('change',function(e){
			var annee = $(this).val();
			var url_base = "<?php echo $this->Html->url(['action' => 'view', $this->data['Client']['id']]); ?>/"+annee;
			window.location = url_base;
    	});

		function OnFail(response) {
			if ( typeof response.code != 'undefined' && response.code == 1 ) {

				$.get("https://api.ipdata.co/?api-key=test", function (response) {
					var url = $('.changeLocation').prop('href');
			    	var latitude = response.latitude;
					var longitude = response.longitude;
					var lien_complet = url+'/'+ latitude +'/'+longitude;
					window.location = lien_complet;
				}, "jsonp");

			}
		}

		function getLocation(url) {
			if ( navigator.geolocation ) {
				navigator.geolocation.getCurrentPosition(showPosition,OnFail);
			} else { 
				alert("La géolocalisation n'est pas prise en charge par cette appareil.");
			}
		}

		function showPosition(position) {
			var url = $('.changeLocation').prop('href');
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;
			var lien_complet = url+'/'+ latitude +'/'+longitude;
			window.location = lien_complet;
		}

		$('.changeLocation').on('click',function(e){
		    e.preventDefault();
		    var url = $(this).prop('href');
		    bootbox.confirm("Êtes-vous sûr de vouloir changer la géolocalisation de ce client ?<br/><strong>Attention : </strong> la géolocalisation de ce client va changer par votre position actuelle ! ", function(result) {
		      if( result ){
				getLocation(url);
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

		$('.btnFlagDelete').on('click',function(e){
		    e.preventDefault();
		    var url = $(this).prop('href');
		    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
		      if( result ){
		      	window.location = url;
		      }
		    });
		});

	});
	</script>
<?php echo $this->element('page-script'); ?>
<?php $url_article = $this->Html->url(['action' => 'remiseArticle', $this->data['Client']['id']]); ?>
<?php echo $this->element('ajax-page-script', ['element' => 'remiseArticle', 'form' => 'RemiseClientArticle', 'url' => $url_article]); ?>

<?php $url_categorie = $this->Html->url(['action' => 'remiseCategorie', $this->data['Client']['id']]); ?>
<?php echo $this->element('ajax-page-script', ['element' => 'remiseCategorie', 'form' => 'RemiseClientCategorie', 'url' => $url_categorie]); ?>

<?php $url_globale = $this->Html->url(['action' => 'remiseGlobale', $this->data['Client']['id']]); ?>
<?php echo $this->element('ajax-page-script', ['element' => 'remiseGlobale', 'form' => 'RemiseClientGlobale', 'url' => $url_globale]); ?>
<?php $this->end(); ?>