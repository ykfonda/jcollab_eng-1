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
			Bon de livraison
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
        <a href="<?php echo $this->Html->url(['action' => 'factureBls']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Facture a partir de plusieurs BLs </a>
        <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau bon de livraison </a>
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'bonlivraisons', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Bonlivraison.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Bonlivraison.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
            </div>
            <?php if ( in_array($role_id, $admins) ): ?>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Bonlivraison.user_id',array('label'=>false,'empty'=>'--Vendeur','class'=>'select2 form-control')) ?>
            </div>
            <?php endif ?>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Bonlivraison.etat',array('label'=>false,'empty'=>'--Etat','class'=>'form-control','options'=>$this->App->getEtatFiche() )) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Bonlivraison.paye',array('label'=>false,'empty'=>'--Statut','class'=>'form-control','options'=>$this->App->getStatutPayment() )) ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Bonlivraison.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Bonlivraison.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
    $('.uniform').uniform();
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('change','#ClientId',function(e){
      var ClientId = $(this).val();
      $.ajax({
        url: "<?php echo $this->Html->url(['action' => 'getclient']) ?>/" + ClientId,
        success: function(dt){
          $('#Remise').val(dt);
        },
        error: function(dt){
          toastr.error("Il y a un problème");
        },
      });
  });

  $('#edit').on('submit','#BonlivraisonEditForm',function(e){
    $('.saveBtn').attr('disabled',true);
  });

  $('#edit').on('submit','#ChangeStatutForm',function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    var form = $(this);
    $('.saveBtn').attr("disabled", true);
    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data:formData,
      success : function(dt){
        $('#edit').modal('hide');
        toastr.success("L'enregistrement a été effectué avec succès.");
        loadIndexAjaxFilter( dataFilter, true );
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
      complete : function(){
        $('.saveBtn').attr("disabled", false);
      },
    });
  });

</script>
<?php echo $this->element('main-script',['ajax'=>false]); ?>
<?php $this->end() ?>