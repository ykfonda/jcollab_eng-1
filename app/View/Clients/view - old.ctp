<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
	#map_canvas {
        height: 350px;
        border:1px solid silver;
    }
</style>
<div class="hr"></div>
<?php if ( isset( $this->data['Client']['id'] ) AND !empty( $this->data['Client']['designation'] ) ): ?>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Information client - <?php echo $this->data['Client']['reference'] ?>
		</div>
		<div class="actions">
			<a href="<?php echo $this->Html->url(['action' => 'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Client']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">

	      		<div class="table-responsive" style="min-height: auto;">
		          <table class="table table-bordered tableHeadInformation">
		            <tbody>
		              <tr>
		                <td class="tableHead" nowrap="">Désignation</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['designation'] ?> 
		                </td>
		                <td class="tableHead" nowrap="">ICE</td>
		                <td nowrap="" colspan="3"> 
		                  <?php echo $this->data['Client']['ice'] ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Type</td>
		                <td nowrap="">
		                  <?php echo $this->data['Categorieclient']['libelle'] ?>
		                </td>
		                <td class="tableHead" nowrap="">Responsable</td>
		                <td nowrap=""> 
		                  <?php echo $this->data['User']['nom']; ?>  <?php echo $this->data['User']['prenom']; ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Tél</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['telmobile'] ?>
		                </td>
		                <td class="tableHead" nowrap="">FAX</td>
		                <td nowrap=""> 
		                  <?php echo $this->data['Client']['fax'] ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Email</td>
		                <td nowrap="">
		                  <?php echo $this->data['Client']['email'] ?>
		                </td>
		                <td class="tableHead" nowrap="">Rating</td>
		                <td nowrap="">
		                  <?php echo ( !empty( $this->data['Client']['rating'] ) ) ? $this->App->getImportance( $this->data['Client']['rating'] ) : '' ; ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Catégorie</td>
		                <td nowrap="" >
		                  <?php echo $this->data['Clienttype']['libelle'] ?>
		                </td>
		                <td class="tableHead" nowrap="">Classification</td>
		                <td nowrap="" >
		                  <?php echo ( !empty( $this->data['Client']['classification'] ) ) ? $this->App->getClassification( $this->data['Client']['classification'] ) : '' ; ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Adresse</td>
		                <td nowrap="" colspan="3">
		                  <?php echo $this->data['Client']['adresse'] ?>
		                </td>
		              </tr>
		              <tr>
		                <td class="tableHead" nowrap="">Note</td>
		                <td>
		                  <?php echo $this->data['Client']['note'] ?>
		                </td>
		                <td class="tableHead" nowrap="">Année d'objectif</td>
		                <td>
		                  <?php echo $this->Form->input('annee',['class' => 'form-control','label'=>false,'empty'=>'-- --','required' => true,'options'=>$this->App->getAnnees() ,'value' => $annee ,'id'=>'ObjYear' ]); ?>
		                </td>
		              </tr>
		            </tbody>
		          </table>
		        </div>

	      	</div>
	  	</div>

	  	<div class="row">
	  		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		    	<div class="dashboard-stat dashboard-stat-v2 blue">
		            <div class="visual">
		                <i class="fa fa-dollar"></i>
		            </div>
		            <div class="details">
		                <div class="number">
		                    <span data-counter="counterup" data-value="<?php echo $ca_ventes ?>"><?php echo $ca_ventes ?></span>
		                </div>
		                <div class="desc"> Chiffre d'affaire vente (<?php echo $annee ?>) </div>
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
		                    <span data-counter="counterup" data-value="<?php echo $ca_avoirs ?>"><?php echo $ca_avoirs ?></span>
		                </div>
		                <div class="desc"> Chiffre d'affaire avoir (<?php echo $annee ?>) </div>
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
		                    <span data-counter="counterup" data-value="<?php echo $ca_total ?>"><?php echo $ca_total ?></span>
		                </div>
		                <div class="desc"> Chiffre d'affaire net (<?php echo $annee ?>) </div>
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
		                    <span data-counter="counterup" data-value="<?php echo $taux ?>"><?php echo $taux ?> %</span>
		                </div>
		                <div class="desc"> Taux de réalisation % (<?php echo $annee ?>) </div>
		            </div>
		        </div>
		    </div>
	  	</div>
	  	
  	</div>
