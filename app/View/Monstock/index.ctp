<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
      Mon stock
		</div>
		<div class="actions">
		  <?php if ( in_array($role_id, $admins) ): ?>
            <!-- <a href="<?php echo $this->Html->url(['action' => 'correction']) ?>" class="action btn btn-primary btn-sm"><i class="fa fa-refresh"></i> Actualiser le stock </a> -->
          <?php endif ?>
          <?php if ($globalPermission['Permission']['e']): ?>
            <?php echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Export Excel',['class'=>'btn btn-primary btn-sm ','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); ?>
          <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="formFilter">
          <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
          <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'smallForm form-horizontal','id'=>'FilterIndexForm','autocomplete'=>'off')) ?>
            <div class="form-group row row">
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Produit.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Produit.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Produit.code_barre',array('label'=>false,'placeholder'=>'Code à barre','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Depotproduit.depot_id',array('label'=>false,'empty'=>'--Dépot','class'=>'select2 form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->submit('Rechercher',array('class' => 'searchBtn btn btn-primary','div' => false)) ?>
                <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
              </div>
            </div>
          <?php echo $this->Form->end() ?>
        </div>
      </div>
      <div class="col-md-12">
        <div id="indexAjax"></div>
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
  }

  Init();

  $('#edit').on('input','.quantite,.paquet,#PrixVente',function(e){
    calculeTotal();
  });

  function calculeTotal() {
    var quantite = $('.quantite').val();
    var paquet = $('.paquet').val();

    if( paquet == '' ) paquet = 1;
    if( quantite == '' ) quantite = 0; 

    var total = quantite*paquet;
    $('.total').val(total);
  }

  $('#edit').on('submit','form',function(e){
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
          loadIndexAjaxFilter( dataFilter , true);
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

  $('.action').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir confirmer cette action ?", function(result) {
      if( result ){
        window.location = url;
      }
    });
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
            loadIndexAjaxFilter( dataFilter, true );
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