<?php echo $this->Html->css('/app-assets/plugins/jquery-multi-select/css/multi-select.css') ?>
<style type="text/css">
  #ms-my_multi_select1{ width: 100% !important; }
  .ms-container .ms-list{ height: 350px !important; }
</style>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Gestionnaire des kds
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle saisie </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'kitchensystems', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Kitchensystem.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Kitchensystem.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Kitchensystem.store_id',array('label'=>false,'empty'=>'--Store','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Kitchensystem.societe_id',array('label'=>false,'empty'=>'--Société','class'=>'form-control')) ?>
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
<?php echo $this->Html->script('/app-assets/plugins/jquery-multi-select/js/jquery.multi-select.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/jquery-quicksearch/jquery.quicksearch.js') ?>
<script>
  var Init = function(){
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
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('click','.select-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('select_all');
  });

  $('#edit').on('click','.deselect-all',function (e) {
    e.preventDefault();
    $('#my_multi_select1').multiSelect('deselect_all');
  });

  $('#edit').on('change','#StoreId',function(e){
    e.preventDefault();
    var store_id = $(this).val();
    societe(store_id);
  });

  function societe(store_id) {
    $.ajax({
      type: 'GET',
      dataType: "json",
      url: "<?php echo $this->html->url(['action' => 'societe']) ?>/"+store_id,
      success : function(dt){
        $('.societe_id').val(dt.societe_id);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
    });
  }
</script>
<?php echo $this->element('main-script',['ajax'=>false]); ?>
<?php $this->end() ?>