</div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des objectifs
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Client']['id'] ) ): ?>
				<a href="<?php echo $this->Html->url(['action' => 'editobjectif',0,$this->data['Client']['id']]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Ajouter objectif </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
	    <div class="row">
	      	<div class="col-md-12">
	      		<?php if ( empty( $objectifs ) ): ?>
	      			<div class="alert alert-warning">
	      				<strong> Attention : </strong> Le taux de réalisation est lié avec objectif annuelle 
	      			</div>
	      		<?php endif ?>
	      		<div class="table-responsive" style="min-height: auto;">
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
							<?php foreach ($objectifs as $dossier): ?>
								<tr>
									<td nowrap=""><?php echo h($dossier['Objectifclient']['reference']); ?></td>
									<td nowrap=""><?php echo h($dossier['Objectifclient']['annee']); ?></td>
									<td nowrap="" class="text-right"><?php echo h($dossier['Objectifclient']['objectif']); ?></td>
									<td nowrap="" class="actions">
										<?php if ( $globalPermission['Permission']['m1'] ): ?>
											<a href="<?php echo $this->Html->url(['action'=>'editobjectif',$dossier['Objectifclient']['id'],$dossier['Objectifclient']['client_id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
										<?php endif ?>
										<?php if ( $globalPermission['Permission']['s'] ): ?>
											<a href="<?php echo $this->Html->url(['action' => 'deleteobjectif', $dossier['Objectifclient']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
										<?php endif ?>
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
			Localisation
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'changelocation',$this->data['Client']['id']]) ?>" class="changeLocation btn btn-primary btn-sm"><i class="fa fa-map-marker"></i> Actualisé la position client </a>
			<?php endif ?>
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

<?php endif ?>

<?php $this->start('js') ?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDc0PN-ZA2y6wjP1dZagSZ1cnlSJYhUsck&sensor=false" type="text/javascript"></script>
<?php echo $this->Html->script('geolocation-marker.js'); ?>
<script>
  var map;

  var latitude = "<?php echo ( !empty( $this->data['Client']['latitude'] ) ) ? $this->data['Client']['latitude'] : '0' ; ?>";
  var longitude = "<?php echo ( !empty( $this->data['Client']['longitude'] ) ) ? $this->data['Client']['longitude'] : '0' ; ?>";
  var zoom = parseInt("<?php echo ( empty( $this->data['Client']['latitude'] ) ) ? 1 : 15 ; ?>");

  function initialize() {
  	var location = new google.maps.LatLng(latitude, longitude);
    var mapOptions = {
      zoom: zoom,
      center: location,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

    var designation = "<?php echo ( !empty( $this->data['Client']['designation'] ) ) ? $this->data['Client']['designation'] : '' ; ?>";
    var adresse = "<?php echo ( !empty( $this->data['Client']['adresse'] ) ) ? $this->data['Client']['adresse'] : '' ; ?>";
    var link ='https://www.google.com/maps/search/?api=1&query='+latitude+','+longitude;
    var href = '<a target="_blank" href='+link+'>Voir sur google maps </a>';
    var label = '<strong>' + designation+'</strong><br/>'+adresse+'<br/>'+href;

    <?php if ( isset( $this->data['Client']['latitude'] ) AND !empty( $this->data['Client']['latitude'] ) ): ?>
    	
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

    <?php endif ?>


  }

  google.maps.event.addDomListener(window, 'load', initialize);

  if(!navigator.geolocation) {
    alert("La géolocalisation n'est pas prise en charge par cette appareil.");
  }
</script>
<script>
	$(function(){

		$('#edit').on('submit','form',function(e){
    		$('.saveBtn').attr("disabled", true);
    	});

		$('#ObjYear').on('change',function(e){
			var annee = $(this).val();
			var url_base = "<?php echo $this->Html->url(['action' => 'view',$this->data['Client']['id']]) ?>/"+annee;
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
<?php $this->end() ?>