<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Gestionnaire des caisses
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
        <?php $base_url = array('controller' => 'caisses', 'action' => 'indexAjax'); ?>
        <?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
        <div class="row">
        <div class="col-md-12 smallForm">
          <div class="form-group row">
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.libelle',array('label'=>false,'placeholder'=>'Libelle','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.store_id',array('label'=>false,'empty'=>'--Store','class'=>'form-control')) ?>
            </div>
            <div class="col-md-2">
              <?php echo $this->Form->input('Filter.Caisse.societe_id',array('label'=>false,'empty'=>'--Société','class'=>'form-control')) ?>
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
<script type="text/javascript">
			
			
		
		
</script>
<script>
  var Init = function(){
    $('.date-picker').flatpickr({
      altFormat: "DD-MM-YYYY",
      dateFormat: "d-m-Y",
      allowInput: true,
      locale: "fr",
    });
  }

  $('#edit').on('change','#StoreId',function(e){
    e.preventDefault();
    var store_id = $(this).val();
    societe(store_id);
  });

  function societe(store_id) {
    $.ajax({
      type: 'GET',
      dataType: "json",
      url: "<?php echo $this->html->url(['action' => 'societe']) ?>/"+store_id,
      success : function(dt){
        $('.societe_id').val(dt.societe_id);
      },
      error: function(dt){
        toastr.error("Il y a un problème");
      },
    });
  }
  /* window.addEventListener("beforeunload", function( event ) {
    event.preventDefault();
  // Chrome requires returnValue to be set.
  event.returnValue = '';
}); */


  $(document).on("click", '.ChooseCaisse', function(e) {
		var adresse_ip = $(this).parent().prev().prev().prev().prev().html();	
    var url_pos = $(this).attr('href');
    e.preventDefault();
			var url = "<?php echo $this->html->url(['action' => 'checkIp']) ?>/"+adresse_ip;
		    $.ajax({
		      url: url,
		      success: function(dt){
		      	if(dt.error == false) {
              window.location = url_pos; 
            }
            else {
              toastr.error("ce poste n'est pas autorisé");
            }
		      }
		    });
		});
</script>
<?php echo $this->element('main-script-compteur'); ?>
<?php $this->end() ?>