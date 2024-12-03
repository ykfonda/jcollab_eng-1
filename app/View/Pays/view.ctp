<div class="pays view">
<h2><?php echo __('Pay'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pay['Pay']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Libelle'); ?></dt>
		<dd>
			<?php echo h($pay['Pay']['libelle']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($pay['Pay']['deleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($pay['Pay']['active']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pay'), array('action' => 'edit', $pay['Pay']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pay'), array('action' => 'delete', $pay['Pay']['id']), array(), __('Etes-vous sûr de vouloir confirmer la suppression  you want to delete # %s?', $pay['Pay']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pays'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pay'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Villes'), array('controller' => 'villes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ville'), array('controller' => 'villes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Villes'); ?></h3>
	<?php if (!empty($pay['Ville'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th nowrap=""><?php echo __('Id'); ?></th>
		<th nowrap=""><?php echo __('Libelle'); ?></th>
		<th nowrap=""><?php echo __('Pay Id'); ?></th>
		<th nowrap=""><?php echo __('Deleted'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pay['Ville'] as $ville): ?>
		<tr>
			<td><?php echo $ville['id']; ?></td>
			<td><?php echo $ville['libelle']; ?></td>
			<td><?php echo $ville['pay_id']; ?></td>
			<td><?php echo $ville['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'villes', 'action' => 'view', $ville['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'villes', 'action' => 'edit', $ville['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'villes', 'action' => 'delete', $ville['id']), array(), __('Etes-vous sûr de vouloir confirmer la suppression  you want to delete # %s?', $ville['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ville'), array('controller' => 'villes', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
