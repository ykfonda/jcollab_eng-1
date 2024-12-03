<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Wallets
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			 <a href="<?php echo $this->Html->url(['action' => 'edit']); ?>" class="edit btn btn-primary btn-sm"><i class="fa fa-plus"></i> Nouvelle saisie </a>
			<?php endif; ?>
		</div>
	</div>
	<div class="portlet-body">
    <div class="row">
     
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

 
</script>
<?php echo $this->element('main-script-compteur'); ?>
<?php $this->end(); ?>