<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
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
			Liste des transferts
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'editall']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transfert en masse</a>
       <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau transfert</a>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal','id'=>'FilterIndexForm')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row row">
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Mouvement.produit_id',array('label'=>false,'empty'=>'--Produit','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-5">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Mouvement.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Mouvement.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
              </div>
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
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;
  
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
    var produit_id = $('#ProduitID').val();
    if( produit_id != '' ) loadDepots(produit_id);
  }

  Init();

  function loadDepots(produit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loaddepots']) ?>/"+produit_id,
      success: function(dt){
        var value = $('#DepotSources').val();
        $('#DepotSources').empty();
        $('#DepotSources').append($('<option>').text('--Dépôt source').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#DepotSources').append($('<option>').text(obj).attr('value', i));
        });
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  function loadQuatite(depot_id,produit_id) {
    $('#BlockInformation').hide();
    $('#BlockError').hide();
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadquatite']) ?>/"+depot_id+"/"+produit_id,
      success: function(dt){
        $("#Quantite").attr({ "max" : dt });
        if ( dt > 0 ) {
          $('#Stock').html(dt+' produit(s)');
          $('#BlockInformation').show();
        } 
        if( dt == 0 && depot_id != '' ){
          $('#BlockError').show();
        }
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  function loadproduit(produit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id,
      success: function(dt){
        if ( typeof dt.Produit.id != 'undefined' ) {
          $('#BlockProduit').show();
          $('#ProduitImage').attr('src',dt.Produit.image);
          $('#ProduitInfo').html('Désignation : '+dt.Produit.libelle+'<br/>Référence : '+dt.Produit.reference+'<br/>Prix de vente : '+dt.Produit.prix_vente);
          $('.prix_vente').val(dt.Produit.prix_vente);
        }else{
          $('.prix_vente').val(0);
          $('#BlockProduit').hide();
          $('#ProduitImage').attr('src','/img/no-avatar.jpg');
          $('#ProduitInfo').html('');
        }
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete: function(dt){
        calcule();
      }
    }); 
  }

  $('#edit').on('input','.stock_destination',function(e){
    calcule();
  });

  function calcule() {
    var quantite = parseInt($('.stock_destination').val());
    var prix_vente = parseInt($('.prix_vente').val());
    var valeur = parseInt(quantite*prix_vente);
    $('.valeur').val(valeur);
  }

  $('#edit').on('change','#ProduitID',function(e){
    $('#BlockInformation').hide();
    $('#BlockError').hide();
    var produit_id = $(this).val();
    loadDepots(produit_id);
    loadproduit( produit_id );
  });

  $('#edit').on('change','#DepotSources',function(e){
    var produit_id = $('#ProduitID').val();
    var depot_id = $(this).val();
    loadQuatite(depot_id,produit_id);
  });

  $('#edit').on('submit','form',function(e){
    e.preventDefault();
    var depot_source = $('#DepotSources').val();
    var depot_destination = $('#MouvementDepotDestinationId').val();

    if ( depot_source == depot_destination ) {
      toastr.error("Veuillez changer le dépôt destination svp !");
      return;
    }

    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data:formData,
      success : function(dt){
        loadIndexAjaxFilter( dataFilter , false);
        $('#edit').modal('hide');
        toastr.success("L'enregistrement a été effectué avec succès.");
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
    });
  });

  $('#indexAjax').on('click','.edit',function(e){
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
        $('#indexAjax').html(dt);
      }
    });
  }

  var loadIndexAjaxFilter = function(data,load){
    if(load !== true)
      dataPage = 1;

    $.ajax({
      type: 'POST',
      url: "<?php echo $this->Html->url(['action' => 'callIndexAjax']) ?>/" + dataPage,
      data: data,
      success : function(dt){
        $('#indexAjax').html(dt);
      }
    });
  }

  loadIndexAjaxFilter( dataFilter , false);

  $('#indexAjax').on('click','.pagination li:not(.disabled,.active) a',function(e){
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

  $('#indexAjax').on('click','.btnFlagDelete',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer la suppression ?", function(result) {
      if( result ){
        $.ajax({
          url: url,
          success: function(dt){
            toastr.success("La suppression a été effectué avec succès.");
            loadIndexAjaxFilter( dataFilter, false );
          },
          error: function(dt){
            toastr.error("Il y a un problème")
          }
        });
      }
    });
  });

  $('#ExcelBtn').on('click',function(e){
    e.preventDefault();
    dataFilter = $('#FilterIndexForm').serialize();
    loadExcelFilter( dataFilter, false );
  });

  var loadExcelFilter = function(data,load){
    if(load !== true)
      dataPage = 1;

    $.ajax({
      type: 'POST',
      url: "<?php echo $this->Html->url(['action' => 'callIndexAjaxExcel']) ?>/" + dataPage,
      data: data,
      success : function(dt){
        window.open(dt ,'_blank' );
      }
    });
  }

 $('#FilterIndexForm').on('submit',function(e){
    e.preventDefault();
    dataFilter = $(this).serialize();
    loadIndexAjaxFilter( dataFilter, false );
  });

  $('.btnResetFilter').on('click',function(e){
    dataFilter = null;
    $('.select2').val('').trigger('change');
    loadIndexAjaxFilter( dataFilter, false );
  });

});
</script>
<?php $this->end() ?>