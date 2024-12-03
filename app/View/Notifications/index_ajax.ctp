<div style="min-height:350px" class="table-scrollable">
	<table class="table table-striped table-bordered  table-hover">
		<thead>
			<tr>
				<th nowrap="">Message</th>
				<th nowrap="">Date</th>
				<th class="actions">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($user_notifications as $notification): ?>
			<tr>
				<td>
					<?php if (empty($notification['NotificationsVue'])): ?>
						<a href="<?php echo $this->Html->url(['action' => 'link', $notification['Notification']['id']]) ?>">
						<?php echo h($notification['Notification']['message']); ?>
						</a>
					<?php else: ?>
						<?php echo h($notification['Notification']['message']); ?>
					<?php endif ?>
				</td>
				<td><?php echo $notification['Notification']['date_c']; ?>&nbsp;</td>
				<td class="actions">
					<a href="<?php echo $this->Html->url(['action' => 'link', $notification['Notification']['id']]) ?>"> <i class="fa fa-link"></i> </a>
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