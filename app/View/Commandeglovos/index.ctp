<?php $this->start('modal'); ?>
<div class="modal fade modal-blue" id="edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

    </div>
  </div>
</div>
<?php $this->end(); ?>
<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des commandes glovo
		</div>
		<div class="actions">
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = ['controller' => 'Commandeglovos', 'action' => 'indexAjax']; ?>
        <?php echo $this->Form->create('Filter', ['url' => $base_url, 'class' => 'filter form-horizontal', 'autocomplete' => 'off']); ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Commandeglovo.order_code', ['label' => false, 'type' => 'text', 'placeholder' => 'No Commande', 'class' => 'form-control']); ?>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->input('Filter.Commandeglovo.client_id', ['label' => false, 'empty' => '--Client', 'class' => 'select2 form-control']); ?>
            </div>
            
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Commandeglovo.etat', ['label' => false, 'empty' => '--Etat', 'class' => 'form-control', 'options' => $this->App->getEtatCommande()]); ?>
            </div>
            <div class="col-md-3">
              <div class="d-flex align-items-end">
                <?php echo $this->Form->input('Filter.Commandeglovo.date1', ['label' => false, 'placeholder' => 'Date 1', 'class' => 'date-picker form-control', 'type' => 'text']); ?>
                <span class="input-group-addon">&nbsp;à&nbsp;</span>
                <?php echo $this->Form->input('Filter.Commandeglovo.date2', ['label' => false, 'placeholder' => 'Date 2', 'class' => 'date-picker form-control', 'type' => 'text']); ?>
              </div>
            </div>
            <div class="col-md-3">
              <?php echo $this->Form->submit('Rechercher', ['class' => 'btn btn-primary', 'div' => false]); ?>
              <?php echo $this->Form->reset('Reset', ['class' => 'btnResetFilter btn btn-default', 'div' => false]); ?>
            </div>
          </div>
        </div>
        </div>
        <?php echo $this->Form->end(); ?>
      </div>
      </div>
      <div class="col-md-12">
        <div id="indexAjax"></div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
        url: "<?php echo $this->Html->url(['action' => 'getclient']); ?>/" + ClientId,
        success: function(dt){
          $('#Remise').val(dt);
        },
        error: function(dt){
          toastr.error("Il y a un problème");
        },
      });
  });
  $('#indexAjax').on('click','.PretePourlivraison',function(e){
    e.preventDefault();
    var url = $(this).prop('href');
      $.ajax({
        url: url,
        success: function(dt){
          var message = dt.message;
          if(dt.error) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: message,
              footer: ''
            }); 
          }
          else {
          Swal.fire(
            'Good !',
            message,
            'success'
          );
        }
        },
        error: function(dt){
          toastr.error("Il y a un problème");
        },
      });
  });
  
    
</script>
<?php echo $this->element('main-script', ['ajax' => false]); ?>
<?php $this->end(); ?>