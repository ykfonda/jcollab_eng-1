<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Promotions
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'editClient']); ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Promotion Client </a>
			 <a href="<?php echo $this->Html->url(['action' => 'editGenerale']); ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Promotion Générale </a>
      <?php endif; ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
      <div class="col-md-12">
      <div class="formFilter">
        <?php $base_url = ['controller' => 'caisses', 'action' => 'indexAjax']; ?>
        <?php echo $this->Form->create('Filter', ['url' => $base_url, 'class' => 'filter form-horizontal', 'autocomplete' => 'off']); ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.libelle', ['label' => false, 'placeholder' => 'Libelle', 'class' => 'form-control']); ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.store_id', ['label' => false, 'empty' => '--Store', 'class' => 'form-control']); ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.societe_id', ['label' => false, 'empty' => '--Société', 'class' => 'form-control']); ?>
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
        <div id="indexAjax">&nbsp;</div>
      </div>
    </div>
  </div>
</div>

<?php $this->start('js'); ?>

<script>
  var Init = function(){
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
    $('.select2').select2();
    $('.uniform').uniform();
  }

  $('.edit_promotion').on('click',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
	        $('#edit .modal-body').html(dt);
	        $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un probleme");
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	});
    $('#indexAjax').on('click','.edit_promotion',function(e){
	    e.preventDefault();
	    $.ajax({
	      url: $(this).attr('href'),
	      success: function(dt){
          $('#edit .modal-content').html("");
	        $('#edit .modal-content').append('<div class="modal-header"><h4 class="modal-title">Saisir informations Client</h4></div><div class="modal-body">');
	        $('#edit .modal-content').append(dt);
          
          $('#edit').modal('show');
	      },
	      error: function(dt){
	        toastr.error("Il y a un problème");
	      },
	      complete: function(){
	        Init();
	      }
	    });
  	});
</script>
<?php echo $this->element('main-script-compteur'); ?>
<?php $this->end(); ?>