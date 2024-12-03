<div class="hr"></div>

<?php echo $this->Form->create('Module'); ?>

	<?php
		echo $this->Form->input('parent_id',array('empty' => true,'options' => $parentModules));
		echo $this->Form->input('libelle');
		echo $this->Form->input('niveau');
		echo $this->Form->input('link');
	?>

<?php echo $this->Form->end(__('Submit')); ?>
