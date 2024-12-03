<div class="hr"></div>
<div class="note note-danger">
    <h4 class="block" style="font-weight: bold;">Attention</h4>
    <p> <?php echo $message; ?> </p>
</div>
<hr/>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php printf(
		__d('cake', 'The requested address %s was not found on this server.'),
		"<strong>'{$url}'</strong>"
	); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
