<div class="hr"></div>
<div class="note note-danger">
    <h4 class="block" style="font-weight: bold;">Attention</h4>
    <p> <?php echo $message; ?> </p>
</div>
<hr/>
<p class="error">
	<strong><?php echo __d('cake', 'Error'); ?>: </strong>
	<?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
