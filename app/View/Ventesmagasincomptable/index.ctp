<style>
  .caisse {
    width : 15rem;
  }
</style>
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
			 Ventes comptables Consolidées par magasin 
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
        <?php $base_url = array('controller' => 'Ventesmagasin', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Salepoint2.magasin_id',array('label'=>false,'empty'=>'--Tout les magasins','placeholder'=>'Référence','class'=>'form-control select2')) ?>
            </div>
            <div class="col-md-2">
            <?php echo $this->Form->input('Filter.Salepoint2.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
            </div>
            
            <div class="col-md-2">
            <?php echo $this->Form->input('Filter.Salepoint2.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>            </div>
          
          <div class="col-md-4">
              <?php echo $this->Form->submit('Rechercher',array('class' => 'btn btn-primary','div' => false)) ?>
              <?php echo $this->Form->reset('Reset',array('class' => 'btnResetFilter btn btn-default','div' => false)) ?>  
            </div>
              
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
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      defaultDate: new Date(),
      allowInput: true,
      locale: "fr",
    });

    
  }

</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>