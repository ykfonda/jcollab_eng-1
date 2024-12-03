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
			Liste des bons d'entrée
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'editall']) ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau bon d'entrée</a>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => $this->params['controller'], 'action' => 'callIndexAjaxExcel'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Bonentree.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Bonentree.depot_id',array('label'=>false,'empty'=>'--Dépot','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-3">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Bonentree.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Bonentree.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>