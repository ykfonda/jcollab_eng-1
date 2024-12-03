<div class="modules view">
<h2><?php echo __('Module'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($module['Module']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Module'); ?></dt>
		<dd>
			<?php echo $this->Html->link($module['ParentModule']['name'], array('controller' => 'modules', 'action' => 'view', $module['ParentModule']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($module['Module']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($module['Module']['rght']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($module['Module']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($module['Module']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($module['Module']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Module'), array('action' => 'edit', $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Module'), array('action' => 'delete', $module['Module']['id']), array(), __('Etes-vous sûr de vouloir confirmer la suppression # %s?', $module['Module']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Modules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Module'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Modules'), array('controller' => 'modules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Module'), array('controller' => 'modules', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Modules'); ?></h3>
	<?php if (!empty($module['ChildModule'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th nowrap=""><?php echo __('Id'); ?></th>
		<th nowrap=""><?php echo __('Parent Id'); ?></th>
		<th nowrap=""><?php echo __('Lft'); ?></th>
		<th nowrap=""><?php echo __('Rght'); ?></th>
		<th nowrap=""><?php echo __('Name'); ?></th>
		<th nowrap=""><?php echo __('Created'); ?></th>
		<th nowrap=""><?php echo __('Updated'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($module['ChildModule'] as $childModule): ?>
		<tr>
			<td><?php echo $childModule['id']; ?></td>
			<td><?php echo $childModule['parent_id']; ?></td>
			<td><?php echo $childModule['lft']; ?></td>
			<td><?php echo $childModule['rght']; ?></td>
			<td><?php echo $childModule['name']; ?></td>
			<td><?php echo $childModule['created']; ?></td>
			<td><?php echo $childModule['updated']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'modules', 'action' => 'view', $childModule['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'modules', 'action' => 'edit', $childModule['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'modules', 'action' => 'delete', $childModule['id']), array(), __('Etes-vous sûr de vouloir confirmer la suppression # %s?', $childModule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Module'), array('controller' => 'modules', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
