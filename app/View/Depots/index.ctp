<div class="hr"></div>
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Liste des dépots</h4>
    <div class="heading-elements">
      <ul class="list-inline mb-0">
        <li>
          <?php if ($globalPermission['Permission']['a']): ?>
            <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau dépot </a>
          <?php endif ?>
        </li>
      </ul>
    </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="formFilter">
            <?php $base_url = array('controller' => 'depots', 'action' => 'indexAjax'); ?>
            <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal')) ?>
            <div class="row">
            <div class="col-md-12 smallForm">
              <div class="form-group row">
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Depot.reference', array('label'=>false,'placeholder'=>'Réf','class'=>'form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Depot.libelle', array('label'=>false,'placeholder'=>'Nom','class'=>'form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Depot.store_id', array('label'=>false, 'empty'=>'--Site', 'class'=>'select2 form-control')) ?>
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
</div>

<?php $this->start('js') ?>
<script>
  var Init = function(){
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

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
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>