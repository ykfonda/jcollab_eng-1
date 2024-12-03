<div class="hr"></div>
<div class="card">
  <div class="card-header">
      <h4 class="card-title">Liste des sites</h4>
      <div class="heading-elements">
          <ul class="list-inline mb-0">
              <li>
                  <?php if ($globalPermission['Permission']['a']): ?>
                    <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau site </a>
                  <?php endif ?>
              </li>
          </ul>
      </div>
  </div>
  <div class="card-content collapse show">
      <div class="card-body">
          <div class="row">
              <div class="col-sm-12">
                <!-- Filters -->
                <div class="formFilter">
                  <?php $base_url = array('controller' => 'stores', 'action' => 'indexAjax'); ?>
                  <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal')) ?>
                  <div class="row">
                    <div class="col-md-12 smallForm">
                      <div class="form-group row">
                        <div class="col-md-2">
                          <?php echo $this->Form->input('Filter.Store.reference',array('label'=>false,'placeholder'=>'Réf','class'=>'form-control')) ?>
                        </div>
                        <div class="col-md-2">
                          <?php echo $this->Form->input('Filter.Store.libelle',array('label'=>false,'placeholder'=>'Nom','class'=>'form-control')) ?>
                        </div>
                        <div class="col-md-2">
                          <?php echo $this->Form->input('Filter.Store.adresse',array('label'=>false,'placeholder'=>'Adresse','class'=>'form-control')) ?>
                        </div>
                        <div class="col-md-2">
                          <?php echo $this->Form->input('Filter.Store.societe_id',array('label'=>false,'empty'=>'--Société','class'=>'form-control')) ?>
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
                <!-- Filters -->
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
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>