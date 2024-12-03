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
			Liste des Expéditions 
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
        <a href="<?php echo $this->Html->url(['action' => '../Expeditions/editexp']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Expédition </a>
       <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Mouvement.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-4">
              <?php echo $this->Form->input('Filter.Mouvement.produit_id',array('label'=>false,'empty'=>'--Produit','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Mouvement.depot_source_id',array('label'=>false,'empty'=>'--Dépot','class'=>'select2 form-control','options'=>$depots)) ?>
            </div>
          </div>
          <div class="form-group row row">
            <div class="col-md-3">
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
  var Init = function(){
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  async function loadDepots(produit_id) {
    await $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loaddepots']) ?>/"+produit_id,
      success: function(dt){
        $('#DepotID').empty();
        $('#DepotID').append($('<option>').text('-- Votre choix --').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#DepotID').append($('<option>').text(obj).attr('value', i));
        });
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  async function loadproduit(produit_id,depot_id) {
    await $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id+"/"+depot_id,
      success: function(dt){
        $('#BlockProduit').hide();
        $('#ProduitImage').attr('src','/img/no-avatar.jpg');
        $('#ProduitInfo').html('');
        $('.stock').val(0);
        $('.stock_source').attr('max',0);
        if ( typeof dt.Produit != 'undefined' && typeof dt.Produit.id != 'undefined' ) {
          $('#BlockProduit').show();
          $('#ProduitImage').attr('src',dt.Produit.image);
          $('#ProduitInfo').html('<b>Libellé :</b> '+dt.Produit.libelle+'<br/><b>Référence :</b> '+dt.Produit.reference+'<br/><b>Code à barre :</b> '+dt.Produit.code_barre+'<br/><b>Qté en stock :</b> '+dt.Produit.stock+' '+dt.Produit.unite);
          $('.stock').val(dt.Produit.stock);
          $('.stock_source').attr('max',dt.Produit.stock);
        }
      },
      error: function(dt){
        $('#BlockProduit').hide();
        $('#ProduitImage').attr('src','/img/no-avatar.jpg');
        $('#ProduitInfo').html('');
        $('.stock').val(0);
        $('.stock_source').attr('max',0);
        toastr.error("Il y a un problème");
      }
    }); 
  }

  $('#edit').on('change','#ProduitId',function(e){
    var depot_id = $('#DepotID').val();
    var produit_id = $('#ProduitId').val();
    loadDepots( produit_id );
    loadproduit( produit_id , depot_id );
  });

  $('#edit').on('change','#DepotID',function(e){
    var depot_id = $('#DepotID').val();
    var produit_id = $('#ProduitId').val();
    loadproduit( produit_id , depot_id );
  });
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>