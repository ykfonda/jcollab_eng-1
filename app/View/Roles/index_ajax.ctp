
<div style="min-height:350px" class="table-scrollable">
	<table class="table table-striped table-bordered  table-hover">
		<thead>
			<tr>
				<th nowrap="">Libellé</th>
				<th nowrap="">Date de création</th>
				<th class="actions" nowrap="">
			</tr>
		</thead>
	<tbody>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td nowrap=""><a href="<?php echo $this->Html->url(['controller' => 'permissions', 'action' => 'setpermissions', $role['Role']['id'], 1]) ?>"><?php echo h($role['Role']['libelle']); ?>&nbsp;</a></td>
		<td nowrap=""><?php echo h($role['Role']['created']); ?>&nbsp;</td>
		<td nowrap="" class="actions">
			<a href="<?php echo $this->Html->url(['controller' => 'permissions', 'action' => 'setpermissions', $role['Role']['id'], 1]) ?>"><i class="fa fa-eye"></i></a>
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'duplique', $role['Role']['id']]) ?>" class="edit"><i class="fa fa-copy"></i></a>
			<?php endif ?>
			<?php if ($globalPermission['Permission']['m1']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'edit', $role['Role']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
			<?php endif ?>
			<?php if ($globalPermission['Permission']['s']): ?>
				<a href="<?php echo $this->Html->url(['action' => 'delete', $role['Role']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="row">
	<div class="col-md-5 col-sm-12">
	<div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite"><?php
	echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.'))); ?></div>
	</div>
	<div class="col-md-7 col-sm-12">
		<div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
			<ul class="pagination">
				<?php 
				    echo $this->Paginator->prev( '<', array( 'class' => 'page-link', 'tag' => 'li' ), null,  array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				    echo $this->Paginator->numbers( array( 'class' => 'page-link', 'tag' => 'li', 'separator' => '', 'currentClass' => 'page-link active', 'currentTag' => 'a' ) );
				    echo $this->Paginator->next( '>', array( 'class' => 'page-link', 'tag' => 'li' ), null, array( 'class' => 'page-link disabled', 'tag' => 'li','disabledTag' => 'a' ) );
				?>
			</ul>
		</div>
	</div>
</div>