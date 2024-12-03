<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end() ?>
<style type="text/css">
  .red{ color: red; }
  .green{ color: green; }
</style>
<div class="hr"></div>
<div class="portlet light bordered">
  <div class="portlet-title">
    <div class="caption">
      Etat des ventes par détails
    </div>
    <div class="actions">
      <?php if ($globalPermission['Permission']['e']): ?>
        <?php echo $this->Form->input('<i class="fa fa-file-excel-o"></i> Export excel',['class'=>'btn btn-primary btn-sm ','label'=>false,'div'=>false,'type'=>'button','escape'=>false,'id'=>'ExcelBtn']); ?>
      <?php endif ?>
    </div>
  </div>
  <div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'etatventes', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
          <div class="col-md-12 smallForm">
            <div class="form-group row">
              <div class="col-md-4">
                <?php echo $this->Form->input('Filter.Bonlivraisondetail.produit_id',array('label'=>false,'empty'=>'--Produit','class'=>'select2 form-control')) ?>
              </div>
              <div class="col-md-4">
                <div class="d-flex align-items-end">
                  <?php echo $this->Form->input('Filter.Bonlivraison.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text','data-default-date'=>date('01-m-Y') )) ?>
                  <span class="input-group-addon">&nbsp;à&nbsp;</span>
                  <?php echo $this->Form->input('Filter.Bonlivraison.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text','data-default-date'=>date('d-m-Y') )) ?>
                </div>
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
        <div id="indexAjax"></div>
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