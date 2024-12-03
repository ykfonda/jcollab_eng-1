<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
  .table>tbody>tr>td{ vertical-align: inherit; }
</style>
<div class="hr"></div>
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Liste des recettes
    </div>
    <div class="actions">
      <?php if ($globalPermission['Permission']['e']): ?>
        <?php echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Export Excel',['class'=>'btn btn-primary btn-sm ','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); ?>
      <?php endif ?>
      <?php if ($globalPermission['Permission']['a']): ?>
        <a href="<?php echo $this->Html->url(['action' => 'importer']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i> Importation </a>
        <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle recette </a>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.code_barre',array('label'=>false,'placeholder'=>'Code à barre','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.categorieproduit_id',array('label'=>false,'empty'=>'--Catégorie','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.souscategorieproduit_id',array('label'=>false,'empty'=>'-- Sous Catégorie','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Produit.unite_id',array('label'=>false,'empty'=>'--Unité','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->submit('Rechercher',array('class' => 'searchBtn btn btn-primary','div' => false)) ?>
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
<?php echo $this->Html->script('papaparse.js') ?>
<script>
  var Init = function(){
    $('.select2').select2();
    $('.uniform').uniform();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('change','.prix_vente',function(e){
    var prix_vente = $('.prix_vente').val();
    var prixachat = $('.prixachat').val();
    if( prix_vente < prixachat ){
      toastr.error("Attention : Prix de vente doit étre supérieur au prix d'achat ! ");
    }
  });

  $('#edit').on('change','.prixachat',function(e){
    var prix_vente = $('.prix_vente').val();
    var prixachat = $('.prixachat').val();
    if( prix_vente < prixachat ){
      toastr.error("Attention : Prix de vente doit étre supérieur au prix d'achat ! ");
    }
  });

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

      $("#libelle").empty();
      $("#libelle").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#libelle").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#libelle").val(1);

      $("#tva_achat").empty();
      $("#tva_achat").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#tva_achat").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#tva_achat").val(3);

      $("#prixachat").empty();
      $("#prixachat").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#prixachat").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#prixachat").val(2);

      $("#tva_vente").empty();
      $("#tva_vente").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#tva_vente").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#tva_vente").val(5);

      $("#prix_vente").empty();
      $("#prix_vente").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#prix_vente").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#prix_vente").val(4);

      $("#unite").empty();
      $("#unite").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#unite").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#unite").val(6);

      $("#categorie").empty();
      $("#categorie").append("<option value=''>--Vide</option>");
      for (var i = 0; i <= table.length; i++) {
          if ( table[i] != 'undefined' && table[i] != '') {
            $("#categorie").append("<option value='"+i+"'>"+table[i]+"</option>");
        }
      }
      $("#categorie").val('');


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

  $('#edit').on('submit','#ProduitImportation',function(e){
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
<?php echo $this->element('main-script',['ajax'=>false,'form'=>'ProduitEditForm']); ?>
<?php $this->end() ?>