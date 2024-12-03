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
			Liste des versements
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouveau </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
        <div class="formFilter">
          <?php $base_url = array('controller' => 'versements', 'action' => 'indexAjax'); ?>
          <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
          <div class="row">
          <div class="col-md-12 smallForm">
            <div class="form-group row">
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Versement.reference',array('label'=>false,'placeholder'=>'Référence','class'=>'form-control')) ?>
              </div>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Versement.client_id',array('label'=>false,'empty'=>'--Client','class'=>'select2 form-control')) ?>
              </div>
              <?php if ( $role_id == 1 ): ?>
              <div class="col-md-3">
                <?php echo $this->Form->input('Filter.Versement.user_id',array('label'=>false,'empty'=>'--Vendeur','class'=>'select2 form-control')) ?>
              </div>
              <?php endif ?>
              <div class="col-md-2">
                <?php echo $this->Form->input('Filter.Versement.etat',array('label'=>false,'empty'=>'--Etat','class'=>'form-control','options'=>$this->App->getEtatVersement() )) ?>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <div class="d-flex align-items-end">
                  <?php echo $this->Form->input('Filter.Versement.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'date-picker form-control','type'=>'text')) ?>
                  <span class="input-group-addon">&nbsp;à&nbsp;</span>
                  <?php echo $this->Form->input('Filter.Versement.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'date-picker form-control','type'=>'text')) ?>
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
    $('.select2').select2();
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('change','#user_id,#client_id',function(e){
    var client_id = $('#client_id').val();
    var user_id = $('#user_id').val();
    loadventes(user_id,client_id);
  });

  function loadventes(user_id,client_id) {
    $.ajax({
      dataType: "json",
      url: "<?php echo $this->Html->url(['action' => 'loadventes']) ?>/"+user_id+"/"+client_id,
      success: function(dt){
        $('#ventes').empty();
        //$('#ventes').append($('<option>').text('').attr('value', ''));
        $.each(dt, function(i, obj){
          $('#ventes').append($('<option>').text(obj).attr('value', i));
        });
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      }
    }); 
  }
</script>
<?php echo $this->element('main-script'); ?>
<?php $this->end() ?>