<div class="hr"></div>
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption">
			Configuration d'application
		</div>
		<div class="actions">
			<?php if ($globalPermission['Permission']['a']): ?>
			   <a href="<?php echo $this->Html->url(['action' => 'edit']) ?>" class="edit btn btn-default btn-sm"><i class="fa fa-plus"></i> Nouvelle société </a>
			<?php endif ?>
		</div>
	</div>


	<div class="portlet-body">
    <div class="row">

    <?php
        debug($details);
    ?>


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