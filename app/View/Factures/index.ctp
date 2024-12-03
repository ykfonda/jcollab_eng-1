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
			Liste des factures
		</div>
		<div class="actions">
      <?php if ($globalPermission['Permission']['a']): ?>
        <a href="<?php echo $this->Html->url(['action' => 'editbonlivraison']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Facture sur plusieurs bons de livraison </a> 
         <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle facture </a> 
      <?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = array('controller' => 'facture', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Facture.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Facture.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
            </div>
            <?php if ( in_array($role_id, $admins) ): ?>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Facture.user_id',array('label'=>false,'empty'=>'--Vendeur','class'=>'select2 form-control')) ?>
            </div>
            <?php endif ?>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Facture.etat',array('label'=>false,'empty'=>'--Etat','class'=>'form-control','options'=>$this->App->getEtatFiche() )) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Facture.paye',array('label'=>false,'empty'=>'--Statut','class'=>'form-control','options'=>$this->App->getStatutPayment() )) ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-3">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Facture.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Facture.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
    $('#BonlivraisonId').select2({multiple: true});
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

  $('#edit').on('change','#ClientIdBL',function(e){
    var client_id = $('#ClientIdBL').val();
    getBonlivraisonClient(client_id);
  });

  function getBonlivraisonClient(client_id) {
    $.ajax({
      dataType:'JSON',
      url: "<?php echo $this->Html->url(['action' => 'getBonlivraisonClient']) ?>/"+client_id,
      success: function(dt){
        
        $('#BonlivraisonId').empty();
        $('#BonlivraisonId').append($('<option>').text('-- Votre choix').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#BonlivraisonId').append($('<option>').text(obj).attr('value', i));
        });
        $('#BonlivraisonId').val( value ).trigger('change');
        
      
      },
      error: function(dt){
      
        toastr.error("Il y a un probléme");
      },
      complete: function(){
      
      }
    });
  }

</script>
<?php echo $this->element('main-script',[ 'form' => "FactureEditForm" ]); ?>); ?>
<?php $this->end() ?>