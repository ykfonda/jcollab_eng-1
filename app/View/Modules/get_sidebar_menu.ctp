<?php $this->start('js') ?>
	<script>
		$(function(){
			window.location.href = '<?php echo $this->Html->url('/') ?>';
		})
	</script>
<?php $this->end() ?>