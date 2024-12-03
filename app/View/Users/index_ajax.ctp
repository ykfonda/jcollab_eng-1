<div class="table-responsive" style="min-height: auto;">
	<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th nowrap="">Nom</th>
			<th nowrap="">Prénom</th>
			<th nowrap="">Username</th>
			<th nowrap="">Role</th>
			<th nowrap="">Date de création</th>
			<th class="actions">Actions</th>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
				<tr>
					<td><?php echo h($user['User']['nom']); ?>&nbsp;</td>
					<td><?php echo h($user['User']['prenom']); ?>&nbsp;</td>
					<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
					<td><?php echo $this->App->getRole($user['User']['role']); ?>&nbsp;</td>
					<td><?php echo h($user['User']['date_c']); ?>&nbsp;</td>
					<td class="actions">
						<?php if ($role == 1): ?>
							<a href="<?php echo $this->Html->url(['action' => 'view', $user['User']['id']]) ?>"><i class="fa fa-eye"></i></a>
							<a href="<?php echo $this->Html->url(['action' => 'edit', $user['User']['id']]) ?>" class="edit"><i class="fa fa-edit"></i></a>
							<?php if ( $role == 1 ): ?>
								<a href="<?php echo $this->Html->url(['action' => 'delete', $user['User']['id']]) ?>" class="btnFlagDelete"><i class="fa fa-trash-o"></i></a>
							<?php endif ?>
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
		echo $this->Paginator->counter(array( 'format' => __('Page {:page} sur {:pages} |  {:current} résultats sur un total de {:count}.')
		)); ?></div>
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