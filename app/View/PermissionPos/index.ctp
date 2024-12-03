
<div class="hr"></div>

<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Liste des rôles
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
				<a href="<?php echo $this->Html->url(array('action' => 'add')) ?>" class="edit btn btn-primary btn-sm" data-id="0"><i class="fa fa-plus"></i> Ajouter un rôle </a>
			<?php endif ?>
		</div>
	</div>
	<div class="portlet-body">
		<div class="row">
			<div class="col-md-12">
			  	<div class="formFilter">
					<?php $base_url = array('action' => 'indexAjax'); ?>
					<?php echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter form-horizontal','autocomplete'=>'off')) ?>
					<div class="row">
						<div class="col-md-12 smallForm">
							<div class="form-group row">
								<div class="col-md-3">
									<?php echo $this->Form->input('Filter.Role.libelle',array('label' => false,'placeholder' => 'Recherche','class' => 'form-control')) ?>
								</div> 
								<div class="col-md-4">
									<div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
										<?php echo $this->Form->input('Filter.Role.date1',array('label' => false,'placeholder' => 'Date 1','class' => 'form-control')) ?>
										<span class="input-group-addon">&nbsp;à&nbsp;</span>
										<?php echo $this->Form->input('Filter.Role.date2',array('label' => false,'placeholder' => 'Date 2','class' => 'form-control')) ?>
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