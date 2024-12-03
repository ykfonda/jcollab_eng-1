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
			Liste des bon de commandes
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
      <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle saisie</a>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'boncommandes', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Boncommande.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Boncommande.fournisseur_id',array('label'=>false,'empty'=>'--Fournisseur','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Boncommande.depot_id',array('label'=>false,'empty'=>'--Dépot','class'=>'select2 form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Boncommande.etat',array('label'=>false,'empty'=>'--Etat','class'=>'form-control','options'=>$this->App->getEtatFiche() )) ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Boncommande.paye',array('label'=>false,'empty'=>'--Statut','class'=>'form-control','options'=>$this->App->getStatutPayment() )) ?>
            </div>
            <div class="col-md-3">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Boncommande.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Boncommande.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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

  $('#edit').on('submit','#BoncommandeEditForm',function(e){
    $('.saveBtn').attr('disabled',true);
  });

</script>
<?php echo $this->element('main-script',['ajax'=>false]); ?>
<?php $this->end() ?>