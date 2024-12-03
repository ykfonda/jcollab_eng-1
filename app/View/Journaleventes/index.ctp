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
			Journal de vente par jour
		</div>
		<div class="actions">

		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="formFilter">
          <?php $base_url = array('controller' => 'journaleventes', 'action' => 'index'); ?>
          <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal')) ?>
            <div class="form-group row" style="margin-top: 15px;">
              <div class="col-lg-2">
                <?php echo $this->Form->input('Filter.Bonlivraison.date',array('label' => false,'placeholder' => 'Date','class' => 'date-picker form-control','required'=>true,'type'=>'text','data-default-date'=>date('d-m-Y') )) ?>
              </div>
              <div class="col-lg-3">
                <?php echo $this->Form->submit('Générer le journal',array('class' => 'btn btn-primary','div' => false)) ?>
              </div>
            </div>
          <?php echo $this->Form->end() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js') ?>
<script>
$(function(){
  var dataFilter = null;
  var dataPage = 1;
  
  var Init = function(){
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  Init();

  var loadIndexAjaxFilter = function(data,load){
    if(load !== true)
      dataPage = 1;

    $.ajax({
      type: 'POST',
      url: "<?php echo $this->Html->url(['action' => 'callIndexAjax']) ?>/" + dataPage,
      data: data,
      success : function(dt){
        window.open(dt ,'_blank' );
      }
    });
  }

  $('#FilterIndexForm').on('submit',function(e){
    e.preventDefault();
    dataFilter = $(this).serialize();
    loadIndexAjaxFilter( dataFilter, false );
  });

  $('.btnResetFilter').on('click',function(e){
    dataFilter = null;
    $('.select2').val('').trigger('change');
    loadIndexAjaxFilter( dataFilter, false );
  });

});
</script>
<?php $this->end() ?>