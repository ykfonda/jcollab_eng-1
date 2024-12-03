<?php echo $this->Html->css('/app-assets/plugins/spectrum/spectrum.css') ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des types commande
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle saisie </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'typecommandes', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Typecommande.reference',array('label'=>false,'placeholder'=>'Réf','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Typecommande.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
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
<?php echo $this->Html->script('/app-assets/plugins/spectrum/spectrum.js'); ?>
<script>
  var Init = function(){
    $(".colorpicker").spectrum();
  }

  $('#edit').on('show.spectrum','.colorpicker',function(e,color) {
    var colorpicked = color.toHexString();
    $('.colorpicker').val(colorpicked);
  });

  $('#edit').on('hide.spectrum','.colorpicker',function(e,color) {
    var colorpicked = color.toHexString();
    $('.colorpicker').val(colorpicked);
  });
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>