<?php $this->start('modal') ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $this->end() ?>
<?php $this->start('page-bar') ?>
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="<?php echo $this->Html->url('/') ?>">
                        <i class="fa fa-line-chart"></i>
                        <span class="title">Tableau de bord</span>
                      </a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="<?php echo $this->Html->url(['action' => 'index']) ?>">Notification</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des notifications
		</div>
		<div class="actions">
       <!-- <a href="<?php echo $this->Html->url(['action' => 'readall']) ?>" class="readall btn btn-primary btn-sm"><i class="fa fa-check-square-o"></i> Marquer comme lu</a> -->
		</div>
	</div>
	<div class="portlet-body">		
		<div class="row">
	      <div class="col-md-12">
	      <div class="formFilter">
	        <?php $base_url = array('controller' => 'notifications', 'action' => 'indexAjax'); ?>
	        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
	        <div class="row">
	        <div class="col-md-12 smallForm">
	          <div class="form-group row">
	            <div class="col-md-2">
	              <?php echo $this->Form->input('Filter.Notification.message',array('label'=>false,'placeholder'=>'Message','class'=>'form-control','type'=>'text')) ?>
	            </div>
	            <div class="col-md-4">
	              <div class="d-flex align-items-end">
	                <?php echo $this->Form->input('Filter.Notification.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
	                <span class="input-group-addon">&nbsp;à&nbsp;</span>
	                <?php echo $this->Form->input('Filter.Notification.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
	        <div id="indexAjax">&nbsp;</div>
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

  $('.readall').on('click',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
    bootbox.confirm("Etes-vous sûr de vouloir marquer toutes les notifications comme lu ?", function(result) {
      if( result ){
        window.location = url;
      }
    });

  });
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>