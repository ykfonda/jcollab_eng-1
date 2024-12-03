<?php echo $this->Html->css('/app-assets/plugins/jquery-multi-select/css/multi-select.css') ?>
<style type="text/css">
  #ms-my_multi_select1{
    width: 100% !important;
  }
  .ms-container .ms-list{
    height: 350px !important;
  }
</style>
<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<?php if ( isset( $this->data['Inventaire']['id'] ) AND !empty( $this->data['Inventaire']['id'] ) ): ?>

<?php if ( !empty( $this->data['Inventaire']['statut'] ) ): ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-default text-right" style="padding: 10px;color:white;background-color: <?php echo $this->App->getStatutInventaireColor( $this->data['Inventaire']['statut'] ) ?>;border-color: <?php echo $this->App->getStatutInventaireColor( $this->data['Inventaire']['statut'] ) ?>">
        <strong>Statut d'inventaire &ensp; : &ensp;</strong>  <?php echo $this->App->getStatutInventaire( $this->data['Inventaire']['statut'] ) ?>
      </div>
    </div>
  </div>
<?php endif ?>

<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Information inventaire 
    </div>
    <div class="actions">
      <a href="<?php echo $this->Html->url(['action'=>'index']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> Vers la liste </a>


      <a href="<?php echo $this->Html->url(['action' => 'exporter',$this->data['Inventaire']['id']]) ?>" class="edit btn btn-primary btn-sm">
      <i class="fa fa-file-excel-o"></i> Exporter Excel </a>


      <?php if ( isset( $this->data['Inventaire']['statut'] ) AND $this->data['Inventaire']['statut'] == -1 AND $globalPermission['Permission']['v'] ): ?>
        <a href="<?php echo $this->Html->url(['action'=>'statut',$this->data['Inventaire']['id'],1 ]) ?>" class="action btn btn-danger btn-sm"><i class="fa fa-check-square-o"></i> Valider & Clôturer </a>
        <?php if ($globalPermission['Permission']['m1']): ?>
         <a href="<?php echo $this->Html->url(['action' => 'edit',$this->data['Inventaire']['id'] ]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i> Modifier inventaire </a>
        <?php endif ?>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">

        <div class="table-scrollable">
          <table class="table table-bordered tableHeadInformation">
            <tbody>

              <tr>
                <td class="tableHead" nowrap="">Objet</td>
                <td nowrap="">
                  <?php echo $this->data['Inventaire']['libelle'] ?>
                </td>
                <td class="tableHead" nowrap="">Référence</td>
                <td nowrap=""> 
                  <?php echo $this->data['Inventaire']['reference'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Date</td>
                <td nowrap=""> 
                  <?php echo $this->data['Inventaire']['date'] ?>
                </td>
                <td class="tableHead" nowrap="">Dépot</td>
                <td nowrap="" >
                  <?php echo $this->data['Depot']['libelle'] ?>
                </td>
              </tr>

              <tr>
                <td class="tableHead" nowrap="">Créé par</td>
                <td nowrap=""> 
                  <?php echo h($this->data['Creator']['nom']); ?> <?php echo h($this->data['Creator']['prenom']); ?>
                </td>
                <td class="tableHead" nowrap="">Créé le</td>
                <td nowrap="" >
                  <?php echo $this->data['Inventaire']['date_c'] ?>
                </td>
              </tr>

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
			Liste des produits
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Inventaire']['statut'] ) AND $this->data['Inventaire']['statut'] == -1 ): ?>
			 <!-- <a href="<?php echo $this->Html->url(['action' => 'affectation',$this->data['Inventaire']['id'] ]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-link"></i> Affectation des produits </a> -->
			<?php endif ?>
      <?php if ($globalPermission['Permission']['a'] AND isset( $this->data['Inventaire']['statut'] ) AND $this->data['Inventaire']['statut'] == -1 ): ?>
       <a href="<?php echo $this->Html->url(['action' => 'importer',$this->data['Inventaire']['id'] ]) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i> Importer des produits </a>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <?php echo $this->Form->create('Inventaire',['id' => 'ScanForm','class' => 'form-horizontal','autocomplete'=>'off']); ?>
        <div class="form-group row row" style="display:none;">
          <div class="col-md-12">
            <?php echo $this->Form->input('code_barre',['class' => 'form-control','label'=>false,'required' => false,'id'=>'code_barre','placeholder'=>'Scanner code à barre ...','form'=>'ScanForm','maxlength'=>13,'minlength'=>13]); ?>
          </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php $url = ['controller'=>'inventaires','action'=>'savedetails',$this->data['Inventaire']['id']] ?>
        <?php $disabled = ( isset( $this->data['Inventaire']['statut'] ) AND $this->data['Inventaire']['statut'] == 1 ) ? 'disabled' : '' ; ?>
        <fieldset <?php echo $disabled ?>>
          <?php echo $this->Form->create('Inventaire',['url'=>$url,'id' => 'DetailForm','class' => ' form-horizontal']); ?>
          <div id="viewAjax">&nbsp;</div>
          <?php echo $this->Form->end(); ?>
        </fieldset>
      </div>
    </div>
  </div>
</div>

<?php endif ?>

<?php $this->start('js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-multi-select/js/jquery.multi-select.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-quicksearch/jquery.quicksearch.js') ?>
<?php echo $this->Html->script('papaparse.js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;
  var count = 0;

  /* Scan code a barre */
  <?php if ( isset($this->data['Inventaire']['id']) AND !empty($this->data['Inventaire']['id']) ): ?>
    
  <?php endif ?>
  $('#ScanForm').on('submit',function(e){
    e.preventDefault();
    var code_barre = $('#code_barre').val();
    scaning(code_barre);
  });

  function scaning(code_barre) {
    if ( code_barre == '' || code_barre == '#' ) { toastr.error("Aucun code barre saisie !"); return; }
    $.ajax({
      url: "<?php echo $this->Html->url(['action' => 'scan',$this->data['Inventaire']['id'] ]) ?>/"+code_barre,
      success: function(result){
        if ( result.error == true ) toastr.error(result.message);
        else{
          toastr.success("La mise à jour a été effectué avec succès.");
          loadIndexViewFilter( dataFilter, true );
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
  /* Scan code a barre */

  /* Importation */

  function errorFn(error, file){
    toastr.error("ERROR:", error, file);
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
      console.log(table);
      $('.saveBtn').prop('disabled', false);

      $("#code_barre").empty();
      $("#code_barre").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#code_barre").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#code_barre").val(0);

      $("#quantite_reel").empty();
      $("#quantite_reel").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#quantite_reel").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#quantite_reel").val(1);

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

  $('#edit').on('submit','#InventairedetailImportation',function(e){
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

  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
    $('#my_multi_select1').multiSelect({
      selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Recherche rapide...'>",
      selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Recherche rapide...'>",
      afterInit: function(ms){
      var that = this,
          $selectableSearch = that.$selectableUl.prev(),
          $selectionSearch = that.$selectionUl.prev(),
          selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
          selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

      that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
      .on('keydown', function(e){
        if (e.which === 40){
          that.$selectableUl.focus();
          return false;
        }
      });

      that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
      .on('keydown', function(e){
        if (e.which == 40){
          that.$selectionUl.focus();
          return false;
        }
      });
      },
      afterSelect: function(){
        count = $("#my_multi_select1 :selected").length;
        $('#count').html(count);
        this.qs1.cache();
        this.qs2.cache();
      },
      afterDeselect: function(){
        count = $("#my_multi_select1 :selected").length;
        $('#count').html(count);
        this.qs1.cache();
        this.qs2.cache();
      },
      selectableOptgroup: true ,
    });
  }
  
  Init();

  $('#edit').on('submit','#InventaireEditForm',function(e){
    $('.saveBtn').attr("disabled", true);
  });

  $('#edit').on('click','.select-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('select_all');
  });

  $('#edit').on('click','.deselect-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('deselect_all');
  });

  $('#edit').on('submit','#InventaireAffectation',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data:formData,
      success : function(dt){
        $('#edit').modal('hide');
        toastr.success("L'enregistrement a été effectué avec succès.");
        loadIndexViewFilter( dataFilter, true );
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
    });
  });

  $('#viewAjax').on('input','.quantite_reel',function(e){
    delay(function () { $('#DetailForm').trigger('submit'); }, 500);
  });

  $('#DetailForm').on('submit',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      data:formData,
      url: form.attr('action'),
      success : function(dt){
        toastr.success("L'enregistrement a été effectué avec succès.");
        loadIndexViewFilter( dataFilter, true );
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
    });
  });

  $('#viewAjax').on('click','.edit',function(e){
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success: function(dt){
        $('#edit .modal-content').html(dt);
        $('#edit').modal('show');
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(){
        Init();
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

// ----------------------- Filtre & Pagination ------------------------ //

  var loadIndexAjax = function(url){
    $.ajax({
      url: url,
      success : function(dt){
        $('#viewAjax').html(dt);
      }
    });
  }

  var loadIndexViewFilter = function(data,load){
    if(load !== true) dataPage = 1;

    $.ajax({
      type: 'POST',
      data: data,
      <?php if ( isset( $this->data['Inventaire']['id'] ) AND !empty( $this->data['Inventaire']['id'] ) ): ?>
      url: "<?php echo $this->Html->url(['action' => 'callDetailsAjax',$this->data['Inventaire']['id'] ]) ?>/" + dataPage,
      <?php endif ?>
      success : function(dt){
        $('#viewAjax').html(dt);
      }
    });
  }

  loadIndexViewFilter( dataFilter , false);

  $('#viewAjax').on('click','.pagination li:not(.disabled,.active) a',function(e){
    e.preventDefault();
    loadIndexAjax( $(this).attr('href') );
    dataPage = 1;

    SplitArr = $(this).attr('href').split('/');
    for (var i = 0; i < SplitArr.length; i++) {
      if(SplitArr[i].split(':')[0] == "page"){
        dataPage = SplitArr[i].split(':')[1];
      }
    };
  });

  $('.action').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("<center style='font-size:20px;'>Etes-vous sûr de vouloir confirmer cette action ? <br/><br/> <b style='color:red'>Attention : Cette action est irréversible !</b></center>", function(result) {
      if( result ){
        window.location = url;
      }
    });
  });

  $('#viewAjax').on('click','.btnFlagDelete',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
      if( result ){
        $.ajax({
          url: url,
          success: function(dt){
            toastr.success("La suppression a été effectué avec succès.");
            loadIndexViewFilter( dataFilter, true );
          },
          error: function(dt){
            toastr.error("Il y a un problème")
          }
        });
      }
    });
  });

});
</script>
<?php $this->end() ?>