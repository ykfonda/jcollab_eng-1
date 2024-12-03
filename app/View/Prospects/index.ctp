<?php echo $this->Html->css('/app-assets/plugins/rating-stars/star-rating.min.css'); ?>
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
			Liste des prospects
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau prospect </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'prospects', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.reference',array('label'=>false,'placeholder'=>'Réference','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.designation',array('label'=>false,'placeholder'=>'Désignation','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.categorieclient_id',array('label'=>false,'empty'=>'--Type','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.ville_id',array('label'=>false,'empty'=>'--Ville','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.rating',array('label'=>false,'empty'=>'--Rating','class'=>'form-control','options'=>$this->App->getImportance() )) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Client.classification',array('label'=>false,'empty'=>'--Classification','class'=>'form-control','options'=>$this->App->getClassification() )) ?>
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
<?php echo $this->Html->script('/app-assets/plugins/rating-stars/star-rating.min.js'); ?>
<script>
  var Init = function(){
    $(".rating").rating({
      min: 1, max: 5,
      showClear: false,
      showCaption: false,
      size: 'xs',  
      stars: 4,
      step: 1,
      readonly:true,
      starCaptions: {1: 'Non-évalué', 2: 'Faible', 3: 'Moyen', 4: 'Fort', 5: 'Trés fort'},
    });
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