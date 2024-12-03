<div class="hr"></div>
<div class="card">
  <div class="card-header">
      <h4 class="card-title">Transformation</h4>
      <div class="heading-elements">
          <ul class="list-inline mb-0">
              <li>
                <?php if ($globalPermission['Permission']['e']): ?>
                  <?php echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Export Excel',['class'=>'btn btn-primary','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); ?>
                <?php endif ?>
                <?php if ($globalPermission['Permission']['a']): ?>
                 <a href="<?php echo $this->Html->url(['action' => 'editall']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Transformation en masse </a>
                <?php endif ?>
              </li>
          </ul>
      </div>
  </div>
  <div class="card-content collapse show">
    <div class="card-body">
      <div class="row">
          <div class="col-sm-12">
            <div class="formFilter smallForm">
              <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'indexAjax'); ?>
              <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal')) ?>
              <div class="form-group row">
                <div class="col-md-2">
                  <?php echo $this->Form->input('Filter.Transformation.reference',array('label'=>false,'placeholder'=>'Réf','class'=>'form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Transformation.libelle',array('label'=>false,'placeholder'=>'Objet','class'=>'form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Transformation.user_id',array('label'=>false,'empty'=>'--Responsable','class'=>'select2 form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->input('Filter.Transformation.depot_id',array('label'=>false,'empty'=>'--Dépot','class'=>'select2 form-control')) ?>
                </div>
                <div class="col-md-3">
                  <?php echo $this->Form->submit('Rechercher',array('class' => 'btn btn-primary','div' => false)) ?>
                  <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>
                </div>
              </div>
              <?php echo $this->Form->end() ?>
            </div>
          </div>
          <div class="col-sm-12">
            <div id="indexAjax"></div>
          </div>
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
</script>
<?php echo $this->element('main-script',['ajax'=>false]); ?>
<?php $this->end() ?>