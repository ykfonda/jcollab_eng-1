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
			Liste des entrées 
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['i']): ?>
        <a target="_blank" href="<?php echo $this->Html->url(['action' => 'journal']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-ticket"></i> Imprimer journal </a>
      <?php endif ?>
      <?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'editall']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Entrée en masse </a>
       <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle entrée </a>
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
          <div class="form-group row row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Mouvement.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-4">
              <?php echo $this->Form->input('Filter.Mouvement.produit_id',array('label'=>false,'empty'=>'--Produit','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Mouvement.fournisseur_id',array('label'=>false,'empty'=>'--Fournisseur','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Mouvement.num_lot',array('label'=>false,'placeholder'=>'Numéro de lot','class'=>'form-control')) ?>
            </div>
          </div>
          <div class="form-group row row">
            <div class="col-md-3">
              <div class="d-flex align-items-end" >
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

  $('#edit').on('input','.stock_source',function(e){
    calcul();
  });

  $('#edit').on('input','.paquet_source',function(e){
    calcul();
  });

  function calcul() {
    var stock_source = $('.stock_source').val();
    var paquet_source = $('.paquet_source').val();
    if( stock_source == '' ) stock_source = 0;
    if( paquet_source == '' ) paquet_source = 0;
    var total =  parseInt(stock_source)*parseInt(paquet_source);
    $('.total_general').val( total );
  }

  function loadproduit(produit_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadproduit']) ?>/"+produit_id,
      success: function(dt){
        if ( typeof dt.Produit.id != 'undefined' ) {
          $('#BlockProduit').show();
          $('#ProduitImage').attr('src',dt.Produit.image);
          $('#ProduitInfo').html('<b>Libellé :</b> '+dt.Produit.libelle+'<br/><b>Référence :</b> '+dt.Produit.reference+'<br/><b>Code à barre :</b> '+dt.Produit.code_barre);
        }else{
          $('#BlockProduit').hide();
          $('#ProduitImage').attr('src','/img/no-avatar.jpg');
          $('#ProduitInfo').html('');
        }
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }

  $('#edit').on('change','#ProduitId',function(e){
    loadproduit( $(this).val() );
  });

</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>