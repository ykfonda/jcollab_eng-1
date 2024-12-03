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
      Stock par dépot
		</div>
		<div class="actions">
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
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Produit.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Produit.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Depotproduit.depot_id',array('label'=>false,'empty'=>'--Dépot','class'=>'form-control')) ?>
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