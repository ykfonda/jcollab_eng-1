
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-money" aria-hidden="true"></i> Banque
		</div>
		<div class="actions">
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="formFilter">
          <?php $base_url = array('controller' => 'avances', 'action' => 'indexAjax'); ?>
          <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'form-horizontal')) ?>
          <div class="row">
          <div class="col-md-12 smallForm">
            <div class="form-group row">
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.reference',array('label'=>false,'placeholder'=>'Réf avance','class'=>'form-control')) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.emeteur',array('label'=>false,'placeholder'=>'Emeteur/Tél','class'=>'form-control')) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.bonlivraison_id',array('label'=>false,'empty'=>'--Bon de livraison','class'=>'select2 form-control')) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.facture_id',array('label'=>false,'empty'=>'--Facture','class'=>'select2 form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Bonlivraison.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.etat',array('label'=>false,'class'=>'form-control','options'=>$this->App->getAvance(),'default'=>-1 )) ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Avance.mode',array('label'=>false,'class'=>'form-control','options'=>$this->App->getModePaiment())) ?>
              </div>
              <div class="col-md-3">
                <div class="d-flex align-items-end">
                  <?php echo $this->Form->input('Filter.Avance.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                  <span class="input-group-addon">&nbsp;à&nbsp;</span>
                  <?php echo $this->Form->input('Filter.Avance.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
    </div>
    <div id="indexAjax">&nbsp;</div>
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