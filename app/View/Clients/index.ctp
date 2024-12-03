<?php echo $this->Html->css('/app-assets/plugins/rating-stars/star-rating.min.css'); ?>
<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des clients
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
        <a href="<?php echo $this->Html->url(['action' => 'importer']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i> Importation </a>
			  <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau client </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'clients', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.reference',array('label'=>false,'placeholder'=>'Réference','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.designation',array('label'=>false,'placeholder'=>'Désignation','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.organisme',array('label'=>false,'empty'=>'--Organisme','class'=>'form-control','options'=>$this->App->getOrganisme() )) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.ville_id',array('label'=>false,'empty'=>'--Ville','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.rating',array('label'=>false,'empty'=>'--Rating','class'=>'form-control','options'=>$this->App->getImportance() )) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->submit('Rechercher',array('class' => 'btn btn-primary','div' => false)) ?>
              <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
            </div>
          </div>
        </div>
        </div>
        <?php echo $this->Form->end() ?>
      </div>
      </div>
      <div class="col-md-12">
        <div id="indexAjax">&nbsp;</div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/rating-stars/star-rating.min.js'); ?>
<?php echo $this->Html->script('papaparse.js') ?>
<script>
  var Init = function(){
    $('.select2').select2();
    $(".rating").rating({
      min: 1, max: 5,
      showClear: false,
      showCaption: false,
      size: 'xs',  
      stars: 4,
      step: 1,
      readonly:true,
      starCaptions: {1: 'Non-évalué', 2: 'Faible', 3: 'Moyen', 4: 'Fort', 5: 'Trés fort'},
    });
    $('.uniform').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  /* Importation */

  function stepFn(results, parserHandle){
    stepped++;
    rows += results.data.length;

    parser = parserHandle;
    
    if (pauseChecked) {
      parserHandle.pause();
      return;
    }
  }

  function chunkFn(results, streamer, file){
    if (!results) return;
    chunks++;
    rows += results.data.length;

    parser = streamer;

    if (pauseChecked){
      streamer.pause();
      return;
    }
  }

  function errorFn(error, file){
    toastr.error("ERROR:", error, file);
  }

  function cleanArray(actual) {
    var newArray = new Array();
    for (var i = 0; i < actual.length; i++) {
      if (actual[i]) {
        newArray.push(actual[i]);
      }
    }
    return newArray;
  }

  function completeFn(){
    end = performance.now();
    var tableCopy = arguments[0].data;
    var table = arguments[0].data[0];
    var a = 0;
    var safe = false;
    if(typeof tableCopy != "undefined"){
        table = tableCopy[0];
        safe = true;
    }else{
      toastr.error("Il y a un problème dans le fichier excel !");
      $('.saveBtn').prop('disabled', true);
    }
    if(table.length > 0 && safe == true){   
      $('.saveBtn').prop('disabled', false);

      $("#designation").empty();
      $("#designation").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#designation").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#designation").val(0);

      $("#ice").empty();
      $("#ice").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#ice").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#ice").val(1);

      $("#telmobile").empty();
      $("#telmobile").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#telmobile").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#telmobile").val(2);

      $("#fax").empty();
      $("#fax").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#fax").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#fax").val(3);

      $("#email").empty();
      $("#email").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#email").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#email").val(4);

      $("#adresse").empty();
      $("#adresse").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != undefined && table[i] != '') {
            $("#adresse").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#adresse").val(5);

    }else{
      toastr.error("Format du fichier excel incompatible !");
      $('.saveBtn').prop('disabled', true);
    }
  }

  function buildConfig(){
    return {
      newline: getLineEnding(),
      complete: completeFn,
      error: errorFn,
    };

    function getLineEnding(){
      if ($('#newline-n').is(':checked')) return "\n";
      else if ($('#newline-r').is(':checked')) return "\r";
      else if ($('#newline-rn').is(':checked')) return "\r\n";
      else return "";
    }
  }

  $('#edit').on('submit','#ClientImportation',function(e){
    $('.saveBtn').attr('disabled',true);
    $('#Loading').slideDown();
  });

  $('#edit').on('change','.imported_file',function(e){
    var valeur = $(this).val();
    if ( valeur == '' ) {
      $('.saveBtn').attr('disabled',true);
      toastr.error("Veuillez sélectionner un fichier !");
      return;
    }

    stepped = 0;
    chunks = 0;
    rows = 0;

    var txt = $('#input').val();
    var files = $('#files')[0].files;
    var config = buildConfig();

    if (files.length > 0) {
      if (!$('#stream').prop('checked') && !$('#chunk').prop('checked')) {
        for (var i = 0; i < files.length; i++) {
          if (files[i].size > 1024 * 1024 * 10) {
            toastr.error("Votre fichier est trop lourd.");
            return;
          }
        }
      }

      start = performance.now();
      
      $('#files').parse({
        config: config,
        before: function(file, inputElem){

        },
        complete: function(){

        }
      });
    } else {
      start = performance.now();
      var results = Papa.parse("Text input", config);
    }
  });

  /* Importation */
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>