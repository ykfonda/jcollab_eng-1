<div class="pays form">
<?php echo $this->Form->create('Pay'); ?>
	<fieldset>
		<legend><?php echo __('Add Pay'); ?></legend>
	<?php
		echo $this->Form->input('libelle');
		echo $this->Form->input('deleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pays'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Villes'), array('controller' => 'villes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ville'), array('controller' => 'villes', 'action' => 'add')); ?> </li>
	</ul>
</div>
