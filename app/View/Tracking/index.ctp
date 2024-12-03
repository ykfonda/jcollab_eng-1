<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
  .main{ background-color: #fbc531 !important; }
</style>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-map-marker"></i> Tracking
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilterSearch">
        <?php $base_url = array('controller' => 'etudiants', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-3 pull-right">
              <?php echo $this->Form->input('Filter.User.key',array('label'=>false,'placeholder'=>'Recherche...','class'=>'key form-control')) ?>
            </div>
          </div>
        </div>
        </div>
        <?php echo $this->Form->end() ?>
      </div>
      </div>
      <div class="col-md-4">
        <div id="indexAjax">&nbsp;</div>
      </div>
      <div class="col-md-8">
        <div id="UserMap" style="width: 100%; height: 500px;"></div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDc0PN-ZA2y6wjP1dZagSZ1cnlSJYhUsck" type="text/javascript"></script>
<script type="text/javascript">
  var locations = [];
  var markers = [];
  
  var map = new google.maps.Map(document.getElementById('UserMap'), {
    zoom: 11,
    streetViewControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: new google.maps.LatLng(33.547118,-7.645164),
  });

  var infowindow = new google.maps.InfoWindow();
  var directionsDisplay = new google.maps.DirectionsRenderer();
  directionsDisplay.setMap(map); 

  function initMap(locations){
    var startPoint;
    var endPoint;
    var waypts = [];

    for (var i=0; i<markers.length; i++) {
      markers[i].setMap(null);
    }

    for (var i = 0; i < locations.length; i++) {  
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        title: locations[i][0],
        icon: locations[i][3],
        map: map,
      });

      if (i == 0) startPoint = new google.maps.LatLng(locations[i][1], locations[i][2]);

      if (i == locations.length - 1) endPoint = new google.maps.LatLng(locations[i][1], locations[i][2]);

      if ((i > 0) && (i < locations.length - 1)) {
        waypts.push({
            location: new google.maps.LatLng(locations[i][1], locations[i][2]),
            stopover: true
        });
      }

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));

      markers.push(marker);

    }

    calcRoute(startPoint, endPoint, waypts);
  }

  //add this function
  function calcRoute(start,end,waypts) { 
    var directionsService = new google.maps.DirectionsService;
    var directionsRenderer = new google.maps.DirectionsRenderer;
    var request = {
        origin: start,
        destination: end,
        waypoints: waypts,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }

  initMap(locations);

  $('#indexAjax').on('click','.user-click',function(e){
    e.preventDefault();
    var url = $(this).data('url');
    $(".users tr").removeClass("main");
    $(this).addClass("main");
    $.ajax({
      url: url,
      success: function(locations){
        initMap(locations);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){

      }
    });
  });

</script>

<script>
  var Init = function(){
    $('.uniform').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>