<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
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
			Liste des utilisateurs
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			  <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau utilisateur </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'administrateurs', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.User.nom',array('label'=>false,'placeholder'=>'Nom','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.User.prenom',array('label'=>false,'placeholder'=>'Prenom','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.User.role_id',array('label'=>false,'empty'=>'--Role','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.StoreUser.store_id',array('label'=>false,'empty'=>'--Site','class'=>'select2 form-control')) ?>
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
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>